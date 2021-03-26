$(document).ready(function () {


    $(".item-menu").click(function () {

        $(".item-menu").removeClass("active");
        $(this).addClass("active");
        $( ".container-activity").hide();
        $( "#container-" + $(this).attr("ref") ).show();
    });

    getAllCourse(function (data) {
        console.log(data);
        var json = JSON.parse(data);
        $("#select-courses").html("<option></option>");
        for(var i= 0 ; i < json.length; i++){
            var elem ='<option value="'+json[i].id+'">'+ json[i].name+ '</option>'
            $("#select-courses").append(elem);
        }
    });

    $("#bt-explore-home").click(function () {

        getSumary(function (data) {
            var json = JSON.parse(data);
            $("#enrolledstudent").html(json.student);
            $("#ncalsses").html(json.activity);
            $("#nactivity").html(json.classes);
            $("#ncompilation").html(json.complitaion);
            $("#npassedtest").html(json.passedtest);
        });
    });

    $("#select-courses").change(function () {
        $.post( "../../backend/session/manager_section.php",
            {currentcourse: $(this).val() },
            function( data ) {
                getSumary(function (data) {
                    var json = JSON.parse(data);
                    $("#enrolledstudent").html(json.student);
                    $("#ncalsses").html(json.activity);
                    $("#nactivity").html(json.classes);
                    $("#ncompilation").html(json.complitaion);
                    $("#npassedtest").html(json.passedtest);
                });
            }
        )
    });

    $("#bt-explore-student").click(function () {

        getStudents(function (data) {
            $("#container-student").html("");

            var json = JSON.parse(data);
            for(var i= 0 ; i < json.length; i++){
                var elem ='<div class="list-item" value="'+json[i].id+'">' +
                    ' <span class="name">'+ json[i].name+'</span>'+
                    ' <span class="label"><i class="icofont-test-bulb"></i> <span class="link"> Activities</span></span>' +
                    ' <span class="label"><i class="icofont-flag"></i>Total Comp: </span><span class="value">'+json[i].compilation+'</span>' +
                    ' <span class="label"><i class="icofont-error"></i>Error Comp: </span><span class="value">'+json[i].error+'</span>' +
                    ' <span class="label"><i class="icofont-check"></i>Test Passed: </span><span class="value">'+json[i].passed+'</span>' +

                    '</div>'
                $("#container-student").append(elem);
            }

        });

    });


});

function getAllCourse(callback) {

    $.post( "../../backend/dashboard/dash_getcoursesbyteacher.php",
        function( data ) {
            callback(data)
        }
    );

}

function getStudents(callback) {

    $.post( "../../backend/course/getsumarystudent_bycourse.php",
        function( data ) {
            callback(data)
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