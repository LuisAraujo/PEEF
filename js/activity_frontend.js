jsonlang =  null;

$(document).ready(function () {

    checkType(1, "../../", readyAfterPermission);

});


function readyAfterPermission() {

    setLog2("oncourse");

    $( ".container-activity").hide();
    $("#container-alerts").show();
    $("#bt-explore-alerts").addClass("active");

    $(".item-menu").click(function () {

        $(".item-menu").removeClass("active");
        $(this).addClass("active");
        $( ".container-activity").hide();
        $( "#container-" + $(this).attr("ref") ).show();
    });


    $("#bt-explore-back").click(function () {
        window.location = "../";
    });

    window.addEventListener("beforeunload", function(e){
        setLog("outcourse");
    }, false);


    getAllClasses();
    getAllAlerts();
    getAllActivity();
    getdatauser();
    getNameCourse();
    getProgress();


}

function getdatauser() {
    $.post("../../../backend/users/getdatauser.php" )
        .done(function(data)
        {
            data = JSON.parse(data);
            $("#labelusername").text(data.name);
            configLang(data.cod);
        })
        .fail(function () {
            console.log("erro");
        });

}

function getNameCourse() {
    $.post("../../../backend/course/getnamecourse.php" )
        .done(function(data)
        {
            $("#namecourse").text(data);
        })
        .fail(function () {
            console.log("erro");
        });
}

function configLang(cod) {
    if(cod == null)
        cod =  "eng";

    jQuery.getJSON("../../../lang/"+cod+"-text.json", function(data){
        jsonlang = data;

        //initial conf

        $("#labelback").text(data.backcourse);
        $("#labelnotification").text(data.notification);
        $("#labelactivity").text(data.activities);
        $("#labeltitle").text(data.title);
        $("#labelsended").text(data.sended);
        $("#labelchat").text(data.chat);
        $("#labelcorrect").text(data.correct);
        $("#labelcourse").text(data.course);
        $("#labelclasses").text(data.classes);
        $("#labelprogress").text(data.progress);
        $("#labelalert").text(data.alert);

    });
}





function getAllClasses() {
    $.post( "../../../backend/course/course_getclasses.php", function( data ) {
       // console.log(data);
        var json = JSON.parse(data);
        for(var i= 0 ; i < json.length; i++){
            var elem ='<div class="class-item"> <div class="title-class">'+json[i].title+'</div> <div class="description-class"> '+json[i].description+' </div> <div class="video-class"> <iframe type="text/html" width="640" height="360" src="http://www.youtube.com/embed/'+json[i].url+'?autoplay=1&origin=http://example.com"></iframe> </div> </div>'
            $("#container-my-classe").append(elem)
        }
    });
}

function getProgress() {
    $.post( "../../../backend/course/course_getprogressbytopic.php", function( data ) {

        var json = JSON.parse(data);
        for(var i= 0 ; i < json.length; i++){
            var elem ='<div class="item-progress-course">\n' +
                '<div class="nametopic-progress-course">'+json[i].topic+'</div>\n' +
                '<div class="progress-course-grey"><div class="progress-course-value" style="width:'+json[i].percent+'% ">' +json[i].percent+ '%</div></div></div>'
            $("#container-my-progress").append(elem)
        }
    });
}

function getAllAlerts() {
    $.post( "../../../backend/course/course_getalerts.php", function( data ) {
        // console.log(data);
        var json = JSON.parse(data);
        for(var i= 0 ; i < json.length; i++){
            var elem ='<div class="alert-course"> <div class="title-class">'+json[i].title+'</div> <div class="datealert-class">'+json[i].date+'</div><div class="description-class"> '+json[i].text+' </div> </div>'
            $("#container-alerts").append(elem)
        }
    });
}

function getAllActivity() {
    $.post("../../../backend/course/course_getactivitiesanddata.php", function (data) {

        var json = JSON.parse(data);
        console.log(json.length);
        for (var i = 0; i < json.length; i++) {
            var elem = "";

            if( ( i == 0) ||  (json[i-1].topic != json[i].topic) ){
                elem += "<h3>"+json[i].topic+"</h3>";
            }

            elem += '<div class="list-item activity-item" idactivity="'+ json[i].id_act  +'" idproject="' + json[i].id + '"> <div class="title-activity">' + json[i].title + '</div> ';
            elem += '<div class="options-item-list"> ';

            if (json[i].delivered == 1)
                elem += '<div class="lable"><i class="icofont-flag actived" title="Delivered"></i></div> ';
            else
                elem += '<div class="lable"><i class="icofont-flag " title="Delivered"></i></div> ';

            if (json[i].correct == 1)
                elem += '<div ><i class="icofont-check-circled" title="Correct"></i></div>';
            else
                elem += '<div class="lable"><i class="icofont-error" title="Error"></i></div>';

            elem += ' <!-- <div ><i class="icofont-error" title="Wrong"></i></div> --> ';

            if (json[i].hasmessage > 0)
                elem += '<div class="lable"><i class="icofont-chat actived" title="message"></i></div> </div>';
            else
                elem += '<div class="lable"><i class="icofont-chat" title="message"></i></div> </div>';


            elem += '</div>';

            $("#container-my-activity").append(elem)
        }


        $(".activity-item").click(function () {

            let idactivity = $(this).attr("idactivity");
            let idproject = $(this).attr("idproject");

            if (idproject == "null") {

                $.post("../../../backend/project/project_create.php", {idactivity: idactivity})

                    .done(function (data) {
                        console.log(data);
                        if (data != "0"){
                            openProjectPage(data);
                        }
                    })
                    .fail(function () {
                        console.log("erro");
                    });

            } else {
                openProjectPage(idproject);
            }
        });
    });
}





function openProjectPage( idactivity ) {


    $.post( "../../../backend/session/manager_section.php", { currentproject: idactivity} )

        .done(function(data)
        {
            console.log(data)
            if(data != "0") {
                window.location = "../../projects/index.html";
            }
        })
        .fail(function () {
            console.log("erro");
        });
}
