<?php 

use WHMCS\Database\Capsule;

function sourei_relatoryTab($perPageRelatory, $pageRelatory, $offset) {
    $relatory = Capsule::table("sr_relatory_for_whmcs")->orderBy('id', 'desc')->limit($perPageRelatory)->offset($offset)->get(); 
    $totalItemsRelatory = Capsule::table("sr_relatory_for_whmcs")->count();
    echo '<div class="divFiltersRelatory">
            <div class="divPerPage">
                <label>
                    Registros por página: 
                    <select id="perPageRelatorySelect" name="perPageRelatory">';
                        $options = [10, 25, 50, 100]; 
                        foreach ($options as $option) {
                            $selected = ($option == $perPageRelatory) ? ' selected' : '';
                            echo "<option value=\"$option\"$selected>$option</option>";
                        }echo
                    '</select>
                </label>
            </div>';
            /*<div class="divSearch">
                <label>
                    Procurar:
                    <input id="searchInput" type="text"/>
                </label>
            </div>
            */
        echo '</div>
        <div class="divTableRelatory">
            <table class="tableRelatory">
                <thead>
                    <tr>
                        <th>';
                            echo "<input type='checkbox' class='selectAllRelatory' id='selectAllRelatory'  name='checkbox'>";
                        echo '</th>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Tipo</th>
                        <th>Nome</th>
                        <th >Mensagem</th>
                        <th>Data do Envio</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($relatory as $item) {
                    $messageTruncated = (strlen($item->message) > 50) ? substr($item->message, 0, 50) . "...": $item->message;
                    $messageTypeRelatory = $item->type;
                    $typeTemplate = Capsule::table("sr_templates_for_whmcs")->where("messageType", "=", $messageTypeRelatory)->value("type");
                    echo "
                    <tr>
                        <td>
                        <input type='checkbox' class='checkboxRelatory' data-id='{$item->id}' name='checkbox'>
                        </td>
                        <td>{$item->id}</td>
                        <td style='color: #25D366; font-weight: bold;'>#({$item->clientId})</td>
                        <td>
                            <div class='messageTypeDivs'>
                                <p>{$item->type}</p>
                            </div>
                            <div class='messageTypeDivs templateType templateType-{$typeTemplate}'>
                                <p>{$typeTemplate}</p>
                            </div>
                        </td>
                        <td>{$item->name}</td>
                        <td>{$messageTruncated}</td>
                        <td>{$item->sendDate}</td>
                        <td>
                            <button id='{$item->id}' class='seeButton'>
                                <i class='fas fa-list-alt fa-lg'></i>
                                <p>VER</p>
                            </button>
                        </td>
                    <tr>";
                }
                echo '
                </tbody>
            </table>
        </div>';
        if ($perPageRelatory > $totalItemsRelatory) {
            $pagesQuantity = 1;
        } else {
            $pagesQuantity = ceil($totalItemsRelatory / $perPageRelatory);
        }
        echo '
        <div class="footerRelatory">
            <div class="divPageRelatory">
                <label>Página:';
                for ($i=1; $i<=$pagesQuantity; $i++) {
                    if ($i == $pageRelatory) {
                        echo "<div data-id='{$i}' class='pageRelatoryItem pageItemSelected'>";
                    } else {
                        echo "<div data-id='{$i}' class='pageRelatoryItem pageItem'>";
                    }
                    echo "
                        <span>{$i}</span>                    
                    </div>";
                }
                echo '</label>
            </div>
            <div class="divSelectAllRelatory">
                <label> Com os selecionados: 
                <select id="checkboxSelectRelatory" name="checkboxSelectRelatory">
                    <option disabled selected>Escolha uma opção</option>
                    <option value="Apagar">Apagar</option>
                </select>
                </label>
            </div>
        </div>';
}

function sourei_relatoryPopup ($perPageRelatory, $pageRelatory, $offset) {
    global $CONFIG;
    $adminFolder = App::get_admin_folder_name();
    $adminUrl = $CONFIG['SystemURL'] . '/' . $adminFolder;
    $relatory = Capsule::table("sr_relatory_for_whmcs")->orderBy('id', 'desc')->limit($perPageRelatory)->offset($offset)->get(); 
    foreach ($relatory as $item) {
        echo "<div class='editDivRelatory see-{$item->id}'>
            <div class='contentDivRelatory'>
                <span class='titleRelatory'>Relatório #{$item->id} - {$item->type}</span><br>
                <div class='titleInfoRelatory'>
                    <span><i class='fas fa-file-alt'></i> DADOS MENSAGEM:</span>
                </div>
                <div class='relatoryInfo'>
                    <div class='divRelatoryInfo'>
                        <span>CLIENTE: </span>
                    
                        <p>{$item->name}  <a href='{$adminUrl}/clientssummary.php?userid={$item->clientId}' target='blank'><bold>(#{$item->clientId})</bold></a></p>
                    </div>
                    <div class='divRelatoryInfo'>
                        <span>CELULAR:</span>
                        <i class='fab fa-whatsapp whatsapp'></i>
                        <p>{$item->phone}</p>
                    </div>
                    <div class='divRelatoryInfo'>
                        <span>DATA DE ENVIO: </span>
                        <p>{$item->sendDate}</p>
                    </div>
                </div>
                <div class='titleInfoRelatory'>
                    <span><i class='fas fa-envelope'></i> MENSAGEM:</span>
                </div>
                <div class='relatoryMessage'>
                    <textarea name='message' rows='4' cols='50'>{$item->message}
                    </textarea><br>
                </div>
            </div>
        </div>";
    }
}
?>