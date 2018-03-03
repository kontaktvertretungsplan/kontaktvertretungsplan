# Kontakt:Vertretungsplan
Kontakt:Vertretungsplan ist ein Telegram Bot geschrieben in PHP.

Entwickelt und bertreut wird das Projekt von [Clemens Riese](https://milchinsel.de) für JugendForscht.

Weitere Infos:
https://kontakt-vertretungsplan.de

## Installation
Vorraussetzungen für den Webserver:
* Apache
* PHP (getestet unter PHP 7.1)
* MySQL (gestestet unter MariaDB 10.1)
* HTTPS

Lade dir die aktuellste Version von Kontakt:Vertretungsplan von der [Release Seite](https://github.com/kontaktvertretungsplan/kontaktvertretungsplan/releases) herunter und entpacke sie im Webverzeichnis deiner Wahl.

Passe die Datei `config/db.json` mit deinen Datenbank Einstellungen an.

Navigiere nun mit einem Browser in dein Webverzeichnis und dort zur Datei `install.php` (`https://deine.domain/dein_verzeichnis/install.php`). Folge den Anweisungen und fülle das Formular aus. (Formularfelder, die nach dem Speichern nicht verschwinden enthielten ungültige Werte)

Sind alle Daten korrekt und gespeichert, starte nun den Telegram Bot.

Klicke im Installer auf weiter und dein Name wird erscheinen, mache dich zu Administrator.

Die Installation ist nun beendet, jedoch müssen noch Cronjobs für automatische Aktualisierungen aktiviert werden.

Du kannst die Datei `install.php` nun löschen.

### Telegram Bot Token
Dieser ist essentiell für die Verwendung von Kontakt:Vertretungsplan, wie dieser generiert wird, ist bei Telegram Dokumentiert:

https://core.telegram.org/bots#6-botfather

### Api Urls
Diese sind die API Endpunkte für den Zugriff auf die Stundenpläne.

Die Kontakt:Vertretungsplan API ist gesondert dokumentiert.

https://github.com/kontaktvertretungsplan/api#kontaktvertretungsplan-daten-api

## Noch Fragen?
Einfach melden:
* E-Mail: hallo@kontakt-vertretungsplan.de
* Twitter: [@kvertretung](https://twitter.com/kvertretung)
* Instagram: [@kontaktvertretungsplan](https://instagram.com/kontaktvertretungsplan)
