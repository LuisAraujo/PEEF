function calctypeerror(idprojects, callback) {

    $.post( "../../backend/calc_type_error.php", {idproject: idprojects},
        function( data ) {

        console.log(data)
        callback();

    })
}

function getprojects(idprojects, callback) {
    console.log("ok");

    $.post( "../../backend/metrics/getjson_editions_onProjects.php", {idproject: idprojects}, function( data ) {
        //console.log(data);
        var json = JSON.parse(data);
        callback(json);

    })
}

function  printprojects(json) {
    console.log(json)
    for(var i = 0; i < json.codes.length; i++){

        var elems = '<div class="container-data-code">';
        elems += '<span class="data-code">DIF: ' +json.codes[i].diff + '- Em: ' +json.codes[i].date + ' às ' +json.codes[i].hours +'</span>';

        if(json.codes[i].typeError ==  'no-error')
            elems += '<span class="data-noerror">No Error</span>';
        else
            elems += '<span class="data-error">'+json.codes[i].typeError+'</span>';

        elems += '<div class="container-code">';

        console.log(json.codes[i].line);

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


}

/*valor fixo
* Colocar uma página anterior, com os cursos / projeto
* passar o id do projeto para esta pagina
* criar um ready
* */
calctypeerror( 9, function () {
    getprojects(9, printprojects );
});
