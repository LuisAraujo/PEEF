$(document).ready(function () {

    $("#button-login").click(function () {
        console.log("teste")
        login( $("#username").val(), $("#password").val(),  $("#inp-mode").val());
    });

});


function login(login, pass, mode) {


    $.post( "../backend/home_login.php", {login:login, password:pass, mode: mode})

        .done( function (data){

           if(data == "logged"){
                window.location = "courses/index.html";
           }else{
               $("#mgs-login").show();
               console.error("Error post ajax login!" + data);
           }
        })
        .fail( function (data) {
            console.error("Fail post");
        });

}