var arrproject = [];
var arrdeliveryproject = [];
var countrequest = 0;
var countresponse = 0;
var countrequest2 = 0;
var countresponse2 = 0;
var arrprojectred = [];
var arrprojecteq = [];

//calc editline frist for count diff
function exportDataStudent(){

    calc_editline( function () {
        getdataallproject(2, function(data){
            countrequest = data.length;
            countresponse = 0;
            for(var i=0; i < data.length; i++) {
                getdataproject(data[i].projectid, data[i].studentid, calc_metrics);
            }
        });
    });
}

//calc editline frist for count diff
function exportDeliveryData(){

    calc_editline( function () {
        getdataallproject(2, function(data){
            countrequest = data.length;
            countresponse = 0;
            for(var i=0; i < data.length; i++) {
                getprojectdelivery(data[i].projectid, data[i].studentid,  exportprojectdelivery);
            }
        });
    });
}


//calc editline frist for count diff
function exportTestData(){

    calc_editline( function () {
        getdataallproject(2, function(data){
            countrequest = data.length;
            countresponse = 0;
            for(var i=0; i < data.length; i++) {
                getprojecttestdata(data[i].projectid, data[i].studentid,  exportprojecttestdata);
            }
        });
    });
}


//calc editline frist for count diff
function exportREDData(){
    getdataallstudents(2, function(data){
        countrequest = data.length;
        countresponse = 0;
        arrprojectred= [];
        for(var i=0; i < data.length; i++) {
            console.log("Ok");
            getprojectred(data[i].studentid,  exportprojectred);
        }
    });
}


//calc editline frist for count diff
function exportEQData(){
    getdataallstudents(2, function(data){
        countrequest = data.length;
        countresponse = 0;
        arrprojectred= [];
        for(var i=0; i < data.length; i++) {
            console.log("Ok");
            getprojecteq(data[i].studentid,  exportprojecteq);
        }
    });
}


//calc editline frist for count diff
function exportLastTestResult(idcourse){
    getdataallstudents(2, function(data){
        countrequest = data.length;
        countresponse = 0;
        arrprojectred= [];
        for(var i=0; i < data.length; i++) {
            console.log("Ok");
            getprojectlasttest(data[i].studentid, idcourse,  exportprojectlasttest);
        }
    });
}


//calc editline frist for count diff
function exportTopError(){
    getdataalltoperror(2, calc_error);
}


//calc editline frist for count diff
function exportAllCompilationError(){

    calc_editline( function () {
        countrequest2 = 1;
        getdataallcompilationerror(2, export_covermessage);
    });
}

//calc editline frist for count diff
function exportEnhancedMessageNoCover(){

    getdataenhancedmessagenocover(2, export_enhancedmessagenocover);

}

/*FAZER ESSA FUNCIONALIDADE*/
function exportDataByActivity() {

    calc_editline( function () {
        getdataallproject(2, function(data){
            countrequest2 = data.length;
            for(var i=0; i < data.length; i++) {
                //CIRAR FUNCOES
                getdataactivity(data[i].projectid, data[i].activityid, calc_metrics2);
            }
        });
    });



}

function getdataproject(idprojects, idstudent, callback) {

    $.post( "../../../backend/metrics/getjson_projecteditions.php", {idproject: idprojects}, function( data ) {

        //valid json
       // if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
       //     replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
       //     replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

        countresponse++;

        if(arrproject[idstudent] == undefined)
            arrproject[idstudent]  = [];

        try {
            //console.error(data);
            json = JSON.parse(data);
            arrproject[idstudent].push( json );

            if(countrequest == countresponse) {
                callback();
                countresponse =0;
                countrequest =0;

            }

        } catch(e) {
            console.log(data); // error in the above string (in this case, yes)!
        }

    });
}

/*Get Activity */
function getprojectred( idstudent, callback) {

    console.log(idstudent)

    $.post( "../../../backend/metrics/getjson_REDByStudents.php", {idstudent: idstudent}, function( data ) {

        //valid json
        if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
            replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
            replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

            // console.log(data);

            if(arrprojectred[idstudent] == undefined)
                arrprojectred[idstudent]  = [];

            json = JSON.parse(data);
            arrprojectred[idstudent] =  json ;

            countresponse++;

            if(countrequest == countresponse) {
                console.log(arrprojectred.length);
                callback();
                countresponse =0;
                countrequest =0;
            }

        }else {
            callback(data);
        }


    });
}


/*Get Activity */
function getprojecteq( idstudent, callback) {

    console.log(idstudent)

    $.post( "../../../backend/metrics/getjson_EQ_jadudthesis.php", {idstudent: idstudent}, function( data ) {

        //valid json
        if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
            replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
            replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

            // console.log(data);

            if(arrprojectred[idstudent] == undefined)
                arrprojecteq[idstudent]  = [];

            json = JSON.parse(data);
            arrprojecteq[idstudent] =  json ;

            countresponse++;

            if(countrequest == countresponse) {
                console.log(arrprojecteq.length);
                callback();
                countresponse =0;
                countrequest =0;
            }

        }else {
            console.log(data)
        }


    });
}


/*Get Last Result Test */
function getprojectlasttest( idstudent, idcourse, callback) {

    $.post( "../../../backend/metrics/getjson_lasttestresult.php", {idstudent: idstudent, idcourse:idcourse}, function( data ) {

        //valid json
        if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
            replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
            replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

            // console.log(data);

            if(arrprojectred[idstudent] == undefined)
                arrprojecteq[idstudent]  = [];

            json = JSON.parse(data);
            arrprojecteq[idstudent] =  json ;

            countresponse++;

            if(countrequest == countresponse) {
                console.log(arrprojecteq.length);
                callback();
                countresponse =0;
                countrequest =0;
            }

        }else {
            console.log(data)
        }


    });
}



function getdataactivity(idprojects, idactivity, callback) {

    $.post( "../../../backend/metrics/getjson_projecteditions.php", {idproject: idprojects}, function( data ) {

        //valid json
        if (/^[\],:{}\s]*$/.test(data.replace(/\\["\\\/bfnrtu]/g, '@').
            replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g, ']').
            replace(/(?:^|:|,)(?:\s*\[)+/g, ''))) {

           // console.log(data);

            if(arrproject[idactivity] == undefined)
                arrproject[idactivity]  = [];

            json = JSON.parse(data);
            arrproject[idactivity].push( json );
            console.log(JSON.parse(json.idproject) );
            countresponse2++;

            if(countrequest2 == countresponse2) {
                callback();
                countresponse2 =0;
                countrequest2 =0;
            }

            //callback( arrproject );


        }else {

            callback(data);
        }


    });
}


//called when all response are given
function calc_editline( callback) {

    $.post( "../../../backend/metrics/calc_editline_dinamicprog.php",function( data ) {
       // console.log(data)
        callback();
    });
}

function getdataallstudents(idcourse, callback) {

    $.post("../../../backend/metrics/getjson_allstudents.php", {idcourse: idcourse}, function (data) {
        var json = JSON.parse(data);
        callback(json);

    });
}


function getdataallproject(idcourse, callback) {

    $.post("../../../backend/metrics/getjson_allprojects.php", {idcourse: idcourse}, function (data) {
        var json = JSON.parse(data);
        callback(json);

    });
}

function getprojectdelivery(idcourse, idstudent, callback){
    $.post("../../../backend/metrics/getjson_deliveryprojects.php", {idcourse: idcourse}, function (data) {

        countresponse++;

        if(arrdeliveryproject[idstudent] == undefined)
            arrdeliveryproject[idstudent]  = [];

        try {
            //console.log(data);
            json = JSON.parse(data);
            arrdeliveryproject[idstudent].push( json );

            if(countrequest == countresponse) {
                alert("ok");
                callback(json);
                countresponse =0;
                countrequest =0;

            }

        } catch(e) {
            console.log(data); // error in the above string (in this case, yes)!
        }



    });

}

function getdataallactivity(idcourse, callback) {

    $.post("../../../backend/metrics/getjson_allactivity.php", {idcourse: idcourse}, function (data) {
        var json = JSON.parse(data);
        callback(json);

    });
}



function getdataalltoperror(idcourse, callback) {

    $.post("../../../backend/metrics/getjson_toperror.php", {idcourse: idcourse}, function (data) {
        var json = JSON.parse(data);
        callback(json);
    });
}

function getdataenhancedmessagenocover(idcourse, callback) {

    $.post("../../../backend/metrics/getjson_enhancedmessagenotcover.php", {idcourse: idcourse}, function (data) {
       // console.log(data);
        var json = JSON.parse(data);
        callback(json);
    });
}


function getdataallcompilationerror(idcourse, callback) {

    $.post("../../../backend/metrics/getjson_infocompilationerror.php", {idcourse: idcourse}, function (data) {
        var json = JSON.parse(data);
        
        callback(json);
    });
}




/*Export Data By Students*/
function calc_metrics() {
    data = arrproject;
    console.log(data);
    strFile = "StudentID, Executing, Sucess, Errors, Test, Pass, Fail, Mean DIF, Total DIF\n";
    arrayData = [];
    for (var i = 0; i < data.length; i++) {
        if (data[i] != undefined) {
            diff = 0;
            execution = 0;
            test = 0;
            testfaill = 0;
            testpass = 0;
            sucess = 0;
            error = 0;
            countcodes=0;

            for (var j = 0; j < data[i].length; j++) {
                //console.log(data[i][j].codes)
                for (var l = 0; l < data[i][j].codes.length; l++) {
                    diff += parseInt( data[i][j].codes[l].diff );
                    countcodes++;

                    if (data[i][j].codes[l].length == "0")
                        continue;

                    if (data[i][j].codes[l].TestPassed == "-1") {

                        execution++;

                        if (data[i][j].codes[l].typeError == "no-error")
                            sucess++;
                        else
                            error++;
                    } else {
                        test++;

                        if (data[i][j].codes[l].TestPassed == 0)
                            testfaill++;
                        else
                            testpass++;
                    }
                }
            }

            strFile += i +"," +execution + "," +sucess + "," + error+ "," +test+ "," + testpass+ "," + testfaill + "," + ( diff/countcodes ) + "," + diff+"\n";

        }
    }

    var blob = new Blob([strFile], {type: "text/plain;charset=utf-8"});
    var now = new Date();
    var date = now.getDay()+"-"+now.getMonth()+"-"+now.getYear()+"-"+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();
    saveAs(blob, "exportdata"+date+".csv");

}


/*Export Data By Students*/
function calc_metrics2() {
    data = arrproject;
    strFile = "ActivitID, Executing, Sucess, Errors, Test, Pass, Fail, Mean DIF, Total DIF\n";
    arrayData = [];
    for (var i = 0; i < data.length; i++) {
        if (data[i] != undefined) {
            diff = 0;
            execution = 0;
            test = 0;
            testfaill = 0;
            testpass = 0;
            sucess = 0;
            error = 0;
            countcodes=0;

            for (var j = 0; j < data[i].length; j++) {
                //console.log(data[i][j].codes)
                for (var l = 0; l < data[i][j].codes.length; l++) {
                    diff += parseInt( data[i][j].codes[l].diff );
                    countcodes++;

                    if (data[i][j].codes[l].length == 0)
                        continue;

                    if (data[i][j].codes[l].TestPassed == -1) {

                        execution++;

                        if (data[i][j].codes[l].typeError == "no-error")
                            sucess++;
                        else
                            error++;
                    } else {
                        test++;

                        if (data[i][j].codes[l].TestPassed == 0)
                            testfaill++;
                        else
                            testpass++;
                    }
                }
            }

            strFile += i +"," +execution + "," +sucess + "," + error+ "," +test+ "," + testpass+ "," + testfaill + "," + ( diff/countcodes ) + "," + diff+"\n";

        }
    }

    var blob = new Blob([strFile], {type: "text/plain;charset=utf-8"});
    var now = new Date();
    var date = now.getDay()+"-"+now.getMonth()+"-"+now.getYear()+"-"+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();
    saveAs(blob, "exportdata_activity"+date+".csv");

}

/*Export Top Erros*/
function calc_error(data) {
    strFile = "Id, Error, Sub-Error, Count\n";

    for (var i = 0; i < data.length; i++) {
        strFile += i+","+data[i].typeError+","+data[i].subtype+","+data[i].quant+"\n"
    }

    var blob = new Blob([strFile], {type: "text/plain;charset=utf-8"});
    var now = new Date();
    var date = now.getDay()+"-"+now.getMonth()+"-"+now.getYear()+"-"+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();
    saveAs(blob, "exportdata_toperror"+date+".csv");

}


/*Export Top Erros*/
function exportprojectdelivery(data) {
    strFile = "Id Project, Id Students, Id Activity, Delivery \n";

    for (var i = 0; i < data.length; i++) {
        strFile += data[i].projectid+","+data[i].studentid+","+data[i].activityid+","+data[i].sended+"\n"
    }

    var blob = new Blob([strFile], {type: "text/plain;charset=utf-8"});
    var now = new Date();
    var date = now.getDay()+"-"+now.getMonth()+"-"+now.getYear()+"-"+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();
    saveAs(blob, "exportdata_delivered"+date+".csv");

}

/*Export RED to projects*/
function exportprojectred() {

    var data = arrprojectred;
    activitylist = [5,8,9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48];

    strFile = "Id Students,";
    strFile += activitylist.join(",");
    strFile += "\n";

    //to each students
    for (var i = 0; i < data.length; i++) {
        //key exists?
        if (data[i] != undefined) {

            strFile += i + ",";

            //turn activity list
            for (var l = 0; l < activitylist.length; l++) {
                var busca = false;
                //seacrh match in projects of students
                for (var j = 0; j < data[i].length; j++) {

                    if(activitylist[l] == parseInt(data[i][j].idactivity) ){
                        if(i == 59)
                            console.log(activitylist[l], data[i][j].score);

                        strFile += data[i][j].score+ ",";
                        busca = true;
                    }
                }
                //not found
                if(!busca){
                    strFile += "NA,";
                }
            }

            strFile += "\n";
        }//if
    }//for

    var blob = new Blob([strFile], {type: "text/plain;charset=utf-8"});
    var now = new Date();
    var date = now.getDay()+"-"+now.getMonth()+"-"+now.getYear()+"-"+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();
    saveAs(blob, "exportdata_red"+date+".csv");

}




/*Export Last Test Result to projects*/
function exportprojectlasttest() {

    var data = arrprojecteq;
    activitylist = [5,8,9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48];

    strFile = "Id Students,";
    strFile += activitylist.join(",");
    strFile += "\n";

    //to each students
    for (var i = 0; i < data.length; i++) {
        //key exists?
        if (data[i] != undefined) {

            strFile += i + ",";

            //turn activity list
            for (var l = 0; l < activitylist.length; l++) {
                var busca = false;
                //seacrh match in projects of students
                for (var j = 0; j < data[i].length; j++) {

                    if(activitylist[l] == parseInt(data[i][j].idactivity) ){

                        strFile += data[i][j].passed+ ",";
                        busca = true;

                    }
                }
                //not found
                if(!busca){
                    strFile += "NA,";
                }
            }

            strFile += "\n";
        }//if
    }//for

    var blob = new Blob([strFile], {type: "text/plain;charset=utf-8"});
    var now = new Date();
    var date = now.getDay()+"-"+now.getMonth()+"-"+now.getYear()+"-"+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();
    saveAs(blob, "exportdata_red"+date+".csv");

}



/*Export EQ to projects*/
function exportprojecteq() {

    var data = arrprojecteq;
    activitylist = [5,8,9, 10, 11, 12, 14, 15, 16, 17, 18, 19, 20, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45, 46, 47, 48];

    strFile = "Id Students,";
    strFile += activitylist.join(",");
    strFile += "\n";

    //to each students
    for (var i = 0; i < data.length; i++) {
        //key exists?
        if (data[i] != undefined) {

            strFile += i + ",";

            //turn activity list
            for (var l = 0; l < activitylist.length; l++) {
                var busca = false;
                //seacrh match in projects of students
                for (var j = 0; j < data[i].length; j++) {

                    if(activitylist[l] == parseInt(data[i][j].idactivity) ){
                        if(i == 59)
                            console.log(activitylist[l], data[i][j].score);

                        var score = 0;

                        for(var m = 0; m < data[i][j].scoresections.length; m++)
                            score +=data[i][j].scoresections[m];

                        score = score/data[i][j].scoresections.length;
                        strFile += score + ",";

                        busca = true;
                    }
                }
                //not found
                if(!busca){
                    strFile += "NA,";
                }
            }

            strFile += "\n";
        }//if
    }//for

    var blob = new Blob([strFile], {type: "text/plain;charset=utf-8"});
    var now = new Date();
    var date = now.getDay()+"-"+now.getMonth()+"-"+now.getYear()+"-"+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();
    saveAs(blob, "exportdata_red"+date+".csv");

}


/*Export Info of Compilation Wifth Error*/
function export_covermessage(data){

    strFile = "StudentID,CompilationID,Erro,Sub-Error,Enhanced Message,	Help?, Whats is?, Next Compilation\n";

    for (var i = 0; i < data.length; i++) {
        strFile += i+","+data[i].Student_id+","+data[i].id+","+data[i].typeError+","+data[i].compMessage+","+data[i].enhancedmessage+", , \n"
    }

    var blob = new Blob([strFile], {type: "text/plain;charset=utf-8"});
    var now = new Date();
    var date = now.getDay()+"-"+now.getMonth()+"-"+now.getYear()+"-"+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();
    saveAs(blob, "exportdata_errorcomp"+date+".csv");



}


/*Export Info of Compilation Wifth Error*/
function export_enhancedmessagenocover(data){

    strFile = "Id,Type,ErroMessage,compMessage,Count\n";

    for (var i = 0; i < data.length; i++) {
        strFile += i+","+data[i].typeError+","+data[i].erromessage+","+data[i].compMessage+","+data[i].quant+"\n"
    }

    var blob = new Blob([strFile], {type: "text/plain;charset=utf-8"});
    var now = new Date();
    var date = now.getDay()+"-"+now.getMonth()+"-"+now.getYear()+"-"+now.getHours()+":"+now.getMinutes()+":"+now.getSeconds();
    saveAs(blob, "exportdata_errorcomp"+date+".csv");

}