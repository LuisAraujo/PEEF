$(document).ready(function () {

    url = window.location.search.substr(1);
    attr = url.split("&");
    idstudent = attr[0].split("=")[1];
    idcourse = attr[1].split("=")[1];

    getAllTimeInPlatform(idstudent,idcourse,"time(H)");
    getDataTimeday(idstudent,idcourse,"time(H)");
    getDataWeekday(idstudent,idcourse,"time(H)");
    getDataPassedTest(idstudent,idcourse);
    getDataMessage(idstudent, idcourse, "Project");
    getDataSolve(idstudent,idcourse,"Time(H)");
    getDataCompilation(idstudent,idcourse);
    getRED(idstudent,"RED");
    getEQ(idstudent,"Sum EQ");

});


function getRED(idstudent, label) {

    $.post( "../../backend/metrics/getjson_REDByStudents.php", {idstudent: idstudent}).done(
        function (data){
            console.log(data);
            data = JSON.parse(data);
            data_chart = [];
            labels_chart = [];

            var i = 0;
            for(i = 0; i < data.length; i++){
                data_chart[i] = data[i].score;
                labels_chart[i] = data[i].id;
            }

            setBarChat("chart_red",labels_chart, data_chart, label);

        });
}


function getEQ(idstudent, label) {

    $.post( "../../backend/metrics/getjson_EQ_jadudthesis.php", {idstudent: idstudent}).done(
        function (data){

            data = JSON.parse(data);
            data_chart = [];
            labels_chart = [];

            var i = 0;
            for(i = 0; i < data.length; i++){
                data_chart[i] = data[i].scoresections;
                count = 0;
                sum =0;
                for(var j=0; j <  data[i].scoresections.length; j++){
                   sum += parseFloat(data[i].scoresections[j]);
                }

                data_chart[i] = sum;
                labels_chart[i] = data[i].id;
            }

            setBarChat("chart_eq",labels_chart, data_chart, label);

        });
}

function getAllTimeInPlatform(idstudent, label) {

    $.post( "../../backend/metrics/getjson_gettimeinplatform.php", {idstudent: idstudent,idcourse: idcourse}).done(
        function (data){
            data = JSON.parse(data);
            $("#timeplatform").html(data.totaltime);
        });
}
function getDataTimeday(idstudent, idcourse, label) {

    $.post( "../../backend/metrics/getjson_timetoday.php", {idstudent: idstudent,idcourse: idcourse}).done(
        function (data){

            data = JSON.parse(data);
            labels_chart = [];
            data_chart = [];
            for(var i = 0; i< data.length; i++){
                arr =  data[i]["time"].split(":");
                min = parseInt(arr[0]) + parseInt(arr[1])/60 + parseInt(arr[2])/60/60;
                data_chart.push(min);
                labels_chart.push(data[i]["date"]);
            }


            setChat("chart_timeday",labels_chart, data_chart, label);
        });

}


function getDataWeekday(idstudent, idcourse, label) {

    $.post( "../../backend/metrics/getjson_timeweekday.php", {idstudent: idstudent,idcourse: idcourse}).done(
        function (data){

            data = JSON.parse(data);

            data_chart = [];
            labels_chart = ["DOM", "SEG", "TER", "QUAR", "QUI", "SEX", "SAB"];
            var i = 0;
            for(i = 0; i < 7; i++){
                if(data[i] != undefined) {
                    arr =  data[i].split(":");
                    min = parseInt(arr[0]) + parseInt(arr[1])/60 + parseInt(arr[2])/60/60;
                    data_chart[i] = min;
                }else
                    data_chart[i] = 0;
            }


            setBarChat("chart_timeweek",labels_chart, data_chart, label);
        });

}

function getDataSolve(idstudent,idcourse, label) {

    $.post( "../../backend/metrics/getjson_timesolveproject.php", {idstudent: idstudent,idcourse: idcourse}).done(
        function (data){
            data = JSON.parse(data);

            data_chart = [];
            labels_chart = [];

            var i = 0;
            for(i = 0; i < data.length; i++){
                arr =  data[i].data.split(":");
                min = parseInt(arr[0]) + parseInt(arr[1])/60;
                data_chart[i] = min;
                labels_chart[i] = "Activity "+data[i].id;
            }

            console.log(data_chart);
            setChat("chart_datasolve",labels_chart, data_chart, label);
        });
}

function getDataMessage(idstudent,idcourse, label) {

    $.post( "../../backend/metrics/getjson_amountmessage.php", {idstudent: idstudent,idcourse: idcourse}).done(
        function (data){
            data = JSON.parse(data);

            data_chart = [];
            labels_chart = [];

            var i = 0;
            for(i = 0; i < data.length; i++){
                data_chart[i] = data[i].data;
                labels_chart[i] = data[i].id;
            }


            setBarChat("chart_datamessage",labels_chart, data_chart, label);
        });
}

function getDataPassedTest(idstudent, idcourse) {

    $.post( "../../backend/metrics/getjson_amounttestpassed.php", {idstudent: idstudent,idcourse: idcourse}).done(
        function (data){
            data = JSON.parse(data);
            data_chart = [];
            data_chart2 = [];
            labels_chart = [];

            var i = 0;
            for(i = 0; i < data.length; i++){
                data_chart[i] = parseInt(data[i].passed);
                data_chart2[i] = parseInt(data[i].npassed);
                labels_chart[i] = "Act:" +data[i].project_id;
            }

            setStackedBar("chart_test",labels_chart, data_chart, data_chart2, "Passed", "Faill");

        });
}



function getDataCompilation(idstudent, idcourse) {

    $.post( "../../backend/metrics/getjson_amountcompilation.php", {idstudent: idstudent,idcourse: idcourse}).done(
        function (data){
            data = JSON.parse(data);
            data_chart = [];
            data_chart2 = [];
            labels_chart = [];

            var i = 0;
            for(i = 0; i < data.length; i++){
                data_chart[i] = parseInt(data[i].success);
                data_chart2[i] = parseInt(data[i].error);
                labels_chart[i] = "Act:" + data[i].project_id;
            }

            setStackedBar("chart_compilation",labels_chart, data_chart, data_chart2, "Success", "Error");

        });
}