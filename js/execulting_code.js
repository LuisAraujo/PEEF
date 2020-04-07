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
            var jdata = JSON.parse( data )

            if( mapcodes.get(idcode.toString()) == undefined)
                mapcodes.set(idcode.toString(), jdata.code);

            callback(  jdata.code  );
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

	$.post( "../../backend/execulting-code.php", {idcode: fileactive }, function(data) { })
	.done(function(data) {
        console.log("compiled code");
		$("#console-container .contents").html(data);
	})
	.fail(function(data) {
        console.log("error on compilation");
		$("#console-container .contents").html("Tivemos um error ao exectar o arquivo, tente novamente! :(" );
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