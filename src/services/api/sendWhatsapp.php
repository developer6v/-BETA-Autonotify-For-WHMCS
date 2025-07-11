<?php
use WHMCS\Database\Capsule;
function sendWhatsappMessage ($message, $phone, $messageType, $clientId) {

    // variaveis gerais
    $instance_key = 'autonotify-ef44ba7f26';
    $website = Capsule::table('tblconfiguration')->where("setting","=", "SystemURL")->value("value");
    $firstname = Capsule::table('tblclients')->where("id","=", $clientId)->value("firstname");
    $lastname = Capsule::table('tblclients')->where("id","=", $clientId)->value("lastname");
    $email = Capsule::table('tblclients')->where("id","=", $clientId)->value("email");
    $company = Capsule::table('tblconfiguration')->where('setting', 'CompanyName')->first()->value;
    $clientName = "{$firstname} {$lastname}";

    // definição da mensagem
    $message = str_replace (
        array(
            "{@clientid}",
            "{@firstname}",
            "{@lastname}",
            "{@email}",
            "{@company}",
            "{@website}",
            "{@autologin}",
        ),
        array (
            $clientId,
            $firstname,
            $lastname,
            $email,
            $company,
            $website,
            $website
        ),
        $message
    );

    $system_status = Capsule::table('sr_autonotify_for_whmcs')->where("id", "=", 1)->value('system_status');
    if ($system_status != "Ativado") {
       return;
    } 

    $message .= "\n\nclient id:". $clientId;


    // Dados Instância - API
    $messages = explode("{@break}", $message); 
    $token = 'gJY1xP/NX6KBZL0dorMVxrdBuyFBNsDwe+lQcJhlIHjhEpEXVR2r+wkNiQ==';
    $host = "nexus.sourei.com.br";

    // DADOS REQUISIÇJÃO - API
    $urlRequisição = "https://{$host}/api/v1/message/text";
    $headers = [
        "x-user-secret:{$token}",
        "Content-Type: application/json"
    ];
    foreach ($messages as $message ) {
        $postFields = json_encode([
            "to" => 5535910173430,
            "message" => $message
            
        ]);
        // REQUISIÇÃO CURL
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlRequisição);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $response = curl_exec($ch);
    }

    $responseDecode = json_decode($response, true);
    if (curl_errno($ch)) {
        $error_msg = curl_error($ch);
    }
    
    curl_close($ch);
    if (isset($error_msg)) {
        $response =  $error_msg;
    }
    $code = $responseDecode['error'] ?? $response;

    //if ($code === "false" || $code === false) {
        $sendDate = date('d/m/Y H:i');
        Capsule::table("sr_relatory_for_whmcs")->insert([
            "type" => $messageType,
            "name" => $clientName,
            "clientId" => $clientId,
            "message" => $message,
            "sendDate" => $sendDate,
            "phone" => 35999309701
        ]);
    //}
    return $response;
}

?>