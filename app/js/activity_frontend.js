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
        setLog2("offcourse");
    }, false);


    getAllClasses();
    getAllAlerts();
    getAllActivity();
    getdatauser();
    getNameCourse();
    getProgress();


    var getidproject = window.location.search.substr(1);
    if((getidproject != undefined) && (getidproject != "")) {
        param = getidproject.split("=")[0];
        page = ""

        if (param == "page") {
            page = getidproject.split("=")[1];
            console.log(param, page);
            if(page == "activity")
                $("#bt-explore-activity").trigger("click");
        }
    }

}

function getdatauser() {
    $.post("../../../backend/users/getdatauser.php" )
        .done(function(data)
        {
            data = JSON.parse(data);
            $("#labelusername").text(data.name);
            $("#profileimage").css("background-image","url(../../../"+data.urlprofile+" )" );

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
        //console.log(data);
        var json = JSON.parse(data);
        for(var i= 0 ; i < json.length; i++){

            var elem ='<div class="class-item"> <div class="title-class">'+json[i].title+'</div> <div id="description-class'+i+'" class="description-class"> '+json[i].description+' <div class="click-reloadvideo" ref="'+json[i].url+'"  ref2="'+i+'" ><i class="icofont-play"></i> reaload</div> </div> <div id="container-video'+i+'" class="video-class" > <iframe  class="frame-video-class" id="videoclass'+i+'" type="text/html" width="640" height="360" src="http://www.youtube.com/embed/'+json[i].url+'"></iframe> </div> </div>';
            //var elem ='<div class="class-item"> <div class="title-class">'+json[i].title+'</div> <div class="description-class"> '+json[i].description+' </div> <div id="videoclass'+i+'" class="video-class" ref="'+json[i].url+'">  </div> </div>'
            $("#container-my-classe").append(elem);

        }

        $(".click-reloadvideo").click(function () {
            console.log( $(this).attr("ref2"), $(this).attr("ref1") );
            $("#container-video"+ $(this).attr("ref2")).remove();
            $("#description-class" + $(this).attr("ref2") ).after('<iframe  class="frame-video-class" id="container-video'+ $(this).attr("ref2")+'"  type="text/html" width="640" height="360" src="http://www.youtube.com/embed/'+$(this).attr("ref")+'"></iframe>');
           // $("#container-video"+ $(this).attr("ref2") ).html();

        });

    });

    var j = document.createElement("script"),
        f = document.getElementsByTagName("body")[0]
    j.src = "//www.youtube.com/iframe_api";
    j.async = true;
    f.parentNode.insertBefore(j, f);
    console.log('API Loaded');

}

function getProgress() {
    $.post( "../../../backend/course/course_getprogressbytopic.php", function( data ) {

        var json = JSON.parse(data);

        for(var i= 0 ; i < json.length; i++){
            var elem ='<div class="item-progress-course">\n' +
                '<div class="nametopic-progress-course">'+json[i].topic+' ('+json[i].percent+ '%)</div>\n' +
                '<div class="progress-course-grey"><div class="progress-course-value" style="width:'+json[i].percent+'% "></div></div></div>'
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


function onYouTubeIframeAPIReady() {


    listvideo = $(".video-class");

    for(var i = 0; i < listvideo.length; i++){
        new YT.Player(listvideo[i].id, {
            height: '360',
            width: '640',
            videoId: $(listvideo[i]).attr("ref"), //'M7lc1UVf-VE',
            events: {
                //'onReady': onPlayerReady,
                'onStateChange': onPlayerStateChange
            }
        });
    }

}

function onPlayerStateChange(event) {
    console.log(YT.PlayerState)

    if (event.data == YT.PlayerState.PLAYING) {

        setLog2("playvideo", event.target.h.id);
    }//do something on video ends
    else if(event.data === YT.PlayerState.PAUSED) {
        setLog2("stopvideo", event.target.h.id);
    }
}