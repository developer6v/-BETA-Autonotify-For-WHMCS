<?php
include_once('../../../../../../init.php');
use WHMCS\Database\Capsule;


$tab = $_POST['tab'];
$idS_toDelete = $_POST['idstodelete'];
$idS_toDelete = explode(',', $idS_toDelete);


if ($tab == 'templates') {
    foreach ($idS_toDelete as $id) {
        Capsule::table('sr_templates_for_whmcs')->where('id', '=', $id)->delete();
    }
} elseif ($tab == 'relatory') {
    foreach ($idS_toDelete as $id) {
        Capsule::table('sr_relatory_for_whmcs')->where('id', '=', $id)->delete();
    }
}

return "Itens Deletados";

?>