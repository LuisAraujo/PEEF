filesnames = [];
fileactive = 0;


$(document).ready(function () {
    var json_result = getAllCodesNameByProject(  setCodeNamesMenu );

    editor = ace.edit("editor");

    $("#editor").hide();

    startAceJs();

    $("#button-run").click( function(){ savecode(
        function(){
            if(fileactive == 0)
                return;

            $("#item-code-"+fileactive).removeClass("no-saved");
            runcode();
        })
    } );

    $(".file-explore-bar").click( function(){
        activeCode( $(this).attr("numberitem") );
    });

});


function setCodeNamesMenu(data) {
    $("#explore-bar").empty("");

    $.each(data, function(i) {
        //show in explore bar
        $("#explore-bar").append(
            '<div id="file-explore-'+i+'" class="file-explore-bar" numberitem="0" idcode ='+data[i].id+' >'+
            '<i class="icofont-file-python"></i>'+
            '<span  class="container-filename">'+ data[i].name +'</span>' +
            '</div>'
        );



        $(".item-code").click( function(){
            activeCode( $(this).attr("idcode") );
        });

        //when click show code in editor
        $(".file-explore-bar").click(function () {
            getCodesById(  $(this).attr("idcode") ,  showCodeInEditor );
            activeCode( $(this).attr("idcode") );

            $("#editor").show();

            if( $("#item-code-" + $(this).attr('idcode') ).length == 0 ) {
               //show in editor bar
               $("#editor-bar").append(
                   '<div id="item-code-' + $(this).attr("idcode") + '" class="item-code" idcode="' + $(this).attr("idcode") + '">' +
                   data[0].name + '</div>'
               )
           }
        });

        //forcing click in first element
        //$("#file-explore-0").trigger("click");

    });
}

function showCodeInEditor(data) {
     editor.setValue(data.code);
}

function activeCode( numberitem ){
    console.log("active")
    $(".item-code").removeClass("active");
    $("#item-code-" +  numberitem).addClass("active");
    fileactive = parseInt( numberitem );
    //showcode(numberitem);
}


function desactiveAllCode(  ){
    console.log("active")
    $(".item-code").removeClass("active");
    $(".item-code").removeClass("no-saved");
}

function startAceJs(){

    editor.setTheme("ace/theme/chrome");
    editor.setShowPrintMargin(false);
    editor.session.setMode("ace/mode/python");
    document.getElementById('editor').style.fontSize='15px';

    editor.getSession().on('change', function() {
        updateAceJs();
    });
}

function updateAceJs(){
    $("#item-code-"+fileactive).addClass("no-saved");
}
