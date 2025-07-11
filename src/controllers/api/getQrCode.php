<?php

include_once('../../../../../../init.php');
use WHMCS\Database\Capsule;

$instance_key = Capsule::table('sr_autonotify_for_whmcs')->first()->instance_key;
$token = 'gJY1xP/NX6KBZL0dorMVxrdBuyFBNsDwe+lQcJhlIHjhEpEXVR2r+wkNiQ==';
$host = 'nexus.sourei.com.br';
$url = "https://{$host}/rest/instance/qrcode_base64/{$instance_key}";
$headers = array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $token
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
$response = curl_exec($ch);
$responseDecode = json_decode($response, true);
$statusResponse = isset($responseDecode['error']) ? $responseDecode['error'] : null;
$messageResponse = isset($responseDecode['message']) ? $responseDecode['message']: null;
$qrCode = isset($responseDecode['qrcode']) ? $responseDecode['qrcode'] : null;
if ($qrCode) {
    echo $qrCode;
} elseif ($messageResponse == "User is already logged in"){
    echo "CONECTADO";
} else {
    echo "ERRO";
}
?>