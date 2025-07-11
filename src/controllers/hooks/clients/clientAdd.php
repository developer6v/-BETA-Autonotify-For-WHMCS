<?php
require_once __DIR__ . '/../../../services/api/sendWhatsapp.php';
use WHMCS\Database\Capsule;

function clientAdd ($vars) {
    $clientId = $vars['client_id'];
    clientAddClient($clientId);
    clientAddAdmin($clientId);
}


function clientAddClient ($clientId) {

    $acceptNotificationId = Capsule::table("tblcustomfields")->where("fieldname", "Aceita Notificações pelo WhatsApp? (Autonotify)")->value("id");
    $acceptNotification = Capsule::table("tblcustomfieldsvalues")->where("fieldid", $acceptNotificationId)->where("relid", $clientId)->value("value");
    
    // variaveis template
    $template = Capsule::table('sr_templates_for_whmcs')->where('messageType', 'Bem-vindo')->where('type', 'CLIENTE')->first();
    $template_status = $template->status;
    $message = $template->message;

    if ($acceptNotification == "Não" || $template_status == "INATIVO") {
        return;
    }

    // variaveis da mensagem
    $phone = Capsule::table('tblclients')->where("id","=", $clientId)->value("phonenumber");
    sendWhatsappMessage ($message, $phone, 'Bem-vindo', $clientId);
}



function clientAddAdmin ($clientId) {

    // variaveis template
    $template = Capsule::table('sr_templates_for_whmcs')->where('messageType', 'Novo Cliente')->where('type', 'ADMIN')->first();
    $template_status = $template->status;
    $message = $template->message;

    if ( $template_status == "INATIVO") {
        return;
    }

    // variaveis da mensagem
    global $CONFIG;
    $adminFolder = App::get_admin_folder_name();
    $adminUrl = $CONFIG['SystemURL'] . '/' . $adminFolder;
    $phone = Capsule::table('tblclients')->where("id","=", $clientId)->value("phonenumber");
    $phoneAdmin = Capsule::table('sr_autonotify_for_whmcs')->where("id","=", 1)->value("admin_phone");


    // definição da mensagem
    $message = str_replace (
        array(
            "{@urlClient}",
            "{@phone}"
        ),
        array (
            $adminUrl,
            $phone
        ),
        $message
    );

    sendWhatsappMessage ($message, $phoneAdmin, 'Novo Cliente', $clientId);
}
?>