String.prototype.addSubStr = function(pos,str){
    var beforeSubStr = this.substring(0,pos);
    var afterSubStr = this.substring(pos,this.length);
    return beforeSubStr+str+afterSubStr;
};

String.prototype.addFilePrefix = function(prefix){
    var pos = this.lastIndexOf('/');
    pos = pos === -1 ? 0 : pos + 1;
    return this.addSubStr(pos,prefix);
};
