function getStartPage(){
    $.post( "../../backend/project_page.php").done(
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