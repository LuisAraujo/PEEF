filesnames = [];
fileactive = undefined;
json=null;
editor = null;
peditor = new PEditor();
peefbot = new PEEFbot();

var mapcodes = new Map();

$(document).ready(function () {
    checkType(1, "../", readAfterPermission);
});

function readAfterPermission() {

    peefbot.start();

    //backend
    getlastmessages( showChatMessageAndNotification );

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
                //console.log("ok");

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

    window.addEventListener("beforeunload", function(e){
        alert("ok")
        setLog("outproject");
    }, false);

    editor = ace.edit("editor");
    startAceJs();

    //$("#editor").hide();

    /** MENU **/
    //Button Teste
    $("#button-test").click( function(){
        if($(this).hasClass("disable")) {
            alert("Esta ação está inativa ou já foi executada!");
            return;
        }else{
            $(this).addClass("disable");
            $("#button-run").addClass("disable");
        }


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

    //Button Run
    $("#button-run").click(function () {
       
        if($(this).hasClass("disable")) {
            alert("Esta ação está inativa ou já foi executada!");
            return;
        }else{
            $("#loading-code").show();
            $(this).addClass("disable");
            $("#button-test").addClass("disable");
            $("#container-alert-ia").hide();
        }

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
        window.location = "../courses/activity/index.html?page=activity";
    });

    $("#button-new-file").click(function () {
        $("#modal-createcode").show();
    });

    $("#button-create-newfile").click(function () {
        alert("Essa função está indisponível");
        return;

        if($("#input-cratecode").val() != "") {
            createcode($("#input-cratecode").val(), "py");
        }
    });

    $("#button-create-cancel").click(function () {
        $("#modal-createcode").hide();
    });

    $("#labeltalkme").click(function () {
        return;
        
        $("#container-chat").show();
        $("#notification-chat").hide();
        $("#notification-chat").html(0);

        setlastmessagesasview(-1, 1);

        getallmessages( function (data) {
            $("#container-mensage-sended").html("");
            setMessageChat(data);
        });
    });

    $("#button-message").click(function () {
        $("#container-chat").show();
        $("#notification-chat").hide();
        $("#notification-chat").html(0);

        setlastmessagesasview(-1, 1);

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

        if((data!=undefined) && (data.sended == 1))
            $("#check-codesended").prop("checked", true);
    });


    $("#bt-send-message").click(function () {
        // console.log("send msg");
        let text = $("#text-type-message").val();
        sendmessage(text, 0, function () {
            $("#text-type-message").val("");

            $.post("../../backend/project/project_getstateteacher.php" )
                .done(function(data)
                {
                    data = JSON.parse(data);
                    if(data.professor_online != "1")
                        peefbot.getResponse(text);
                })
                .fail(function () {
                    console.log("erro");
                });




            getlastmessages( function (data) {
                setMessageChat(data);
            });
        });
    });


    //verify chat messages
    window.setInterval( function () {
        getlastmessages( showChatMessageAndNotification );
    }, 60*100);


    $(".option-eval").click(function (e) {
        console.log("click")
        updateEnhancedMessage($(this).attr('value'));
        $("#modal-error").hide();
    });


}

function  showChatMessageAndNotification( data ) {
        let unviewed = 0;
        let  length = data.length-1;

        //console.log(data);
        //console.log(data.length);

        if(data.length > 0) {

            //console.log(data[length - unviewed].fromprofessor, data[length - unviewed].hasview)
            //console.log((data[length - unviewed].fromprofessor == "1" ) && (data[length - unviewed].hasview == "0"))

            while ( (data[length - unviewed].fromprofessor == "1" ) && (data[length - unviewed].hasview == "0")) {
                unviewed++;

                if(data[length - unviewed] == undefined)
                    break;


            }

            if(unviewed>0) {
                let lastview = parseInt($("#notification-chat").html());
                $("#notification-chat").html(lastview+unviewed);
                $("#notification-chat").show();

            }else if( $("#notification-chat").html() == "0") {
                $("#notification-chat").hide();
            }
        }

        setMessageChat(data);

        if($("#container-chat").css("display") == "block") {
            setlastmessagesasview(-1, 1);
        }
}

function setMessageChat(data, callback) {

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


    var chatcontainer = $('#container-mensage-sended');
    chatcontainer.scrollTop(chatcontainer.prop("scrollHeight"));

    if(callback != undefined)
        callback();

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

        setLog("indescription");

        getDataActivity( function (data) {

            $("#title-modal-description").html(data.title);
            $("#text-modal-description").html(data.description);
            $("#text-modal-description_input").html(data.description_input);
            $("#text-modal-description_output   ").html(data.description_output);

            $("#out1").html("<td>"+data.input01+"</td><td>"+data.output01+"</td>");
            if( data.output02 != "")
                $("#out2").html("<td>"+data.input02+"</td><td>"+data.output02+"</td>");
            else{
                $("#out2").css("display", "none");
            }
           // $("#modal-description-img").html('<span class="link-image-description"><a href="'+data.image+'" target="_blank"> <i class="icofont-file-jpg"></i> Image 01 </a></span>');
            if(data.image != "") {
                $("#modal-description-img-alt").attr('href', data.image);
                $("#modal-description-img").attr('src', data.image);
            }else{
                $("#modal-description-img").css("display", "none");
                $("#labelimagesuport").css("display", "none");
            }
            $("#modal-description").show();
        });

    });

    $("#bt-close-modal-description").click(function () {
        $("#modal-description").hide();
    });

    $("#bt-close-modal-error").click(function(){
        $("#modal-error").hide();
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
        if($(this).attr("id") == "file-explore-description") {
            return;
        }

        var idcode =  $(this).attr("idcode");
        activeCode( idcode );
        $("#editor").show();


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

    //start with file opened
    if($("#file-explore-0") != undefined){
        $("#file-explore-0").trigger("click");
       // console.log("btn defined");
    }else{
        //console.log("btn undefined");
    }



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


        if( $("#check-codesended").is(':checked') ){
            removeSendProject();
            $("#check-codesended").prop("checked", false);
        }


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