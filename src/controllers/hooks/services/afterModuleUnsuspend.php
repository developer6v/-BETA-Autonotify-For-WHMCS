<?php

function afterModuleUnsuspend ($vars) {
    $clientId =$vars['params']['userid'];
    $serviceId = $vars['params']['serviceid']; 
  
    // DADOS MÓDULO E TEMPLATES
    $system_status = Capsule::table('sr_autonotify_for_whmcs')->where("id", "=", 1)->value('system_status');
    $templates_status = Capsule::table('sr_templates_for_whmcs')->where("id", "=", 8)->value("status");
    // VERIFICA SE O ENVIO DE MENSAGENS ESTA ATIVADO
    if ($system_status == "Ativado" && $templates_status == "ATIVO") {
        $varSetMessage = [
            "clientId" => $clientId,
            "templateId" => 8,
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