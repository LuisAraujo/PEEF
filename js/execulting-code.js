function getAllCodesNameByProject( callback ) {

    $.post("../../backend/project_getallcodes.php"
        , function (data) {})
        .done(function (data){
            callback(  JSON.parse( data ) );
        })
        .fail(function () {
            console.log("erro");
        });

}


function getCodesById(id, callback ) {

    $.post("../../backend/project_getcodeprojectbyid.php",
        {idcode: id})
        .done(function (data) {
            callback(  JSON.parse( data ) );
        })
        .fail(function () {
            console.log("erro");
        });

}

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

function savecode(callback) {
    console.log("saving...");
    $.post( "../../backend/save_code.php", {idcode: fileactive, code: editor.getValue() })
        .done(function(data) {
            desactiveAllCode();
            console.log("code saved " + fileactive + "  " +editor.getValue() );
            callback();
        })
}