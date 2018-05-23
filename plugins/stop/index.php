<?php

// Holen der Nutzerinformationen
$statement = $PDO->prepare("SELECT ID, role from user WHERE telegram = ?");
if (!$statement->execute([$message["from"]["id"]])) {
    sendMessage($message['from']['id'], '*ERROR*\nEtwas ging schief.');
    return;
}
// Prüfen ob nutzer überhaupt existiert
$rowCount = $statement->rowCount();
if ($rowCount !== 1) {
    // Wenn nutzer nicht existiert sende Nachricht & breche ab
    sendMessage($message['from']['id'], '*ERROR*
Du bist entweder kein Nutzer mehr oder warst nie einer.');
    logIt($message["from"]["id"], "bot", "stop", "failed", "User not found
rowCount = " . $rowCount);
    return;
}

$row = $statement->fetch();

// Prüfen ob rollen nicht leer sind
if (strlen($row['role']) > 4) {
    $role = json_decode($row["role"]);
    // Wennn nutzer Admin ist verweigere löschung und informiere Nutzer
    if (is_array($role) && array_search("admin", $role) !== false) {
        sendMessage($message['from']['id'], '*ERROR*
Als Admin kannst du dich leider nicht löschen. Entferne im Webinterface zuerst die Rolle!',
        [[["text" => "Benutzerverwaltung", "url" => $SETTINGS['url'] . "?p=admin:user-edit&id=" . $row["id"]]]]);
        logIt($message["from"]["id"], "bot", "stop", "failed", "User is Admin");
        return;
    }
}

// Lösche Nutzereintrag aus user, aus den logs, aus den Sessions und von subscriptions
sendMessage($message['from']['id'], 'Deine daten werden nun gelöscht...');
statement = $PDO->prepare("DELETE FROM `user` WHERE `telegram` = ?");
$statement->execute([$message["from"]["id"]]);
$statement = $PDO->prepare("DELETE FROM `log` WHERE `user` = :telegramId OR `notice` = :noticeTelegramId");
$statement->bindParam(":telegramId", );
$userIdWildcard = "%" . $message["from"]["id"] . "%";
$statement->execute([$message["from"]["id"], $userIdWildcard]);
$statement = $PDO->prepare("DELETE FROM `session` WHERE `user` = ?");
$statement->execute([$row["id"]]);
$statement = $PDO->prepare("DELETE FROM `subscription` WHERE `user` = ?");
$statement->execute([$row["id"]]);
sendMessage($message['from']['id'], '*Löschen Erfolgreich*
Auf wiedersehen');
logIt($message["from"]["id"], "bot", "stop", "ok", "Erfolgreich");
