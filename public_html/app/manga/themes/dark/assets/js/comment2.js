function load_Comment(t)
{
	$.get(
		siteURL+"/app/manga/controllers/cont.listComment.php", 
		{
			act: 'list_comment',
			page: 1,
			manga: t
		}).done(function(a) {
			data = JSON.parse(a);
			ListCommentProcess(data, '#cmt-manga');
		});
	}
	function load_Comment_Chapter_Only_View(t)
	{
		$.get(
			siteURL+"/app/manga/controllers/cont.listComment.php", 
			{
				act: 'list_comment_chapter_only_view',
				page: 1,
				manga: t
			}).done(function(a) {
				data = JSON.parse(a);
				ListCommentProcess(data, '#cmt-chapter');
			});
		}
		function load_Comment_Chapter(t, c)
		{
			$.get(
				siteURL+"/app/manga/controllers/cont.listComment.php", 
				{
					act: 'list_comment_chapter',
					page: 1,
					manga: t,
					chapter: c
				}).done(function(a) {
					data = JSON.parse(a);
					ListCommentProcess(data, '#cmt-chapters');
				});
			}

			function ListCommentProcess(data, id) {
				$(id+" .pagination").replaceWith(data.page_list);
				$(id+">.rows-cmt").html(data.comment_list);
			}
			$(document).ready(function() {
				$("#cmt-chapter").on("click", ".pagination li a", function (a) {
					a.preventDefault();
					var b = $(this),
					manga = $('input[name=manga]').val();
					title = $(this).attr("title");

					b.css({ cursor: "default", "pointer-events": "none", opacity: "0.6" });
					var page = title.match(/Page (\d+)/);
					console.log(page);
					$.get(siteURL+"/app/manga/controllers/cont.listComment.php",{
						act: 'list_comment_chapter_only_view',
						page: page[1],
						manga: manga
					}).done(function (a) {
						data = JSON.parse(a);
						ListCommentProcess(data, '#cmt-chapter');
						b.css({ cursor: "pointer", "pointer-events": "auto", opacity: "1" });
						$("html, body").animate({ scrollTop: $("#commentbox").offset().top }, "slow");
					});
				});

				$("#cmt-chapters").on("click", ".pagination li a", function (a) {
					a.preventDefault();
					var b = $(this),
					manga = $('input[name=manga]').val(),
					chapter = $('input[name=cm_chapter]').val(),
					title = $(this).attr("title");

					b.css({ cursor: "default", "pointer-events": "none", opacity: "0.6" });
					var page = title.match(/Page (\d+)/);
					console.log(chapter);
					$.get(siteURL+"/app/manga/controllers/cont.listComment.php",{
						act: 'list_comment_chapter',
						page: page[1],
						manga: manga,
						chapter: chapter
					}).done(function (a) {
						data = JSON.parse(a);
						ListCommentProcess(data, '#cmt-chapters');
						b.css({ cursor: "pointer", "pointer-events": "auto", opacity: "1" });
						$("html, body").animate({ scrollTop: $("#commentbox").offset().top }, "slow");
					});
				});

				$("#cmt-manga").on("click", ".pagination li a", function (a) {
					a.preventDefault();
					var b = $(this),
					manga = $('input[name=manga]').val();
					title = $(this).attr("title");

					b.css({ cursor: "default", "pointer-events": "none", opacity: "0.6" });
					var page = title.match(/Page (\d+)/);
					console.log(page);
					$.get(siteURL+"/app/manga/controllers/cont.listComment.php",{
						act: 'list_comment',
						page: page[1],
						manga: manga
					}).done(function (a) {
						data = JSON.parse(a);
						ListCommentProcess(data, '#cmt-manga');
						b.css({ cursor: "pointer", "pointer-events": "auto", opacity: "1" });
						$("html, body").animate({ scrollTop: $("#commentbox").offset().top }, "slow");
					});
				});
			});

			var showEditor=function(t)
			{
				tinymce.init(
				{
					language:"vi_VN",selector:t,entity_encoding:"raw",paste_as_text:!0,oninit:t,theme:"modern",content_css:"/app/manga/themes/dark/assets/js/tinymce/skins/lightgray/content.min.css",menubar:!1,plugins:["image","emobabysoldier, emoonion, emobafu, emothobua, emothotuzki, emoyoyo, emopanda","textcolor paste"],paste_as_text:!0,toolbar:"bold | underline | italic | image | imagetools | emoonion | emobafu | emothobua | emothotuzki | emoyoyo | emopanda | emotrollface | emobabysoldier",image_advtab:!0,setup:function(t)
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
				var e='<img src="'+siteURL+'/app/manga/themes/default/assets/images/loading.gif" style="width:100%">',o=$("#formComment :hidden[name='manga']").val(),chapter_id=$("#formComment :hidden[name='chapter_id']").val(),chapter=$("#formComment :hidden[name='cm_chapter']").val();
				$("#cancel").click(function()
				{
					$("#comment").val(""),tinymce.activeEditor.setContent("")
				}
				),$("#formComment").on("submit",function(t)
				{
					t.preventDefault();
					if (userId) {
						var n=$("#txtcomment").val(),a=siteURL+"/app/manga/controllers/cont.Comment.php?act=add_comment";
						""==n?alert("You need login to comment"):$.ajax(
						{
							url:a,type:"POST",dataType:"html",data:
							{
								content:n,manga:o,c_id:"0",chapter:chapter,chapter_id:chapter_id
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
						alert('You need login to comment');
					}

				}
				),$("#commentbox").on("click",".cm-reply",function()
				{
					$(this).removeClass("cm-reply").addClass("cm-reply-cancel");
					var t=$(this).data("id"),e=$("#reply"+t);
					if("none"==e.css("display"))e.show();
					else
					{
						var o='<div class="row replyComment" id="reply'+t+'"><div class="col-md-2 col-sm-2 hidden-xs"></div><div class="col-md-10 col-sm-10">        <form method="post" name="formReplyComment" id="formReplyComment" role="form" data-id="'+t+'">        <div class="form-group">        <label>Reply this comment</label>        <input type="hidden" name="txtReplyOfID" data-id="'+t+'" value="'+t+'" id="txtReplyOfID'+t+'" />        <textarea class="form-control" rows="3" name="txtText" id="txtText'+t+'"></textarea>        </div>        <p class="text-right" id="cmfooter">        <div class="col-sm-8" id="reply-loading"></div>        <button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-send"></i> Post</button>        <button type="reset" class="btn btn-default btn-sm btn-huy" data-id="'+t+'"> Cancel</button>        </p>        </form></div></div>';
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
					""==m?alert("You need to enter content to comment!"):$.ajax(
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
					if(confirm("Are you sure you want to delete comments?"))
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
								console.log("An error occurred!")
							}
						}
						)
					}
				}
				);
				var n='<div class="modal fade" id="comment-modal" tabindex="-1" role="dialog" aria-labelledby="myModalComment"><div class="modal-dialog" role="document"><div class="modal-content">  <div class="modal-header">  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title" id="myModalComment">Edit comment</h4>  </div>  <div class="modal-body">  <form name="frmEditComment" id="frmEditComment" method="post">  <div class="comment-post">  <p>  <input type="hidden" name="id" id="cmID"/>  <textarea class="form-control" rows="3" name="txtEditText" id="txtEditText"></textarea>  </p>  </div>  <p class="text-right"><button type="submit" class="btn btn-default btn-sm"><i class="glyphicon glyphicon-send"></i> Edit</button></p>  </form>  </div>  </div>  </div>  </div>';
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
