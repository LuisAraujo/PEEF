var lastcompilation;

function getStartPage(callback){
    $.post( "../../backend/project/project_getidcode.php").done(
        function (data){
          // console.log(data)
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
            console.log(data);
            callback(data);
        });
}


function getDataActivity(callback){
    $.post( "../../backend/project/project_getdataactivity.php").done(
        function (data){
            console.log(data);
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

function getSendedProject(callback) {
    $.post("../../backend/project/project_getsendproject.php",{sended:1} )
        .done(function(data)
        {
            //console.log(data)
            data = JSON.parse(data);
            callback(data);
        })
        .fail(function () {
            console.log("erro");
        });

}

function sendProject() {
    $.post("../../backend/project/project_sendproject.php",{sended:1} )
    .done(function(data)
    {
        console.log(data)
    })
    .fail(function () {
        console.log("erro");
    });

}


function removeSendProject() {
    $.post("../../backend/project/project_sendproject.php",{sended:0} )
    .done(function(data)
    {
        console.log(data)
    })
    .fail(function () {
        console.log("erro");
    });
}

function getdatauser(callback) {
    $.post("../../backend/users/getdatauser.php" )
        .done(function(data)
        {
            data = JSON.parse(data);
            $("#labelusername").text(data.name);
            $("#img-profile").css("background-image","url(../../"+data.urlprofile+" )" );

            configLang(data.cod, callback);
        })
        .fail(function () {
            console.log("erro");
        });

}

function configLang(cod, callback) {
    if(cod == null)
        cod =  "eng";

    jQuery.getJSON("../../lang/"+cod+"-text.json", function(data){
        json = data;

        //initial conf
        //initial conf
        $("#labelnewfile").text(data.newfile);
        $("#labelsave").text(data.save);
        $("#labelrun").text(data.run);
        $("#labeltest").text(data.test);
        $("#labeldownload").text(data.download);
        $("#labelchat").text(data.chat);
        $("#labelsendcode").text( data.send_code.toUpperCase());
        $("#labeldescription").text( data.description);
        $("#labeldescription_input").text( data.input);
        $("#labelinput").text( data.input);
        $("#labeldescription_output").text( data.output);
        $("#labeloutput").text( data.output);
        $("#labeltalkme").text(data.talkme);
        $("#labelneedhelp").text( data.needhelp);
        $("#labelbackcourse").text( data.backcourse);

        callback();

    });
}


function saveExecution(errormsg){
    $.post("../../backend/runcode/save_execution.php", {errormsg: errormsg})
        .done(function(data)
        {
            console.log(data);
            data = JSON.parse(data);
            lastcompilation = data.id;
            
        })
        .fail(function () {
            console.log("erro");
        });
}

function saveEnhancedMessage(data){
  
 $.post("../../backend/runcode/save_enhancedmessage.php", {id: lastcompilation, message: data })
        .done(function(data)
        {console.log(data);
            data = JSON.parse(data);
            console.log(data);
            lastenhancedmsg = data.id;
        })
        .fail(function () {
            console.log("erro");
        });
}

function updateEnhancedMessage(data){
 $.post("../../backend/runcode/update_enhancedmessage.php", {id: lastenhancedmsg, value: data})
        .done(function(data)
        {console.log(data);
            data = JSON.parse(data);
            console.log(data);
        })
        .fail(function () {
            console.log("erro");
        });
}