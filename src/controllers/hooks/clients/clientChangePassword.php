<?php
require_once __DIR__ . '/../../../services/api/sendWhatsapp.php';
use WHMCS\Database\Capsule;

function clientChangePassword ($vars) {
 
    $userId = $vars['userid'];
    $clientId = Capsule::table('tblusers_clients')->where('id', '=', $userId)->value('client_id');
	$ipaddress =  $_SERVER['REMOTE_ADDR'];
    $phone = Capsule::table('tblclients')->where("id","=", $clientId)->value("phonenumber");
    $date = date("d/m/Y");
    $hour = date("H:i");

    // variaveis template
    $acceptNotificationId = Capsule::table("tblcustomfields")->where("fieldname", "Aceita Notificações pelo WhatsApp? (Autonotify)")->value("id");
    $acceptNotification = Capsule::table("tblcustomfieldsvalues")->where("fieldid", $acceptNotificationId)->where("relid", $clientId)->value("value");
    $template = Capsule::table('sr_templates_for_whmcs')->where('messageType', 'Troca de senha')->where('type', 'CLIENTE')->first();
    $template_status = $template->status;
    $message = $template->message;


    if ($acceptNotification == "Não" || $template_status == "INATIVO") {
        return;
    }
    // definição da mensagem
    $message = str_replace (
        array(
            "{@ipaddr}",
            "{@date}",
            "{@hour}"
        ),
        array (
            $ipaddress,
            $date,
            $hour
        ),
        $message
    );

    sendWhatsappMessage ($message, $phone, 'Troca de senha', $clientId);    
}

?>