getstudentedetails = null;
lastcountmessage = 0;

$(document).ready(function () {

    checkType(2, "../", readyAfterPermission);
    audionotify = document.getElementById('audionotfy');



});


function readyAfterPermission() {

    getdatauser();

    $.post( "../../backend/session/manager_section.php",
        {currentcourse: -1  });

    $(".item-menu").click(function () {

        clearInterval(getstudentedetails);

        $(".item-menu").removeClass("active");
        $(this).addClass("active");
        $( ".container-activity").hide();
        $( "#container-" + $(this).attr("ref") ).show();
    });

    $("#bt-explore-settings").click(function () {
        window.open("../settings/index.html", "_self");
    });
    getAllCourse(function (data) {
        console.log(data);
        var json = JSON.parse(data);
        $("#select-courses").html("<option></option>");
        for(var i= 0 ; i < json.length; i++){
            var elem ='<option value="'+json[i].id+'">'+ json[i].name+ '</option>'
            $("#select-courses").append(elem);
        }

        configLang($("#labelusername").attr("codlang"), function (data ) {
            // $("#select-courses").append("<option value='-1' >"+ data.newcourse +"</option>");
        })

    });

    $("#bt-explore-home").click(function () {

        getSumary(function (data) {

            var json = JSON.parse(data);
            $("#enrolledstudent").html(json.student);
            $("#ncalsses").html(json.classes);
            $("#nactivity").html(json.activity);
            $("#ncompilation").html(json.complitaion);
            $("#npassedtest").html(json.passedtest);
            $("#test").html(json.test);

        });
    });

    $("#select-courses").change(function () {

        if($(this).val() == -1){

            $("#bt-explore-settings").trigger("click");

        }else {
            $.post("../../backend/session/manager_section.php",
                {currentcourse: $(this).val()},
                function (data) {

                    //get message unread and notify
                    getUnreadMessage(showUnreadMessage);

                    setInterval( function () {
                        getUnreadMessage(showUnreadMessage);
                    }, 10000);


                    getSumary(function (data) {
                        console.log(data)
                        var json = JSON.parse(data);
                        $("#enrolledstudent").html(json.student);
                        $("#ncalsses").html(json.classes);
                        $("#nactivity").html(json.activity);
                        $("#ncompilation").html(json.complitaion);
                        $("#ntest").html(json.passedtest);
                        $("#passedtest").html(json.passedtest);
                        $("#test").html(json.test);
                    });

                    if ($("#container-student").css("display") != "none")
                        $("#bt-explore-student").trigger("click")
                    if ($("#container-activity").css("display") != "none")
                        $("#bt-explore-activity").trigger("click")
                }
            )

        }
    });

    $("#bt-explore-student").click(function () {
        getStudents( showListStudents, "project" );
    });

    $("#bt-explore-message").click(function () {

    });

    $("#bt-explore-activity").click(function () {
        getActivity( showActivity );
    });

    $("#bt-explore-settings").click(function () {
        getStudents( showListStudents, "project" );
    });

    $("#selecamounttest").change( function () {
        createTestsInputs();
    });

    $("#selecamountinputs").change( function () {
        createTestsInputs();
    });


}

function getdatauser() {
    $.post("../../backend/users/getdatauser.php" )
        .done(function(data)
        {
            data = JSON.parse(data);
            $("#labelusername").text(data.name);
            $("#labelusername").attr("codlang", data.cod);
            configLang(data.cod, function(data){
                jsonlang = data;

                //initial conf
                $("#labelhome").text(data.home);
                $("#labelstudent").text(data.student);
                $("#labelactivity").text(data.activities);
                $("#labelasetting").text(data.setting);
                $("#labelcourse").text(data.course);
                $("#labelenrolledstudent").text(data.enrolledstudent);
                $("#labeltotalclasses").text(data.totalclasses);
                $("#labeltotalactivity").text(data.totalactivity);
                $("#labeltotalcompilation").text(data.totalcompilation);
                $("#labeltotaltest").text(data.totaltest);
                $("#labeltotalpassestest").text(data.totalpassestest);
                $("#labelmessages").text(data.message);

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

function getStudents(callback, param) {

    $.post( "../../backend/course/getsumarystudent_bycourse.php",
        function( data ) {
            callback(data, param)
        }
    );

}
function getSumary(callback) {

    $.post( "../../backend/dashboard/dash_sumary.php",
        function( data ) {
            callback(data)
        }
    );

}

function getActivity(callback) {
    $.post( "../../backend/dashboard/dash_getactivitiesbycourse.php",
        function( data ) {
           callback(data);
        }
    );
}

function getActivityByStudent(idstudent, callback) {
    $.post( "../../backend/dashboard/dash_getactivitiesbystudent.php",{idstudent:idstudent},
        function( data ) {
        console.log(data);
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

function  showListStudents( data, order) {

    console.log(order);

        $("#container-student").html("");

        var json = JSON.parse(data);

        if(order == "online")
            json.sort(function (a, b) {
                return b.online - a.online;
            });

        if(order == "project")
            json.sort( function(a, b) {
                return b.projectstarted - a.projectstarted;
            });

        if(order == "error")
            json.sort( function(a, b) {
                return b.error - a.error;
            });


        if(json.length==0)
            $("#container-student").html("list returned empty");
        else {
            $("#container-student").html("<div class='hearder-list'> <span id='bt-order-stud-online' class='bt-order-list'> <img src='../../sources/images/col_drop.png'>Online</span> <span id='bt-order-stud-project' class='bt-order-list'><img src='../../sources/images/col_drop.png'>Project</span> <span id='bt-order-stud-error' class='bt-order-list'><img src='../../sources/images/col_drop.png'>Error</span> </div>")
           for (var i = 0; i < json.length; i++) {

                var elem = '<div class="list-item" value="' + json[i].id + '">' +
                    ' <div class="name" ref="'+ json[i].id + '">' + json[i].name;

                    if(json[i].online == 1){
                        elem += '<span class="stud-online" ></span>';
                    }else{
                        elem += '<span class="stud-offline" ></span>';
                    }

                    elem += '</div>' +
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

                $("#container-message").hide();
                $("#container-student").hide();
                $("#container-activity-details").show();

                var idstudant = $(this).attr("value");
                getActivityByStudent( idstudant ,  showActivityByStudent);

                getstudentedetails = setInterval(function () {

                    if( $("#container-activity-details").css("display") != "none"){
                        getActivityByStudent( idstudant ,  showActivityByStudent);
                    }

                }, 60 * 100);

            });

            $(".statistic-item-list").click(function () {
                window.open('../statistic/students.html?idstudent=' + $(this).attr("value") +'&idcourse=' + $("#select-courses").val() , '_blank');
            });

            $("#bt-order-stud-online").click(function () {
                getStudents(  showListStudents, "online")
            });

            $("#bt-order-stud-project").click(function () {
                getStudents( showListStudents, "project")
            });

            $("#bt-order-stud-error").click(function () {
                getStudents(  showListStudents, "error")
            });
        }
}

function showUnreadMessage(json, count) {
    $("#container-message").html("");
    console.log(json);

    if(count > lastcountmessage) {
        lastcountmessage = count;
        $("#notifymessage").addClass("actived");
        audionotify.play();
    }

    if(json.length == 0){
        $("#container-message").html("list returned empty");
    }else {
        for (var i = 0; i < json.length; i++) {

            var elem = '<div class="list-item" value="' + json[i].id + '">' +
                ' <div class="name">' + json[i].title + ' ('+json[i].namestud+')</div>' +
                ' <div class="options-item-list" </div>' +
                 '<div class="label chat-item-list" title="unviewed" value="'+json[i].id+'"><i class="icofont-chat"></i><div class="value">' + json[i].unviewed + '</div></div></div>' +

                '</div>'

            $("#container-message").append(elem);
        }

        $(".chat-item-list").click(function () {
            window.open('../chat/index.html?id=' + $(this).attr("value"), '_blank');
        });
    }


}



function  getUnreadMessage(callback) {
    $.post( "../../backend/dashboard/getunreadmessage.php",
        function( data ) {
            data = JSON.parse(data);
            countmessage = 0;
            for(i=0; i < data.length; i++)
                countmessage+= data[i].unviewed;


            callback(data, parseInt(countmessage));
        }
    );
}

function showActivity( data ) {

        $("#container-activity").html("");
        console.log(data);
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