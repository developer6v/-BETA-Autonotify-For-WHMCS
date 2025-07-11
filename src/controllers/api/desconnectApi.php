<?php
include_once('../../../../../../init.php');
use WHMCS\Database\Capsule;

$instance_key = Capsule::table('sr_autonotify_for_whmcs')->first()->instance_key;
$host = 'wpp.sourei.com.br';
$token = 'eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiV1BQIFNPVVJFSSJ9.ydKDUr3hpLYW_8v6nVQFMnU_oeU0D5P6i_Yc67tFVLQMPksg0IGdn7FsBDWiQDuNIbP_2PkPjfkMrqbIqoR07A';
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