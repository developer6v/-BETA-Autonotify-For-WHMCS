<?php

function orderPaid ($vars) {
    $orderId = $vars['orderId'];
    $order = Capsule::table('tblorders')->where('id', $orderId)->first();
    $clientId = $order->userid;
    $system_status = Capsule::table('sr_autonotify_for_whmcs')->where("id", "=", 1)->value('system_status');
    $templates_status = Capsule::table('sr_templates_for_whmcs')->where("id", "=", 22)->value("status");
    if ($system_status == "Ativado" && $templates_status == "ATIVO") {
        $varSetMessage = [
            "clientId" => $clientId,
            "templateId" => 22,
            "orderId" => $orderId
        ];
        $varsSendMessage = setMessage($varSetMessage);

        $message = $varsSendMessage['message'];
        $instance_key= $varsSendMessage['instance_key'];
        $phone = $varsSendMessage['phone'];
        $messageType = $varsSendMessage['messageType'];
        $clientName = $varsSendMessage['clientName'];
        $sendWhatsappMessage = sendWhatsappMessage($instance_key, $message, $phone, $messageType, $clientName, $clientId);
    }
}


?>