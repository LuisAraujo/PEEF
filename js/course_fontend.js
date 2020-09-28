$(document).ready(function () {

    setLog("online");

    showAllCourse();

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
        $("#labelnotifcation").text(data.notification);
        $("#labelcourse").text(data.course);
        $("#labelfind").text(data.find);
        $("#labelfindcourse").attr("placeholder", data.findcourse);

    });
}


function findCoursByName(data) {

    $("#container-my-courses").html("");

    $.post("../../backend/course_getcoursesbyname.php",{namecourse: data} )
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

    $.post("../../backend/course_getcourses.php" )
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

        elem += '<span class="bt-close"> <i class="icofont-navigation-menu"></i> </span> <div class="name-course">';
        elem +=  data[i].name;
        elem += '</div> <div class="code-course"> <i class="icofont-code"></i> <span>'
        elem +=  data[i].code;
        elem += '</span> </div> <div class="professor-course"> <i class="icofont-user"></i><span>';
        elem += data[i].profname + '</span> </div> </div>';

        $("#container-my-courses").append(elem);

        $(".item-courses").click(function () {
            $.post( "../../backend/manager_section.php", { currentcourse: $(this).attr("idcourse")  } )
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