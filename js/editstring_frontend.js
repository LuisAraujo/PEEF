idproject = -1;

$(document).ready(function () {

    getidproject = window.location.search.substr(1);
    if((getidproject != undefined) && (getidproject != "")) {
        param = getidproject.split("=")[0];
        if (param == "id") {
            getidproject = getidproject.split("=")[1];
            checkPermisionProject(getidproject, function (data) {
                if (parseInt(data) != 0) {
                    idproject = data;

                    calctypeerror( idproject, function () {
                        getprojects(idproject, printprojects );
                    });

                }
            });
        }
    }

    $("#button-turnchat").click(function () {
        window.location = "../chat/index.html?id=" + idproject;
    });

});
