jQuery(document).ready(function($){

    var checkboxes = $("#intervalDiv .checkbox");

    checkboxes.on("change", function() {
        checkboxes.not(this).prop("checked", false);
    });

   

    $("#saveAutonotify").click(function(){
        var instance_key = $("#instancekey").val();
        var admin_phone = $("#adminphone").val();
        var systemStatus = $("#systemstatus").val();
        
        $.ajax({
            url: "/modules/addons/autonotify_module_whmcs/src/services/module/saveConfig.php",
            type: "POST",
            data: {
                "instance_key": instance_key,
                "admin_phone": admin_phone,
                "systemStatus" : systemStatus
            }
        }).always(function(response) {
            var data;
            if (response.responseText) {
                console.log("Erro: " + response.responseText);
            } else {
                data = response;
                alert("Sucesso");
                location.reload();
            }
        });
    });



});

function saveTemplate(id) {
    var status = $("#templateStatus-" + id).val();
    var message = $("#templateMessage-" + id).val();
    jQuery.ajax({
        url: "/modules/addons/autonotify_module_whmcs/src/services/module/saveTemplate.php",
        type: "POST",
        data: {
            "idTemplate": id,
            "messageTemplate": message,
            "statusTemplate": status
        }
    }).always(function(response) {
        var data;
        if (response.responseText) {
            console.log("Erro: " + response.responseText);
        } else {
            data = response;
            alert("Template Salvo");
            location.reload();
        }
    });
}
