<?php
include_once('../../../../../../init.php');
use WHMCS\Database\Capsule;

$instance_key = isset($_POST['instance_key']) ? $_POST['instance_key'] : null;
$admin_phone = isset($_POST['admin_phone']) ? $_POST['admin_phone'] : null;
$systemstatus = isset($_POST['systemStatus']) ? $_POST['systemStatus'] : null;


if ($instance_key && $systemstatus) {
    
    Capsule::table('sr_autonotify_for_whmcs')  
    ->update([
        'instance_key' => $instance_key,
        'admin_phone' => $admin_phone,
        'system_status' => $systemstatus
    ]);
    echo "funcionou!";
} else {
    echo "erro ao pegar variaveis";
}


?>