/*  
jQUERY FORM
*/
!function(a){"use strict";function c(b){var c=b.data;b.isDefaultPrevented()||(b.preventDefault(),a(this).ajaxSubmit(c))}function d(b){var c=b.target,d=a(c);if(!d.is(":submit,input:image")){var e=d.closest(":submit");if(0===e.length)return;c=e[0]}var f=this;if(f.clk=c,"image"==c.type)if(void 0!==b.offsetX)f.clk_x=b.offsetX,f.clk_y=b.offsetY;else if("function"==typeof a.fn.offset){var g=d.offset();f.clk_x=b.pageX-g.left,f.clk_y=b.pageY-g.top}else f.clk_x=b.pageX-c.offsetLeft,f.clk_y=b.pageY-c.offsetTop;setTimeout(function(){f.clk=f.clk_x=f.clk_y=null},100)}function e(){if(a.fn.ajaxSubmit.debug){var b="[jquery.form] "+Array.prototype.join.call(arguments,"");window.console&&window.console.log?window.console.log(b):window.opera&&window.opera.postError&&window.opera.postError(b)}}var b={};b.fileapi=void 0!==a("<input type='file'/>").get(0).files,b.formdata=void 0!==window.FormData,a.fn.ajaxSubmit=function(c){function x(b){for(var d=new FormData,e=0;e<b.length;e++)d.append(b[e].name,b[e].value);if(c.extraData)for(var f in c.extraData)c.extraData.hasOwnProperty(f)&&d.append(f,c.extraData[f]);c.data=null;var g=a.extend(!0,{},a.ajaxSettings,c,{contentType:!1,processData:!1,cache:!1,type:"POST"});c.uploadProgress&&(g.xhr=function(){var a=jQuery.ajaxSettings.xhr();return a.upload&&(a.upload.onprogress=function(a){var b=0,d=a.loaded||a.position,e=a.total;a.lengthComputable&&(b=Math.ceil(d/e*100)),c.uploadProgress(a,d,e,b)}),a}),g.data=null;var h=g.beforeSend;g.beforeSend=function(a,b){b.data=d,h&&h.call(b,a,c)},a.ajax(g)}function y(b){function x(a){return a.contentWindow?a.contentWindow.document:a.contentDocument?a.contentDocument:a.document}function A(){function g(){try{var a=x(o).readyState;e("state = "+a),a&&"uninitialized"==a.toLowerCase()&&setTimeout(g,50)}catch(a){e("Server abort: ",a," (",a.name,")"),F(w),t&&clearTimeout(t),t=void 0}}var b=h.attr("target"),c=h.attr("action");f.setAttribute("target",m),d||f.setAttribute("method","POST"),c!=j.url&&f.setAttribute("action",j.url),j.skipEncodingOverride||d&&!/post/i.test(d)||h.attr({encoding:"multipart/form-data",enctype:"multipart/form-data"}),j.timeout&&(t=setTimeout(function(){s=!0,F(v)},j.timeout));var i=[];try{if(j.extraData)for(var k in j.extraData)j.extraData.hasOwnProperty(k)&&i.push(a('<input type="hidden" name="'+k+'">').attr("value",j.extraData[k]).appendTo(f)[0]);j.iframeTarget||(n.appendTo("body"),o.attachEvent?o.attachEvent("onload",F):o.addEventListener("load",F,!1)),setTimeout(g,15),f.submit()}finally{f.setAttribute("action",c),b?f.setAttribute("target",b):h.removeAttr("target"),a(i).remove()}}function F(b){if(!p.aborted&&!E){try{C=x(o)}catch(a){e("cannot access response document: ",a),b=w}if(b===v&&p)return void p.abort("timeout");if(b==w&&p)return void p.abort("server abort");if(C&&C.location.href!=j.iframeSrc||s){o.detachEvent?o.detachEvent("onload",F):o.removeEventListener("load",F,!1);var d,c="success";try{if(s)throw"timeout";var f="xml"==j.dataType||C.XMLDocument||a.isXMLDoc(C);if(e("isXml="+f),!f&&window.opera&&(null===C.body||!C.body.innerHTML)&&--D)return e("requeing onLoad callback, DOM not available"),void setTimeout(F,250);var g=C.body?C.body:C.documentElement;p.responseText=g?g.innerHTML:null,p.responseXML=C.XMLDocument?C.XMLDocument:C,f&&(j.dataType="xml"),p.getResponseHeader=function(a){return{"content-type":j.dataType}[a]},g&&(p.status=Number(g.getAttribute("status"))||p.status,p.statusText=g.getAttribute("statusText")||p.statusText);var h=(j.dataType||"").toLowerCase(),i=/(json|script|text)/.test(h);if(i||j.textarea){var k=C.getElementsByTagName("textarea")[0];if(k)p.responseText=k.value,p.status=Number(k.getAttribute("status"))||p.status,p.statusText=k.getAttribute("statusText")||p.statusText;else if(i){var m=C.getElementsByTagName("pre")[0],q=C.getElementsByTagName("body")[0];m?p.responseText=m.textContent?m.textContent:m.innerText:q&&(p.responseText=q.textContent?q.textContent:q.innerText)}}else"xml"==h&&!p.responseXML&&p.responseText&&(p.responseXML=G(p.responseText));try{B=I(p,h,j)}catch(b){c="parsererror",p.error=d=b||c}}catch(b){e("error caught: ",b),c="error",p.error=d=b||c}p.aborted&&(e("upload aborted"),c=null),p.status&&(c=p.status>=200&&p.status<300||304===p.status?"success":"error"),"success"===c?(j.success&&j.success.call(j.context,B,"success",p),l&&a.event.trigger("ajaxSuccess",[p,j])):c&&(void 0===d&&(d=p.statusText),j.error&&j.error.call(j.context,p,c,d),l&&a.event.trigger("ajaxError",[p,j,d])),l&&a.event.trigger("ajaxComplete",[p,j]),l&&!--a.active&&a.event.trigger("ajaxStop"),j.complete&&j.complete.call(j.context,p,c),E=!0,j.timeout&&clearTimeout(t),setTimeout(function(){j.iframeTarget||n.remove(),p.responseXML=null},100)}}}var g,i,j,l,m,n,o,p,q,r,s,t,f=h[0],u=!!a.fn.prop;if(a(":input[name=submit],:input[id=submit]",f).length)return void alert('Error: Form elements must not have name or id of "submit".');if(b)for(i=0;i<k.length;i++)g=a(k[i]),u?g.prop("disabled",!1):g.removeAttr("disabled");if(j=a.extend(!0,{},a.ajaxSettings,c),j.context=j.context||j,m="jqFormIO"+(new Date).getTime(),j.iframeTarget?(n=a(j.iframeTarget),r=n.attr("name"),r?m=r:n.attr("name",m)):(n=a('<iframe name="'+m+'" src="'+j.iframeSrc+'" />'),n.css({position:"absolute",top:"-1000px",left:"-1000px"})),o=n[0],p={aborted:0,responseText:null,responseXML:null,status:0,statusText:"n/a",getAllResponseHeaders:function(){},getResponseHeader:function(){},setRequestHeader:function(){},abort:function(b){var c="timeout"===b?"timeout":"aborted";e("aborting upload... "+c),this.aborted=1,n.attr("src",j.iframeSrc),p.error=c,j.error&&j.error.call(j.context,p,c,b),l&&a.event.trigger("ajaxError",[p,j,c]),j.complete&&j.complete.call(j.context,p,c)}},l=j.global,l&&0==a.active++&&a.event.trigger("ajaxStart"),l&&a.event.trigger("ajaxSend",[p,j]),j.beforeSend&&!1===j.beforeSend.call(j.context,p,j))return void(j.global&&a.active--);if(!p.aborted){q=f.clk,q&&(r=q.name)&&!q.disabled&&(j.extraData=j.extraData||{},j.extraData[r]=q.value,"image"==q.type&&(j.extraData[r+".x"]=f.clk_x,j.extraData[r+".y"]=f.clk_y));var v=1,w=2,y=a("meta[name=csrf-token]").attr("content"),z=a("meta[name=csrf-param]").attr("content");z&&y&&(j.extraData=j.extraData||{},j.extraData[z]=y),j.forceSync?A():setTimeout(A,10);var B,C,E,D=50,G=a.parseXML||function(a,b){return window.ActiveXObject?(b=new ActiveXObject("Microsoft.XMLDOM"),b.async="false",b.loadXML(a)):b=(new DOMParser).parseFromString(a,"text/xml"),b&&b.documentElement&&"parsererror"!=b.documentElement.nodeName?b:null},H=a.parseJSON||function(a){return window.eval("("+a+")")},I=function(b,c,d){var e=b.getResponseHeader("content-type")||"",f="xml"===c||!c&&e.indexOf("xml")>=0,g=f?b.responseXML:b.responseText;return f&&"parsererror"===g.documentElement.nodeName&&a.error&&a.error("parsererror"),d&&d.dataFilter&&(g=d.dataFilter(g,c)),"string"==typeof g&&("json"===c||!c&&e.indexOf("json")>=0?g=H(g):("script"===c||!c&&e.indexOf("javascript")>=0)&&a.globalEval(g)),g}}}if(!this.length)return e("ajaxSubmit: skipping submit process - no element selected"),this;var d,f,g,h=this;"function"==typeof c&&(c={success:c}),d=this.attr("method"),f=this.attr("action"),g="string"==typeof f?a.trim(f):"",g=g||window.location.href||"",g&&(g=(g.match(/^([^#]+)/)||[])[1]),c=a.extend(!0,{url:g,success:a.ajaxSettings.success,type:d||"GET",iframeSrc:/^https/i.test(window.location.href||"")?"javascript:false":"about:blank"},c);var i={};if(this.trigger("form-pre-serialize",[this,c,i]),i.veto)return e("ajaxSubmit: submit vetoed via form-pre-serialize trigger"),this;if(c.beforeSerialize&&!1===c.beforeSerialize(this,c))return e("ajaxSubmit: submit aborted via beforeSerialize callback"),this;var j=c.traditional;void 0===j&&(j=a.ajaxSettings.traditional);var l,k=[],m=this.formToArray(c.semantic,k);if(c.data&&(c.extraData=c.data,l=a.param(c.data,j)),c.beforeSubmit&&!1===c.beforeSubmit(m,this,c))return e("ajaxSubmit: submit aborted via beforeSubmit callback"),this;if(this.trigger("form-submit-validate",[m,this,c,i]),i.veto)return e("ajaxSubmit: submit vetoed via form-submit-validate trigger"),this;var n=a.param(m,j);l&&(n=n?n+"&"+l:l),"GET"==c.type.toUpperCase()?(c.url+=(c.url.indexOf("?")>=0?"&":"?")+n,c.data=null):c.data=n;var o=[];if(c.resetForm&&o.push(function(){h.resetForm()}),c.clearForm&&o.push(function(){h.clearForm(c.includeHidden)}),!c.dataType&&c.target){var p=c.success||function(){};o.push(function(b){var d=c.replaceTarget?"replaceWith":"html";a(c.target)[d](b).each(p,arguments)})}else c.success&&o.push(c.success);c.success=function(a,b,d){for(var e=c.context||c,f=0,g=o.length;f<g;f++)o[f].apply(e,[a,b,d||h,h])};var q=a("input:file:enabled[value]",this),r=q.length>0,s="multipart/form-data",t=h.attr("enctype")==s||h.attr("encoding")==s,u=b.fileapi&&b.formdata;e("fileAPI :"+u);var v=(r||t)&&!u;!1!==c.iframe&&(c.iframe||v)?c.closeKeepAlive?a.get(c.closeKeepAlive,function(){y(m)}):y(m):(r||t)&&u?x(m):a.ajax(c);for(var w=0;w<k.length;w++)k[w]=null;return this.trigger("form-submit-notify",[this,c]),this},a.fn.ajaxForm=function(b){if(b=b||{},b.delegation=b.delegation&&a.isFunction(a.fn.on),!b.delegation&&0===this.length){var f={s:this.selector,c:this.context};return!a.isReady&&f.s?(e("DOM not ready, queuing ajaxForm"),a(function(){a(f.s,f.c).ajaxForm(b)}),this):(e("terminating; zero elements found by selector"+(a.isReady?"":" (DOM not ready)")),this)}return b.delegation?(a(document).off("submit.form-plugin",this.selector,c).off("click.form-plugin",this.selector,d).on("submit.form-plugin",this.selector,b,c).on("click.form-plugin",this.selector,b,d),this):this.ajaxFormUnbind().bind("submit.form-plugin",b,c).bind("click.form-plugin",b,d)},a.fn.ajaxFormUnbind=function(){return this.unbind("submit.form-plugin click.form-plugin")},a.fn.formToArray=function(c,d){var e=[];if(0===this.length)return e;var f=this[0],g=c?f.getElementsByTagName("*"):f.elements;if(!g)return e;var h,i,j,k,l,m,n;for(h=0,m=g.length;h<m;h++)if(l=g[h],j=l.name)if(c&&f.clk&&"image"==l.type)l.disabled||f.clk!=l||(e.push({name:j,value:a(l).val(),type:l.type}),e.push({name:j+".x",value:f.clk_x},{name:j+".y",value:f.clk_y}));else if((k=a.fieldValue(l,!0))&&k.constructor==Array)for(d&&d.push(l),i=0,n=k.length;i<n;i++)e.push({name:j,value:k[i]});else if(b.fileapi&&"file"==l.type&&!l.disabled){d&&d.push(l);var o=l.files;if(o.length)for(i=0;i<o.length;i++)e.push({name:j,value:o[i],type:l.type});else e.push({name:j,value:"",type:l.type})}else null!==k&&void 0!==k&&(d&&d.push(l),e.push({name:j,value:k,type:l.type,required:l.required}));if(!c&&f.clk){var p=a(f.clk),q=p[0];j=q.name,j&&!q.disabled&&"image"==q.type&&(e.push({name:j,value:p.val()}),e.push({name:j+".x",value:f.clk_x},{name:j+".y",value:f.clk_y}))}return e},a.fn.formSerialize=function(b){return a.param(this.formToArray(b))},a.fn.fieldSerialize=function(b){var c=[];return this.each(function(){var d=this.name;if(d){var e=a.fieldValue(this,b);if(e&&e.constructor==Array)for(var f=0,g=e.length;f<g;f++)c.push({name:d,value:e[f]});else null!==e&&void 0!==e&&c.push({name:this.name,value:e})}}),a.param(c)},a.fn.fieldValue=function(b){for(var c=[],d=0,e=this.length;d<e;d++){var f=this[d],g=a.fieldValue(f,b);null===g||void 0===g||g.constructor==Array&&!g.length||(g.constructor==Array?a.merge(c,g):c.push(g))}return c},a.fieldValue=function(b,c){var d=b.name,e=b.type,f=b.tagName.toLowerCase();if(void 0===c&&(c=!0),c&&(!d||b.disabled||"reset"==e||"button"==e||("checkbox"==e||"radio"==e)&&!b.checked||("submit"==e||"image"==e)&&b.form&&b.form.clk!=b||"select"==f&&-1==b.selectedIndex))return null;if("select"==f){var g=b.selectedIndex;if(g<0)return null;for(var h=[],i=b.options,j="select-one"==e,k=j?g+1:i.length,l=j?g:0;l<k;l++){var m=i[l];if(m.selected){var n=m.value;if(n||(n=m.attributes&&m.attributes.value&&!m.attributes.value.specified?m.text:m.value),j)return n;h.push(n)}}return h}return a(b).val()},a.fn.clearForm=function(b){return this.each(function(){a("input,select,textarea",this).clearFields(b)})},a.fn.clearFields=a.fn.clearInputs=function(b){var c=/^(?:color|date|datetime|email|month|number|password|range|search|tel|text|time|url|week)$/i;return this.each(function(){var d=this.type,e=this.tagName.toLowerCase();c.test(d)||"textarea"==e?this.value="":"checkbox"==d||"radio"==d?this.checked=!1:"select"==e?this.selectedIndex=-1:b&&(!0===b&&/hidden/.test(d)||"string"==typeof b&&a(this).is(b))&&(this.value="")})},a.fn.resetForm=function(){return this.each(function(){("function"==typeof this.reset||"object"==typeof this.reset&&!this.reset.nodeType)&&this.reset()})},a.fn.enable=function(a){return void 0===a&&(a=!0),this.each(function(){this.disabled=!a})},a.fn.selected=function(b){return void 0===b&&(b=!0),this.each(function(){var c=this.type;if("checkbox"==c||"radio"==c)this.checked=b;else if("option"==this.tagName.toLowerCase()){var d=a(this).parent("select");b&&d[0]&&"select-one"==d[0].type&&d.find("option").selected(!1),this.selected=b}})},a.fn.ajaxSubmit.debug=!1}(jQuery)

/*
JQUERY SMARTSUGGEST
*/
!function(j){function a(b){clearTimeout(b),b=null}j.fn.smartSuggest=function(k){var k=j.extend({boxId:"%-suggestions",classPrefix:"ss-",timeoutLength:500,src:"",resultsText:"$ of % results",noResultsText:"No results.",showEmptyCategories:!1,fillBox:!1,fillBoxWith:"primary",executeCode:!0,showImages:!0,minChars:2},k);k.boxId=k.boxId.replace("%",j(this).attr("id"));var b="";j(this).wrap("<div class=\""+k.classPrefix+"wrap\"></div>"),j(this).attr("autocomplete","off"),j(this).after("<ul class=\""+k.classPrefix+"box\" id=\""+k.boxId+"\" style=\"display: none;\"></ul>");var l=j(this),d=j("#"+k.boxId),g=null;l.keyup(function(c){if(13!=c.keyCode&&9!=c.keyCode){var e=l.val();""==e||e.length<k.minChars?(d.fadeOut(),a(g)):(null!=g&&a(g),g=setTimeout(function(){l.addClass(k.classPrefix+"input-thinking"),b=e,j.getJSON(k.src+"?q="+e,function(a,b){if("success"==b){var c="",g=!1;j.each(a,function(c,a){0<a.data.length&&(g=!0)}),g?j.each(a,function(a,b){if(k.showEmptyCategories||!k.showEmptyCategories&&0!=b.data.length){var e=b.header.limit,f=0;c+="<li class=\""+k.classPrefix+"header\">\n",c+="<p class=\""+k.classPrefix+"header-text\">"+b.header.title+"</p>\n",c+="<p class=\""+k.classPrefix+"header-limit\">"+k.resultsText.replace("%",b.header.num).replace("$",b.header.limit<b.data.length?b.header.limit:b.data.length)+"</p>\n",c+="</li>";var g=k.fillBox?"document.getElementById('"+l.attr("id")+"').value = '%';":"";j.each(b.data,function(h,a){if(f<e){var b="<a href=\"";b+=null==a.url?"javascript: void(0);":a.url,b+="\" ",b+=null==a.onclick?"":" onclick=\""+g.replace("%",a[k.fillBoxWith])+(k.executeCode?a.onclick:"")+"\" ",b+=">",c+="<li class=\""+k.classPrefix+"result\">"+b+"\n",c+="<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" style=\"border-collapse: separate; border-spacing: 10px 5px;\"><tr>",c+=null!=a.image&&k.showImages?"<td style=\"background-image:url('"+a.image+"');width:50px;height:50px;background-size: 50px; background-position:50% 30%; margin-right:2px;\"></td>\n":"",c+="<td>",c+="<p>",c+=null==a.primary?"":"<span class=\""+k.classPrefix+"result-title\">"+a.primary+"</span><br />\n",c+=null==a.secondary?"":"<span class=\""+k.classPrefix+"result-last\">"+a.secondary+"</span>\n",c+="</p>\n",c+="</td>",c+="</tr></table>",c+="</a></li>\n"}f++})}}):(c+="<li class=\""+k.classPrefix+"header\">\n",c+="<p class=\""+k.classPrefix+"header-text\">"+k.noResultsText+"</p>\n",c+="<p class=\""+k.classPrefix+"header-limit\">0 results</p>\n",c+="</li>"),d.html(c),d.fadeIn(),l.removeClass(k.classPrefix+"input-thinking")}})},k.timeoutLength))}}),l.blur(function(){d.fadeOut()}),l.focus(function(){l.val()==b&&""!=l.val()&&d.fadeIn()})}}(jQuery);

function read_noti(t){return!!parseInt(t)&&void $.ajax({url:siteURL+"/app/manga/controllers/cont.dellNoti.php",type:"POST",dataType:"html",data:{id:t,type:"read"}})}function show(t){return $("#pop_manga").html('<img src=" '+siteURL+'/app/manga/themes/default/assets/images/pop-load.gif">').css({width:"auto"}).stop(!0,!0).show(0),jQuery.ajax({url:siteURL+"/app/manga/controllers/cont.pop.php",data:{action:"pop",id:t},success:function(t){$("#pop_manga").animate({width:"500px"},400),$("#pop_manga").html(t)},error:function(t){console.log(t)}}),!1}function out_show(){$("#pop_manga").html("").stop(!0,!0).hide(0)}$(document).ready(function(){$("a.icon-noti").one("click",function(){$.ajax({url:siteURL+"/app/manga/controllers/cont.navbarNoti.php",type:"POST",dataType:"html",data:{active:"showNoti"},beforeSend:function(){$(".scroll-noti").html('<img src="'+siteURL+'/app/manga/themes/default/assets/images/loading.gif" style="width:100%">').delay(5e3)},success:function(t){$(".scroll-noti").html(t)}})}),$("#tickAll").one("click",function(t){$.ajax({url:siteURL+"/app/manga/controllers/cont.dellNoti.php",type:"POST",dataType:"html",data:{type:"read-all"},success:function(t){$("span").remove(".badge"),$("li").removeClass("not-read")}})})}),$(document).ready(function(){$(".btn-report").click(function(t){var a=$("#manga").val(),n=$("#chapter").val(),o=$("#content").val();t.preventDefault(),""==o?alert("Bạn vui lòng nhập lỗi mà bạn gặp phải!"):$.ajax({url:siteURL+"/app/manga/controllers/cont.ReportError.php",type:"POST",dataType:"html",data:{mid:a,cid:n,content:o},success:function(t){$("#content").val(""),$("#modal_baoloi").modal("hide"),$("#report_error").fadeOut(2e3)}})}),$.fn.charCounter=function(n,o){function e(t,a){(t=$(t)).val().length>n&&(t.val(t.val().substring(0,n)),o.pulse&&!i&&function t(a,n){i&&(window.clearTimeout(i),i=null),a.animate({opacity:.1},100,function(){$(this).animate({opacity:1},100)}),n&&(i=window.setTimeout(function(){t(a)},200))}(a,!0)),0<o.delay?(c&&window.clearTimeout(c),c=window.setTimeout(function(){a.html(o.format.replace(/%1/,n-t.val().length))},o.delay)):a.html(o.format.replace(/%1/,n-t.val().length))}var i,c;return n=n||100,o=$.extend({container:"<span></span>",classname:"charcounter",format:"(Còn %1 ký tự)",pulse:!0,delay:0},o),this.each(function(){var a;o.container.match(/^<.+>$/)?($(this).next("."+o.classname).remove(),a=$(o.container).insertAfter(this).addClass(o.classname)):a=$(o.container),$(this).unbind(".charCounter").bind("keydown.charCounter",function(){e(this,a)}).bind("keypress.charCounter",function(){e(this,a)}).bind("keyup.charCounter",function(){e(this,a)}).bind("focus.charCounter",function(){e(this,a)}).bind("mouseover.charCounter",function(){e(this,a)}).bind("mouseout.charCounter",function(){e(this,a)}).bind("paste.charCounter",function(){var t=this;setTimeout(function(){e(t,a)},10)}),this.addEventListener&&this.addEventListener("input",function(){e(this,a)},!1),e(this,a)})},jQuery,$(function(){$(".counted").charCounter(250,{container:"#counter"})})}),$(document).mousemove(function(t){$("#pop_manga").scrollTop(),$("#pop_manga").css("left",t.pageX+20),$("#pop_manga").css("top",t.clientY+20)}),$(document).ready(function(){$("#bookmark_form").on("submit",function(t){t.preventDefault(),$("a[id=bookmark_btn]").html("Waiting..."),$(this).ajaxSubmit({target:"#bookmark_output",success:function(){"bookmark"==$("a[id=bookmark_btn]").attr("action")?($("a[id=bookmark_btn]").attr("action","unbookmark"),$("a[id=bookmark_btn]").html('<i class="fa fa-bell-slash" aria-hidden="true"></i> Hủy theo dõi</a>')):($("a[id=bookmark_btn]").attr("action","bookmark"),$("a[id=bookmark_btn]").html('<i class="fa fa-bell" aria-hidden="true"></i> Theo dõi</a>'))}})})}),$(document).ready(function(t){$("a.chance-captcha").click(function(t){$.ajax({url:siteURL+"/controllers/cont.main.php?type=captcha",type:"GET",datatype:"html",data:{},success:function(t){$("img.captcha").attr("src","/controllers/cont.main.php?type=captcha")}})})});

if (ttazPage == 'chapter') {
	$(document.documentElement).ready(function() {
		var url_next = $('ul.chapter_select option:selected').prev().val();
		var url_prev = $('ul.chapter_select option:selected').next().val();
		if (typeof(url_next) == "undefined") {
			$('ul.chapter_select').find('a.next').remove();
		} else {
			$('a.next').on('click', function(next) {
				next.preventDefault();
				window.location.replace(url_next);
			});
		}
		if (typeof(url_prev) == "undefined") {
			$('ul.chapter_select').find('a.prev').remove();
		} else {
			$('a.prev').on('click', function(prev) {
				prev.preventDefault();
				window.location.replace(url_prev);
			});
		}
	})
}