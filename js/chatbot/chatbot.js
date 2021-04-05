function PEEFbot(){

    this.nodes = [];
    this.currentnode = null;
    this.startnode = null;
    this.errornode = null;
    this.solutionnode = null;
    this.waitteacher = false;
    this.avaliation = null;
    this.arrsolution = [];
    this.countmsg = 0;


}

PEEFbot.prototype.reset = function () {
    this.getSolutions("Syntax Error");
    this.currentnode = null;
}

PEEFbot.prototype.start = function () {

    this.getSolutions("Syntax Error");

    let nsalutation = new Nodemessage("salutation", ["Oi, eu sou o PEEFbot", "Oi, como vai?", "Quer conversar?"] );

    let nhelp = new Nodemessage("help", ["Como posso lhe ajudar?", "Vejo que precisa de ajuda.", "Algum problema ai?"] );
    let nenhanced = new Nodemessage("enhanced", ["Nós adicionamos uma mensagem melhorada...", "O PEEF utiliza mensagem melhorada...", "O PEEF utiliza mensagem melhorada..."] );
    let nundestand = new Nodemessage("undestand", ["Você conseguiu entender a mensagem de erro?"] );
    let nanalysis = new Nodemessage("analysis", ["Ok, vou analisar o seu código. Um instante!", "Ok, um instante! Vou verificar  o seu erro."] );
    let ntypeerror = new Nodemessage("typeerror", ["Você tem um erro de "] );
    let npresentation = new Nodemessage("presentation", ["Eu tenho alguma possíveis soluções.", "Acho que tenho algo que pode lhe ajudar.", "Vamos lá!"] );
    let nsolution = new Nodemessage("solution", ["Você já tentou fazer ", "Que tal tentar ", "Fazer  isso pode lhe ajudar: "] );

    let nconfirm = new Nodemessage("confirm", ["Vi que resolveu o seu problema. Parabéns! De 1 a 10 quanto a minha dica lhe ajudou!"] );
    let navaliation = new Nodemessage("avaliation", ["Você solucionou o seu problema?"] );


    let noversolution = new Nodemessage("oversolution", ["Não entendi muito bem...", "Não entendi muito bem...", "Desculpa, pode falar de outra forma?"] );
    let nclose = new Nodemessage("close", ["Até mais!", "Tchau!"] );
    let nerror = new Nodemessage("close", ["Infelizmente não consegui me conectar ao servidor...","Infelizmente não consigo lhe ajudar agora...", "Infelizmente não consigo lhe ajudar agora..."] );

    let nmanualmessage =new Nodemessage("manualmessage", ["Um instante!"] );

    nsalutation.setMessageYes(nhelp);
    nsalutation.setMessageNo(nhelp);

    nhelp.setMessageYes(nenhanced);
    nhelp.setMessageNo(nclose);

    nenhanced.setMessageYes(nundestand);
    nenhanced.setMessageNo(nundestand);

    nundestand.setMessageYes(npresentation);
    nundestand.setMessageNo(nanalysis);

    nanalysis.setMessageYes(ntypeerror);
    nanalysis.setMessageNo(ntypeerror);

    ntypeerror.setMessageYes(npresentation);
    ntypeerror.setMessageNo(npresentation);

    npresentation.setMessageYes(nsolution);
    npresentation.setMessageNo(nsolution);

    nsolution.setMessageYes(navaliation);
    nsolution.setMessageNo(nmanualmessage);

    navaliation.setMessageYes(nconfirm);
    navaliation.setMessageNo(npresentation);

    noversolution.setMessageYes(nmanualmessage);
    noversolution.setMessageNo(nerror);

    nconfirm.setMessageYes(nclose);
    nconfirm.setMessageNo(nsolution, noversolution);

    nmanualmessage.setMessageNo(nerror);

    this.solutionnode = nsolution;
    this.startnode = nsalutation;
    this.errornode = new Nodemessage("try", ["Não entendi, tente novamente...", "Como?", "Acho que não entendi!"] );
    this.avaliation = navaliation;

}

PEEFbot.prototype.getResponse = function(text)
{
    this.countmsg++;

    let response = this.nextNode(this.processText(text));

    if((response[1] == "salutation") || (response[1] ==  "enhanced") || (response[1] == "presentation")
        || ( response[1] == "analysis") || ( response[1] == "close") || (response[1] == "typeerror")
    ) {

        setTimeout(this.getResponse.bind(this, "yes"), 1500);


    }else if ( response[1] == "manualmessage"){
        this.waitteacher = true;

        setTimeout( function(){
            if(this.waitteacher == true)
                this.getResponse.bind(this,"no");
        }, 6000);
    }

    console.log(response[0], response[1]);

    sendmessage(response[0], 1 , function (data2) {
        console.log(data2);

        getlastmessages( function (data) {
            if(response[1] == "typeerror") {
                setMessageChat(data, function () {
                    $.post("../../backend/project/project_getlastcompilation.php" )
                        .done(function(data)
                        {
                            data = JSON.parse(data);
                            $(".msgtypeerror").last().html( data.typeerror);

                        })

                });
            }else{
                setMessageChat(data);
            }

        });
    });
}

PEEFbot.prototype.setNode = function (node) {
    if(node == "avaliation")
        this.currentnode =  this.avaliation;
}


PEEFbot.prototype.processText = function (text) {

    text = text.toLocaleLowerCase().replace(/\n/g, '');
    text = " " + text + " ";

    let no = [" não ", " nao ", " n ", " no ", " not ", " ñ "];
    let yes = [" sim ", "s ", "ss ", " yes ", "y"];
    let error = [" erro "];
    let other = [" outra ", " outra solução "];


    for(let i = 0; i < no.length; i++)
        if( text.includes(no[i]))
            return "no";

    for(let i = 0; i < yes.length; i++)
        if( text.includes(yes[i]))
            return "yes";

    for(let i = 0; i < error.length; i++)
        if( text.includes(error[i]))
            return "error";

    for(let i = 0; i < other.length; i++)
        if( text.includes(other[i]))
            return "other";

    if(!isNaN(text)){
        return text;
    }
}


PEEFbot.prototype.getSolutions = function (typeerror) {
    //check n solution?
    this.arrsolution = ["S1", "S2", "S3"];
}


PEEFbot.prototype.nextNode = function (response) {
    let tempnode = null;

    if(this.currentnode == null) {
        this.currentnode = this.startnode;
        return  [this.currentnode.getMessage(), this.currentnode.type];
    }

    if(this.currentnode.type == "help"){
        if(response == "error"){
            this.currentnode = this.currentnode.getMessageYes();
            return [this.currentnode.getMessage(), this.currentnode.type]
        }
    }

    if(this.currentnode.type == "confirm") {
        this.currentnode = this.currentnode.getMessageYes();
        if (parseInt(response) < 7)
            return ["Ok, Tentarei melhorar! " + this.currentnode.getMessage(), this.currentnode.type];
        else
            return ["Obrigado! " + this.currentnode.getMessage(), this.currentnode.type];
    }



    if(response == "no"){

       tempnode = this.currentnode.getMessageNo();

       if (tempnode.type == "typeerror") {
           //get error
           this.currentnode = tempnode;

           return [tempnode.getMessage() + '<i class="msgtypeerror">...</i>' , tempnode.type]
       }

       this.currentnode = tempnode;
       return [tempnode.getMessage(), tempnode.type];

    }else if(response == "yes"){

        tempnode = this.currentnode.getMessageYes();

        if(this.currentnode.type == "presentation") {

            let sl = this.arrsolution.shift();
            if (sl != undefined) {
                this.currentnode = tempnode;
                return [tempnode.getMessage() + sl + ". Digite <i>outra solução</i> caso já tenha tentado!", tempnode.type];
            } else {
                tempnode = this.currentnode.getMessageYesAlt();
                this.currentnode = tempnode;
                return ["Não encontrei nada...", null];
            }

        }else if(this.currentnode.type == "analysis"){
            //get error
            this.currentnode = tempnode;


            return [tempnode.getMessage() + '<i class="msgtypeerror">...</i>' , tempnode.type, this.countmsg ]


        }else if(this.currentnode.type == "solution") {

            //check n solution?
            this.currentnode = tempnode;
            return [tempnode.getMessage(), tempnode.type];

        }else if (this.currentnode.type == "typeerror") {
            //get error
            this.currentnode = tempnode;
            return [tempnode.getMessage(), tempnode.type]
        }

        this.currentnode = tempnode;
        return [tempnode.getMessage(), tempnode.type];

    }else if((response == "other") && (this.currentnode.type == "solution" )){

        this.currentnode = this.solutionnode;
        tempnode = this.currentnode;

        let sl = this.arrsolution.shift();
        if(sl != undefined) {

            this.currentnode = tempnode;
            return [tempnode.getMessage() + sl + ". Digite <i>outra solução</i>  caso já tenha tentado!", tempnode.type];

        }else{
            //manual message
            tempnode = this.currentnode.getMessageNo();
            this.currentnode = tempnode;

            return [tempnode.getMessage(), tempnode.type];
        }

    }else{
        return [this.errornode.getMessage(), this.errornode.type];
    }

}