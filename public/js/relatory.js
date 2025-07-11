jQuery(document).ready(function($){

    $(".pageRelatoryItem").click(function(){
        var page = $(this).data("id");
        var currentURL = window.location.href;
        var urlObject = new URL (currentURL);
        urlObject.searchParams.set("pageRelatory", decodeURIComponent(encodeURIComponent(page)));
        window.location.href = urlObject.href;
    });

    $("#perPageRelatorySelect").on("change", function() {
        var perPage = $(this).val();
        var currentURL = window.location.href;
        var urlObject = new URL (currentURL);
        urlObject.searchParams.set("perPageRelatory", decodeURIComponent(encodeURIComponent(perPage)));
        window.location.href = urlObject.href;
    });


    $("#checkboxSelectRelatory").on("change", function() {
        var ids = [];
        $("input[type=\'checkbox\'].checkboxRelatory:checked").each(function() {
            ids.push($(this).data("id"));
        });
        var ids = ids.join(",");
        $.ajax({
            url: "/modules/addons/autonotify_for_whmcs/src/services/module/deleteItems.php",
            type: "POST",
            data: {
                "tab": "relatory",
                "idstodelete": ids
            }
        }).always(function(response) {
            var data;
            if (response.responseText) {
                console.log("Erro: " + response.responseText);
            } else {
                data = response;
                alert("Itens deletados com sucesso!");
                location.reload();
            }
        });
    });
    $("#selectAllRelatory").on("click", function() {
        if ($("#selectAllRelatory").is(":checked")) {
            $("input[type=\'checkbox\'].checkboxRelatory").prop("checked", true);

        } else {
            $("input[type=\'checkbox\'].checkboxRelatory").prop("checked", false);
        }
        
    });
});