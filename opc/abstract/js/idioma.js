function es(){
    var get = window.location.search.substr(1);
    var txt_get = "";
    if(get === ""){
        txt_get = get;
    } else {
        var tmp = [];
        var item = get.split("&");
        for(var i=0; i < item.length; i++){
            tmp = item[i].split("=");
            if(tmp[0] !== "lang"){
                txt_get += "&"+tmp[0]+"="+tmp[1];
            }
        }
    }
    window.location.href = "?lang=es"+txt_get;
}
function en(){
    var get = window.location.search.substr(1);
    var txt_get = "";
    if(get === ""){
        txt_get = get;
    } else {
        var tmp = [];
        var item = get.split("&");
        for(var i=0; i < item.length; i++){
            tmp = item[i].split("=");
            if(tmp[0] !== "lang"){
                txt_get += "&"+tmp[0]+"="+tmp[1];
            }
        }
    }
    window.location.href = "?lang=en"+txt_get;
}
function pt(){
    var get = window.location.search.substr(1);
    var txt_get = "";
    if(get === ""){
        txt_get = get;
    } else {
        var tmp = [];
        var item = get.split("&");
        for(var i=0; i < item.length; i++){
            tmp = item[i].split("=");
            if(tmp[0] !== "lang"){
                txt_get += "&"+tmp[0]+"="+tmp[1];
            }
        }
    }
    window.location.href = "?lang=pt"+txt_get;
}