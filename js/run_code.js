var noutput = 0;
var ninput = 0;
var lastlengthout = 0;
var started = false;
token = "";
internalCheckOut = null;

var runCode = function(token){

    $.ajax({
        url: "../../backend/runcode/run_code.php",
        method: "POST",
        data: {token: token}
    }).done(function(data) {

        console.log("executing php called");
        console.log(data);
    });
}

var showError = function(callback){
    $.ajax({
        url: "../../backend/runcode/open_errorfile.php",
        method: "POST",
        data: {token: token}
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
        data:{input: input, n_input: n_input, token: token}

    }).done(function(data) {
        console.log(data);

        if(data == 1)
            ninput++;
    });
}

var checkOutput = function(){

    $.ajax({
        url: "../../backend/runcode/open_outputfile.php",
        method: "POST",
        data:{token: token}
    }).done(function(data) {

        var lines = data.split("\n");

        if(noutput < lines.length-1){
            if(lines[noutput] == "__close"){
                $("#out_lines").append("<br>Seu programa terminou...");
                clearInterval(internalCheckOut);
                $("#in").hide();

            }else if(lines[noutput] == "__error"){
                showError( function(data){

                    data = data.replaceAll("\n", "<br>");
                    $("#out_lines").append("<span class='alert-error'>"+data+"</span>");
                });
            }else{
                $("#out_lines").append( lines[noutput] + "<br>");
            }

            noutput++;
        }



    });
}




var onkey = $(document).on('keypress', function(e) {
    if(e.which == 13) {
        if( $("#in").is(":focus") ){
            setInput( $("#in").val(), ninput, token );
            $("#out_lines").append( ">> " + $("#in").val() + "<br>" );
            $("#in").val("");
        }else{
            console.log("no focus");
        }
    }
});

var getToken = function(){

    return    String.fromCharCode(Math.floor( Math.random() * 25  + 65  )) +""+  String.fromCharCode(Math.floor(Math.random() * 25 + 65 )) +""+  Math.floor(Math.random() * 25  + 65 ) +""+  Math.floor(Math.random() * 25  + 65 ) +""+  String.fromCharCode(Math.floor(Math.random() * 25  + 97 ));

}

runcode = function () {
    console.log("runnig code");
    token = getToken();

    runCode(token);
    internalCheckOut = setInterval( function(){ checkOutput(token)} , 1000);

    $("#in").focus();
};


$("#out").click(function(){
    $("#in").focus();
});