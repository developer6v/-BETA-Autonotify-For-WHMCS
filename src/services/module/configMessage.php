<?php

use WHMCS\Database\Capsule;
function setMessage ($vars) {
    // parametros padrão  
    $clientId = $vars['clientId'];
    $templateId = $vars['templateId'];
    // website
    $website = Capsule::table('tblconfiguration')->where("setting","=", "SystemURL")->value("value");
    // definição das variaveis de mensagem padrão
    $message = Capsule::table('sr_templates_for_whmcs')->where("id", "=", $templateId)->value("message");
    $typeTemplate = Capsule::table('sr_templates_for_whmcs')->where("id", "=", $templateId)->value("type");
    $firstname = Capsule::table('tblclients')->where("id","=", $clientId)->value("firstname");
    $lastname = Capsule::table('tblclients')->where("id","=", $clientId)->value("lastname");
    $email = Capsule::table('tblclients')->where("id","=", $clientId)->value("email");
    $company = Capsule::table('tblconfiguration')->where('setting', 'CompanyName')->first()->value;
    if ($typeTemplate == "CLIENTE") {
        $phone = Capsule::table('tblclients')->where("id","=", $clientId)->value("phonenumber");
    } elseif ($typeTemplate == "ADMIN") {
        $phone = Capsule::table('sr_autonotify_for_whmcs')->where("id", "=", 1)->value("admin_phone");
    }
    $invoiceId = null;
    // definição da mensagem com as variaveis padrão
    switch ($templateId) {
        // createdinvoice
        case 1: 
            
            $invoiceId = $vars['invoiceId'];
            $value = Capsule::table('tblinvoices')->where('id', $invoiceId)->value('total');
            $message = str_replace (
                array(
                    "{@invoiceid}",
                    "{@value}"

                ),
                array (
                    $invoiceId,
                    $value,      
                ),
                $message
            );    
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/src/controllers/api/autoauth.php?clientId={$clientId}&page=invoices";    
            break;

        // invoicereminder
        case 2:
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/src/controllers/api/autoauth.php?clientId={$clientId}&page=invoices";          
            break;

        // invoicepaid
        case 3:
            $invoiceId = $vars['invoiceId'];
            $value = Capsule::table('tblinvoices')->where('id', $invoiceId)->value('total');
            $message = str_replace (
                array(
                    "{@invoiceid}",
                    "{@value}"
                ),
                array (
                    $invoiceId,
                    $value,      
                ),
                $message
            );  
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/src/controllers/api/autoauth.php?clientId={$clientId}&page=invoices";          
            break;

        // ticketcreated
        case 4:
            $ticketId = $vars['ticketId'];
            $ticketTitle = $vars['ticketTitle'];
            $ticketDetails = Capsule::table('tbltickets')->where('id', $ticketId)->first();
            $ticketNumber = $ticketDetails->tid;
            $ticketCode = $ticketDetails->c;
            $date = date("d/m/Y", strtotime($ticketDetails->date));
            $hour = date("H:i", strtotime($ticketDetails->date));
            $autologin_ticket = "{$website}viewticket.php?tid={$ticketNumber}&c={$ticketCode}";
            $message = str_replace (
                array(
                    "{@titleTicket}",
                    "{@ticket}",
                    "{@autologin_ticket}",
                    "{@date}",
                    "{@hour}"

                ),
                array (
                    $ticketTitle,
                    $ticketId,
                    $autologin_ticket,
                    $date,
                    $hour
                ),
                $message
            );
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/functions/apiFunctions/autoauth.php?clientId={$clientId}&page=tickets";    
            break;

        // ticketreplied
        case 5:
            $ticketId = $vars['ticketId'];
            $ticketTitle = $vars['ticketTitle'];
            $ticketDetails = Capsule::table('tbltickets')->where('id', $ticketId)->first();
            $ticketNumber = $ticketDetails->tid;
            $ticketCode = $ticketDetails->c;
            $date = date("d/m/Y", strtotime($ticketDetails->date));
            $hour = date("H:i", strtotime($ticketDetails->date));
            $autologin_ticket = "$website/viewticket.php?tid={$ticketNumber}&c={$ticketCode}";
            $message = str_replace ( array(
                    "{@titleTicket}",
                    "{@ticket}",
                    "{@autologin_ticket}",
                    "{@date}",
                    "{@hour}"
                ),array (
                    $ticketTitle,
                    $ticketId,
                    $autologin_ticket,
                    $date,
                    $hour
                ), $message
            );
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/functions/apiFunctions/autoauth.php?clientId={$clientId}&page=tickets";    
            break;

        // servicecreated
        case 6:
            $serviceId = $vars['serviceId'];
            $productName = Capsule::table('tblhosting')->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')->where('tblhosting.id', $serviceId)->value('tblproducts.name');
            $message = str_replace ("{@product}", $productName, $message);
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/functions/apiFunctions/autoauth.php?clientId={$clientId}&page=product_details&serviceId={$serviceId}";
            break;

        //servicesuspended
        case 7:
            $serviceId = $vars['serviceId'];
            $productName = Capsule::table('tblhosting')->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')->where('tblhosting.id', $serviceId)->value('tblproducts.name');
            $message = str_replace ("{@product}", $productName, $message);
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/functions/apiFunctions/autoauth.php?clientId={$clientId}&page=product_details&serviceId={$serviceId}";
            break;

        //servicereactivated
        case 8:
            $serviceId = $vars['serviceId'];
            $productName = Capsule::table('tblhosting')->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')->where('tblhosting.id', $serviceId)->value('tblproducts.name');
            $message = str_replace ("{@product}", $productName, $message);
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/functions/apiFunctions/autoauth.php?clientId={$clientId}&page=product_details&serviceId={$serviceId}";
            break;

        // servicececancelled
        case 9:
            $serviceId = $vars['serviceId'];
            $productName = Capsule::table('tblhosting')->join('tblproducts', 'tblhosting.packageid', '=', 'tblproducts.id')->where('tblhosting.id', $serviceId)->value('tblproducts.name');
            $message = str_replace ("{@product}", $productName, $message);
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/functions/apiFunctions/autoauth.php?clientId={$clientId}&page=product_details&serviceId={$serviceId}";
            break;

        // wellcome
        case 10:
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/functions/apiFunctions/autoauth.php?clientId={$clientId}&page=profile";
            break;

        // clientlogin
        case 11: 
            $ipaddress = $vars['ipaddress'];
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/functions/apiFunctions/autoauth.php?clientId={$clientId}&page=profile";
            $date = date("d/m/Y");
            $hour = date("H:i");
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
            break;
        // invoicecancelled
        case 13:
            $invoiceId = $vars['invoiceId'];
            $value = Capsule::table('tblinvoices')->where('id', $invoiceId)->value('total');
            $message = str_replace (
                array(
                    "{@invoiceid}",
                    "{@value}"
                ),
                array (
                    $invoiceId,
                    $value
                ),
                $message
            );
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/src/controllers/api/autoauth.php?clientId={$clientId}&page=invoices";    
            break;
        //clientchangepassword
        case 14:
            $ipaddress = $vars['ipaddress'];
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/functions/apiFunctions/autoauth.php?clientId={$clientId}&page=profile";
            $date = date("d/m/Y");
            $hour = date("H:i");
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
            break;

        // invoicerefunded
        case 15:
            $invoiceId = $vars['invoiceId'];
            $value = Capsule::table('tblinvoices')->where('id', $invoiceId)->value('total');
            $message = str_replace (
                array(
                    "{@invoiceid}",
                    "{@value}"

                ),
                array (
                    $invoiceId,
                    $value,      
                ),
                $message
            );    
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/src/controllers/api/autoauth.php?clientId={$clientId}&page=invoices";    
            break;

        // ticketclose
        case 16:
            $ticketId = $vars['ticketId'];
            $ticketTitle = $vars['ticketTitle'];
            $ticketDetails = Capsule::table('tbltickets')->where('id', $ticketId)->first();
            $ticketNumber = $ticketDetails->tid;
            $ticketCode = $ticketDetails->c;
            $date = date("d/m/Y");
            $hour = date("H:i");
            $autologin_ticket = "{$website}viewticket.php?tid={$ticketNumber}&c={$ticketCode}";
            $message = str_replace (
                array(
                    "{@titleTicket}",
                    "{@ticket}",
                    "{@autologin_ticket}",
                    "{@date}",
                    "{@hour}"

                ),
                array (
                    $ticketTitle,
                    $ticketId,
                    $autologin_ticket,
                    $date,
                    $hour
                ),
                $message
            );
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/functions/apiFunctions/autoauth.php?clientId={$clientId}&page=tickets";
            break;

        // ticketuserreply
        case 17:
            $adminUrl = $vars['adminUrl'];
            $ticketId = $vars['ticketId'];
            $ticketTitle = $vars['ticketTitle'];
            $ticketDetails = Capsule::table('tbltickets')->where('id', $ticketId)->first();
            $ticketNumber = $ticketDetails->tid;
            $ticketMessage = $ticketDetails->message;
            $ticketCode = $ticketDetails->c;
            $date = date("d/m/Y", strtotime($ticketDetails->date));
            $hour = date("H:i", strtotime($ticketDetails->date));
            $autologinticketAdmin = "{$adminUrl}/supporttickets.php?action=view&id={$ticketId}";
            $autologin_ticket = "{$website}viewticket.php?tid={$ticketNumber}&c={$ticketCode}";
            $message = str_replace (
                array(
                    "{@titleTicket}",
                    "{@ticket}",
                    "{@autologin_ticket}",
                    "{@date}",
                    "{@hour}",
                    "{@ticketMessage}",
                    "{@autologinticketAdmin}"
                ),
                array (
                    $ticketTitle,
                    $ticketId,
                    $autologin_ticket,
                    $date,
                    $hour,
                    $ticketMessage,
                    $autologinticketAdmin
                ),
                $message
            );
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/functions/apiFunctions/autoauth.php?clientId={$clientId}&page=tickets";
            break;
        // ticketcreatedadmin
        case 18:
            $adminUrl = $vars['adminUrl'];
            $ticketId = $vars['ticketId'];
            $ticketTitle = $vars['ticketTitle'];
            $ticketDetails = Capsule::table('tbltickets')->where('id', $ticketId)->first();
            $ticketNumber = $ticketDetails->tid;
            $ticketMessage = $ticketDetails->message;
            $ticketCode = $ticketDetails->c;
            $date = date("d/m/Y", strtotime($ticketDetails->date));
            $hour = date("H:i", strtotime($ticketDetails->date));
            $autologinticketAdmin = "{$adminUrl}/supporttickets.php?action=view&id={$ticketId}";
            $autologin_ticket = "{$website}viewticket.php?tid={$ticketNumber}&c={$ticketCode}";
            $message = str_replace (
                array(
                    "{@titleTicket}",
                    "{@ticket}",
                    "{@autologin_ticket}",
                    "{@date}",
                    "{@hour}",
                    "{@ticketMessage}",
                    "{@autologinticketAdmin}"
                ),
                array (
                    $ticketTitle,
                    $ticketId,
                    $autologin_ticket,
                    $date,
                    $hour,
                    $ticketMessage,
                    $autologinticketAdmin
                ),
                $message
            );
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/functions/apiFunctions/autoauth.php?clientId={$clientId}&page=tickets";
            break;

        // notafiscal
        case 19:
            /*{@linkNFS} - Link para visualizar a Nota Fiscal*/
            $autorizado = date("d/m/Y H:i");
            $invoiceId = $vars['invoiceId'];
            $idNFS = $vars['idNFS'];
            $value = Capsule::table('mod_nfeio_si_serviceinvoices')->where('id', $idNFS)->value('services_amount');
            $idNotaAPI = Capsule::table('mod_nfeio_si_serviceinvoices')->where('id', $idNFS)->value('nfe_id');
            $company_id = Capsule::table('tbladdonmodules')->where("module", "NFEioServiceInvoices")->where("setting", "company_id")->value("value");
            $linkNFS = "https://app.nfe.io/companies/{$company_id}/service-invoices/{$idNotaAPI}";
            
            $message = str_replace (
                array(
                    "{@invoiceid}",
                    "{@value}",
                    "{@idnfs}",
                    "{@autorizado}",
                    "{@linkNFS}"
                ),
                array (
                    $invoiceId,
                    $value,
                    $idNFS,
                    $autorizado,
                    $linkNFS
                ),
                $message
            );  
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/src/controllers/api/autoauth.php?clientId={$clientId}&page=invoices";          
            break;
        
        case 20:
            $adminUrl = $vars['adminUrl'];
            $urlClient = "{$adminUrl}/clientssummary.php?userid={$clientId}";
            $phoneClient = Capsule::table("tblclients")->where("id", $clientId)->value("phonenumber");

            $message = str_replace(
                array(
                    "{@urlClient}",
                    "{@phone}"
                ),
                array(
                    $urlClient,
                    $phoneClient
                ),
                $message
            );
            break;
            
       
        case 21:
            $orderId = $vars['orderId'];
            $order = Capsule::table('tblorders')->where("id", $orderId)->first();
            $value = number_format($order->amount, 2, ',', '.');
            $dateUnformatted = $order->date;
            $dateUnformatted = new DateTime($dateUnformatted);
            $invoiceId = $order->invoiceid;
            $date = $dateUnformatted->format("d/m/Y");
            $hour = $dateUnformatted->format("H:i:s");
            $client = Capsule::table('tblclients')->where("id","=", $clientId)->first();
            $phoneClient = $client->phonenumber;
            $paymentGateway = $order->paymentmethod;
            $paymentMethod = Capsule::table("tblpaymentgateways")->where("gateway", $paymentGateway)->where("setting", "name")->value("value");
            $statusOrder = Capsule::table('tblinvoices')->where("id", $invoiceId)->value('status');
            switch ($statusOrder) {
                case "Unpaid":
                    $statusOrder = "Pendente";
                    break;
                case "Pendente":
                    $statusOrder = "Pendente";
                    break;
                case "Paid":
                    $statusOrder = "Pago";
                    break;
                case "Draft":
                    $statusOrder = "Rascunho";
                    break;
                case "Cancelled":
                    $statusOrder = "Cancelado";
                    break;
            }
            $cupomCode = $order->promocode;
            if ($cupomCode) {
                $cupomValue = number_format($order->promovalue, 0, ',', '');
                $cupomLine = "\nCupom: {$cupomCode} (%{$cupomValue})\n";
            }

            // verificar a existencia de afiliados
            $affiliateId = Capsule::table("tblaffiliateshistory")->where('invoice_id', $invoiceId)->value("affiliateid");
            if ($affiliateId) {
                $affiliateClientId = Capsule::table("tblaffiliates")->where("id", $affiliateId)->value("clientid");
                $affiliateClient = Capsule::table("tblclients")->where("id", $affiliateClientId)->first();
                $affiliateFirstName = $affiliateClient->firstname;
                $affiliateLastName = $affiliateClient->lastname;
                $affiliateLine = "\nAfiliado: {$affiliateFirstName} {$affiliateLastName} (#{$affiliateClientId})\n";
            }

            $requestorId = Capsule::table('tblorders')->where('id', $orderId)->value('requestor_id');
            $adminRequestorId = Capsule::table('tblorders')->where('id', $orderId)->value('admin_requestor_id');
            if ($requestorId != 0 && $adminRequestorId == 0) {
                $firstname = Capsule::table('tblusers')->where('id', $requestorId)->value('first_name');
                $lastname = Capsule::table('tblusers')->where('id', $requestorId)->value('last_name');
                $requestor = "\n*Pedido criado por:*\nUsuário - {$firstname} {$lastname} (ID: {$requestorId})\n\n";
            } else if ($requestorId == 0 && $adminRequestorId != 0) {
                $firstname = Capsule::table('tbladmins')->where('id', $adminRequestorId)->value('firstname');
                $lastname = Capsule::table('tbladmins')->where('id', $adminRequestorId)->value('lastname');
                $requestor = "\n*Pedido criado por:*\nAdmin - {$firstname} {$lastname} (ID: {$adminRequestorId})\n\n";
            }

            // Obter nomes dos produtos e ciclos de faturamento
            $packages = Capsule::table("tblhosting")
            ->join("tblproducts", "tblhosting.packageid", "=", "tblproducts.id")
            ->where("tblhosting.orderid", $orderId)
            ->get(["tblhosting.billingcycle", "tblhosting.domain", "tblproducts.name"]);

            $productDetails = [];
            foreach ($packages as $package) {
                $productDetails[] = "{$package->name} ({$package->billingcycle}) - {$package->domain}";
            }
            $productList = implode("\n", $productDetails);
            $address = trim($client->address1 . " - " . ($client->address2 ?? "")) . " - " . $client->city . " - " . $client->state . ", " . $client->postcode;

            $message = str_replace (
                array(
                    "{@value}",
                    "{@orderid}",
                    "{@date}",
                    "{@hour}",
                    "{@paymentmethod}",
                    "{@cupomLine}",
                    "{@affiliateLine}",
                    "{@requestorLine}",
                    "{@productslist}",
                    "{@phone}",
                    "{@address}",
                    "{@statusorder}"
                ),
                array (
                    $value,
                    $orderId,
                    $date,
                    $hour,
                    $paymentMethod,
                    $cupomLine,
                    $affiliateLine,
                    $requestor,
                    $productList,
                    $phoneClient,
                    $address,
                    $statusOrder
                ),
                $message
            );

            break;
            
              
        case 22:
            $orderId = $vars['orderId'];
            $order = Capsule::table('tblorders')->where("id", $orderId)->first();
            $value = number_format($order->amount, 2, ',', '.');
            $dateUnformatted = $order->date;
            $dateUnformatted = new DateTime($dateUnformatted);
            $invoiceId = $order->invoiceid;
            $date = $dateUnformatted->format("d/m/Y");
            $hour = $dateUnformatted->format("H:i:s");
            $client = Capsule::table('tblclients')->where("id","=", $clientId)->first();
            $phoneClient = $client->phonenumber;
            $paymentGateway = $order->paymentmethod;
            $paymentMethod = Capsule::table("tblpaymentgateways")->where("gateway", $paymentGateway)->where("setting", "name")->value("value");
            $statusOrder = Capsule::table('tblinvoices')->where("id", $invoiceId)->value('status');
            switch ($statusOrder) {
                case "Unpaid":
                    $statusOrder = "Pendente";
                    break;
                case "Pendente":
                    $statusOrder = "Pendente";
                    break;
                case "Paid":
                    $statusOrder = "Pago";
                    break;
                case "Draft":
                    $statusOrder = "Rascunho";
                    break;
                case "Cancelled":
                    $statusOrder = "Cancelado";
                    break;
            }
            $cupomCode = $order->promocode;
            if ($cupomCode) {
                $cupomValue = number_format($order->promovalue, 0, ',', '');
                $cupomLine = "\nCupom: {$cupomCode} (%{$cupomValue})\n";
            }

            // verificar a existencia de afiliados
            $affiliateId = Capsule::table("tblaffiliateshistory")->where('invoice_id', $invoiceId)->value("affiliateid");
            if ($affiliateId) {
                $affiliateClientId = Capsule::table("tblaffiliates")->where("id", $affiliateId)->value("clientid");
                $affiliateClient = Capsule::table("tblclients")->where("id", $affiliateClientId)->first();
                $affiliateFirstName = $affiliateClient->firstname;
                $affiliateLastName = $affiliateClient->lastname;
                $affiliateLine = "\nAfiliado: {$affiliateFirstName} {$affiliateLastName} (#{$affiliateClientId})\n";
            }

            $requestorId = Capsule::table('tblorders')->where('id', $orderId)->value('requestor_id');
            $adminRequestorId = Capsule::table('tblorders')->where('id', $orderId)->value('admin_requestor_id');
            if ($requestorId != 0 && $adminRequestorId == 0) {
                $firstname = Capsule::table('tblusers')->where('id', $requestorId)->value('first_name');
                $lastname = Capsule::table('tblusers')->where('id', $requestorId)->value('last_name');
                $requestor = "\n*Pedido criado por:*\nUsuário - {$firstname} {$lastname} (ID: {$requestorId})\n\n";
            } else if ($requestorId == 0 && $adminRequestorId != 0) {
                $firstname = Capsule::table('tbladmins')->where('id', $adminRequestorId)->value('firstname');
                $lastname = Capsule::table('tbladmins')->where('id', $adminRequestorId)->value('lastname');
                $requestor = "\n*Pedido criado por:*\nAdmin - {$firstname} {$lastname} (ID: {$adminRequestorId})\n\n";
            }

            // Obter nomes dos produtos e ciclos de faturamento
            $packages = Capsule::table("tblhosting")
            ->join("tblproducts", "tblhosting.packageid", "=", "tblproducts.id")
            ->where("tblhosting.orderid", $orderId)
            ->get(["tblhosting.billingcycle", "tblhosting.domain", "tblproducts.name"]);

            $productDetails = [];
            foreach ($packages as $package) {
                $productDetails[] = "{$package->name} ({$package->billingcycle}) - {$package->domain}";
            }
            $productList = implode("\n", $productDetails);
            $address = trim($client->address1 . " - " . ($client->address2 ?? "")) . " - " . $client->city . " - " . $client->state . ", " . $client->postcode;

            $message = str_replace (
                array(
                    "{@value}",
                    "{@orderid}",
                    "{@date}",
                    "{@hour}",
                    "{@paymentmethod}",
                    "{@cupomLine}",
                    "{@affiliateLine}",
                    "{@requestorLine}",
                    "{@productslist}",
                    "{@phone}",
                    "{@address}",
                    "{@statusorder}"
                ),
                array (
                    $value,
                    $orderId,
                    $date,
                    $hour,
                    $paymentMethod,
                    $cupomLine,
                    $affiliateLine,
                    $requestor,
                    $productList,
                    $phoneClient,
                    $address,
                    $statusOrder
                ),
                $message
            );

            break;

        case 23:
            $params = $vars['params'];
            $domainid = $params['domainid'];
            $sld = $params['sld'];
            $tld = $params['tld'];
            $dominio = "{$sld}.{$tld}";
            $regperiod = $params['regperiod'];
            $contactName = $params['fullname'];
            $contactPhone = $params['fullphonenumber'];
            $contactEmail = $params['email'];

            $message = str_replace (array(
                    "{@domainid}",
                    "{@dominio}",
                    "{@regperiod}",
                    "{@contactname}",
                    "{@contactemail}",
                    "{@contactphone}"
                ), array (
                    $domainid,
                    $dominio,
                    $regperiod,
                    $contactName,
                    $contactEmail,
                    $contactPhone
                ), $message
            );
            break;

        case 24:
            $params = $vars['params'];
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
            break;
        
     
        // DEFAULT
        default:
            $autologin = "{$website}modules/addons/autonotify_for_whmcs/functions/apiFunctions/autoauth.php?clientId={$clientId}&page=profile";
            break;
    }
    $message = str_replace (
        array(
            "{@clientid}",
            "{@firstname}",
            "{@lastname}",
            "{@email}",
            "{@autologin}",
            "{@company}",
            "{@website}"
        ),
        array (
            $clientId,
            $firstname,
            $lastname,
            $email,
            $autologin,
            $company,
            $website
        ),
        $message
    );

    if ($invoiceId) {
        $invoice = Capsule::select('SELECT duedate FROM tblinvoices WHERE id = ?', [$invoiceId])[0];
        $due_date = isset($invoice->duedate) ? $invoice->duedate : 'Data não encontrada';
        $message = str_replace('{@duedate}', $due_date, $message);
    }

    // definição das variaveis para enviar mensagem
    $instance_key = Capsule::table('sr_autonotify_for_whmcs')->where("id", "=", 1)->value('instance_key');
    $clientName = "{$firstname} {$lastname}";
    $messageType = Capsule::table('sr_templates_for_whmcs')->where("id", "=", $templateId)->value("messageType");
    // organização das variaveis e retorno da função
    $vars = [
        "instance_key" => $instance_key,
        "message" => $message,
        "phone" => $phone,
        "messageType" => $messageType,
        "clientName" => $clientName
    ];
    return $vars;
}
?>