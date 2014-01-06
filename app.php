<?php
require 'Predis/Autoloader.php';
Predis\Autoloader::register();
date_default_timezone_set('America/Denver');

function getNotes($redisId) {
    $client = new Predis\Client();
    $notes = $client->get($redisId);
    return array(
        'notes' => json_decode($notes, true),
    );
}

function createNote($note, $redisId) {
    $client = new Predis\Client();
    $notes = json_decode($client->get($redisId));
    if (!is_array($notes)) {
        $notes = array();
    }
    $newNote = array(
        'time' => date('Y/m/d H:i:s'),
        'text' => $note,
        'id' => count($notes) + 1
    );
    array_push($notes,$newNote);
    $client->set($redisId, json_encode($notes));
    return $newNote;
}

if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['userInput'] && $_POST['userInput'] != '') {
        echo json_encode(createNote($_POST['userInput'], 'notes'));
    }
    else {
        // Invalid request
    }
}
else if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'GET') {
    echo json_encode(getNotes('notes'));
}