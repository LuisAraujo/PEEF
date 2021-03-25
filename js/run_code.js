var noutput = 0;
var ninput = 0;
token = "";
iduser = -1;
internalCheckOut = null;

var startRunCode = function () {
   // console.log("runnig code");
    token = getToken();

    noutput = 0;
    ninput = 0;
    $("#out_lines").html("");
    $("#in").show();
    $("#in").focus();

    //get learner n é preciso, id user está na sessao
    getIdLearner(function (data) {
        iduser = data;
        gerateFileCode(iduser, token, function(token, filename){
           // console.log(filename);
            runCode(token, filename);
            internalCheckOut = setInterval(
                function(){ checkOutput(token)} , 1000
            );
        });
    })

};

var gerateFileCode = function(iduser, token, callback){
    $.ajax({
        url: "../../backend/runcode/createfiletempcode.php",
        method: "POST",
        data: {token: token, iduser: iduser, idcode: fileactive}
    }).done(function(data) {
        //console.log(data)
        if(data!="0");
            callback(token, data);
    });
}





var runCode = function(token, nametemp){

    $.ajax({
        url: "../../backend/runcode/run_code.php",
        method: "POST",
        data: {token: token, iduser: iduser, idcode: fileactive, nametemp: nametemp}
    }).done(function(data) {

        if(data == "1"){

            if( peditor.laststatus == PEditor.no){
               // peditor.getfeedbackonmessage = true;
                alertFeedbackonMensage();
            }

            peditor.laststatus= PEditor.success;

        }else if(data == "0"){
            peditor.laststatus=PEditor.error;
        }
        console.log(data);
    });
}

var showError = function(callback){
    $.ajax({
        url: "../../backend/runcode/open_errorfile.php",
        method: "POST",
        data: {token: token, iduser: iduser}
    }).done(function(data) {
        //console.log("getting error");
        callback(data);
    });
}

var setInput = function(input, n_input, token){
    //console.log(input, n_input);
    $.ajax({
        url: "../../backend/runcode/create_input.php",
        method: "POST",
        data:{input: input, n_input: n_input, token: token, iduser: iduser}

    }).done(function(data) {
        //console.log(data);

        if(data == 1)
            ninput++;
    });
}

checkEnhanced = function(token, callback){

    $.ajax({
        url: "../../backend/runcode/open_enhancedfile.php",
        //url: "../../backend/depreciate.manager_section1.php",
        method: "POST",
        data:{token: token, iduser: iduser}
    }).done(function(data) {

        callback(data);

    }) .fail(function(data) {
        console.log(data);
    })
    .always(function() {

    });
}

checkOutput = function(token){

    $.ajax({
        url: "../../backend/runcode/open_outputfile.php",
        //url: "../../backend/depreciate.manager_section1.php",
        method: "POST",
        data:{token: token, iduser: iduser}
    }).done(function(data) {
       // console.log(data);

        var lines = data.split("\n");

        if(noutput < lines.length-1) {

            var localnoutput =  noutput;
            noutput++;

            if (lines[localnoutput] == "__close") {
                $("#out_lines").append("<br>Seu programa terminou...");
                clearInterval(internalCheckOut);
                $("#in").hide();

            } else if (lines[localnoutput] == "__error") {
                showError(function (data) {

                    data = data.replaceAll("\n", "<br>");
                    $("#out_lines").append("<br></b><span class='alert-error'>" + json.originalmessage +": "+ data + "</span>");
                });

                checkEnhanced(token, function (data) {
                    if(data.trim() == "error")
                        data = json.nofound;

                    $("#out_lines").append("<br>-------------------- <br><span class='enhanced-error'>" + json.enhancedmessage +": "+ data + "</span><br>");
                });
            } else {

                if( parseInt(lines[localnoutput].charCodeAt(0)) == 0 ) {
                    $("#in").show();
                    $("#in").focus();
                }

                $("#out_lines").append(lines[localnoutput] + "<br>");
            }
        }
        }) .fail(function(data) {
            console.log("erro");
        })
        .always(function() {

        });
}

/*
* getToken
* geretare token with latter and numbers.
* */
var getToken = function(){
    return    String.fromCharCode(Math.floor( Math.random() * 25  + 65  )) +""+  String.fromCharCode(Math.floor(Math.random() * 25 + 65 )) +""+  Math.floor(Math.random() * 25  + 65 ) +""+  Math.floor(Math.random() * 25  + 65 ) +""+  String.fromCharCode(Math.floor(Math.random() * 25  + 97 ));
}


/*Eventos*/

$(document).on('keypress', function(e) {
    if(e.which == 13) {
        if( $("#in").is(":focus") ){
            $("#in").hide();
            setInput( $("#in").val(), ninput, token );
            $("#out_lines").append( ">> " + $("#in").val() + "<br>" );
            $("#in").val("");
        }else{
            console.log("no focus");
        }
    }
});


$("#out").click(function(){
    $("#in").focus();
});