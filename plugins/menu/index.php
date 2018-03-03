<?php
/*
*==============================================================*
* |\      /| | |     /---- |    | | |\   | /----\ |---- |      *
* | \    / | | |     |     |    | | | \  | |      |     |      *
* |  \  /  | | |     |     |----| | |  \ | \----\ |---- |      *
* |   \/   | | |     |     |    | | |   \|      | |     |      *
* |        | | |---- \---- |    | | |    | \----/ |---- |----- *
*==============================================================*
*        Written by Clemens Riese (c)milchinsel.de 2018        *
*==============================================================*

Kontakt:Vertretungsplan Telegram Bot

PLUGIN
*/

sendMessage($message['from']['id'], '*Hauptmenü*
Alle Befehle auf einem Blick
', [[["text" => "Stundenplan", "callback_data" => "/stundenplan"]],[["text" => "Einstellungen", "callback_data" => "/settings"]], [["text" => "Info", "callback_data" => "/help"]]]);