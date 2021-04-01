
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
            console.log(data);
        })
        .fail(function () {
            console.log("erro");
        });

}