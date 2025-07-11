<?php
include_once __DIR__ . '/hooks.php';
include_once __DIR__ . '/src/config/index.php';
include_once __DIR__ . '/src/tabs/tabs_manager.php';

function autonotify_module_whmcs_config() {
    return array(
        'name' => 'Autonotify Module For WHMCS',
        'description' => 'Este é um módulo responsável por automatizar mensagens referentes à notificações do WHMCS.',
        'version' => '1.0',
        'author' => 'Sourei',
        'fields' => array()
    );
}

function autonotify_module_whmcs_activate() {
    autonotify_config();
    return array('status' => 'success', 'description' => 'Módulo ativado com sucesso! As seguintes tabelas foram criadas no banco de dados (se não existiam): sr_autonotify_for_whmcs, sr_templates_for_whmcs, sr_relatory_for_whmcs.');
}

function autonotify_module_whmcs_deactivate() {
    return array('status' => 'success', 'description' => 'Módulo desativado com sucesso!');
}

function autonotify_module_whmcs_output($vars) {
    echo tabs_manager($vars);
}
?>