function calctypeerror(idprojects, callback) {

    $.post( "../../backend/calc_type_error.php", {idproject: idprojects},
        function( data ) {

        console.log(data)
        callback();

    })
}

function getprojects(idprojects, callback) {
    console.log("ok");

    $.post( "../../backend/metrics/getjson_projecteditions.php", {idproject: idprojects}, function( data ) {
        console.log(data);
        var json = JSON.parse(data);
        console.log(json)
        callback(json);

    })
}

function  printprojects(json) {
    console.log(json)

    if(json.codes.length == 0){
        $("#all-codes").append("Don't have compilation to this project!");
    }

    for(var i = 0; i < json.codes.length; i++){
        var elems = '';

        if(json.codes[i].TestPassed == -1 )
            elems = '<div class="container-data-code comp-data-code">';
        else
            elems = '<div class="container-data-code test-data-code">';


        elems += '<span class="data-code">DIF: ' +json.codes[i].diff + '- Em: ' +json.codes[i].date + ' às ' +json.codes[i].hours +'</span>';
        elems += '<span class="data-lable">'+json.codes[i].compid+'</span>';


        if(json.codes[i].typeError ==  'no-error') {

            elems += '<span class="data-lable data-noerror">No Error</span>';

            if(json.codes[i].TestPassed == 0 ) {
                elems += '<span class="data-lable data-faill">Faill</span>';
            }else if(json.codes[i].TestPassed == 1 ){
                elems += '<span class="data-lable data-passed">Passed</span>';
            }else{
                elems += '<span class="data-lable data-nomessage">No Message</span>';
            }

        }else {
            elems += '<span class="data-lable data-error" title="Error : ' + json.codes[i].compMessage + ' - ECM : ' +json.codes[i].EnhancedMessage +'">' + json.codes[i].typeError + '</span>';

            console.log(json.codes[i].TestPassed);

            if(json.codes[i].TestPassed == 0 ) {
                elems += '<span class="data-lable data-faill">Faill</span>';
            }else if(json.codes[i].TestPassed == 1 ){
                elems += '<span class="data-lable data-passed">Passed</span>';
            }else if(json.codes[i].EnhancedMessage ==  '') {
                elems += '<span class="data-lable data-nomessage">No Message</span>';
            }else
                elems += '<span class="data-lable data-message" title="Enhanced message: '+json.codes[i].EnhancedMessage+'">'+json.codes[i].EnhancedMessage+'</span>';

        }

        var code = json.codes[i].code.join('\n') ;

        elems += '<div  class="container-code">';
        elems += '<div id="code-'+i+'" class="copy-code" code="'+code+'"> <i class="icofont-copy"></i> </div>'
        for(var j = 0; j < json.codes[i].code.length; j++) {
            elems += '<span class="';

            if(json.codes[i].line.includes(j+1+"") )
                elems += 'line-changed';

            if (j % 2 == 0)
                elems += ' line1"><span class="number">'+(j+1)+'</span>';
            else
                elems += ' line2"><span class="number">'+(j+1)+'</span>';

            elems += json.codes[i].code[j] +'</span>'

        }
        elems += "</div></div>";

        $("#all-codes").append(elems);
    }


    $(".copy-code").click(function () {
        code = $(this).attr("code");
        navigator.clipboard.writeText(code).then(function() {
            alert("Code copied!");
        });

    });


}

