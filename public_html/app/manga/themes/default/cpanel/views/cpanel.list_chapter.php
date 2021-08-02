 <?
 if(!$user->isLoggedIn()){ header('Location: ../index.html'); }

 $_GET['manga'] = str_replace(array('\'', '\"'), '', $_GET['manga']);

 $thisGroup = $db->Query(APP_TABLES_PREFIX.'user','group_uploader',array('id'=>$_SESSION['userId']));

 $check_user_group = mysqli_fetch_assoc(mysqli_query($db->Connect(), "SELECT id FROM ".APP_TABLES_PREFIX."manga_mangas WHERE slug = '".$_GET[manga]."' AND group_uploader = ".$thisGroup[0]['group_uploader']." AND group_uploader != 0"));

 $check_submitter = $huy->isExist(APP_TABLES_PREFIX.'manga_mangas', 'id', array('slug'=>$_GET['manga'], 'submitter'=>$_SESSION['userId']));

 if (!$check_submitter && !count($check_user_group)) {
 	header('Location: /index.html');
 }

 ?>
 <style type="text/css">
 	.modal-output {
 		max-height: 250px;
 		overflow-y: scroll;
 		max-width: 100%;
 	}
 	.list-img {
 		max-width: 100%;
 		padding: 5px;
 	}
 	.modal-content {
 		background: #2c3e50;
 		color: #fff;
 		
 	}
 </style>
 <div class="col-lg-12">
 	<div class="panel panel-default">
 		<div class="panel-heading">
 			<h3 class="panel-title"><b>Danh sách Chapter truyện <?=$_GET['manga']?></b></h3>
 		</div>
 		<div class="panel-body">
 			<?=$user->alert('danger', $lang['Delete_chapter_warning'])?>
 			<p>
 				<div class="btn-group">
 					<a href="/quan-ly/dang-chuong/<?=$_GET['manga']?>.html" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-plus"></i> <?=$lang['Add_new']?> <?=$lang['Chapter']?></a>
 				</div>
 				<div class="btn-group">
 					<button id="dropdownMenu1" type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
 						<i class="glyphicon glyphicon-adjust"></i> Ẩn / Hiện
 						<span class="caret"></span>
 					</button>
 					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
 						<li><a id="HiddenAllButton"> Ẩn</a></li>
 						<li><a id="ShowAllButton"> Hiện</a></li>
 					</ul>
 				</div>
 				<br /><br />
 			</p>
 			<div class="modal fade" id="modal-preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
 				<div class="modal-dialog" role="document">
 					<div class="modal-content">
 						<div class="modal-header">
 							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
 							<h4 class="modal-title">Nội dung xem trước!</h4>
 						</div>
 						<div class="modal-body modal-output">

 						</div>
 						<div class="modal-footer">
 							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
 						</div>
 					</div>
 				</div>
 			</div>
 			<div id="UserTableContainer" style="width: 100%;"></div>
 		</div>
 	</div>
 </div>	
 <script type="text/javascript">

 	$(document).ready(function () {

		    //Prepare jTable
		    $('#UserTableContainer').jtable({
		    	title: 'Danh sách chương',
		    	paging: true,
		    	pageSize: 20,
		    	sorting: true,
		    	selecting: true,
		    	multiselect: true,
		    	selectingCheckboxes: true,
		    	defaultSorting: 'chapter ASC',
		    	actions: {
		    		listAction: '/app/manga/controllers/cont.user.chapterManagement.php?action=list&manga=<?=$_GET['manga']?>'
		    	},
		    	sorting: true,
		    	messages: {
		    		serverCommunicationError: 'Có lỗi xảy ra trong khi kết nối với máy chủ cơ sơ dữ liệu.',
		    		loadingMessage: 'Đang tải chương...',
		    		noDataAvailable: 'Không có dữ liệu!',
		    		addNewRecord: 'Thêm thành viên mới',
		    		editRecord: 'Chỉnh sửa thành viên',
		    		areYouSure: 'Bạn có chắc chắn không?',
		    		deleteConfirmation: 'Chương này sẽ bị xóa. Bạn có chắc chắn không?',
		    		save: 'Lưu',
		    		saving: 'Đang lưu',
		    		cancel: 'Hủy bỏ',
		    		deleteText: 'Xóa',
		    		deleting: 'Đang xóa',
		    		error: 'Lỗi',
		    		close: 'Đóng',
		    		cannotLoadOptionsFor: 'Không thể tải các tùy chọn cho các lĩnh vực {0}',
		    		pagingInfo: 'Thấy {0}-{1} của {2}',
		    		pageSizeChangeLabel: 'Tổng số hàng',
		    		gotoPageLabel: 'Đi đến trang',
		    		canNotDeletedRecords: 'Không thể xóa {0} của {1} chương!',
		    		deleteProggress: 'Xóa {0} của {1} chương, đang sử lý...'
		    	},
		    	fields: {
		    		id: {
		    			key: true,
		    			create: false,
		    			edit: false,
		    			list: false
		    		},
		    		chapter: {
		    			title: 'Chương',
		    			width: '20%',
		    			display: function(data) {
		    				if (data.record.hidden == 1) {
		    					return '<a style="text-decoration: line-through;background-color:red;border-color:red" class="btn btn-xs btn-primary" href="/doc-'+data.record.manga+'-chuong-'+data.record.chapter+'.html" target="_blank">'+data.record.chapter+'</a>';
		    				} else {
		    					return '<a class="btn btn-xs btn-primary" href="/doc-'+data.record.manga+'-chuong-'+data.record.chapter+'.html" target="_blank">'+data.record.chapter+'</a>';
		    				}
		    				
		    			}
		    		},
		    		name: {
		    			title: 'Tên chương',
		    			width: '20%'
		    		},
		    		MyButton: {
		    			title: '<?=$lang['Action']?>',
		    			width: '30%',
		    			sorting: false,
		    			display: function(data) {
		    				return '<div class="btn-group"><a href="/quan-ly/sua-chuong/'+data.record.id+'/<?=$_GET['manga']?>.html" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-wrench"></i> EDIT</a><a id="preview" data-id="'+data.record.id+'" onclick="load_img('+data.record.id+')" class="preview btn btn-danger btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Xem trước</a></div>';
		    			}
		    		},
		    	}
		    });
			//Load person list from server
			$('#UserTableContainer').jtable('load');
			$('#HiddenAllButton').click(function () {
				var $selectedRows1 = $('#UserTableContainer').jtable('selectedRows');
				if ($selectedRows1.length <= 0) {
					alert('Bạn chưa chọn bất kì một trường nào!');
				} else {
					for (var i = 0; i < $selectedRows1.length; i ++) {
						id = $selectedRows1[i].dataset.recordKey;
						$.ajax({
							url: siteURL+'/app/manga/controllers/cont.chapterManagement.php?action=hidden',
							type: 'POST',
							dataType: 'json',
							data: {
								id: id
							}, success: function(data) {
							}
						})
					}
					$('#UserTableContainer').jtable('load');
				}
			});
			$('#ShowAllButton').click(function () {
				var $selectedRows1 = $('#UserTableContainer').jtable('selectedRows');
				if ($selectedRows1.length <= 0) {
					alert('Bạn chưa chọn bất kì một trường nào!');
				} else {
					for (var i = 0; i < $selectedRows1.length; i ++) {
						id = $selectedRows1[i].dataset.recordKey;
						$.ajax({
							url: siteURL+'/app/manga/controllers/cont.chapterManagement.php?action=show',
							type: 'POST',
							dataType: 'json',
							data: {
								id: id
							}, success: function(data) {
								
							}
						})
					}
					$('#UserTableContainer').jtable('load');
				}
			});

		});
 function load_img(cid) {
 	$url = siteURL +'/app/manga/controllers/cont.chapterPreview.php?type=chapter'
 	$.ajax({
 		type: 'POST',
 		dataType: 'html',
 		url: $url,
 		data: {
 			id: cid
 		}, success: function(data) {
 			$('#modal-preview').modal('show');
 			$('.modal-output').html(data);
 		}
 	});
 }
</script>