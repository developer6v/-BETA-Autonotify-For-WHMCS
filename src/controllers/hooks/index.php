<?php


// clients
include_once __DIR__ . '/clients/clientAdd.php';
include_once __DIR__ . '/clients/clientChangePassword.php';
include_once __DIR__ . '/clients/userLogin.php';

// domains
include_once __DIR__ . '/domains/afterRegistrarRegistration.php';
include_once __DIR__ . '/clients/afterRegistrarRegistrationFailed.php';

// invoices
include_once __DIR__ . '/invoices/invoiceCancelled.php';
include_once __DIR__ . '/invoices/invoiceCreated.php';
include_once __DIR__ . '/invoices/invoicePaid.php';
include_once __DIR__ . '/invoices/invoiceRefunded.php';

// orders
include_once __DIR__ . '/orders/afterShoppingCartCheckout.php';
include_once __DIR__ . '/orders/orderPaid.php';

// services
include_once __DIR__ . '/services/afterModuleSuspend.php';
include_once __DIR__ . '/services/afterModuleTerminate.php';
include_once __DIR__ . '/services/afterModuleUnsuspend.php';

// tickets
include_once __DIR__ . '/tickets/ticketAdminReply.php';
include_once __DIR__ . '/tickets/ticketClose.php';
include_once __DIR__ . '/tickets/ticketOpen.php';
include_once __DIR__ . '/tickets/ticketUserReply.php';

?>