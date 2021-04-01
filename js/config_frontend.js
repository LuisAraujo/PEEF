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


    $("#selecamounttest").change( function () {
       createTestsInputs();
    });

    $("#selecamountinputs").change( function () {
        createTestsInputs();
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


function getActivityByStudent(idstudent, callback) {
    $.post( "../../backend/dashboard/dash_getactivitiesbystudent.php",{idstudent:idstudent},
        function( data ) {
           callback(data, idstudent);
        }
    );
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

function  showListStudents( data ) {

        $("#container-student").html("");
        var json = JSON.parse(data);
        if(json.length==0)
            $("#container-student").html("list returned empty");
        else {

            for (var i = 0; i < json.length; i++) {
                var elem = '<div class="list-item" value="' + json[i].id + '">' +
                    ' <div class="name" ref="'+ json[i].id + '">' + json[i].name + '</div>' +
                    ' <div class="options-item-list" </div>' +
                    '<div class="label activity-item-list" title="activities started" value="' + json[i].id + '" value2="' + json[i].idactivity + '"><i class="icofont-test-bulb"></i> <div class="value">'+json[i].projectstarted+'</div></div>' +
                    '<div class="label statistic-item-list" title="statistic" value="' + json[i].id + '"><i class="icofont-chart-bar-graph"></i> </div>' +
                    ' <div class="label inactive" title="delivery"><i class="icofont-flag"></i><div class="value">' + json[i].delivery + '</div></div>' +
                    ' <div class="label inactive" title="compilations"><i class="icofont-code"></i><div class="value">' + json[i].compilation + '</div></div>' +
                    ' <div class="label inactive" title="total errors"><i class="icofont-error"></i> <div class="value">' + json[i].error + '</div></div>' +
                    ' <div class="label inactive" title="tests passed"><i class="icofont-check"></i><div class="value">' + json[i].passed + '</div></div></div>' +
                    '</div>'

                $("#container-student").append(elem);
            }

            $(".activity-item-list").click(function () {

                $("#container-student").hide();
                $("#container-activity-details").show();
                var idstudant = $(this).attr("value");
                getActivityByStudent( idstudant ,  showActivityByStudent);

                setInterval(function () {

                    if( $("#container-activity-details").css("display") != "none"){
                        getActivityByStudent( idstudant ,  showActivityByStudent);
                    }

                }, 60 * 100);

            });

            $(".statistic-item-list").click(function () {
                window.open('../statisticstudents.html?id=' + $(this).attr("value"), '_blank');
            });
        }
}


function showActivity( data ) {

        $("#container-activity").html("");
        var json = JSON.parse(data);

        if(json.length == 0){
            $("#container-activity").html("list returned empty");
        }else {
            for (var i = 0; i < json.length; i++) {
                var elem = '<div class="list-item" value="' + json[i].id + '">' +
                    ' <div class="name">' + json[i].title + '</div>' +
                    ' <div class="options-item-list" </div>' +

                    '<div class="label statistic-item-list" title="statistic" value="' + json[i].id + '"><i class="icofont-chart-bar-graph"></i> </div>' +
                    ' <div class="label inactive" title="compilations"><i class="icofont-code"></i><div class="value">' + json[i].compilation + '</div></div>' +
                    ' <div class="label inactive" title="total errors"><i class="icofont-error"></i> <div class="value">' + json[i].error + '</div></div>' +
                    ' <div class="label inactive" title="total tests"><i class="icofont-list"></i> <div class="value">' + json[i].test + '</div></div>' +
                    ' <div class="label inactive" title="tests passed"><i class="icofont-check"></i><div class="value">' + json[i].passed + '</div></div></div>' +

                    '</div>'
                $("#container-activity").append(elem);
            }

            $(".statistic-item-list").click(function () {
                window.open('../statisticactivity.html?id=' + $(this).attr("value"), '_blank');
            });
        }

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