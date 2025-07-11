<?php

function sourei_qrCode() {
 echo '<div class="qrCodeDiv" id="qrCodeDiv">
    <img src="" class="qrCodeImg" alt=""/>
    <div class="buttonsQrCode">
        <button id="desconnect" onclick="desconnectApi()" style="display: none;">
            <i class="fas fa-sign-out-alt"></i>
            <p>Desconectar</p>
        </button>
    </div>
</div>';
}


?>