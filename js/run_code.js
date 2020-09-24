var noutput = 0;
var ninput = 0;
token = "";
iduser = -1;
internalCheckOut = null;

var startRunCode = function () {
    console.log("runnig code");
    token = getToken();

    noutput = 0;
    ninput = 0;
    $("#out_lines").html("");
    $("#in").show();



    $("#in").focus();

    getIdLearner(function (data) {
        iduser = data;
        runCode(token);
        internalCheckOut = setInterval( function(){ checkOutput(token)} , 1000);

    })

};

var runCode = function(token){

    $.ajax({
        url: "../../backend/runcode/run_code.php",
        method: "POST",
        data: {token: token, iduser: iduser}
    }).done(function(data) {
        console.log("executing php called");
        console.log(data);
    });
}

var showError = function(callback){
    $.ajax({
        url: "../../backend/runcode/open_errorfile.php",
        method: "POST",
        data: {token: token, iduser: iduser}
    }).done(function(data) {
        console.log("getting error");
        callback(data);
    });
}

var setInput = function(input, n_input, token){
    console.log(input, n_input);
    $.ajax({
        url: "../../backend/runcode/create_input.php",
        method: "POST",
        data:{input: input, n_input: n_input, token: token, iduser: iduser}

    }).done(function(data) {
        console.log(data);

        if(data == 1)
            ninput++;
    });
}

checkOutput = function(token){

    $.ajax({
        url: "../../backend/runcode/open_outputfile.php",
        //url: "../../backend/manager_section1.php",
        method: "POST",
        data:{token: token, iduser: iduser}
    }).done(function(data) {

        console.log(" --- " +data);

        var lines = data.split("\n");

        if(noutput < lines.length-1) {
            if (lines[noutput] == "__close") {
                $("#out_lines").append("<br>Seu programa terminou...");
                clearInterval(internalCheckOut);
                $("#in").hide();

            } else if (lines[noutput] == "__error") {
                showError(function (data) {

                    data = data.replaceAll("\n", "<br>");
                    $("#out_lines").append("<span class='alert-error'>" + data + "</span>");
                });
            } else {

                    console.log(lines[noutput].charCodeAt(0))
                    if( parseInt(lines[noutput].charCodeAt(0)) == 0 ) {
                        $("#in").show();
                        $("#in").focus();
                    }

                $("#out_lines").append(lines[noutput] + "<br>");
            }

            noutput++;
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