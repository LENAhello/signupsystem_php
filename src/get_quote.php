<?php

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://zenquotes.io/api/random");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

header('Content-Type: application/json');

if ($data && isset($data[0]['q'])) {
    echo json_encode([
        'quote' => $data[0]['q'],
        'author' => $data[0]['a']
    ]);
} else {
    echo json_encode(['error' => 'Could not fetch quote']);
}
