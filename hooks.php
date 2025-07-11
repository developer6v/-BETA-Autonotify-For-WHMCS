<?php

if (!defined("WHMCS")) {
    exit("Denied access");
}
use WHMCS\Database\Capsule;

require_once __DIR__ . '/src/controllers/hooks/index.php';
require_once __DIR__ . '/src/config/module/configScripts.php';

add_hook('InvoiceCreated', 1, function($vars) {
  invoiceCreated($vars);
});

add_hook('InvoicePaid', 1, function ($vars) {
//invoicePaid($vars);
});

add_hook('TicketOpen', 1, function($vars) {
  //  ticketOpen($vars);
});

add_hook('TicketAdminReply', 1, function($vars) {
  //  ticketAdminReply($vars);
});

add_hook('OrderPaid', 1, function($vars) {
 //   orderPaid($vars);
});

add_hook('AfterShoppingCartCheckout', 1, function($vars) {
    //afterShoppingCartCheckout($vars);
});

add_hook('AfterModuleSuspend', 1, function($vars) {
   // afterModuleSuspend($vars);
});

add_hook('AfterModuleUnsuspend', 1, function($vars) {
    //afterModuleUnsuspend($vars);
});

add_hook('AfterModuleTerminate', 1, function($vars) {
  //  afterModuleTerminate($vars);
});

add_hook('ClientAdd', 1, function($vars) {
  clientAdd($vars);
});

add_hook('UserLogin', 1, function($vars) {
  userLogin($vars);
});

add_hook('InvoiceCancelled', 1, function($vars) {
  invoiceCancelled($vars);
});

add_hook('ClientChangePassword', 1, function($vars) {
  clientChangePassword($vars);
});

add_hook('InvoiceRefunded', 1, function($vars) {
  // invoiceRefunded($vars);
});

add_hook('TicketClose', 1, function($vars) {
   // ticketClose($vars);
});

add_hook('TicketUserReply', 1, function($vars) {
   // ticketUserReply($vars);
});

add_hook('AfterRegistrarRegistrationFailed', 1, function ($params){
   // afterRegistrarRegistrationFailed($params);
});

add_hook('AfterRegistrarRegistration', 1, function ($params){
   // afterRegistrarRegistration($params);
});

add_hook('AdminAreaHeaderOutput', 1, function($vars) {
    global $root_directory;
    $root_directory = __DIR__;
    $script = setScripts();
    return $script;
});
?>