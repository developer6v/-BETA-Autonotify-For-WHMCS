<?php

function getProfilePicture ($number, $instance_key) {
    $token = "eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiV1BQIFNPVVJFSSJ9.ydKDUr3hpLYW_8v6nVQFMnU_oeU0D5P6i_Yc67tFVLQMPksg0IGdn7FsBDWiQDuNIbP_2PkPjfkMrqbIqoR07A";
    $host = "wpp.sourei.com.br";
    $endpoint = "https://{$host}/rest/instance/getProfilePicture/{$instance_key}?to={$number}";
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
    $urlPicture = $responseDecode['data'];
    return ($urlPicture);
}

?>