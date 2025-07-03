/*Get Activity */
function sendPromptbyGroup( prompt, callback) { 
    var key = 0;
    var promptFine = "";
    var promptFew = "";
    var prompt;
    //get id current user, get id current activity 
    $.post( "../../../backend/getdatabygroup.php", function( data ) {
        //GROUP A 
        if(parseInt(data.user)%2 == 0){
            if(parseInt(data.atv)%3 == 0){
                //fewshot
                key =0;
                prompt= promptFew;
                
            }else if(parseInt(data.atv)%2 == 0){
                //fine-tuning
                key =1
                prompt= promptFine;
            }else{
                key = 3;
                prompt= promptZero;
            }
        //GROUP B 
        }else{
            if(parseInt(data.atv)%3 == 0){
                //fine-tunning
                key =1;
                prompt= promptFine;
            }else if(parseInt(data.atv)%2 == 0){
               //fewshot 
               key =0;
               prompt= promptFew;
            }else{
                key = 3;
                prompt= promptZero;
            }
        }

        requestChatGPT(prompt, key, callback);
    });
}