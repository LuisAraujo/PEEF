function checkPermisionProject(idproject, callback) {

    $.post( "../../backend/session/checkpermissionproject.php", {idproject: idproject}).done(
    function (data){
        //console.log(data)
        callback(idproject);
    });

}


function getDataProject(idproject, callback) {

    $.post( "../../backend/datacourse/getdatastudentactivity.php", {idproject: idproject}).done(
        function (data){
            data = JSON.parse(data);
            console.log(data);
            callback(data);
        });

}


function  getInfoCode(idproject, callback) {

    $.post( "../../backend/datacourse/getinfocode.php", {idproject: idproject}).done(
        function (data){
            data = JSON.parse(data);
            console.log(data);
            callback(data);
        });
}

