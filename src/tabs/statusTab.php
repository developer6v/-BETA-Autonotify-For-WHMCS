<?php
use WHMCS\Database\Capsule;

require_once __DIR__ . '/../services/api/getStatusData.php';

function sourei_statusTab() {
    $instance_key = Capsule::table('sr_autonotify_for_whmcs')->first()->instance_key;
    $statusData = soureiGetStatusData($instance_key);
    $connection = $statusData['connection'];
    $apiStatus = $statusData['api'];

    echo "<div class='statusDiv'>
        <div class='statusItem'>
            <span>Status API: </span>
            <p class='apiData_{$apiStatus}'> {$apiStatus}</p>
        </div>
    </div>
    <div class='statusDiv'>
        <div class='statusItem'>
            <span>Status Conexão (Whatsapp): </span>
            <p class='connectionData_{$connection}'> {$connection}</p>
        </div>
    </div>";
}

?>