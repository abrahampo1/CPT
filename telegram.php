<?php
include("config.php");
$api_telegram = $config["api_telegram"];
$update = json_decode(file_get_contents("php://input"), TRUE);
$path = "https://api.telegram.org/bot" . $api_telegram;
$message = "";
$chatId = "";
$chatId = $update["message"]["chat"]["id"];
$message = $update["message"]["text"];
$nombre_telegram = $update["message"]["chat"]["first_name"];
$apellido_telegram = $update["message"]["chat"]["last_name"];

$texto = "¡Hola $nombre_telegram! Soy un bot creado por Abraham Leiro Fernandez, dispuesto a hacer la gestión mucho mas sencilla.";
file_get_contents($path . "/sendmessage?chat_id=" . $chatId . "&text=" . $texto);