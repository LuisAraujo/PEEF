lastidmsg = 0;

function sendmessage( text, fromprof, callback) {

    $.post( "../../backend/chat/sendmessage.php", { text:text,  fromprof: fromprof },
        function( data ) {

        //console.log(data)
        callback();

    });
}


function getallmessages( callback) {

    $.post( "../../backend/chat/getallmessages.php",
        function( data ) {

            data = JSON.parse(data);
            //console.log( data[data.length-1] );
            if(data[data.length-1]!= undefined)
                lastidmsg = data[data.length-1].id;

            callback(data);

        });
}



function getallmessagesbyprojectid(idproject, callback) {

    $.post( "../../backend/chat/getallmessagesbyidproject.php",{idproject:idproject},
        function( data ) {

            data = JSON.parse(data);
            //console.log( data[data.length-1] );
            if(data[data.length-1]!= undefined)
                lastidmsg = data[data.length-1].id;

            callback(data);

        });
}

function sendmessagetoproject( text, fromprof, idproject, callback) {

    $.post( "../../backend/chat/sendmessagetoproject.php", { text:text,  fromprof: fromprof, idproject:idproject},
        function( data ) {

            //console.log(data)
            callback();

        });
}



/*marcar as mensagens como vistas*/

function getlastmessagesbyprojectid(idproject, callback) {

    $.post( "../../backend/chat/getlastmessagebyprojectid.php", {idproject:idproject, lastidmsg:  lastidmsg },
        function( data ) {
            data = JSON.parse(data);
            if(data[data.length-1]!= undefined)
                lastidmsg = data[data.length-1].id;

            callback(data);

        });
}



function getlastmessages( callback) {

    $.post( "../../backend/chat/getlastmessage.php", { lastidmsg:  lastidmsg },
        function( data ) {
            data = JSON.parse(data);
            if(data[data.length-1]!= undefined)
                lastidmsg = data[data.length-1].id;

            callback(data);

        });
}
