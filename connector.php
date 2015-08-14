<?php
class curl
{
         function __construct($use = 1)
         {
         $this->ch = curl_init();
                 if($use = 1)
                 {
                         curl_setopt ($this->ch, CURLOPT_POST, 1);
                         curl_setopt ($this->ch, CURLOPT_COOKIEJAR, 'cookie.txt');
                         curl_setopt ($this->ch, CURLOPT_FOLLOWLOCATION, 1);
                         curl_setopt ($this->ch, CURLOPT_RETURNTRANSFER, 1);

                 }
         }
         function first_connect($loginform,$logindata)
         {
                 curl_setopt($this->ch, CURLOPT_URL, $loginform);
                 curl_setopt ($this->ch, CURLOPT_POSTFIELDS, $logindata);
         }
         function store()
         {
                 $store = curl_exec ($this->ch);
         }
         function execute($page)
         {
                 curl_setopt($this->ch, CURLOPT_URL, $page);
                 $this->content = curl_exec ($this->ch);
         }
         function close()
         {
                 curl_close ($this->ch);
         }

         function __toString()
         {
         return $this->content;
         }
}

$content = new curl();
$content->first_connect('https://www.lsf.hs-weingarten.de/qisserver/servlet/de.his.servlet.RequestDispatcherServlet?state=user&type=1','action=dologin&username='.$username.'&password='.$password.'&submit=Jetzt+einloggen'); 
$content->store();
$content->execute('https://www.lsf.hs-weingarten.de/qisserver/servlet/de.his.servlet.RequestDispatcherServlet?state=user&type=0&category=menu.browse&breadCrumbSource=&startpage=portal.vm');
$countMatches = preg_match_all('%asi=(.*?)\"%s', $content, $matches, PREG_SET_ORDER);


?>