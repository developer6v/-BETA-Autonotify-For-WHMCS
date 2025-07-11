<?php

use WHMCS\Database\Capsule;
function addToQueue ($instance_key, $message, $phone, $messageType, $clientName, $clientId) {
    // Dados Instância - API
    $token = "eyJhbGciOiJIUzUxMiIsInR5cCI6IkpXVCJ9.eyJuYW1lIjoiV1BQIFNPVVJFSSJ9.ydKDUr3hpLYW_8v6nVQFMnU_oeU0D5P6i_Yc67tFVLQMPksg0IGdn7FsBDWiQDuNIbP_2PkPjfkMrqbIqoR07A";
    $host = "wpp.sourei.com.br";

    // DADOS REQUISIÇJÃO - API
    $urlRequisição = "https://{$host}/rest/sendMessage/{$instance_key}/text";
    $headers = [
        "Authorization: Bearer {$token}",
        "Content-Type: application/json"
    ];

    $postFields = json_encode([
        "messageData" => [
            "to" => $phone,
            "text" => $message
        ]
    ]);

    // REQUISIÇÃO CURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlRequisição);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    $response = curl_exec($ch);
    $responseDecode = json_decode($response, true);
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
    }
    
    curl_close($ch);
    if (isset($error_msg)) {
        $response =  $error_msg;
    }
    $code = $responseDecode['error'] ?? $response;

    if ($code === "false" || $code === false) {
        $sendDate = date('d/m/Y H:i');
        Capsule::table("sr_relatory_for_whmcs")->insert([
            "type" => $messageType,
            "name" => $clientName,
            "clientId" => $clientId,
            "message" => $message,
            "sendDate" => $sendDate,
            "phone" => $phone
        ]);
    }
    return $response;
}

?>