function Nodemessage(type, messagens){
    this.type = type
    this.messages = messagens;
    this.nodeno = null;
    this.nodeyes = null;
    this.nodeno_alt = null;
    this.nodeyes_alt = null;

}

Nodemessage.prototype.setMessageYes = function (nodeyes, nodeyes_alt) {
    this.nodeyes = nodeyes;

    if(nodeyes_alt != undefined)
        this.nodeyes_alt = nodeyes_alt;
}

Nodemessage.prototype.setMessageNo = function (nodeno, nodeno_alt) {
    this.nodeno = nodeno;

    if(nodeno_alt != undefined)
        this.nodeno_alt = nodeno_alt;
}


Nodemessage.prototype.getMessageYes = function () {
   return this.nodeyes;
}

Nodemessage.prototype.getMessageNo = function () {
    return this.nodeno;
}


Nodemessage.prototype.getMessageYesAlt = function () {
    return this.nodeyes_alt;
}

Nodemessage.prototype.getMessageNoAlt = function () {
    return this.nodeno_alt;
}


Nodemessage.prototype.getMessage = function () {
    return  this.messages[ parseInt( Math.random() * this.messages.length) ];
}