LSF Noten Checker (Automatische Noten-Benachrichtigung)


Das LSF (Lehre Studium Forschung) dient f�r viele Hochschulen als Kurs- und Notenverteilung.
Leider besitzt es keine Benachrichtigungsfunktion f�r neu eingetragene Noten.
Alexander Czyrny und ich (David Hadizadeh) haben uns heute die Aufgabe gestellt, diese Funktion unabh�ngig vom LSF zu realisieren.
Den Code dazu wollen wir hier ver�ffentlichen.
Der LSF Noten Checker besteht aus f�nf Dateien.
Die saveCount.txt und tmpSave.txt beinhalten das Ergebnis des letzten Aufrufes und reduzieren den Traffic zum LSF.
Beide Dateien sollten 777 (chmod) Rechte erhalten (Lese-, Schreibrechte sind mindestens notwendig).
Die einzige Datei, die angepasst werden muss, ist die config.php.
Diese beinhaltet euer LSF-Passwort, den LSF-Loginname (Matrikelnummer) und eine E-Mail-Adresse, an die die Benachrichtigungen f�r neue Noten gesendet werden.
Das Hauptscript selbst befindet sich in der lsf_reader.php. Diese stellt eine Verbindung mit der PHP eigenen Funktion Curl zum LSF her und liest die entsprechenden Daten aus.

Dies beinhaltet:
- Login in das LSF
- Ermittelung der ASI-ID �ber regul�re Ausdr�cke
- Aufruf der Notenseite mithilfe der ermittelten ASI
- Parsen der Noten in ein Array
- Speichern der Notenanzahl in der saveCount.txt
- Speichern der genauen Daten in der tmpSave.txt


Sollte eine neue Note eingetragen worden sein, wird eine E-Mail mit den neu eingetragenen Noten versandt.
Um die aktuellen Noten formatiert zu sehen ruft man einfach die index.php auf.
Dieser gesamte Vorgang erspart das Einloggen in das LSF und das manuelle Aufrufen der Noten�bersicht.
M�chte man die Funktion des Scriptes und die damit verbundenen E-Mail-Funktion automatisieren, ist es notwendig einen Cronjob anzulegen, der die Datei lsf_reader.php regelm��ig aufruft.

Cronjob-Beispiel unter Debian:
crontab -e [zum Bearbeiten der Crontab-Liste]
Dort folgende Code-Zeile erg�nzen:
0,5,10,15,20,25,30,35,40,45,50,55 * * * * wget --spider "www.domain.de/ordner/LSF-Noten-Checker/lsf_reader.php"
Damit w�rde das Script alle 5 Minuten aufgerufen werden. Das kann nat�rlich entsprechend angepasst werden.
Weitere Informationen zu Cronjobs sind hier zu finden:
http://unixhelp.ed.ac.uk/CGI/man-cgi?crontab+5
http://de.wikipedia.org/wiki/Cron


Wer dazu nicht die M�glichkeit hat, kann auch �ber diverse Internet-Dienste Cronjobs erzeugen, die die lsf_reader.php in selber Art und Weise aufrufen.
Unter http://www.cronjob.de/ ist dies beispielsweise m�glich.

Den Code findet ihr hier als gepacktes Zip-Paket. Bei Fragen einfach eine Mail schreiben oder den News-Eintrag kommentieren.

http://hadizadeh.de/downloadcenter/downloaddetails/?id=5
