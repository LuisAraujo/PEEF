idproject = -1;
idcode = -1;
editor = null;



$(document).ready(function () {

    getidproject = window.location.search.substr(1);
    if((getidproject != undefined) && (getidproject != "")){
        param = getidproject.split("=")[0];
        if(param == "id") {
            getidproject = getidproject.split("=")[1];

            checkPermisionProject(getidproject, function (data) {
                if(parseInt(data) != 0){
                    idproject = data;

                    setChatOn(idproject);
                    editor = ace.edit("editor");
                    startAceJs();

                    getDataProject( idproject, function (data) {
                        $("#studentename").val(data.sname);
                        $("#activityname").val(data.title);
                        $("#coursename").val(data.cname);
                    });

                    getIdCode(idproject, setDataStudent);

                    window.setInterval( function () {
                        getIdCode(idproject, setDataStudent );
                    }, 60*100);


                    $("#button-turnedit").click(function () {
                       window.location = "../editstring/index.html?id="+idproject;
                    });



                    $.post( "../../backend/project/project_setstateteacher.php", {state: 1, idproject: idproject} )
                        .done(function(data) {
                            console.log(data)
                        } );

                }
            });

        }else{

        }
    }



    window.addEventListener("beforeunload", function(e){
        $.post( "../../backend/project/project_setstateteacher.php", {state: 0, idproject: idproject} )
            .done(function(data2) {} );
    }, false);




});


function setDataStudent(data) {


        $("#status_typeerro").html(data.typeerror);

        if(data.typeerror == "no-error"){

            $("#status_typeerro").removeClass("error");
            $("#status_typeerro").addClass("success");

        }else{
            $("#status_typeerro").removeClass("sucess");
            $("#status_typeerro").addClass("error");
        }

        $("#status_lineerro").html(data.lineerror);
        $("#status_testpassed").html(data.testpassed);
        $("#status_erromsg").html(data.erromessage.substr(0, 10));
        $("#status_erromsg").attr("title", data.erromessage);
        editor.setValue(data.code);
        editor.setReadOnly(true)
}

function setChatOn(idproject) {

    $("#default-messages").change(function () {
        $("#text-type-message").html( $(this).val() );
    });

    //verify chat messages
    window.setInterval( function () {
        getlastmessagesbyprojectid( idproject ,function (data) {
            setMessageChat(data);
            setlastmessagesasview(idproject, 0);
        });
    }, 60*100);

    getallmessagesbyprojectid( idproject , function (data) {

        $("#container-mensage-sended").html("");
        setMessageChat(data);
    });


    $("#bt-send-message").click(function () {

        let text = $("#text-type-message").val();
        sendmessagetoproject(text, 1, idproject ,function () {
            $("#text-type-message").val("");

            getlastmessagesbyprojectid( idproject, function (data) {
                setMessageChat(data);

            });
        });
    });



}

function setMessageChat(data) {

    for(let i = 0; i < data.length; i++){

        if(data[i].fromprofessor == 0){

            let msg = '<div class="message-item message-sended"><div class="user">Estudante</div>' +
                '<div class="text">'+data[i].text+'</div><div class="date">'+data[i].date+', '+data[i].horas+'</div></div>';

            $("#container-mensage-sended").append(msg);

        }else{
            let msg = '<div class="message-item message-received"><div class="user">Eu</div>' +
                '<div class="text">'+data[i].text+'</div><div class="date">'+data[i].date+', '+data[i].horas+'</div></div>';

            $("#container-mensage-sended").append(msg);
        }
    }

    var chatcontainer = $('#container-mensage-sended');
    chatcontainer.scrollTop(chatcontainer.prop("scrollHeight"));
}



function startAceJs(){

    editor.setTheme("ace/theme/chrome");
    editor.setShowPrintMargin(false);
    editor.session.setMode("ace/mode/python");
    document.getElementById('editor').style.fontSize='15px';
}