$(document).ready(function(){function e(a){a.length>0?$.post("controllers/auto-suggest.php",{latestQuery:a},function(a){if(a.length>0){a=$.parseJSON(a),$("#artists li").remove(":contains('No results')"),$("#results").show(),previousTerms=new Array,$("#artists li").each(function(){previousTerms.push($(this).text())}),keepTerms=new Array;for(term in a)url=a[term],-1===$.inArray(term,previousTerms)?d.prepend('<li><a href="'+url+'" title="'+term+'">'+term+"</a></li>"):keepTerms.push(term);if(""==a||0==keepTerms.length&&(0!=previousTerms.length||""==b.val()))d.html("<li>Not manga found!</li>");else for(term in previousTerms)-1===$.inArray(previousTerms[term],keepTerms)&&$("#artists li").filter(function(){return $(this).text()==previousTerms[term]}).remove()}}):d.html("<li>Not manga found!</li>")}var a=$("#hidden-search"),b=$("#display-search"),c=$("#search-overlay"),d=$("#artists");$("#search").click(function(){c.show(),a.focus()}),c.click(function(b){a.focus(),"search-overlay"!=b.target.id&&"close"!=b.target.id||(a.blur(),$(this).animate({opacity:0},500,function(){$(this).hide().css("opacity",1)}))}),a.keydown(function(a){currentQuery=b.val(),8==a.keyCode?(latestQuery=currentQuery.substring(0,currentQuery.length-1),b.val(latestQuery),e(latestQuery)):(32==a.keyCode||a.keyCode>=65&&a.keyCode<=90||a.keyCode>=48&&a.keyCode<=57)&&(latestQuery=currentQuery+String.fromCharCode(a.keyCode),b.val(latestQuery),e(latestQuery))})});