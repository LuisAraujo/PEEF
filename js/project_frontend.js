filesnames = [];
fileactive = undefined;
json=null;
editor = null;
peditor = new PEditor();

var mapcodes = new Map();

$(document).ready(function () {
    //backend

    setLog("inproject");

    getStartPage( function () {
        //get all name project and set it on bar-explore
        getdatauser( function () {
            getAllCodesNameByProject( setCodeNamesMenu);
        });

    });



    editor = ace.edit("editor");
    startAceJs();

    //$("#editor").hide();

    /** MENU **/
    //Button Run
    $("#button-test").click( function(){
        if($(this).hasClass("disable"))
            return;

        $("#percent-passed").html("0%") ;
        $("#percent-passed").css("width", "0%" );
        $("#ntestepassed").html("?");
        $("#ntestefailed").html("?");
        $("#container-unittests").html("  ...");

        $("#console-container").hide();
        $("#test-container").show();

        savecode(
            function(){
                if(fileactive == 0)
                    return;

                $("#item-code-"+fileactive).removeClass("no-saved");
                testcode();
            }
        );


    } );

    $("#button-run").click(function () {
        if($(this).hasClass("disable"))
            return;

        $("#console-container").show();
        $("#test-container").hide();

        savecode(
            function(){
                if(fileactive == 0)
                    return;

                $("#item-code-"+fileactive).removeClass("no-saved");
                startRunCode();
            }
        );

    });

    $("#button-save").click(function () {
        if($(this).hasClass("disable"))
            return;
       savecode(function () {});
    });

    $("#button-download").click(function () {
        if($(this).hasClass("disable"))
            return;
        downloadcode();
    });

    $("#button-new-file").click(function () {
        $("#modal-createcode").show();
    });

    $("#button-create-newfile").click(function () {
        if($("#input-cratecode").val() != "") {

            createcode($("#input-cratecode").val(), "py");
        }
    });

    $("#button-create-cancel").click(function () {
        $("#modal-createcode").hide();
    });

    $("#button-message").click(function () {
        $("#container-chat").show();
    });

    $("#bt-close-chat").click(function () {
        $("#container-chat").hide();
    });



    window.addEventListener("beforeunload", function(e){
       setLog("outproject")
    }, false);


});


function getdatauser(callback) {
    $.post("../../backend/getdatauser.php" )
        .done(function(data)
        {
            data = JSON.parse(data);
            $("#labelusername").text(data.name);
            configLang(data.cod, callback);
        })
        .fail(function () {
            console.log("erro");
        });

}

function configLang(cod, callback) {
    if(cod == null)
        cod =  "eng";

    jQuery.getJSON("../../lang/"+cod+"-text.json", function(data){
        json = data;

        //initial conf
        //initial conf
        $("#labelnewfile").text(data.newfile);
        $("#labelsave").text(data.save);
        $("#labelrun").text(data.run);
        $("#labeltest").text(data.test);
        $("#labeldownload").text(data.download);
        $("#labelchat").text(data.chat);
        $("#labelsendcode").text( data.send_code.toUpperCase());
        $("#labeldescription").text( data.description);
        $("#labeldescription_input").text( data.input);
        $("#labelinput").text( data.input);
        $("#labeldescription_output").text( data.output);
        $("#labeloutput").text( data.output);
        $("#labeltalkme").text(data.talkme);
        $("#labelneedhelp").text( data.needhelp);

        callback();

    });
}



function setCodeNamesMenu(data) {
    //1.clear bar explore
    $("#explore-bar").empty("");


    $("#explore-bar").append(
        '<div id="file-explore-description" class="file-explore-bar"  >' +
        '<i class="icofont-file-pdf"></i>' +
        '<span  id="labeldescription" class="container-filename"> '+ json.description +'    </span>' +
        '</div>'
    );


    $("#file-explore-description").click(function () {

        getDataActivity( function (data) {
            //console.log(data);
            $("#title-modal-description").html(data.title);
            $("#text-modal-description").html(data.description);
            $("#text-modal-description_input").html(data.description_input);
            $("#text-modal-description_output   ").html(data.description_output);

            $("#out1").html("<td>"+data.input01+"</td><td>"+data.output01+"</td>");
            $("#out2").html("<td>"+data.input02+"</td><td>"+data.output02+"</td>");

            $("#modal-description-img").html('<span class="link-image-description"><a href="'+data.image+'" target="_blank"> <i class="icofont-file-jpg"></i> Image 01 </a></span>');
            $("#modal-description").show();
        });

    });

    $("#bt-close-modal-description").click(function () {
        $("#modal-description").hide();
    });

    //2.get file list and set item file-explore-bar in bar explore
    $.each(data, function(i) {
        //show in explore bar
        $("#explore-bar").append(
            '<div id="file-explore-' + i + '" class="file-explore-bar"  name =' + data[i].name + ' idcode =' + data[i].id + ' >' +
            '<i class="icofont-file-python"></i>' +
            '<span  class="container-filename"> ' + data[i].name + '</span>' +
            '</div>'
        );
    });

    //3. when click in itens file-explore-bar show code in editor
    $(".file-explore-bar").click(function () {
        if($(this).attr("id") == "file-explore-description")
            return;

        var idcode =  $(this).attr("idcode");
        activeCode( idcode );

        //already get data?
        if( $("#item-code-" + idcode ).length == 0 ) {

            //get code the first time in bd
            getCodesById( idcode ,  showCodeInEditor );

            //console.info("get code bd");

            //show in ed
            $("#editor-bar").append(
               '<div id="item-code-' + $(this).attr("idcode") + '" class="item-code" idcode="' + $(this).attr("idcode") + '">' +
                $(this).attr("name") + '</div>'
            );

            //item tab code
            $(".item-code").click( function(){
                activeCode( $(this).attr("idcode") );
            });


       }else{
            //console.log("get code the temp code \n"+ idcode + "  "+ mapcodes.get(idcode.toString()));
            //get code the temp code
            showCodeInEditor( mapcodes.get(idcode), "temp");
        }



    });



}

function showCodeInEditor(data) {

    editor.setValue(data);

}

function activeCode( idcode ){

    $(".item-code").removeClass("active");
    $("#item-code-" +  idcode).addClass("active");

    fileactive = idcode;

    var tempcode = mapcodes.get(fileactive.toString());

    if(tempcode != undefined)
        showCodeInEditor( tempcode );

    $("#button-download").removeClass("disable");
    $("#button-run").removeClass("disable");
    $("#button-test").removeClass("disable");
    $("#button-save").removeClass("disable");
}


function desactiveAllCode(  ){
    //console.log("active")
    $(".item-code").removeClass("active");

}

function startAceJs(){

    editor.setTheme("ace/theme/chrome");
    editor.setShowPrintMargin(false);
    editor.session.setMode("ace/mode/python");
    document.getElementById('editor').style.fontSize='15px';

    editor.getSession().on('change', function() {

        if( peditor.laststatus == PEditor.error){
            peditor.laststatus = PEditor.no;
            setLog("fixingcode");
        }
        if (fileactive != undefined) {
            mapcodes.set(fileactive.toString(), editor.getValue());
            updateAceJs();
        }else{
            console.error("Fileactive is undefined!")
        }


    });
}

function updateAceJs(){
    $("#item-code-"+fileactive).addClass("no-saved");
}


function alertFeedbackonMensage(){
console.log('feedback');
    confirm("Pelo visto você solucionou o problema. A mensagem de erro lhe ajudou nisso?", function (){},function (){});

}