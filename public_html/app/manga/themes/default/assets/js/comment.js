function load_Comment(t)
{
	return $(".list-comment").load(siteURL+"/app/manga/controllers/cont.listComment.php?act=list_comment&manga="+t)
}
var showEditor=function(t)
{
	tinymce.init(
	{
		language:"vi_VN",selector:t,entity_encoding:"raw",paste_as_text:!0,oninit:t,theme:"modern",skin:"lightgray",menubar:!1,plugins:["image","emobabysoldier, emoonion, emobafu, emothobua, emothotuzki, emoyoyo, emopanda, emotrollface","textcolor paste"],paste_as_text:!0,toolbar:"bold | underline | italic | image | imagetools | emoonion | emobafu | emothobua | emothotuzki | emoyoyo | emopanda | emotrollface | emobabysoldier",image_advtab:!0,setup:function(t)
		{
			t.on("change",function(t)
			{
				tinyMCE.triggerSave()
			}
			)
		}
		,paste_auto_cleanup_on_paste:!0,force_br_newlines:!0,force_p_newlines:!1,save_onsavecallback:"onSavePluginCallback"
	}
	),$(document).on("focusin",function(t)
	{
		$(t.target).closest(".mce-window").length&&t.stopImmediatePropagation()
	}
	)
};
$(document).ready(function()
{
	function t()
	{
		$("#comment-modal #cmID").val(""),$("#comment-modal #txtEditText").val(""),tinymce.activeEditor.setContent("")
	}
		showEditor("#txtcomment");
	var e='<img src="'+siteURL+'/app/manga/themes/default/assets/images/loading.gif" style="width:100%">',o=$("#formComment :hidden[name='manga']").val();
	$("#cancel").click(function()
	{
		$("#comment").val(""),tinymce.activeEditor.setContent("")
	}
	),$("#formComment").on("submit",function(t)
	{
		t.preventDefault();
		if (userId) {
			var n=$("#txtcomment").val(),a=siteURL+"/app/manga/controllers/cont.Comment.php?act=add_comment";
		""==n?alert("Bạn cần nhập nội dung bình luận"):$.ajax(
		{
			url:a,type:"POST",dataType:"html",data:
			{
				content:n,manga:o,c_id:"0"
			}
			,beforeSend:function()
			{
				$("#loading").prepend(e)
			}
			,success:function(t)
			{
				$(".list-comment").prepend(t),$("#txtcomment").val(""),tinymce.activeEditor.setContent(""),$("#loading").find("img").remove(),$("html, body").animate(
				{
					scrollTop:$("#loading").offset().top
				}
				,1e3)
			}
		});
		} else {
			alert('Bạn cần đăng nhập hoặc đăng kí để có thể bình luận');
		}
		
	}
	),$("#commentbox").on("click",".cm-reply",function()
	{
		$(this).removeClass("cm-reply").addClass("cm-reply-cancel");
		var t=$(this).data("id"),e=$("#reply"+t);
		if("none"==e.css("display"))e.show();
		else
		{
			var o='<div class="row replyComment" id="reply'+t+'"><div class="col-md-2 col-sm-2 hidden-xs"></div><div class="col-md-10 col-sm-10">        <form method="post" name="formReplyComment" id="formReplyComment" role="form" data-id="'+t+'">        <div class="form-group">        <label>Trả lời bình luận</label>        <input type="hidden" name="txtReplyOfID" data-id="'+t+'" value="'+t+'" id="txtReplyOfID'+t+'" />        <textarea class="form-control" rows="3" name="txtText" id="txtText'+t+'"></textarea>        </div>        <p class="text-right" id="cmfooter">        <div class="col-sm-8" id="reply-loading"></div>        <button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-send"></i> Đăng</button>        <button type="reset" class="btn btn-default btn-sm btn-huy" data-id="'+t+'"> Hủy</button>        </p>        </form></div></div>';
			$("#comment_"+t).after(o),showEditor("#txtText"+t)
		}
		$("html, body").animate(
		{
			scrollTop:$("#reply"+t).offset().top
		}
		,1e3)
	}
	),$("#commentbox").on("submit","#formReplyComment",function(t)
	{
		t.preventDefault();
		var n=$(this).data("id"),a=$(".user"+n).data("id"),m=$("#txtText"+n).val(),i=siteURL+"/app/manga/controllers/cont.Comment.php?act=add_comment";
		""==m?alert("Bạn cần nhập nội dung để comment!"):$.ajax(
		{
			type:"POST",dataType:"html",url:i,data:
			{
				manga:o,content:m,c_id:n,user:a
			}
			,beforeSend:function()
			{
				$("#reply-loading").prepend(e)
			}
			,success:function(t)
			{
				$("#comment_"+n).after(t),$("#txtText"+n).val(""),tinymce.activeEditor.setContent(""),$("#reply-loading").find("img").remove(),$("html, body").animate(
				{
					scrollTop:$("#comment_"+n).offset().top
				}
				,1e3)
			}
		}
		)
	}
	),$("#commentbox").on("click",".replyComment .btn-huy, .cm-reply-cancel",function()
	{
		var t=$(this).data("id");
		$("#comment_"+t).find(".cm-reply-cancel").removeClass("cm-reply-cancel").addClass("cm-reply"),$("#reply"+t).hide()
	}
	),$("#commentbox").on("click",".cm-delete",function(t)
	{
		if(confirm("Bạn có chắc chắn muốn xóa bình luận này không?"))
		{
			var e=$(this).data("id"),n=siteURL+"/app/manga/controllers/cont.Comment.php?act=delete_comment";
			$.ajax(
			{
				type:"post",url:n,data:
				{
					id:e,manga:o
				}
				,success:function(t)
				{
					$(".list-comment").load(siteURL+"/app/manga/controllers/cont.listComment.php?act=list_comment&manga="+o),$("html, body").animate(
					{
						scrollTop:$("#comment_"+e).offset().top
					}
					,1e3)
				}
				,error:function(t,e,o)
				{
					console.log("Có lỗi xảy ra!")
				}
			}
			)
		}
	}
	);
	var n='<div class="modal fade" id="comment-modal" tabindex="-1" role="dialog" aria-labelledby="myModalComment"><div class="modal-dialog" role="document"><div class="modal-content">  <div class="modal-header">  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="myModalComment">Sửa bình luận</h4>  </div>  <div class="modal-body">  <form name="frmEditComment" id="frmEditComment" method="post">  <div class="comment-post">  <p>  <input type="hidden" name="id" id="cmID"/>  <textarea class="form-control" rows="3" name="txtEditText" id="txtEditText"></textarea>  </p>  </div>  <p class="text-right"><button type="submit" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-send"></i> Sửa</button></p>  </form>  </div>  </div>  </div>  </div>';
	$("#commentbox").on("click",".cm-edit",function()
	{
		$("#frmEditComment").length||($("body").append(n),n="",$("#comment-modal").on("shown.bs.modal",function()
		{
			$("#comment-modal #txtEditText").focus()
		}
		),$("#comment-modal").on("hidden.bs.modal",function()
		{
			t()
		}
		)),$("#comment-modal").modal("show");
		var o=$(this).data("id"),a=siteURL+"/app/manga/controllers/cont.Comment.php?act=show_content";
		$.ajax(
		{
			type:"POST",url:a,data:
			{
				id:o
			}
			,beforeSend:function()
			{
				$("#loading").append(e)
			}
			,success:function(t)
			{
				$("#comment-modal #cmID").val(o),$("#comment-modal #txtEditText").val(t),showEditor("#frmEditComment #txtEditText"),tinymce.activeEditor.setContent(t),$("#loading").find("img").remove()
			}
		}
		)
	}
	),$("body").on("submit","#frmEditComment",function(e)
	{
		e.preventDefault();
		var o=$("#cmID").val();
		tinymce.triggerSave();
		var n=siteURL+"/app/manga/controllers/cont.Comment.php?act=edit_comment";
		$.ajax(
		{
			type:"POST",url:n,data:$("#frmEditComment").serialize(),success:function(e)
			{
				$("#comment-modal").modal("hide"),$("#comment_"+o).replaceWith(e).fadeOut(100).fadeIn(100),t()
			}
		}
		)
	}
	)
}
);
