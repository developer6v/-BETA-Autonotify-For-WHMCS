<?php

function ticketAdminReply ($vars) {
    // DADOS CLIENTE E TICKET
    $ticketId = $vars['ticketid'];
    $ticketTitle = $vars['subject'];
    $clientId =Capsule::table('tbltickets')->where("id","=", $ticketId)->value("userid");
        // DADOS MÓDULO E TEMPLATES
    $system_status = Capsule::table('sr_autonotify_for_whmcs')->where("id", "=", 1)->value('system_status');
    $templates_status = Capsule::table('sr_templates_for_whmcs')->where("id", "=", 5)->value("status");

    // VERIFICA SE O ENVIO DE MENSAGENS ESTA ATIVADO
    if ($system_status == "Ativado" && $templates_status == "ATIVO") {
        $varSetMessage = [
            "clientId" => $clientId,
            "templateId" => 5,
            "ticketTitle" => $ticketTitle,
            "ticketId" => $ticketId
        ];
        $varsSendMessage = setMessage($varSetMessage);

        // variaveis para fazer a requisição
        $message = $varsSendMessage['message'];
        $instance_key = $varsSendMessage['instance_key'];
        $phone = $varsSendMessage['phone'];
        $messageType = $varsSendMessage['messageType'];
        $clientName = $varsSendMessage['clientName'];
        $sendWhatsappMessage = sendWhatsappMessage ($instance_key, $message, $phone, $messageType, $clientName, $clientId);
    }
}

?>