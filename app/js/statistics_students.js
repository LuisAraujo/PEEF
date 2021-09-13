function getProjectsActivity(idstudent, idcourse, callback) {

    $.post("../../../backend/log/getactionsproject.php",
        {idstudent: idstudent, idcourse:idcourse})
        .done(function (data){
            //console.log(data);

            callback(data);
        })
        .fail(function () {
            console.log("erro");
        });
}
