!function(a){function i(a,b,c,d,e,f){a=String(a);for(var g=0,h=0,i=a.length,j="",k=0;h<i;){var l=a.charCodeAt(h);for(l=l<256?c[l]:-1,g=(g<<e)+l,k+=e;k>=f;){k-=f;var m=g>>k;j+=d.charAt(m),g^=m<<k}++h}return!b&&k>0&&(j+=d.charAt(g<<f-k)),j}for(var b="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/",c="",d=[256],e=[256],f=0,g={encode:function(a){return a.replace(/[\u0080-\u07ff]/g,function(a){var b=a.charCodeAt(0);return String.fromCharCode(192|b>>6,128|63&b)}).replace(/[\u0800-\uffff]/g,function(a){var b=a.charCodeAt(0);return String.fromCharCode(224|b>>12,128|b>>6&63,128|63&b)})},decode:function(a){return a.replace(/[\u00e0-\u00ef][\u0080-\u00bf][\u0080-\u00bf]/g,function(a){var b=(15&a.charCodeAt(0))<<12|(63&a.charCodeAt(1))<<6|63&a.charCodeAt(2);return String.fromCharCode(b)}).replace(/[\u00c0-\u00df][\u0080-\u00bf]/g,function(a){var b=(31&a.charCodeAt(0))<<6|63&a.charCodeAt(1);return String.fromCharCode(b)})}};f<256;){var h=String.fromCharCode(f);c+=h,e[f]=f,d[f]=b.indexOf(h),++f}var j=a.base64=function(a,b,c){return b?j[a](b,c):a?null:this};j.btoa=j.encode=function(a,c){return a=!1===j.raw||j.utf8encode||c?g.encode(a):a,(a=i(a,!1,e,b,8,6))+"====".slice(a.length%4||4)},j.atob=j.decode=function(a,b){a=String(a).split("=");var e=a.length;do{--e,a[e]=i(a[e],!0,d,c,6,8)}while(e>0);return a=a.join(""),!1===j.raw||j.utf8decode||b?g.decode(a):a}}(jQuery);