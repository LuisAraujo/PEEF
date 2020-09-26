function setLog( action) {

    $.post("../../backend/log/setlog.php",
        {action: action})
        .done(function (data){
            console.log(data);
        })
        .fail(function () {
            console.log("erro");
        });
}


function setLog2( action) {

    $.post("../../../backend/log/setlog.php",
        {action: action})
        .done(function (data){
            console.log(data);
        })
        .fail(function () {
            console.log("erro");
        });
}

