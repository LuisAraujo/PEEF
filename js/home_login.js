$(document).ready(function () {

    $("#button-login").click(function () {
        console.log("login started")
        login( $("#username").val(), $("#password").val(),  $("#inp-mode").val());
    });

});


function login(login, pass, mode) {


    $.post( "../backend/home_login.php", {login: login, password:pass, mode: mode})

        .done( function (data){
            console.log(data)
           if(data != "error"){
               console.log("login no error!");

               $.post( "../backend/manager_section.php", { currentuser: data} )
               .done(function(data2)
               {
                   if(data != "0") {
                       window.location = "courses/index.html";
                   }
               })
               .fail(function () {
                   console.log("erro");
               });

           }else{
               $("#mgs-login").show();
               console.error("Error post ajax login!" + data);
           }
        })
        .fail( function (data) {
            console.error("Fail post");
        });

}