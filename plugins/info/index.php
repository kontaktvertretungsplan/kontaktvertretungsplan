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

sendMessage($message['from']['id'], '*Info*
Kontakt:Vertretungsplan
von Clemens Riese

Bereitgestellt von:
'.$SETTINGS['provider:name'].'
_'.$SETTINGS['provider:address'].'_
'.$SETTINGS['provider:url'].'

Für:
'.$SETTINGS['school:name'].'
_'.$SETTINGS['school:address'].'_
'.$SETTINGS['school:url'].'
', [[["text" => "Haupmenü", "callback_data" => "/menu"]]]);