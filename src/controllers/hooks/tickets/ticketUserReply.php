<?php

function ticketUserReply ($vars) {
    global $CONFIG;
    $adminFolder = App::get_admin_folder_name();
    $adminUrl = $CONFIG['SystemURL'] . '/' . $adminFolder;
    // DADOS CLIENTE E TICKET
    $ticketId = $vars['ticketid'];
    $clientId =$vars['userid'];
    $ticketTitle = Capsule::table('tbltickets')->where("id", "=", $ticketId)->value("title");
    // DADOS MÓDULO E TEMPLATES
    $system_status = Capsule::table('sr_autonotify_for_whmcs')->where("id", "=", 1)->value('system_status');
    $templates_status = Capsule::table('sr_templates_for_whmcs')->where("id", "=", 17)->value("status");

    // VERIFICA SE O ENVIO DE MENSAGENS ESTA ATIVADO
    if ($system_status == "Ativado" && $templates_status == "ATIVO") {
        $varSetMessage = [
            "clientId" => $clientId,
            "templateId" => 17,
            "ticketTitle" => $ticketTitle,
            "ticketId" => $ticketId,
            "adminUrl" => $adminUrl
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