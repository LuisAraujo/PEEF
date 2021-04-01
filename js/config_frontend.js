$(document).ready(function () {
    getdatauser();

    $.post( "../../backend/session/manager_section.php",
        {currentcourse: -1  });

    $(".item-menu").click(function () {

        $(".item-menu").removeClass("active");
        $(this).addClass("active");
        $( ".container-activity").hide();
        $( "#container-" + $(this).attr("ref") ).show();
    });

    $("#bt-dashboard").click(function () {
        window.open("../dashboard/index.html", "_self");
    });


   getAllCourse(function (data) {

        var json = JSON.parse(data);
        $("#selectcourses_createclass").html("<option></option>");
        $("#selectcourses_createactivity").html("<option></option>");
        for(var i= 0 ; i < json.length; i++){
            var elem ='<option value="'+json[i].id+'">'+ json[i].name+ '</option>'
            $("#selectcourses_createclass").append(elem);
            $("#selectcourses_createactivity").append(elem);
        }

    });


    getLanguages(function (json) {

        $("#newcourselang").html("");

        for(var i= 0 ; i < json.length; i++){
            var elem ='<option value="'+json[i].id+'">'+ json[i].name+ '</option>'
            $("#newcourselang").append(elem);
        }
    });

    $("#selecamounttest").change( function () {
       createTestsInputs();
    });

    $("#selecamountinputs").change( function () {
        createTestsInputs();
    });


    $("#bt-newcourse").click( function () {
        createCourse();
    });



});

function getdatauser() {
    $.post("../../backend/getdatauser.php" )
        .done(function(data)
        {
            data = JSON.parse(data);
            $("#labelusername").text(data.name);
            $("#labelusername").attr("codlang", data.cod);
            configLang(data.cod, function(data){
                jsonlang = data;

                //initial conf
                $("#labelcourse").text(data.course);
                $("#labelstudent").text(data.student);
                $("#labelactivity").text(data.activities);
                $("#labelnewcourse").text(data.newcourse);
                $("#labelnewactivity").text(data.newactivity);
                $("#labeleditcourse").text(data.editcourse);
                $("#labeleditactivity").text(data.editactivity);
                $("#labelnewstudent").text(data.newstudent);
                $("#labelnewclass").text(data.newclass);
                $("#labeleditclass").text(data.editclass);

            });
        })
        .fail(function () {
            console.log("erro");
        });

}


function configLang(cod, callback) {
    if(cod == null)
        cod =  "eng";

    jQuery.getJSON("../../lang/"+cod+"-text.json", callback);
}

function getAllCourse(callback) {

    $.post( "../../backend/dashboard/dash_getcoursesbyteacher.php",
        function( data ) {
            callback(data)
        }
    );

}


function createCourse() {

    if(
    ($("#newcoursename").val() != undefined) &&
    ($("#newcoursecode").val() != undefined) &&
    ($("#newcoursekey").val() != undefined) &&
    ($("#newcourselang").val() != undefined)
    )
    {

        createNewCourse($("#newcoursename").val(),$("#newcoursecode").val(),
            $("#newcoursekey").val(), $("#newcourselang").val());

    }else {
        alert("Erro");
    }

}


function createTestsInputs() {


    let container="";
    for(let j = 0; j < $("#selecamounttest").val(); j++) {

        container += '<div><h4>Test '+(j+1)+'</h4>' +
            ' <label class="from-label" id="">Inputs</label>';

        for (let i = 0; i < $("#selecamountinputs").val(); i++)
            container += '<div class="inp-form large "><input name="newcoursename"  placeholder="input ' + (i + 1) + '" required></div>'

        container += '<label class="from-label" id="">Output</label>' +
            '<div class="inp-form large "><input name="newcoursename"  placeholder="output"></div></div>';
    }

    $("#container-tests").html(container);

}


function showActivityByStudent(data, idstudent) {

        $("#container-activity-details").html("");
        var json = JSON.parse(data);

        if(json.length == 0){
            $("#container-activity-details").html("list returned empty");
        }else {


            $("#container-activity-details").append('<div class="list-item title-student-list" value="">'+ $(".name[ref="+idstudent+"]").html()+ '</div>');

            for (var i = 0; i < json.length; i++) {
                var elem = '<div class="list-item" value="' + json[i].id + '">' +
                    ' <div class="name">' + json[i].title + '</div>' +
                    ' <div class="options-item-list" </div>' +

                    '<div class="label editstring-item-list" title="editstring" value="' + json[i].id + '"><i class="icofont-chart-line"></i> </div>' ;
                    if(json[i].unviewed == "0")
                        elem += '<div class="label inactive chat-item-list" title="message unviewed" value="' + json[i].id + '"><i class="icofont-chat"></i><div class="value">' + json[i].unviewed + '</div> </div>';
                    else
                        elem += '<div class="label chat-item-list" title="message unviewed" value="' + json[i].id + '"><i class="icofont-chat"></i><div class="value">' + json[i].unviewed + '</div> </div>';

                    if(json[i].typeerror == "no-error")
                        elem += ' <div class="label success" title="actual state"><div class="value">  no-error </div></div>';
                    else
                        elem += ' <div class="label error" title="actual state"><div class="value">' + json[i].typeerror + '</div></div>';

                    if(json[i].passed == "1"){

                        if(json[i].idcomp == json[i].idpassed)
                            elem += ' <div class="label success" title="tests passed"><i class="icofont-check"></i><div class="value"> passed </div></div>';
                        else
                            elem += ' <div class="label warnig" title="tests passed*"><i class="icofont-exclamation"></i><div class="value"> passed </div></div>';
                    }else
                        elem += ' <div class="label error" title="tests passed"><i class="icofont-check"></i><div class="value"> faill </div></div>';


                elem += ' <div class="label inactive" title="compilations"><i class="icofont-code"></i><div class="value">' + json[i].compilation + '</div></div>' +
                    ' <div class="label inactive" title="total errors"><i class="icofont-error"></i> <div class="value">' + json[i].error + '</div></div>' +
                    ' <div class="label inactive" title="total tests"><i class="icofont-list"></i> <div class="value">' + json[i].test + '</div></div>' +
                    '</div></div>'
                $("#container-activity-details").append(elem);
            }

            $(".chat-item-list").click(function () {
                window.open('../chat/index.html?id=' + $(this).attr("value"), '_blank');
            });

            $(".editstring-item-list").click(function () {
                let idproject = $(this).attr("value")
                calcEditString( idproject,function (data) {
                    console.log(data)
                    window.open('../editstring/index.html?id=' + idproject, '_blank');
                })


            });

        }
}