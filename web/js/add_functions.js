String.prototype.addSubStr = function(pos,str){
    var beforeSubStr = this.substring(0,pos);
    var afterSubStr = this.substring(pos,this.length);
    return beforeSubStr+str+afterSubStr;
};
