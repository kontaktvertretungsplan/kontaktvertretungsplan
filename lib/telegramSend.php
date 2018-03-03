<?php
/*
*==============================================================*
* |\      /| | |     /---- |    | | |\   | /----\ |---- |      *
* | \    / | | |     |     |    | | | \  | |      |     |      *
* |  \  /  | | |     |     |----| | |  \ | \----\ |---- |      *
* |   \/   | | |     |     |    | | |   \|      | |     |      *
* |        | | |---- \---- |    | | |    | \----/ |---- |----- *
*==============================================================*
*        Written by Clemens Riese (c)miclhinsel.de 2018        *
*==============================================================*

Kontakt:Vertretungsplan Telegram Bot

Bibliothek, die verschiedene Sendemöglichkeiten für Telegram Nachrichten bietet 

Funktionen:
answerCallbackQuery
sendMessage
forwardMessage
sendPhoto
sendAudio
sendDocument
sendSticker
sendVideo
sendVoice
sendLocation
sendVenue
sendContact
*/

function telegramGo($method, $post) {
	global $SETTINGS;
	$bot_token = $SETTINGS['telegram:token'];
	$host = "api.telegram.org";
	$APIurl = "https://".$host."/bot".$bot_token."/";
	
	$ch = curl_init($APIurl.$method);
	curl_setopt_array($ch, array(
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_HEADER => false,
		CURLOPT_HTTPHEADER => array('Host: '.$host, 'Content-Type: multipart/form-data'),
		CURLOPT_POSTFIELDS => $post,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_CONNECTTIMEOUT => 6000,
		CURLOPT_SSL_VERIFYPEER => false,
	));
	curl_exec($ch);
	
	return true;
}

function create_keyboard($keys) {
	if($keys != "") {
		return '{"inline_keyboard": '. json_encode($keys).'}';
	}
}

// answerCallbackQuery (https://core.telegram.org/bots/api#answerCallbackQuery)
function answerCallbackQuery($query_id) {
	telegramGo("answerCallbackQuery", [
		'callback_query_id' => $query_id
		]
	);
}

// sendMessage (https://core.telegram.org/bots/api#sendmessage)
function sendMessage($chat_id, $text, $keys = "", $silent = false) {
	telegramGo("sendMessage", [
		'chat_id' => $chat_id,
		'text' => $text,
		'parse_mode' => 'Markdown',
		'reply_markup' => create_keyboard($keys),
		'disable_notification' => $silent
		]
	);
}

// forwardMessage (https://core.telegram.org/bots/api#forwardmessage)
function forwardMessage($chat_id, $from_chat_id, $message_id) {
	telegramGo("forwardMessage", [
		'chat_id' => $chat_id,
		'from_chat_id' => $from_chat_id,
		'message_id' => $message_id
		]
	);
}

// sendPhoto (https://core.telegram.org/bots/api#sendphoto)
function sendPhoto($chat_id, $photo, $caption = "") {
	$mimetype = mime_content_type($photo);
	$photo = new CurlFile($photo, $mimetype);
	
	telegramGo("sendPhoto", [
		'chat_id' => $chat_id,
		'photo' => $photo,
		'caption' => $caption
		]
	);
}

// sendAudio (https://core.telegram.org/bots/api#sendaudio)
function sendAudio($chat_id, $audio, $caption = "") {
	$mimetype = mime_content_type($audio);
	$audio = new CurlFile($audio, $mimetype);
	
	telegramGo("sendAudio", [
		'chat_id' => $chat_id,
		'audio' => $audio,
		'caption' => $caption
		]
	);
}

// sendDocument (https://core.telegram.org/bots/api#senddocument)
function sendDocument($chat_id, $document, $caption = "") {
	$mimetype = mime_content_type($document);
	$document = new CurlFile($document, $mimetype);
	
	telegramGo("sendDocument", [
			'chat_id' => $chat_id,
			'document' => $document,
			'caption' => $caption
		]
	);
}

// sendSticker (https://core.telegram.org/bots/api#sendsticker)
function sendSticker($chat_id, $sticker) {
	$mimetype = mime_content_type($sticker);
	$sticker = new CurlFile($sticker, $mimetype);
	
	telegramGo("sendSticker", [
			'chat_id' => $chat_id,
			'sticker' => $sticker
		]
	);
}

// sendVideo (https://core.telegram.org/bots/api#sendvideo)
function sendVideo($chat_id, $video, $caption = "") {
	$mimetype = mime_content_type($video);
	$video = new CurlFile($video, $mimetype);
	
	telegramGo("sendVideo", [
			'chat_id' => $chat_id,
			'video' => $video,
			'caption' => $caption
		]
	);
}

// sendVoice (https://core.telegram.org/bots/api#sendvoice)
function sendVoice($chat_id, $voice, $caption = "") {
	$mimetype = mime_content_type($voice);
	$voice = new CurlFile($voice, $mimetype);
	
	telegramGo("sendVoice", [
			'chat_id' => $chat_id,
			'voice' => $voice,
			'caption' => $caption
		]
	);
}

// sendLocation (https://core.telegram.org/bots/api#sendlocation)
function sendLocation($chat_id, $latitude, $longitude) {
	telegramGo("sendLocation", [
			'chat_id' => $chat_id,
			'latitude' => $latitude,
			'longitude' => $longitude
		]
	);
}

// sendVenue (https://core.telegram.org/bots/api#sendvenue)
function sendVenue($chat_id, $latitude, $longitude, $title, $address) {
	telegramGo("sendVenue", [
			'chat_id' => $chat_id,
			'latitude' => $latitude,
			'longitude' => $longitude,
			'title' => $title,
			'address' => $address
		]
	);
}

// sendContact (https://core.telegram.org/bots/api#sendcontact)
function sendContact($chat_id, $phone_number, $first_name, $last_name = "") {
	telegramGo("sendContact", [
			'chat_id' => $chat_id,
			'phone_number' => $phone_number,
			'first_name' => $first_name,
			'last_name' => $last_name
		]
	);
}
?>