define(['avalon'], function(){
    var escapeMap = {
        "<": "&#60;",
        ">": "~~&#62;",
        '"': "&#34;",
        "'": "&#39;",
        "&": "&#38;"
    };
    var escapeHTML = function (content) {
        return String(content)
        .replace(/&(?![\w#]+;)|[<>"']/g, function(s){
            return escapeMap[s];
        });
    };
    avalon.filters.myTruncate = function(str, length, truncation, elem) {
        length = length || 30
        truncation = truncation === void(0) ? "..." : truncation;

        str = escapeHTML(str);

        if(str==null || str== 'NULL'){
            return '';
        }else{
            return str.length > length ? '<span tooltip-content="'+str+'">'+str.slice(0, length - truncation.length) + truncation +'</span>': String(str);
        }
    };
    avalon.filters.highlight = function(str, search, color){
        return String(str).replace(new RegExp(search, 'g'), function(a){
            return '<span style="color:'+color+'">'+a+'</span>';
        });
    };
    avalon.filters.myTurnHtml = function(str, search, color){
        return str.replace(/(&lt;)/g,'<').replace(/(&gt;)/g,'>').replace(/(&quot;)/g, '"');
    };
    avalon.filters.flowMatrix = function(str){
        if(str > 1024*1024*1024){
            str = (str/1024/1024/1024).toFixed(2)+'G';
        }else if(str > 1024/1024){
            str = (str/1024/1024).toFixed(2) + 'M';
        }else if(str > 1024){
            str = (str/1024).toFixed(2) + 'KB';
        }
        return str;
    };
    avalon.filters.myMatrix = function(str){
        if(str > 10000000){
            str = (str/10000000).toFixed(2) + 'KW';
        }if(str > 10000){
            str = (str/10000).toFixed(2) + 'W';
        }else if(str > 1000){
            str = (str/1000).toFixed(2) + 'K';
        }
        return str;
    };
})