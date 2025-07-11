<?php

include_once('../../../../../../init.php');
use WHMCS\Database\Capsule;



$idTemplate = $_POST['idTemplate'];
$messageTemplate = $_POST['messageTemplate'];
$statusTemplate = $_POST['statusTemplate'];


Capsule::table('sr_templates_for_whmcs')
->where('id', '=', $idTemplate)
->update([
    'message' => $messageTemplate,
    'status' => $statusTemplate
]);


?>