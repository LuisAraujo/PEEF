function getAllCodesByProject() {

    console.log("getAllCodesByproject");

    $.post("backend/project_getallcodes.php"
        , function (data) {
            console.log("teste");
        })
        .done(function (data) {
            console.log("teste");
        })
        .fail(function () {
            console.log("teste");
        });

}