$(document).ready(function () {

    $("#button-login").click(function () {
        console.log("login started");
		 $("#mgs-login").hide();
        login( $("#username").val(), $("#password").val(),  $("#inp-mode").val());
    });


    $(document).on('keypress',function(e) {
        if(e.which == 13) {
            login( $("#username").val(), $("#password").val(),  $("#inp-mode").val());

        }
    });

});


function login(login, pass, mode) {


    $.post( "../backend/home_login.php", {login: login, password:pass, mode: mode})

        .done( function (data){

           if(data != "error"){

               $.post( "../backend/session/manager_section.php", {free:1, typeuser:2, currentuser: data} )
               .done(function(data2)
               {

                   console.log(data);
                   if(data != "0") {
                       if(mode==1)
                           window.location = "courses/index.html";
                       else
                           window.location = "dashboard/index.html";
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