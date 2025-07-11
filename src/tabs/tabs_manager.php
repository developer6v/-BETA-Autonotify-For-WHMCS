<?php

include_once __DIR__ . '/configTab.php'; 
include_once __DIR__ . '/qrcodeTab.php'; 
include_once __DIR__ . '/relatoryTab.php'; 
include_once __DIR__ . '/statusTab.php'; 
include_once __DIR__ . '/tabs.php'; 
include_once __DIR__ . '/templatesTab.php'; 


function tabs_manager($vars) {
    global $CONFIG;
    global $root_directory;
    echo $root_directory;
    $adminFolder = App::get_admin_folder_name();
    $adminUrl = $CONFIG['SystemURL'] . '/' . $adminFolder;
    
    // overlay --------------------------
    echo '<div class="overlaySourei"></div>';

    // tabs contents --------------------------
    echo '<div class="sourei_tab_contents">';
        sourei_getTabs();
    echo '</div>';

    // config --------------------------
    echo ' <div class="div_content sourei_config">';
        sourei_tabConfig();
    echo '</div>';

    // templates -----------------------
    echo '<div class="div_content sourei_template">';
        sourei_tabTemplates();
    echo '</div>';
    sourei_templatesPopup();

    // qrcode -----------------------
    echo '<div class="div_content sourei_qrcode">';
        sourei_qrCode();
    echo '</div>';

 
    // relatory -----------------------
    $perPageRelatory = $_GET['perPageRelatory'] ?? 10;
    $pageRelatory = $_GET['pageRelatory'] ?? 1;
    $offset = ($pageRelatory - 1) * $perPageRelatory;
    echo '
    <div class="div_content sourei_relatory">';
        sourei_relatoryTab($perPageRelatory, $pageRelatory, $offset);
    echo '</div>';
    sourei_relatoryPopup($perPageRelatory, $pageRelatory, $offset);
    

    // status -----------------------
    echo '<div class="div_content sourei_status">';
        sourei_statusTab();
    echo '</div>';
}

?>