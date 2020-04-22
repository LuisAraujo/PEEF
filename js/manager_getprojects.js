function getprojects(idprojects, callback) {
    console.log("ok");

    $.post( "../../backend/getjson_editions_onProjects.php", function( data ) {
        //console.log(data);
        var json = JSON.parse(data);
        callback(json);

    })
}

function  printprojects(json) {

    for(var i = 0; i < json.codes.length; i++){

        var elems = '<div class="container-data-code">';
        elems += '<span class="data-code">DIF: ' +json.codes[i].diff + '- Em: ' +json.codes[i].date + ' às ' +json.codes[i].hours +'</span>';

        if(json.codes[i].typeError ==  'no-error')
            elems += '<span class="data-noerror">No Error</span>';
        else
            elems += '<span class="data-error">'+json.codes[i].typeError+'</span>';

        elems += '<div class="container-code">';

        console.log( json.codes[i])
        for(var j = 0; j < json.codes[i].code.length; j++) {
            elems += '<span class="';

            if(parseInt( json.codes[i].line) == j+1 )
                elems += 'line-changed';

            if (i % 2 == 0)
                elems += ' line1"><span class="number">'+(j+1)+'</span>';
            else
                elems += ' line2"><span class="number">'+(j+1)+'</span>';

            elems += json.codes[i].code[j] +'</span>'

        }
        elems += "</div></div>";

        $("#all-codes").append(elems);
    }


}

getprojects(1 , printprojects );