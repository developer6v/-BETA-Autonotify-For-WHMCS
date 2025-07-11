<?php

function setScripts () {
    // define o css e os scripts
    $moduleName = 'autonotify_for_whmcs';
    $adminPage = isset($_GET['module']) ? $_GET['module'] : '';
    $script = '';
    // api.js
    $script .= '<script src="/modules/addons/autonotify_for_whmcs/public/js/api.js"></script>';
    // qrcode.js
    $script .= '<script src="/modules/addons/autonotify_for_whmcs/public/js/qrCode.js"></script>';
    // config.js
    $script .= '<script src="/modules/addons/autonotify_for_whmcs/public/js/config.js"></script>';
    // display.js
    $script .= '<script src="/modules/addons/autonotify_for_whmcs/public/js/display.js"></script>';
    // popups.js
    $script .= '<script src="/modules/addons/autonotify_for_whmcs/public/js/popups.js"></script>';
    // relatory.js
    $script .= '<script src="/modules/addons/autonotify_for_whmcs/public/js/relatory.js"></script>';

    // app.css
    $script .= '<link rel="stylesheet" type="text/css" href="/modules/addons/autonotify_for_whmcs/public/css/app.css"/>';
    return $script;  
}

?>