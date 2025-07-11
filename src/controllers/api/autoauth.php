<?php

$clientId = $_GET['clientId'] ?? null;
$page = $_GET['page'] ?? null;

if (!$clientId) {
    die("Parâmetros obrigatórios ausentes.");
}

switch ($page) {
    case "product_details":
        $serviceId = $_GET['serviceId'] ?? null;
        $destination = "clientarea:product_details";
        break;
    case "invoices":
        $destination = "clientarea:invoices";
        break;
    case "tickets":
        $destination = "clientarea:tickets";
        break;
    case "profile":
        $destination = "clientarea:profile";
        break;
    default:
        $destination = "clientarea:profile";
        break;
}
$schema = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http';
$domain = $_SERVER['HTTP_HOST'];
$website = $schema . "://" . $domain;
$ch = curl_init();

if (isset($serviceId)) {
    curl_setopt($ch, CURLOPT_URL, "{$website}/includes/api.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        http_build_query(
            array(
                'action' => 'CreateSsoToken',
                'username' => 'MK5HBqLPPzij9rdukdExIABrWrXcpRuA',
                'password' => 'jOWIh9r9oSQEmw3B9Be3gF2xJ6YD9RL2',
                'client_id' => $clientId,
                'accesskey' => 'souREI-padrao123###',
                'destination' => $destination,
                'service_id' => $serviceId,
                'responsetype' => 'json'
            )
        )
    );
} else {
    curl_setopt($ch, CURLOPT_URL, "{$website}/includes/api.php");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS,
        http_build_query(
            array(
                'action' => 'CreateSsoToken',
                'username' => 'MK5HBqLPPzij9rdukdExIABrWrXcpRuA',
                'password' => 'jOWIh9r9oSQEmw3B9Be3gF2xJ6YD9RL2',
                'client_id' => $clientId,
                'accesskey' => 'souREI-padrao123###',
                'destination' => $destination,
                'responsetype' => 'json'
            )
        )
    );
}

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);
$jsonResponse = json_decode($response, true);
$autologin = $jsonResponse['redirect_url'];
header("Location: $autologin");


?>