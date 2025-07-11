<?php
include_once('../../../../../../init.php');
use WHMCS\Database\Capsule;

$instance_key = Capsule::table('sr_autonotify_for_whmcs')->first()->instance_key;
$host = 'nexus.sourei.com.br';
$token = 'gJY1xP/NX6KBZL0dorMVxrdBuyFBNsDwe+lQcJhlIHjhEpEXVR2r+wkNiQ==';
$url = "https://{$host}/rest/instance/{$instance_key}/logout";
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
   "Authorization: Bearer " . $token,
]);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Erro';
} else {
    echo 'Executou';
}
curl_close($ch);