jQuery(document).ready(function($){
    getQrCode();
    setInterval(getQrCode, 10000);
    function getQrCode() {
        $.ajax({
            url: "/modules/addons/autonotify_module_whmcs/src/controllers/api/getQrCode.php",
            type: "POST",

        }).always(function(response) {
            var data;
            if (response.responseText) {
                data = response.responseText;
            } else {
                data = response;
            }
            if (data == "CONECTADO") {
                var pathConnected = "/modules/addons/autonotify_module_whmcs/public/img/connected.png";
                $(".qrCodeImg").attr("src", pathConnected);
            } else if (data == "ERRO") {
                var pathNotConnected = "/modules/addons/autonotify_module_whmcs/public/img/error.png";
                $(".qrCodeImg").attr("src", pathNotConnected);
            } else {
                $(".qrCodeImg").attr("src", data);
            }
            $(".qrCodeImg").attr("alt", data);
            if (data == "CONECTADO") {
                $("#desconnect").show();
            } else {
                $("#desconnect").hide();
            }
        });
    }
});