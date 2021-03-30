jsonlang =  null;

$(document).ready(function () {

    setLog2("oncourse");

    $("#container-my-activity").hide();

    $("#bt-explore-activity").click(function () {
       showActivity();
    });

    $("#bt-explore-home").click(function () {
       showHome();
    });

    window.addEventListener("beforeunload", function(e){
        setLog("outcourse")
    }, false);

    getAllClasses();
    getAllActivity();
    getdatauser();
    getNameCourse();



});


function getdatauser() {
    $.post("../../../backend/getdatauser.php" )
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

        $("#labelhome").text(data.home);
        $("#labelnotification").text(data.notification);
        $("#labelactivity").text(data.activity);
        $("#labeltitle").text(data.title);
        $("#labelsended").text(data.sended);
        $("#labelchat").text(data.chat);
        $("#labelcorrect").text(data.correct);
        $("#labelcourse").text(data.course);



    });
}


function  showActivity() {
    $("#container-my-classe").hide();
    $("#container-my-activity").show();
}

function  showHome() {
    $("#container-my-activity").hide();
    $("#container-my-classe").show();
}


function getAllClasses() {
    $.post( "../../../backend/course/course_getclasses.php", function( data ) {
        console.log(data);
        var json = JSON.parse(data);
        for(var i= 0 ; i < json.length; i++){
            var elem ='<div class="class-item"> <div class="title-class">'+json[i].title+'</div> <div class="description-class"> '+json[i].description+' </div> <div class="video-class"> <iframe type="text/html" width="640" height="360" src="http://www.youtube.com/embed/'+json[i].url+'?autoplay=1&origin=http://example.com"></iframe> </div> </div>'
            $("#container-my-classe").append(elem)
        }
    });
}


function getAllActivity() {
    $.post( "../../../backend/course/course_getactivitiesanddata.php", function( data ) {

    var json = JSON.parse(data);
    for(var i= 0 ; i < json.length; i++){

        var elem ='<div class="list-item activity-item" idactivity="'+json[i].id+'"> <div class="title-activity">'+json[i].title+'</div> ';
        elem +=  '<div class="options-item-list"> ';

        if(json[i].delivered == 1)
            elem +=  '<div class="lable"><i class="icofont-flag actived" title="Delivered"></i></div> ';
        else
            elem +=  '<div class="lable"><i class="icofont-flag " title="Delivered"></i></div> ';

        if(json[i].correct == 1)
            elem +=  '<div ><i class="icofont-check-circled" title="Correct"></i></div>';
        else
            elem +=  '<div class="lable"><i class="icofont-error" title="Error"></i></div>';

        elem +=  ' <!-- <div ><i class="icofont-error" title="Wrong"></i></div> --> ';

        if(json[i].hasmessage > 0)
            elem +=  '<div class="lable"><i class="icofont-chat actived" title="message"></i></div> </div>';
        else
            elem +=  '<div class="lable"><i class="icofont-chat" title="message"></i></div> </div>';


        elem +=  '</div>';

        $("#container-my-activity").append(elem)

    }

    $(".activity-item").click(function () {
        console.log("click item")
       // $.post( "../../../backend/course/course_getidproject.php", { idactivity: $(this).attr("idactivity")  } )
        //.done(function(data)
       // {
            //data = JSON.parse(data);
            //console.log("get data idproj" , data);
            //$.post( "../../../backend/session/manager_section.php", { currentproject: data.id } )
            $.post( "../../../backend/session/manager_section.php", { currentproject: $(this).attr("idactivity") } )

                .done(function(data)
                {
                    console.log("get data editstring")
                    if(data != "0") {
                        window.location = "../../projects/index.html";
                    }
                })
                .fail(function () {
                    console.log("erro");
                });


        })
       // .fail(function () {
        //    console.log("erro");
        //});
    //});
  });
}



