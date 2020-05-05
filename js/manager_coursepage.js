$(document).ready(function () {
    $("#container-my-activity").hide();

    $("#bt-explore-activity").click(function () {
       showActivity();
    });

    $("#bt-explore-home").click(function () {
       showHome();
    });

    getAllClasses();
    getAllActivity();
});


function  showActivity() {
    $("#container-my-classe").hide();
    $("#container-my-activity").show();
}

function  showHome() {
    $("#container-my-activity").hide();
    $("#container-my-classe").show();
}


function getAllClasses() {
    $.post( "../../../backend/course_getclasses.php", function( data ) {
        console.log(data);
        var json = JSON.parse(data);
        for(var i= 0 ; i < json.length; i++){
            var elem ='<div class="class-item"> <div class="title-class">'+json[i].title+'</div> <div class="description-class"> '+json[i].description+' </div> <div class="video-class"> <iframe type="text/html" width="640" height="360" src="http://www.youtube.com/embed/'+json[i].url+'?autoplay=1&origin=http://example.com"></iframe> </div> </div>'
            $("#container-my-classe").append(elem)
        }
    });
}


function getAllActivity() {
    $.post( "../../../backend/course_getactivities.php", function( data ) {
    //console.log(data);
    var json = JSON.parse(data);
    for(var i= 0 ; i < json.length; i++){

        var elem ='<div class="activity-item" idactivity="'+json[i].id+'"> <div class="title-activity">'+json[i].title+'</div> ';
        elem +=  '<div ><i class="icofont-flag" title="Sended"></i></div> ';
        elem +=  '<div ><i class="icofont-check-circled" title="Correct"></i></div>';
        elem +=  ' <!-- <div ><i class="icofont-error" title="Wrong"></i></div> --> ';
        elem +=  '<div><i class="icofont-chat actived" title="message"></i></div> </div>';

        $("#container-my-activity").append(elem)

    }

    $(".activity-item").click(function () {
        console.log("click item")
        $.post( "../../../backend/course_getidproject.php", { idactivity: $(this).attr("idactivity")  } )
        .done(function(data)
        {
            data = JSON.parse(data);
            console.log("get data idproj" + data);
            $.post( "../../../backend/manager_section.php", { currentproject: data.id } )

                .done(function(data)
                {
                    console.log("get data manager")
                    if(data != "0") {
                        window.location = "../../projects/index.html";
                    }
                })
                .fail(function () {
                    console.log("erro");
                });


        })
        .fail(function () {
            console.log("erro");
        });
    });
  });
}



