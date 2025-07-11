<?php
    function sourei_getTabs() {
        echo '
            <div class="tab_content tabContent-config" data-div="config">
                <i class="fas fa-cog fa-lg"></i>
                <p>Configuração</p>
            </div>
            <div class="tab_content tabContent-template" data-div="template">
                <i class="fas fa-list-alt fa-lg"></i>
                <p>Templates</p>
            </div>
            <div class="tab_content tabContent-qrcode" data-div="qrcode">
                <i class="fas fa-qrcode fa-lg"></i>
                <p>Qrcode</p>
            </div>
            <div class="tab_content tabContent-relatory" data-div="relatory">
                <i class="fas fa-list-alt fa-lg"></i>
                <p>Relatórios</p>
            </div>
            <div style="display: none;" class="tab_content tabContent-envio" data-div="envio">
                <i class="fas fa-envelope fa-lg"></i>
                <p>Envio Manual</p>
            </div>
            <div class="tab_content tabContent-status" data-div="status">
                <i class="fas fa-info-circle fa-lg"></i>
                <p>Status</p>
            </div>';
    }
?>