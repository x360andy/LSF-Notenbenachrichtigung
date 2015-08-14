# LSF-Notenbenarichtigung

Das LSF (Lehre Studium Forschung) dient für viele Hochschulen als Kurs- und Notenverteilung.
Leider besitzt es keine Benachrichtigungsfunktion für neu eingetragene Noten.

Dieses Script ermöglicht und erweitert genau dieseBenachrichtigungsfunktion.

Screenshot und weitere Informationen unter http://rauscher.media/de/projekte/lsf-notenbenarichtigung

Das Script besteht aus drei Dateien.

Die saveCount.txt und tmpSave.txt beinhalten das Ergebnis des letzten Aufrufes und reduzieren den Traffic zum LSF.
Beide Dateien sollten 777 (chmod) Rechte erhalten (Lese-, Schreibrechte sind mindestens notwendig).
Die einzige Datei, die angepasst werden muss, ist die config.php.
Diese beinhaltet euer LSF-Passwort, den LSF-Loginname (Matrikelnummer) und eine E-Mail-Adresse, an die die Benachrichtigungen für neue Noten gesendet werden.
Das Hauptscript selbst befindet sich in der index.php. Diese stellt eine Verbindung (connector.php) mit der PHP eigenen Funktion Curl zum LSF her und liest die entsprechenden Daten aus.

Dies beinhaltet:
- Login in das LSF
- Ermittelung der ASI-ID über reguläre Ausdrücke
- Aufruf der Notenseite mithilfe der ermittelten ASI
- Parsen der Noten in ein Array
- Speichern der Notenanzahl in der saveCount.txt
- Speichern der genauen Daten in der tmpSave.txt


Sollte eine neue Note eingetragen worden sein, wird eine E-Mail mit den neu eingetragenen Noten versandt.

Dieser gesamte Vorgang erspart das Einloggen in das LSF und das manuelle Aufrufen der Notenübersicht.
Möchte man die Funktion des Scriptes und die damit verbundenen E-Mail-Funktion automatisieren, ist es notwendig einen Cronjob anzulegen, der die Datei index.php regelmäßig aufruft.

Cronjob-Beispiel unter Debian:
crontab -e [zum Bearbeiten der Crontab-Liste]
Dort folgende Code-Zeile ergänzen:
0,5,10,15,20,25,30,35,40,45,50,55 * * * * wget --spider "www.domain.de/ordner/LSF-Notenbenarichtigung/index.php"
Damit würde das Script alle 5 Minuten aufgerufen werden. 
Das kann natürlich entsprechend angepasst werden.
Weitere Informationen zu Cronjobs sind hier zu finden:

http://unixhelp.ed.ac.uk/CGI/man-cgi?crontab+5

http://de.wikipedia.org/wiki/Cron



Wer dazu nicht die Möglichkeit hat, kann auch über diverse Internet-Dienste Cronjobs erzeugen, die die index.php in selber Art und Weise aufrufen.
Unter http://www.cronjob.de/ ist dies beispielsweise möglich.

Veröffentlicht unter hadizadeh.de - angepasst und allgemein optimier hier, für die Hochschule Weingarten
