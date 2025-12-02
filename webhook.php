<?php
header("Content-Type: application/json");

// Leer JSON crudo enviado por Wasender
$raw = file_get_contents("php://input");
$data = json_decode($raw, true);

// Guardar en un log para ver si llega el webhook
file_put_contents("log.txt", "[".date("Y-m-d H:i:s")."] " . $raw . PHP_EOL, FILE_APPEND);

// Respuesta a Wasender
echo json_encode([
    "status" => "ok",
    "message" => "Webhook recibido correctamente",
    "data" => $data
]);
