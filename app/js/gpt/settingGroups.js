/*Get Activity */
function sendPromptbyGroup(data) { 
    var key = 0;
    
    var prompt;
    //get id current user, get id current activity 
    $.post( "../../backend/util/getuserid.php", function( id ) {
            
            //GROUP A - zero shot
            if(parseInt(id)%3 == 0){
   
                prompt= getPrompt('zero', data);
            //GROUP B - few shot
            } if(parseInt(id)%2 == 0){

                 prompt= getPrompt('few', data);
            //GROUP C - fine-tuning
            }else{
       
                prompt= getPrompt('fine', data);
            }
     
        //requestChatGPT(prompt, key, callback);
    });
}


function getPrompt(type, data){
    if(type == "zero"){
        filename = '../../js/gpt/_prompt_zero.txt';
        key =  0;
    }else if(type == "few"){
        filename = '../../js/gpt/_prompt_few.txt';
        key =  0;
    }else if(type == "fine"){
        filename = '../../js/gpt/_prompt_fine.txt';
        key =  1;
    }

    var prompt = "";

    // Lê o conteúdo do arquivo prompt.txt
    fetch(filename)
        .then(response => {
            if (!response.ok) {
                throw new Error('Erro ao carregar o arquivo: ' + response.statusText);
            }
            return response.text(); // Lê o conteúdo como texto
        })
        .then(fileContent => {
            console.log(data);

            prompt += fileContent;
            prompt += "# DESCRIÇÃO DA ATIVIDADE\n";
            prompt += data.atvdesc+"\n";

            prompt +="# CÓDIGO COM ERRO\n";
            prompt += data.code +"\n";

            prompt +="# MENSAGEM DE ERRO\n";
            prompt += data.error+"\n";

            prompt += "#Explique qual o erro sintático deste código? Dê exemplos de como resolver\n";
   

            requestChatGPT(prompt, key, function(data){
                console.log(data);
                data = data.replaceAll("\n", "<br>");

               $("#modal-error").show();
               $("#mensage-error").html(data);
               
                //exibir
               //salvar
            })
        })
        .catch(error => {
            console.error('Erro ao ler o arquivo:', error);
        });
}

