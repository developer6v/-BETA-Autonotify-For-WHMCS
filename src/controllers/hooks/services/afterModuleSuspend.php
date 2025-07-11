<?php

function afterModuleSuspend ($vars) {
    // service id e client id
    $clientId =$vars['params']['userid'];
        $serviceId = $vars['params']['serviceid'];
    // opções do modulo
    $system_status = Capsule::table('sr_autonotify_for_whmcs')->where("id", "=", 1)->value('system_status');
    $templates_status = Capsule::table('sr_templates_for_whmcs')->where("id", "=", 7)->value("status");

    // verifica se o módulo esta ativo
    if ($system_status == "Ativado" && $templates_status == "ATIVO") {
        $varSetMessage = [
            "clientId" => $clientId,
            "templateId" => 7,
            "serviceId" =>$serviceId
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