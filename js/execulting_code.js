/**
 * @name getAllCodesNameByProject
 * @desc get all name of codes in database  by project id
 * @param idproject - identify the project
 * @param callback - function called after done
 */
function getAllCodesNameByProject(idproject, callback ) {

    $.post("../../backend/project_getallcodes.php",
    {idproject: idproject})
        .done(function (data){
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


    $.post("../../backend/project_getcodeprojectbyid.php",
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


/**
 * @name runcode
 * @desc run the current active code data in databasee
 */
function runcode(){

	$.post( "../../backend/execulting_code.php", {idcode: fileactive }, function(data) { })
	.done(function(out) {
        console.log("compiled code");
        var msg =  "<span class='alert'>"+COMPILED_SUCESS+"</span> <br><br>";

        if(out == "1")
           msg +=  "<span class='alert-sucess'> " +TEST_PASSED;
        else {
            msg += "<span class='alert-error'> " + TEST_NPASSED + "(" + out + "%) </span>" ;
        }

        $("#console-container .contents").html(msg);
		//$("#console-container .contents").html(msg + out);
	})
	.fail(function(data) {
        console.log("error on compilation");
        var msg = "<span class='alert-error'> " + ERROR_ACESSFILE + "(" + data + "%) </span>" ;
		$("#console-container .contents").html(msg);
	})

}

/**
 * @name savecode
 * @desc save the current active code data in database
 * @param callback - function called after done
 */
function savecode(callback) {
    console.log("saving...");
    $.post( "../../backend/save_code.php", {idcode: fileactive, code: editor.getValue() })
        .done(function(data) {

            $("#item-code-"+fileactive).removeClass("no-saved");

            console.log("code saved " + fileactive + "  " +editor.getValue() );
            callback();
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
    req.open("GET", '../../backend/download_code.php?idcode='+fileactive , true);
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