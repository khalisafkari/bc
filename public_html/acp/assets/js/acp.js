!function ($) {
	$(function(){
		$('#Image-Maps_6201310270647366').tooltip({
			selector: "[data-toggle=tooltip]",
			container: "#Image-Maps_6201310270647366"
		})
	});
}(window.jQuery)	

tinymce.init({
	selector: 'textarea.tiny',
	language : 'en_GB',
	entity_encoding: "raw",
	oninit: "setPlainText",
	height: 300,
	theme: 'modern',
	menubar: false,
	plugins: [
	'advlist autolink lists link image charmap print preview hr anchor pagebreak',
	'searchreplace wordcount visualblocks visualchars code fullscreen',
	"emoyahoo, emobabysoldier, emoonion, media, emobafu, emothobua, emothotuzki, emoyoyo, emopanda, emotrollface",
	'insertdatetime media nonbreaking save table contextmenu directionality',
	'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
	],
	toolbar1: 'undo redo | insert styleselect | bold italic | alignleft aligncenter | alignright alignjustify | bullist numlist | link image',
	toolbar2: 'preview media | forecolor backcolor | emoonion emobafu | emothobua emothotuzki | emoyoyo emopanda | emotrollface emobabysoldier | emoyahoo',
	image_advtab: true,
	setup: function (ed) {
		ed.on('change', function (e) {
			tinyMCE.triggerSave();
			$('textarea#description').valid();  
		});
	},
	paste_auto_cleanup_on_paste: true,
	force_br_newlines: true,
	force_p_newlines: false,
	save_onsavecallback: 'onSavePluginCallback',
});

function thetime(){
	if (!document.all&&!document.getElementById)
		return
	thelement=document.getElementById? document.getElementById("tickticktick"): document.all.tick2
	var Digital=new Date()
	var hours=Digital.getHours()
	var minutes=Digital.getMinutes()
	var seconds=Digital.getSeconds()
	var dn="PM"
	if (hours<12)
		dn="AM"
	if (hours>12)
		hours=hours-12
	if (hours==0)
		hours=12
	if (minutes<=9)
		minutes="0"+minutes
	if (seconds<=9)
		seconds="0"+seconds
	var ctime=hours+":"+minutes+":"+seconds+" "+dn
	thelement.innerHTML=""+ctime+""
	setTimeout("thetime()",1000)
}
window.onload=thetime