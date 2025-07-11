<?php


function soureiGetStatusData($instance_key) {
    $token = 'gJY1xP/NX6KBZL0dorMVxrdBuyFBNsDwe+lQcJhlIHjhEpEXVR2r+wkNiQ==';
    $host = 'nexus.sourei.com.br';
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
    );

    // REQUISIÇÃO CONEXÃO
    $urlConnection = "https://{$host}/rest/instance/qrcode_base64/{$instance_key}";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlConnection);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $response = curl_exec($ch);
    $responseDecode = json_decode($response, true);
    $statusResponse = isset($responseDecode['error']) ? $responseDecode['error'] : null;
    $messageResponse = isset($responseDecode['message']) ? $responseDecode['message']: null;
    if ($messageResponse == "User is already logged in"){
        $connectionStatus = "Conectado";
    } elseif (strpos($response, "image")) {
        $connectionStatus = "Desconectado";
    } else {
        $connectionStatus = $messageResponse;
    }

    //REQUISIÇÃO INSTANCIA
    $urlApi = "https://{$host}/rest/instance/{$instance_key}";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlApi);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_TIMEOUT, 60);
    $response = curl_exec($ch);
    $responseDecode = json_decode($response, true);
    $statusResponse = isset($responseDecode['error']) ? $responseDecode['error'] : null;
    $messageResponse = isset($responseDecode['message']) ? $responseDecode['message']: null;
    if ($messageResponse == "Instance data fetched"){
        $apiStatus = "Ativo";
    } elseif ($messageResponse ==  "Instance not found") {
        $apiStatus = "Inativo";
    } else {
        $apiStatus = $messageResponse;
    }

    $numberConnected = $responseDecode['instance']['user']['id'] ?? "Desconectado";

    $response = [
        'connection' => $connectionStatus,
        'api' => $apiStatus,
        'numberConnected' => $numberConnected
    ];

    return ($response);
}
?>