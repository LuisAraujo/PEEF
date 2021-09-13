
function getLanguages(callback) {
    $.post("../../backend/course/course_getlanguages.php" )
        .done(function(data)
        {
            data = JSON.parse(data);
            callback(data);
        })
        .fail(function () {
            console.log("erro");
        });

}



function createNewCourse(newcoursename,newcoursecode, newcoursekey, newcourselang, callback){
    console.log(newcoursename,newcoursecode, newcoursekey, newcourselang, callback);

    $.post("../../backend/course/course_create.php",
        {newcoursename:newcoursename,newcoursecode:newcoursecode,
        newcoursekey:newcoursekey, newcourselang:newcourselang} )
        .done(function(data)
        {
            //data = JSON.parse(data);
            if(data== "1")
                alert("Curso cadastrado!");
            else
                alert("Erro ao cadastrar curso!");
        })
        .fail(function () {
            console.log("erro");
        });

}


function  createNewClass(courses,newclassname,
    urlvideo, description) {


    $.post("../../backend/course/course_createclass.php",
        {courses:courses,newclassname:newclassname,
            urlvideo:urlvideo, description:description} )
        .done(function(data)
        {
            console.log(data);
            if(data== "1")
                alert("Aula cadastrado!");
            else
                alert("Erro ao cadastrar aula!");
        })
        .fail(function () {
            console.log("erro");
        });

}


function   createNewActivity(idtopic,    activityname, description,
    descriptionin,descriptionout, datashow, datadelivery,  inputs ) {


    $.post("../../backend/course/course_createactivity.php",
        {idtopic:idtopic,activityname:activityname,
            description:description,descriptionin:descriptionin,
            descriptionout:descriptionout, datashow: datashow, datadelivery:datadelivery,
            inputs:inputs} )
        .done(function(data)
        {
            console.log(data);
            if(data== "1")
                alert("Aula cadastrado!");
            else
                alert("Erro ao cadastrar aula!");
        })
        .fail(function () {
            console.log("erro");
        });

}
