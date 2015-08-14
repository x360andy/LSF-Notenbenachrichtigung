<?php
// Nur tagsüber prüfen, da das System nachts oft nicht erreichbar ist. 
if (date("H") < "06")
die();


include('config.php');
include('connector.php');

$content->execute('https://www.lsf.hs-weingarten.de/qisserver/servlet/de.his.servlet.RequestDispatcherServlet?state=htmlbesch&moduleParameter=Student&menuid=notenspiegel&asi='.$matches[0][1]);
$content->close();


$file = fopen($filename, "a+");
$countLastScores = fgets($file, 100);


$doc = @DOMDocument::loadHTML($content);
$countMatches = 0;
$xpath = new DOMXPath($doc);
$nodes = $xpath->query('//*[@class="posrecords"]');

$matches = array();


foreach ($nodes as $node) {
	$matches[$c/7][$c%7] = preg_replace('/[^[:print:]]/',"",trim($node->nodeValue));	
	$c++;
$countMatches++;
}

$countMatches = $countMatches/7;

$i = 0;
$filetmp = fopen($filenametmp, "w+");
rewind($filetmp);
for ($i = 0; $i < $countMatches; $i++) {
	$text = trim($matches[$i][1]).'||'.trim($matches[$i][2]).'||'.trim($matches[$i][3]).'||'.trim($matches[$i][4]).'||'.trim($matches[$i][5]).'||
';
	fwrite($filetmp, $text);
}
fclose($filetmp);



	rewind($file);
	fwrite($file, $i);

	$printString = "<style>
	html{
			font-family: verdana;

	}
	.lsf {
		border:1px dotted #C0C0C0;
		border-collapse:collapse;
		padding:5px;
		font-size:10pt; 
	}
	.lsf th {
		border:1px dotted #C0C0C0;
		padding:5px;
		background:#F0F0F0;
	}
	.lsf td {
		border:1px dotted #C0C0C0;
		padding:5px;
	}
</style>
<table class='lsf'>
	<caption>Notenspiegel</caption>
	<thead>
	<tr>
		<th>Fach</th>
		<th>Semester</th>
		<th>Note</th>
		<th>Status</th>
		<th>Credits</th>
			<th>Versuch</th>
	</tr>
	</thead>
	<tbody>
";


	$lastcolor = ""; 
	$r = 255; 
	$g = 225; 
	$b = 220; 
	
	for ($k = 0; $k < $i; $k++) {
	
	if ($lastcolor != $matches[$k][2]){
	
		$r = $r-(rand(0,3)*15);
		$g =  $g-(rand(0,3)*15);
		$b =  $b-(rand(0,3)*15);
		$lastcolor = $matches[$k][2];

	}
	$not = str_replace(",",".",$matches[$k][3]); 
	
	if ( $matches[$k][3] != "---"){
		if ( $not <= 4){
			$credits+= $matches[$k][5];	
			$note += ($not*$matches[$k][5]); 
		}
	}
	
	
		$printString .= '<tr style="background-color:rgb('.$r.','.$g.','.$b.');">
		<td>'.trim($matches[$k][1]).'
		</td>		<td>'.trim($matches[$k][2]).'
		</td>		<td>'.trim($matches[$k][3]).'
		</td>		<td>'.trim($matches[$k][4]).'
		</td>		<td>'.trim($matches[$k][5]).'
		</td>		<td>'.trim($matches[$k][6]).'
</td>
	</tr>
';


	}
		$printString .= "	</tbody>
</table><br><span style='		font-size:10pt; '>Schnitt: <b>".substr($note/$credits,0,strpos($note/$credits,".")+2)."</span></b>";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <'.$email.'>' . "\r\n";
if ($countLastScores != $i) {
// mail($email, "NEUE LSF-NOTEN", $printString,$headers);
}

fclose($file);

die($printString); 
?>