var LINKS = LINKS || (function(){
    var _args = {};

    return {
        init : function(Args) {
            _args = Args;
        },
        returnLink : function(subject_dtype, username) {
            return subject_dtype + " " + username;
        }
    };
}());