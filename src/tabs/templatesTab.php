<?php
    use WHMCS\Database\Capsule;
    function sourei_tabTemplates () {
        $templates = Capsule::table("sr_templates_for_whmcs")->get();
        echo '
        <div class="divTableTemplates">
        <table class="tableTemplates">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="width: 20%;">Tipo da Mensagem</th>
                    <th style="width: 40%;">Mensagem</th>
                    <th style="width: 20%; margin-left: 10px;">Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>';
            foreach ($templates as $template) {
                $messageTruncated = (strlen($template->message) > 50) ? substr($template->message, 0, 50) . "...": $template->message;
                echo "
                <tr>
                    <td>{$template->id}</td>
                    <td>
                        <div class='messageTypeDivs'>
                            <p>{$template->messageType}</p>
                        </div>
                        <div class='messageTypeDivs templateType templateType-{$template->type}'>
                            <p>$template->type</p>
                        </div>
                    </td>
                    <td>{$messageTruncated}</td>
                    <td>
                        <div class='statusTd statusTd-{$template->status}'>
                            {$template->status}
                        </div>        
                    </td>
                    <td>
                        <button id='edit-{$template->id}' class='editButton'>
                            <i class='fas fa-list-alt fa-lg'></i>
                            <p>EDITAR</p>
                        </button>
                    </td>
                <tr>
                ";
            }
            echo '
            </tbody>
        </table>
        </div>';
    }

    function sourei_templatesPopup () {
        $templates = Capsule::table("sr_templates_for_whmcs")->get();
        foreach ($templates as $template) {
            $selectedAtivo = ($template->status == 'ATIVO') ? " selected" : "";
            $selectedInativo = ($template->status == 'INATIVO') ? " selected" : "";
            $variables = explode(",", $template->variables);
            echo "
            <div class='editDivTemplate edit-{$template->id}'>
                <div class='contentDivTemplate'>
                    <span>Mensagem: #{$template->id} - {$template->messageType}</span><br>
                    <textarea id='templateMessage-{$template->id}' name='message' rows='4' cols='50'>{$template->message}</textarea><br>
                    <span>Variáveis Disponíveis:</span><br>
                    <div class='variablesTemplates'>
                        <ul>";
                        foreach ($variables as $variable) {
                            echo "
                            <li class='variableItem'> {$variable} </li>";
                        }            
                            echo "<li class='variableItem'>{@break} - Dividir mensagem</li>
                        </ul>
                    </div>
                    <select id='templateStatus-{$template->id}' name='templateStatus' class='templateStatus'>
                        <option value='ATIVO'{$selectedAtivo}>Ativo</option>
                        <option value='INATIVO'{$selectedInativo}>Inativo</option>
                    </select>
                    <button onclick='saveTemplate(\"{$template->id}\")' class='buttonEdit saveTemplate' data-messageType='{$template->messageType}'>SALVAR ALTERAÇÕES</button>
                    <button class='buttonEdit cancelTemplate'>CANCELAR ALTERAÇÕES</button>
                </div>
            </div>
            ";
        }
    }
?>