<?php

function afterRegistrarRegistrationFailed ($params) {
    $vars = $params['params'];
    $userId = $vars['userid'];
    $clientId = Capsule::table('tblusers_clients')->where('id', '=', $userId)->value('client_id');
    $phoneAdmin = Capsule::table('sr_autonotify_for_whmcs')->where("id","=", 1)->value("admin_phone");

    // variaveis template
    $template = Capsule::table('sr_templates_for_whmcs')->where('messageType', 'Falha no registro de domínio')->where('type', 'ADMIN')->first();
    $template_status = $template->status;
    $message = $template->message;

    if ( $template_status == "INATIVO") {
        return;
    }

    // variaveis da mensagem
    $domainid = $params['domainid'];
    $sld = $params['sld'];
    $tld = $params['tld'];
    $erro = $params['error'];
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
            "{@contactphone}",
            "{@error}"
        ),
        array (
            $domainid,
            $dominio,
            $regperiod,
            $contactName,
            $contactEmail,
            $contactPhone,
            $erro
        ),
        $message
    );
    sendWhatsappMessage ($message, $phoneAdmin, 'Falha no registro de domínio', $clientId);
}


?>