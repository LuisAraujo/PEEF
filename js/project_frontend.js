filesnames = [];
fileactive = 0;
var mapcodes = new Map();

$(document).ready(function () {

    //get all name project and set it on bar-explore
    getAllCodesNameByProject(getIdCurrentProject,  setCodeNamesMenu );

    editor = ace.edit("editor");
    startAceJs();

    //$("#editor").hide();

    /** MENU **/
    //Button Run
    $("#button-run").click( function(){ savecode(
        function(){
            if(fileactive == 0)
                return;

            $("#item-code-"+fileactive).removeClass("no-saved");
            runcode();
        })
    } );

    $("#button-save").click(function () {
       savecode(function () {});
    });


});


function setCodeNamesMenu(data) {
    $("#explore-bar").empty("");

    $.each(data, function(i) {
        //show in explore bar
        $("#explore-bar").append(
            '<div id="file-explore-' + i + '" class="file-explore-bar" numberitem="0" idcode =' + data[i].id + ' >' +
            '<i class="icofont-file-python"></i>' +
            '<span  class="container-filename">' + data[i].name + '</span>' +
            '</div>'
        );

    });

        $(".item-code").click( function(){
            activeCode( $(this).attr("idcode") );
        });

        //when click show code in editor
        $(".file-explore-bar").click(function () {

        var idcode =  $(this).attr("idcode");
        activeCode( idcode );
        //$("#editor").show();



        if( $("#item-code-" + $(this).attr('idcode') ).length == 0 ) {
            //get code the first time in bd
            getCodesById( idcode ,  showCodeInEditor );
            console.log("get code bd");
           //show in editor bar
           $("#editor-bar").append(
               '<div id="item-code-' + $(this).attr("idcode") + '" class="item-code" idcode="' + $(this).attr("idcode") + '">' +
               data[0].name + '</div>'
           )
       }else{
            console.log("get code the temp code \n"+ mapcodes.get(idcode.toString()));
            //get code the temp code
            showCodeInEditor( mapcodes.get(idcode) );
        }


    });
}

function showCodeInEditor(data) {
     editor.setValue(data);
     //forcing remove * in name file, couse modification in editor
     //$("#item-code-"+fileactive).removeClass("no-saved");
}

function activeCode( numberitem ){

    $(".item-code").removeClass("active");
    $("#item-code-" +  numberitem).addClass("active");
    fileactive = parseInt( numberitem );

}


function desactiveAllCode(  ){
    console.log("active")
    $(".item-code").removeClass("active");

}

function startAceJs(){

    editor.setTheme("ace/theme/chrome");
    editor.setShowPrintMargin(false);
    editor.session.setMode("ace/mode/python");
    document.getElementById('editor').style.fontSize='15px';

    editor.getSession().on('change', function() {

        mapcodes.set(fileactive.toString(), editor.getValue()) ;
        console.log(fileactive);
        console.log("change \n" + mapcodes.get(fileactive.toString()) );
        updateAceJs();
    });
}

function updateAceJs(){
    $("#item-code-"+fileactive).addClass("no-saved");
}
