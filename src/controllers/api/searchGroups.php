<?php
include_once('../../../../../../init.php');
use WHMCS\Database\Capsule;
$instance_key = Capsule::table('sr_autonotify_for_whmcs')->first()->instance_key;

$token = "eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiV1BQIFNPVVJFSSJ9.ydKDUr3hpLYW_8v6nVQFMnU_oeU0D5P6i_Yc67tFVLQMPksg0IGdn7FsBDWiQDuNIbP_2PkPjfkMrqbIqoR07A";
$host = "wpp.sourei.com.br";
$endpoint = "https://{$host}/rest/group/list/{$instance_key}";
$headers = array (
    'Content-Type: application/json',
    'Authorization: Bearer '. $token
);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_TIMEOUT, 60);
$response = curl_exec($ch);
$responseDecode = json_decode($response, true);
$grupos  = [];
foreach ($responseDecode['groups'] as $group) {
    $grupos[] = array (
        'id' => $group['id'],
        'title' => $group['subject']
    );
}
echo json_encode($grupos);

?>