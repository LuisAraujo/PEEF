$(document).ready(function () {

    setLog("online");

    showAllCourse();

    $("#bt-courses").click( function () {
        showCourse();
    });

    $("#bt-profile").click( function () {
        showProfile();
    });


    $("#inp-find-course").change(function () {
        findCoursByName( $("#inp-find-course").val() );
    });

    $("#bt-find-course").click(function () {
        findCoursByName( $("#inp-find-course").val() );
    });

    window.addEventListener("beforeunload", function(e){
        setLog("offline")
    }, false);

    getdatauser();
});


function  showProfile() {
    $("#container-my-courses").hide();
    $("#container-profile").show();
}

function  showCourse() {
    $("#container-profile").hide();
    $("#container-my-courses").show();
}



function getdatauser() {
    $.post("../../backend/getdatauser.php" )
        .done(function(data)
        {
            data = JSON.parse(data);
            $("#username").text(data.name);
            configLang(data.cod);
        })
        .fail(function () {
            console.log("erro");
        });

}
function configLang(cod) {
    if(cod == null)
        cod =  "eng";

    jQuery.getJSON("../../lang/"+cod+"-text.json", function(data){
        json = data;

        //initial conf
        $("#labelhome").text(data.home);
        $("#labelcourse").text(data.courses);
        $("#labelfind").text(data.find);
        $("#inp-find-course").attr("placeholder", data.findcourse);
        $("#labelprofile").text(data.profile);


    });
}


function findCoursByName(data) {

    $("#container-my-courses").html("");

    $.post("../../backend/course/course_getcoursesbyname.php",{namecourse: data} )
        .done(function(data)
        {
            printDataCourse(data);
        })
        .fail(function () {
            console.log("erro");
        });
}
function showAllCourse() {

    $("#container-my-courses").html("");

    $.post("../../backend/course/course_getcourses.php" )
        .done(function(data)
        {
            printDataCourse(data);
        })
        .fail(function () {
            console.log("erro");
        });


}

function printDataCourse( data ) {

    console.log(data)
    data = JSON.parse(data);
    if(data.length == 0){
        $("#container-my-courses").append("<span>Nothing course finded... </span>");
    }

    for(var i = 0; i < data.length; i++){
        var elem = '<div id="course-'+data[i].id+'" idcourse='+data[i].id+' class="item-courses ';
        if(i%2 == 0)
            elem += 'blue"> ';
        else
            elem += 'blue2"> ';

        elem += '<div class="name-course">';
        elem +=  data[i].name;
        elem += '</div> <div class="container-tag"><div class="tag-course"> <i class="icofont-code"></i> <span>'
        elem +=  data[i].code;
        elem += '</span> </div> <div class="tag-course"> <i class="icofont-user"></i><span>';
        elem += data[i].profname + '</span> </div> ';
        elem += '</div><div class="progress-course"><div class="progress-course-value">30%</div></div>';
        elem += '<div class="title-progress-course">progress</div>';
        elem += ' </div>';

        $("#container-my-courses").append(elem);

        $(".item-courses").click(function () {
            $.post( "../../backend/session/manager_section.php", { currentcourse: $(this).attr("idcourse")  } )
            .done(function(data)
            {
                if(data != "0") {
                    window.location = "activity/index.html";
                }
            })
            .fail(function () {
                console.log("erro");
            });
        })

    }

}