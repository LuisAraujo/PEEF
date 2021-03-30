function calcEditString(idproject, callback) {

    $.post( "../../backend/metrics/calc_editline_dinamicprog_byproject.php", {idproject: idproject}).done(
        function (data){
            //console.log(data)
            callback(idproject);
        });

}