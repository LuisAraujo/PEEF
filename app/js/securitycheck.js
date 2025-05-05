function checkType(type, back, callback,callback2) {

    $.ajax({
        url: back+"../backend/security/checktypeuser.php",
    }).done( function(data){
        if(data == type){
            console.log(data);
            callback(data);
        }else{
            if(callback2 != undefined)
                callback2(data);
            else
                window.location =  back;
        }
    });
}
