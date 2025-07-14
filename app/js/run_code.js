var noutput = 0;
var ninput = 0;
token = "";
iduser = -1;
internalCheckOut = null;
timeCheckOut = 600;
var out_lines = document.getElementById("out_lines");
var listPromise = [];
var cancelAll = false;

function inputf () {
    // the function returns a promise to give a result back later...
    $("#in").show();
    $("#in").focus();

     var l = new Promise(function(resolve,reject){
       
         $("#in").on("keyup",function(e){
           if (e.keyCode == 13)
           {
               // remove keyup handler from #output
               $("#in").off("keyup");
               // resolve the promise with the value of the input field
               try{
                 resolve($("#in").val());
                 console.log("input "+ $("#in").val());
                 $("#in").val("");
                 $("#in").hide();
               }catch(e){
                 console.log(e);
               }
           }
       })

       if(cancelAll){
           reject(); 
       }
    });
    listPromise.push(l);
    return l;
 }

 function outf(text) {
    console.log("out");
     if(text=="")
        return;

    if(out_lines.innerHTML == "")
        out_lines.innerHTML = out_lines.innerHTML + ">> " +text;
    else
        out_lines.innerHTML = out_lines.innerHTML +"<br> >> "+ text;
// }
   $("#input").val("");
}

function builtinRead(x) {
    //console.log(x);
    if (Sk.builtinFiles === undefined || Sk.builtinFiles["files"][x] === undefined)
            throw "File not found: '" + x + "'";
    return Sk.builtinFiles["files"][x];
    }

    
var startRunCode = function () {
    
    var prog = editor.getValue(); 
    
    out_lines.innerHTML = ''; 
    Sk.pre = "output";
    
    Sk.configure({
        inputfun: inputf,
        output: outf,
        read: builtinRead
    });

    var myPromise = Sk.misceval.asyncToPromise(
        function() {
            return Sk.importMainWithBody("<stdin>", false, prog, true);
        }
    );

    myPromise.then(function(mod) {
        console.log("hahhsa");
      
        $("#loading-code").hide();
        $("#out_lines").append("<br>Seu programa terminou...");
        $("#button-run").removeClass("disable");
        saveExecution("");
        //showSuccessMensage();
    },
    function(err) {
        $("#loading-code").hide();
        $("#out_lines").append("<br></b><span class='alert-error'>" + err.toString() +"</span>");
        $("#button-run").removeClass("disable");
        data = {code: editor.getValue(), error: err.toString(), atvdesc: $("#text-modal-description").text() }
        sendPromptbyGroup(data, function(){ $("#container-alert-ia").hide();});
        console.log("error");
        saveExecution(err.toString());
        $("#container-alert-ia").show();
        /*state_code = ERROR;
        msgerro = err.toString();
        saveExecution();*/

    });

};


/*Eventos
$(document).on('keypress', function(e) {
    if(e.which == 13) {
        if( $("#in").is(":focus") ){
            $("#in").hide();
            $("#out_lines").append("<< " +$("#in").val() + "<br>" );
            $("#in").val("");
        }else{
            console.log("no focus");
        }
    }
});*/


$("#out").click(function(){
    $("#in").focus();
});