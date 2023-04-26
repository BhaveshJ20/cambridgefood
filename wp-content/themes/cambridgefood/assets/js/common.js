$(window).on("load", function() {
    $(".preloader").hide();    
    
    /*var page_url = $("#page_url").val();    
    if(page_url.indexOf('/specials/leaflets') !== -1 ){
        $("#enq_button").click();
    }*/
});

function openTips(tipsName){
    var previousTipDisplay = $("#currentTipDisplay").val();
    $("#main-tip-section").hide();
    if(previousTipDisplay != tipsName && previousTipDisplay != ''){        
        $("#"+previousTipDisplay).hide();
        $("#"+tipsName).show();        
    }else{        
        $("#"+tipsName).show();
    } 
    $("#currentTipDisplay").val(tipsName);
}

function goBackTips(){
    var previousTipDisplay = $("#currentTipDisplay").val();
    $("#main-tip-section").show();
    $("#"+previousTipDisplay).hide();    
}


function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}