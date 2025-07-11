<?php
use WHMCS\Database\Capsule;
 
function invoiceCreated($vars) {
    file_put_contents("hookcalled.txt", "Hook chamado com sucesso: " . json_encode($vars));
    $invoiceId = $vars['invoiceid'];
    $clientId = Capsule::table('tblinvoices')->where("id", "=",  $invoiceId)->value("userid");

    // variaveis template
    $template = Capsule::table('sr_templates_for_whmcs')->where('messageType', 'Fatura Criada')->where('type', 'CLIENTE')->first();
    $template_status = $template->status;
    $message = $template->message;

    if ( $template_status == "INATIVO") {
        return;
    }

    // variaveis da mensagem
    $phone = Capsule::table('tblclients')->where("id","=", $clientId)->value("phonenumber");
    $value = Capsule::table('tblinvoices')->where('id', $invoiceId)->value('total');
    $duedate = Capsule::table('tblinvoices')->where("id", "=",  $invoiceId)->value("duedate");

    $message = str_replace (
        array(
            "{@invoiceid}",
            "{@value}",
            "{@duedate}"
        ),
        array (
            $invoiceId,
            $value,
            $duedate
        ),
        $message
    );
    sendWhatsappMessage ($message, $phone, 'Fatura Criada', $clientId);
}


?>