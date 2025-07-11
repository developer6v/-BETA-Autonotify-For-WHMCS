<?php

function afterRegistrarRegistration ($params) {
    $vars = $params['params'];
    $userId = $vars['userid'];
    $clientId = Capsule::table('tblusers_clients')->where('id', '=', $userId)->value('client_id');
    $phoneAdmin = Capsule::table('sr_autonotify_for_whmcs')->where("id","=", 1)->value("admin_phone");

    // variaveis template
    $template = Capsule::table('sr_templates_for_whmcs')->where('messageType', 'Registro de domínio')->where('type', 'ADMIN')->first();
    $template_status = $template->status;
    $message = $template->message;

    if ( $template_status == "INATIVO") {
        return;
    }

    // variaveis da mensagem
    $domainid = $params['domainid'];
    $sld = $params['sld'];
    $tld = $params['tld'];
    $dominio = "{$sld}.{$tld}";
    $regperiod = $params['regperiod'];
    $regperiod = $params['regperiod'];
    $contactName = $params['fullname'];
    $contactPhone = $params['fullphonenumber'];
    $contactEmail = $params['email'];


    $message = str_replace (
        array(
            "{@domainid}",
            "{@dominio}",
            "{@regperiod}",
            "{@contactname}",
            "{@contactemail}",
            "{@contactphone}"
        ),
        array (
            $domainid,
            $dominio,
            $regperiod,
            $contactName,
            $contactEmail,
            $contactPhone
        ),
        $message
    );
    sendWhatsappMessage ($message, $phoneAdmin, 'Registro de domínio', $clientId);
}



?>