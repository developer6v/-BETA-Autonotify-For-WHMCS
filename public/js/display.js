jQuery(document).ready(function($){


    $(".tab_content").click(function(){
        $(".tab_content").css("color", "black");
        $(this).css("color", "#1062fe");
        $(".div_content").css("display", "none");
        var divOpen = $(this).data("div");
        $(".sourei_" + divOpen).css("display", "block");
        var currentURL = window.location.href;
        var urlObject = new URL (currentURL);
        urlObject.searchParams.set("tab", decodeURIComponent(encodeURIComponent(divOpen)));
        history.pushState({}, "", urlObject);
    });
});