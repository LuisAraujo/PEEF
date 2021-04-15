function checkType(type, back, callback,callback2) {

    $.ajax({
        url: back+"../backend/security/checktypeuser.php",
    }).done( function(data){
        if(data == type){
            callback();
        }else{
            if(callback2 != undefined)
                callback2();
            else
                window.location =  back;
        }
    });
}
