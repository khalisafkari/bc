!function(j){function a(b){clearTimeout(b),b=null}j.fn.smartSuggest=function(k){var k=j.extend({boxId:"%-suggestions",classPrefix:"ss-",timeoutLength:500,src:"",resultsText:"$ of % results",noResultsText:"No results.",showEmptyCategories:!1,fillBox:!1,fillBoxWith:"primary",executeCode:!0,showImages:!0,minChars:2},k);k.boxId=k.boxId.replace("%",j(this).attr("id"));var b="";j(this).wrap("<div class=\""+k.classPrefix+"wrap\"></div>"),j(this).attr("autocomplete","off"),j(this).after("<ul class=\""+k.classPrefix+"box\" id=\""+k.boxId+"\" style=\"display: none;\"></ul>");var l=j(this),d=j("#"+k.boxId),g=null;l.keyup(function(c){if(13!=c.keyCode&&9!=c.keyCode){var e=l.val();""==e||e.length<k.minChars?(d.fadeOut(),a(g)):(null!=g&&a(g),g=setTimeout(function(){l.addClass(k.classPrefix+"input-thinking"),b=e,j.getJSON(k.src+"?q="+e,function(a,b){if("success"==b){var c="",g=!1;j.each(a,function(c,a){0<a.data.length&&(g=!0)}),g?j.each(a,function(a,b){if(k.showEmptyCategories||!k.showEmptyCategories&&0!=b.data.length){var e=b.header.limit,f=0;c+="<li class=\""+k.classPrefix+"header\">\n",c+="<p class=\""+k.classPrefix+"header-text\">"+b.header.title+"</p>\n",c+="<p class=\""+k.classPrefix+"header-limit\">"+k.resultsText.replace("%",b.header.num).replace("$",b.header.limit<b.data.length?b.header.limit:b.data.length)+"</p>\n",c+="</li>";var g=k.fillBox?"document.getElementById('"+l.attr("id")+"').value = '%';":"";j.each(b.data,function(h,a){if(f<e){var b="<a href=\"";b+=null==a.url?"javascript: void(0);":a.url,b+="\" ",b+=null==a.onclick?"":" onclick=\""+g.replace("%",a[k.fillBoxWith])+(k.executeCode?a.onclick:"")+"\" ",b+=">",c+="<li class=\""+k.classPrefix+"result\">"+b+"\n",c+="<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" width=\"100%\" style=\"border-collapse: separate; border-spacing: 10px 5px;\"><tr>",c+=null!=a.image&&k.showImages?"<td style=\"background-image:url('"+a.image+"');width:100px;height:100%;background-size: 100px; background-position:50% 30%; margin-right:2px;\"></td>\n":"",c+="<td>",c+="<p>",c+=null==a.primary?"":"<span class=\""+k.classPrefix+"result-title\">"+a.primary+"</span><br />\n",c+=null==a.secondary?"":"<span class=\""+k.classPrefix+"result-last\">"+a.secondary+"</span>\n",c+="</p>\n",c+="</td>",c+="</tr></table>",c+="</a></li>\n"}f++})}}):(c+="<li class=\""+k.classPrefix+"header\">\n",c+="<p class=\""+k.classPrefix+"header-text\">"+k.noResultsText+"</p>\n",c+="<p class=\""+k.classPrefix+"header-limit\">0 results</p>\n",c+="</li>"),d.html(c),d.fadeIn(),l.removeClass(k.classPrefix+"input-thinking")}})},k.timeoutLength))}}),l.blur(function(){d.fadeOut()}),l.focus(function(){l.val()==b&&""!=l.val()&&d.fadeIn()})}}(jQuery);