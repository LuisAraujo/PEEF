class PEditor {
    static error = 0;
    static success = 1;
    static no = 2;
    static start = -1;

    constructor() {

        this._filesnames = "a";
        this._fileactive = undefined;
        this._laststatus = PEditor.start; //"sucess"
        this._getfeedbackonmessage = false;
    }

    get fileNames(){
        return this._filesnames;
    }

    set fileNames(filesnames){
        this._filesnames = filesnames;
    }

    get fileActive(){
        return this._fileactive;
    }

    set fileActive(fileactive){
        this._fileactive = fileactive;
    }

    get laststatus(){
        return this._laststatus;
    }

    set laststatus(status){
        this._laststatus = status;
    }

    get getfeedbackonmessage(){
        return this._getfeedbackonmessage;
    }

    set getfeedbackonmessage(getfeedbackonmessage){
        this._getfeedbackonmessage = getfeedbackonmessage;
    }

    
}