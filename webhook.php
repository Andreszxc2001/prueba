<?php
// -------------------------------
// LEER JSON DEL WEBHOOK
// -------------------------------
$rawData = file_get_contents("php://input");

// -------------------------------
// CONFIG SUPABASE
// -------------------------------
$supabaseKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVicnd3aGptenlnaXJ5ZW1ubWNkIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTYxODQxNTYsImV4cCI6MjA3MTc2MDE1Nn0.yZ7MntkA_WUvjFYNyeOUNjOzKYzV9PxiF2jxejP-bCI";
$bucket      = "imagenes_posts";

// TUS URLs
$url_supabasev1 = 'https://ebrwwhjmzygiryemnmcd.supabase.co/rest/v1';
$url_supabasev2 = 'https://ebrwwhjmzygiryemnmcd.supabase.co/storage/v1/object';

// Nombre del archivo JSON en el bucket
$filename = "mensaje_" . time() . ".json";

// URL final para subir archivo
$uploadUrl = "$url_supabasev2/$bucket/$filename";

// -------------------------------
// SUBIR A STORAGE
// -------------------------------
$ch = curl_init($uploadUrl);

curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $supabaseKey",
    "apikey: $supabaseKey"
]);

curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $rawData);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$status   = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

// -------------------------------
// RESPUESTA DEL SERVIDOR
// -------------------------------
if ($status === 200) {
    echo "OK - JSON guardado en Supabase Storage";
} else {
    echo "ERROR ($status)\n";
    echo $response;
}
?>
