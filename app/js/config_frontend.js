$(document).ready(function () {

    checkType(2, "../", readyAfterPermission);

});

function readyAfterPermission() {

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

        $("#selectcourses_createactivity").change( function () {
             idcourse =  $(this).val();

             //if(idcourse != 0){
            $("#selecttopic_createactivity").attr('disabled', false);
             //}

            getAllTopicByCourse(idcourse, function (data) {

                json = JSON.parse(data);
                for(var i= 0 ; i < json.length; i++){
                    var elem ='<option value="'+json[i].id+'">'+ json[i].name+ '</option>'
                    $("#selecttopic_createclass").append(elem);
                    $("#selecttopic_createactivity").append(elem);
                }

            });

        })
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


    $("#from-newcourse").submit( function () {
        alert("ok")
        createCourse();
        return false;
    });

    $("#form-newclass").submit( function () {
        createClass();
        return false;
    });

    $("#from-newactivity").submit(function () {
        createActivity();
        return false;
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

function getAllTopicByCourse(idcourse, callback) {

    $.post( "../../backend/dashboard/dash_gettopicbycourse.php",
        {idcourse: idcourse},
        function( data ) {
            callback(data)
        }
    );

}

function createCourse() {

    createNewCourse($("#newcoursename").val(),$("#newcoursecode").val(),
    $("#newcoursekey").val(), $("#newcourselang").val());

}


function createTestsInputs() {

    let container="";
    for(let j = 0; j < $("#selecamounttest").val(); j++) {

        container += '<div><h4>Test '+(j+1)+'</h4>';

        if($("#selecamountinputs").val() != 0)
            container += ' <label class="from-label" id="">Inputs</label>';

        for (let i = 0; i < $("#selecamountinputs").val(); i++)
            container += '<div class="inp-form large "><input  id="input_' +(j + 1)+'_'+ (i + 1) + '" placeholder="input ' + (i + 1) + '" required></div>'

        container += '<label class="from-label" id="">Output</label>' +
            '<div class="inp-form large "><input id="output'+(j+1)+'" placeholder="output" required></div></div>';
    }

    $("#container-tests").html(container);

}

function createClass() {

    createNewClass($("#selectcourses_createclass").val(),$("#newclassname").val(),
$("#urlvideo").val(),$("#textclassdescription").val() );

}


/*Get data from form and send do createNewActivity */
function createActivity() {
    let arr  = [];

    for(let j = 0; j < $("#selecamounttest").val(); j++) {
        arr.push([]);
        for (let i = 0; i < $("#selecamountinputs").val(); i++){
            arr[ arr.length -1 ].push( $("#input_"+(j+1)+"_"+(i+1)).val() );
        }

        arr[ arr.length -1 ].push( $("#output"+(j+1) ).val() );

    }

    createNewActivity($("#selecttopic_createactivity").val(),    $("#newactivityname").val(), $("#textdescription").val(),
        $("#textdescriptionin").val(),$("#textdescriptionout").val(), $("#datashow").val(), $("#datadelivery").val(),  arr );

}