$(document).ready(function () {

    checkType(1, "../", readAfterPermission);

});



function readAfterPermission() {


    setLog("online");
    showAllCourse();

    getSexy( function (data) {
        for(let i = 0; i < data.length; i++)
            $("#selectsexy").append("<option value='"+data[i].id+"'>"+data[i].name+"</option>")

        getLanguages( function (data) {
            for(let i = 0; i < data.length; i++)
                $("#selectlanguage").append("<option value='"+data[i].id+"'>"+(data[i].cod.toUpperCase())+"</option>")

            getdatauser(function (data) {
                $("#username").text(data.name);
                $("#username2").val(data.name);
                $("#usersexy").val(data.sexy);
                $("#userbio").val(data.bio);

                $("#selectlanguage").val(data.idlang);
                $("#selectsexy").val(data.sexy);
                $("#profileimage").css("background-image","url(../../"+data.urlprofile+" )" );

            });

        });
    });




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


    $("#from-updateprofile").submit(function () {

        dataform = new FormData(this);

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "../../backend/users/updateuser.php",
            data: dataform,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false
        }).done( function(data){

            $("#userpassword").val("");

            if(data == "1"){

                alert("Cadastro atualizado!");

                getdatauser(function (data) {
                    $("#username").text(data.name);
                    $("#username2").val(data.name);
                    $("#usersexy").val(data.sexy);
                    $("#userbio").val(data.bio);

                    $("#selectlanguage").val(data.idlang);
                    $("#selectsexy").val(data.sexy);
                    $("#profileimage").css("background-image","url(../../"+data.urlprofile+")" );

                });
            }else{
                alert("Erro ao atualizar o Cadastro!");
            }
        }).fail( function(data){
            console.log(data);
        });

        return false;

    });


    $("#btcall-image").click(function () {
        $("#inp-imageprofile").trigger("click");
    });

    $("#inp-imageprofile").change(function (e) {
        $("#namefile").html( $(this)[0].files[0].name );
    });


}


function  showProfile() {
    $("#container-my-courses").hide();
    $("#container-profile").show();
}

function  showCourse() {
    $("#container-profile").hide();
    $("#container-my-courses").show();
}



function getdatauser(callback) {
    $.post("../../backend/users/getdatauser.php" )
        .done(function(data)
        {
            data = JSON.parse(data);
            configLang(data.cod);

            if(callback != undefined)
                callback(data);
        })
        .fail(function () {
            console.log("erro");
        });

}

function getLanguages(callback) {
    $.post("../../backend/users/getsislanguage.php" )
        .done(function(data)
        {
            data = JSON.parse(data);
            callback(data);
        })
        .fail(function () {
            console.log("erro");
        });
}

function getSexy(callback) {
    $.post("../../backend/users/getsexy.php" )
        .done(function(data)
        {
            data = JSON.parse(data);
            callback(data);
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



function printDataCourse( data, percent ) {

    console.log(data)
    data = JSON.parse(data);
    if(data.length == 0){
        $("#container-my-courses").append("<span>Nothing course finded... </span>");
    }

    for(var i = 0; i < data.length; i++){
        localdata = data[i];

        $.post("../../backend/course/course_getprogress.php",{idcourses: data[i].id} )
            .done(function(data2) {

                data2 = JSON.parse(data2);

                var elem = '<div id="course-'+localdata.id+'" idcourse='+localdata.id+' class="item-courses ';
                if(i%2 == 0)
                    elem += 'blue"> ';
                else
                    elem += 'blue2"> ';

                elem += '<div class="name-course">';
                elem +=  localdata.name;
                elem += '</div> <div class="container-tag"><div class="tag-course"> <i class="icofont-code"></i> <span>'
                elem +=  localdata.code;
                elem += '</span> </div> <div class="tag-course"> <i class="icofont-user"></i><span>';
                elem += localdata.profname + '</span> </div> ';
                elem += '</div><div class="progress-course"><div class="progress-course-value" style="width:'+data2.percent+'% ">'+data2.percent+'%</div></div>';
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

            });

    }

}