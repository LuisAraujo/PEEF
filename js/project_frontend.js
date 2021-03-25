filesnames = [];
fileactive = undefined;
json=null;
editor = null;
peditor = new PEditor();

var mapcodes = new Map();

$(document).ready(function () {
    //backend

    $(document).keydown(function(event) {

            // If Control or Command key is pressed and the S key is pressed
            // run save function. 83 is the key code for S.


            if((event.ctrlKey || event.metaKey) && event.which == 83) {
                // Save Function
                if(fileactive != undefined )
                    $("#button-save").trigger("click");

                event.preventDefault();
                return false;


            //(R)un code
            }

            if((event.ctrlKey || event.metaKey) && event.which == 82) {
                // Save Function
                if(fileactive != undefined )
                    $("#button-run").trigger("click");

                event.preventDefault();
                return false;


            }

            if((event.ctrlKey || event.metaKey) && event.which == 69) {
                console.log("ok");

                // Save Function
                if(fileactive != undefined )
                    $("#button-test").trigger("click");

                event.preventDefault();
                return false;
            }
        }
    );

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
                startTestCode(); //testcode();
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

    $("#button-back-course").click(function () {
        window.location = "../courses/activity/index.html";
    });

    $("#button-new-file").click(function () {
        $("#modal-createcode").show();
    });

    $("#button-create-newfile").click(function () {
        alert("Essa função está indisponível")

        if($("#input-cratecode").val() != "") {

            createcode($("#input-cratecode").val(), "py");
        }
    });

    $("#button-create-cancel").click(function () {
        $("#modal-createcode").hide();
    });

    $("#button-message").click(function () {
        $("#container-chat").show();

        getallmessages( function (data) {
            $("#container-mensage-sended").html("");
            setMessageChat(data);
        });
    });

    $("#bt-close-chat").click(function () {
        $("#container-chat").hide();
    });

    $('#check-codesended').change(function() {
        if(this.checked) {
            sendProject();
        }else{
            removeSendProject();
        }
    });


    getSendedProject(function (data) {
        if(data.sended == 1)
            $("#check-codesended").prop("checked", true);
    });


    $("#bt-send-message").click(function () {
        console.log("send msg");
        let text = $("#text-type-message").val();
        sendmessage(text, 0, function () {
            $("#text-type-message").val("");

            getlastmessages( function (data) {
                setMessageChat(data);
            });
        });
    });


    //verify chat messages
    window.setInterval( function () {
        getlastmessages( function (data) {
            setMessageChat(data);
        });
    }, 60*100);


    window.addEventListener("beforeunload", function(e){
       setLog("outproject")
    }, false);


});



function setMessageChat(data) {

    for(let i = 0; i < data.length; i++){

        if(data[i].fromprofessor == 1){

            let msg = '<div class="message-item message-sended"><div class="user">Chatbot</div>' +
                '<div class="text">'+data[i].text+'</div><div class="date">'+data[i].date+', '+data[i].horas+'</div></div>';

            $("#container-mensage-sended").append(msg);

        }else{
            let msg = '<div class="message-item message-received"><div class="user">me</div>' +
                '<div class="text">'+data[i].text+'</div><div class="date">'+data[i].date+', '+data[i].horas+'</div></div>';

            $("#container-mensage-sended").append(msg);
        }
    }
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