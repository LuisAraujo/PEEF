function setLog( action, value) {

    $.post("../../backend/log/setlog.php",
        {action: action, value:value})
        .done(function (data){
            console.log(data);
        })
        .fail(function () {
           console.log("erro");
        });
}



function setLog2( action,value) {

    $.post("../../../backend/log/setlog.php",
        {action: action, value:value})
        .done(function (data){
           // console.log(data);
        })
        .fail(function () {
            //console.log("erro");
        });
}

