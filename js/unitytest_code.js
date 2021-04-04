/**
 * @name getAllCodesNameByProject
 * @desc get all name of codes in database  by project id
 * @param idproject - identify the project
 * @param callback - function called after done
 */
function getAllCodesNameByProject(callback) {

    $.post("../../backend/project/project_getallcodes.php")
        .done(function (data){
            console.log(data);
            callback(  JSON.parse( data ) );
        })
        .fail(function () {
            console.log("erro on get names code");
        });
}

/**
 * @name getCodesById
 * @desc get code by code id
 * @param idproject - identify the code
 * @param callback - function called after done
 */
function getCodesById(idcode, callback ) {


    $.post("../../backend/project/project_getcodeprojectbyid.php",
        {idcode: idcode})
        .done(function (data) {

            var jdata = JSON.parse( data );

            if( mapcodes.get(idcode.toString()) == undefined)
                mapcodes.set( idcode.toString(), jdata.code);

            showCodeInEditor( jdata.code, "get bd" );

        })
        .fail(function () {
            console.log("erro on get code by id");
        });
}



var startTestCode = function () {

    token = getToken();

    gerateFileTestCode( token, function(token, filename){
        console.log(filename);
        testCode(token, filename);
    });


};



var gerateFileTestCode = function( token, callback){
    $.ajax({
        url: "../../backend/unitytest/createfiletemptestcode.php",
        method: "POST",
        data: {token: token, idcode: fileactive}
    }).done(function(data) {
        console.log(data)
        if(data!="0")
            callback(token);
    });
}


/**
 * @name runcode
 * @desc run the current active code data in databasee
 */
function testCode(token){

	//$.post( "../../backend/depreciate.unitytest_code.php",
	$.post( "../../backend/unitytest/unitytest_code_.php",
    {idcode: fileactive, token: token },
    function(data) { })
	.done(function(out) {
        console.log(out)
        $("#labelresulttest").text(json.result_test);

        if(out != "0"){

            var jsonout = JSON.parse(out);

            console.log(jsonout)

            $("#percent-passed").html(jsonout.total.percent + "%") ;
            $("#percent-passed").css("width", jsonout.total.percent + "%")
            $("#ntestepassed").html(jsonout.total.npassed + " " +json.test2 + "(s) " + json.passed);
            $("#ntestefailed").html(jsonout.total.nfail +" " +json.test2 + "(s) " + json.fail);


            $("#container-unittests").html("");
            for(var i = 0; i < jsonout.tests.length; i++)
            {
                var testunit = '<div class="container-unittest"> <div class="hlinetest-container"><b>'+json.test2 + ' '+(i+1)+'</b></div>';
                if(jsonout.tests[i].passed == 1)
                    testunit += '<div class="linetest-container"><b>'+json.status+':</b> <span class="status-unittest approved"></span> '+json.passed+'</div>';
                else
                    testunit += '<div class="linetest-container"><b>'+json.status+':</b> <span class="status-unittest reapproved"></span>'+json.fail+' </div>';

                testunit += '<div class="linetest-container"><b>'+json.input+'(s):'+jsonout.tests[i].in+'</b>  </div>';
                testunit += '<div class="linetest-container"><b>'+json.actual_output+'(s):'+jsonout.tests[i].out+'</b>  </div>';
                testunit += '<div class="linetest-container"><b>'+json.expected_output+'(s): '+jsonout.tests[i].wait+'</b> </div> </div>';

                $("#container-unittests").append(testunit);
            }

            if( peditor.laststatus == PEditor.no){
                peditor.laststatus = PEditor.success;
                alertFeedbackonMensage();
            }

        }else if(out == "0"){
           $("#container-unittests").append(json.error_code);
            peditor.laststatus = PEditor.error;
           return;
        }





        //$("#console-container .contents").html(msg);
		//$("#console-container .contents").html(msg + out);
	})
	.fail(function(data) {
        //console.log("error on compilation");
        var msg = "<span class='alert-error'> " + ERROR_ACESSFILE + "(" + data + "%) </span>" ;
		$("#console-container .contents").html(msg);
	})

}



/**
 * @name runcode
 * @desc run the current active code data in database
 * @param callback - function called after done

function runcode(callback) {

    console.log("saving...");

    $.post( "../../backend/runcode/run_code.php",
        {idcode: fileactive, code: editor.getValue() })
        .done(function(data) {


        })
}
 */

/**
 * @name savecode
 * @desc save the current active code data in database
 * @param callback - function called after done
 */
function savecode(callback) {

   // console.log("saving...");

    $.post( "../../backend/save_code.php",
        {idcode: fileactive, code: editor.getValue() })
        .done(function(data) {

            $("#item-code-"+fileactive).removeClass("no-saved");

            //console.log("code saved " + fileactive + "  " +editor.getValue() );
            callback();
           // console.log(callback);
        })
}



/**
 * @name createcode
 * @desc create code tin databasee
 */
function createcode(name, extension ){

    $.post( "../../backend/create_code.php", {name: name, extension: extension })
        .done(function(data) {

            getAllCodesNameByProject(getIdCurrentProject,  setCodeNamesMenu );
            $("#modal-createcode").hide();
        })
        .fail(function(data) {
            console.log("error on create file");
            $("#console-container .contents").html(ERROR_CREATEFILE);
        });
}

function  downloadcode() {
  if(fileactive == 0)
       return;

    var req = new XMLHttpRequest();
    req.open("GET", '../../backend/project/download_code.php?idcode='+fileactive , true);
    req.responseType = "blob";
    req.onload = function (event) {
        console.log(req)
        var blob = req.response;
        var fileName = req.getResponseHeader('Content-Disposition').split("fileName=")[1];  //if you have the fileName header available
        var link=document.createElement('a');
        link.href=window.URL.createObjectURL(blob);
        link.download=fileName;
        link.click();
    };

    req.send();


   /* $.post( "../../backend/download_code.php", {idcode: fileactive}) .done(
        function(data) {console.log(data)
        });*/

}