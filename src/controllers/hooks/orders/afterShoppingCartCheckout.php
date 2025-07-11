<?php

function afterShoppingCartCheckout ($vars) {
    // service id e client id
    $orderId = $vars['OrderID'];
    $order = Capsule::table('tblorders')->where('id', $orderId)->first();
    $clientId =$order->userid;
    
    $system_status = Capsule::table('sr_autonotify_for_whmcs')->where("id", "=", 1)->value('system_status');
    $templates_status = Capsule::table('sr_templates_for_whmcs')->where("id", "=", 6)->value("status");

    // verifica se o módulo esta ativo
    if ($system_status == "Ativado" && $templates_status == "ATIVO") {
        $orderServices = Capsule::table('tblhosting')
        ->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')
        ->where('tblhosting.orderid', $orderId)
        ->get(['tblhosting.*', 'tblproducts.name as productName']);

        foreach ($orderServices as $item) {
            $serviceId = $item->id; 
            $varSetMessage = [
                "clientId" => $clientId,
                "templateId" => 6,
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

    // Novo pedido - ADMIN
    $templates_status = Capsule::table('sr_templates_for_whmcs')->where("id", "=", 21)->value("status");
    if ($templates_status == 'ATIVO') {
        $varSetMessage = [
            "clientId" => $clientId,
            "templateId" => 21,
            "orderId" => $orderId
        ];
        $varsSendMessage = setMessage($varSetMessage);

        $message = $varsSendMessage['message'];
        $instance_key['instance_key'];
        $phone = $varsSendMessage['phone'];
        $messageType = $varsSendMessage['messageType'];
        $clientName = $varsSendMessage['clientName'];
        $sendWhatsappMessage = sendWhatsappMessage($instance_key, $message, $phone, $messageType, $clientName, $clientId);
    }
}

?>