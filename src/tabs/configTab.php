<?php
use WHMCS\Database\Capsule;

require_once __DIR__ . '/../services/api/getStatusData.php';
require_once __DIR__ . '/../services/api/getProfilePicture.php';




function sourei_tabConfig() {
    $dataConfig = Capsule::table('sr_autonotify_for_whmcs')->first();
    $instance_key = str_replace(" ", "", $dataConfig->instance_key);
    $system_status = $dataConfig->system_status;
    $admin_phone = str_replace(" ", "", $dataConfig->admin_phone);
    $intervalBetweenMessages = str_replace(" ", "", $dataConfig->intervalBetweenMessages);
    // profile picture
    $statusDataApi = soureiGetStatusData($instance_key);
    $numberConnected = $statusDataApi['numberConnected'];
    echo "<div style='display: grid; width: 100%;'>
    <div class='sourei_configDiv'>";
    if ($numberConnected != "Desconectado") {
        $numberConnected = explode(":",$numberConnected);
        $numberConnected = $numberConnected[0];
        $urlPicture = getProfilePicture($numberConnected, $instance_key);
        echo "<div class='imageProfile'>
            <img src='{$urlPicture}' width='100px'/>
        </div>";
    }
    echo "
        <div class='formConfigAutonotify'>
            <div class = 'formStat'>
                <label for='instancekey'>Token</label>
                <input id='instancekey' type='text' value='{$instance_key}'></input>
            </div>
            <div class = 'formStat'>
                <label for='systemstatus'> Status do Sistema</label>
                <select id='systemstatus' name='statuSystem'>";
                    if ($system_status) {
                        echo '<option value="Ativado" selected>Ativado</option>
                        <option value="Desativado">Desativado</option>';
                    } else {
                        echo '<option value="Ativado">Ativado</option>
                        <option value="Desativado" selected>Desativado</option>';
                    } echo "
                </select>
            </div>
            <div class = 'formStat'>
                <label for='adminphone'>Telefone do Administrador</label>
                <input id='adminphone' type='text' value='{$admin_phone}'></input>
            </div>
            <div class='formStat'>
                <button id='saveAutonotify'><i class='fas fa-cogs'></i> Salvar Edição</button>
            </div>
            <div class='formStat'>
                <button class='moreConfig' ><i class='fas fa-cogs'></i> Mais Configurações...</button>
            </div>
        </div>
        </div>
    </div>";







    // Popup - Editar Config
    echo "<div class='popupEditConfig'>
        <h1> AINDA EM DESENVOLVIMENTO.....</h1><span>Configurações Adicionais</span>
        <p>Alterar as configurações pode ter um impacto perceptível na performance da sua plataforma, portanto, tome cuidado ao efetivar as alterações.</p>";
        //<button id='searchGroups'>Procurar Grupos</button>
        //<img  src = '/modules/addons/autonotify_for_whmcs/assets/img/saving.gif' class='ajaxImg'/>
        echo "
        <div class='editConfigInput'>";
            echo "<div id='intervalDiv'>
                <span>Intervalo entre os envios das mensagens</span>
                <div class='divOptionConfig'>";
                    $intervalActivatedLine = $intervalBetweenMessages == "Ativado" ? "<input id='intervalActivated' type='checkbox' class='checkbox' value='Ativado' checked/>" : "<input id='intervalActivated' type='checkbox' class='checkbox' value='Ativado'/>";
                    echo "{$intervalActivatedLine}
                    <label for='intervalActivated'>Ativado</label>
                </div>
                <div class='divOptionConfig'>";
                    $intervalDisabledLine = $intervalBetweenMessages == "Desativado" ? "<input id='intervalDisabled' type='checkbox' class='checkbox' value='Desativado' checked/>" : "<input id='intervalDisabled' type='checkbox' class='checkbox' value='Desativado'/>";
                    echo "{$intervalDisabledLine}
                    <label for='intervalDisabled'>Desativado</label>
                </div>
                <input class='intervalInput' id='intervalInput' type='text' placeholder='Informe em segundos o intervalo'/>
            </div>"; 
    
        echo "</div>
        <button id='saveConfigPlus'><i class='fas fa-cogs'></i>Salvar Alterações</button>
    </div>";
}
?>