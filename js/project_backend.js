function getStartPage(){
    $.post( "../../backend/project_getidcode.php").done(
        function (data){
            console.log("ok");
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
            data = JSON.parse(data);
            callback(data);
        });
}
