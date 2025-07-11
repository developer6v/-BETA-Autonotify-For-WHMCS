
jQuery(document).ready(function($){
    $("#searchGroups").click(function() {
        $.ajax({
            url: "/modules/addons/autonotify_for_whmcs/src/controllers/api/searchGroups.php",
            type: "POST",
            beforeSend: function() {
                $(".ajaxImg").css("display","block");
            }
        }).always(function(response) {
            $(".ajaxImg").css("display", "none");

            var data;
            if (response.responseText) {
                console.log("Erro: " + response.responseText);
                data = []; 
            } else {
                data = JSON.parse(response);
            }
            var groups = data;
            var selectGroups = $(".groupConfig");
            selectGroups.empty(); // Limpar opções existentes

            for (var i = 0; i < groups.length; i++) {
                var option = $("<option>", {
                    value: groups[i].id,
                    text: groups[i].title
                });
                selectGroups.append(option);
            }
        });
    });
});



function desconnectApi() {
    jQuery.ajax({
        url: "/modules/addons/autonotify_for_whmcs/src/controllers/api/desconnectApi.php",
        type: "POST"
    }).always(function(response) {
        var data;
        if (response.responseText) {
            data = response.responseText;
        } else {
            data = response;
        }
        if (data == "Erro") {
            alert("Erro na requisição!");
        } else {
            alert("Desconectado!");
        }
        location.reload();
    });
}
