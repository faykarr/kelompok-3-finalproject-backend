<?php

$data = array('message' => 'Hello, how are you?');
$data_json = json_encode($data);


$ch = curl_init('http://localhost:5000/predict');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_json))
);

$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>