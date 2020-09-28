function getStartPage(callback){
    $.post( "../../backend/project_getidcode.php").done(
        function (data){
           console.log(data)
           callback();
        });
}


function getIdCurrentProject(){
    return 1;
}

function getIdCurrentCode(){
    return 1;
}

function getIdCurrentAtcivity(){
    return 1;
}

function getIdCurrentLearner(){
    return 1;
}

function getIdLearner(callback){
    $.post( "../../backend/util/getuserid.php").done(
        function (data){
            callback(data);
        });
}


function getDataActivity(callback){
    $.post( "../../backend/project_getdataactivity.php").done(
        function (data){
            console.log(data)
            data = JSON.parse(data);
            callback(data);
        });
}



function   verifyProjectExists(callback) {
    $.post( "../../backend/course_createproject.php").done(
        function (data){
            if(data == "1")
             callback(data);
            else
                alert("Erro when open project!")
        });

}