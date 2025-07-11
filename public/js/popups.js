jQuery(document).ready(function($){

    $(".editButton").click(function(){
        $(".editDivTemplate").css("display", "none");
        $(".overlaySourei").css("display", "block");
        var id = $(this).attr("id");
        $("." + id).css("display", "block");
    });

    $(".moreConfig").click(function(){
        $(".overlaySourei").css("display", "block");
        $(".popupEditConfig").css("display", "block");
    });

    $(".overlaySourei").click(function(){
        $(".popupEditConfig").css("display", "none");
        $(".editDivTemplate").css("display", "none");
        $(".editDivRelatory").css("display", "none");
        $(".overlaySourei").css("display", "none");
    });
    $(".cancelTemplate").click(function(){
        $(".editDivTemplate").css("display", "none");
        $(".overlaySourei").css("display", "none");
    });

    $(".seeButton").click(function(){
        $(".editDivRelatory").css("display", "none");
        $(".overlaySourei").css("display", "block");
        var id = $(this).attr("id");
        $(".see-" + id).css("display", "block");
    }); 

});