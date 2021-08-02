 <? if(!$user->isLoggedIn()){ header('Location: ../index.html'); } ?>

 	<div class="col-lg-12">
 		<div class="panel panel-default">
 			<div class="panel-heading">
 				<h3 class="panel-title"><?=$lang['Manga_List']?></h3>
 			</div>
 			<div class="panel-body">
 				<?=$user->alert('danger', $lang['Delete_warning'])?>
 				<small>
 					<div class="btn-group">
 						<a href="/dang-truyen.html" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-plus"></i> <?=$lang['Add_new']?> <?=$lang['Manga']?></a>
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
 					<div class="btn-group col-lg-4 pull-right">
 						<form  method="POST" role="form">
 							<div class="form-group"> 
 								<div class="input-group">
 									<div class="input-group-btn search-panel">
 										<button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
 											<span id="search_concept">Status</span> <span class="caret"></span>
 										</button>
 										<ul class="dropdown-menu" role="menu">
 											<li><a href="#mHidden" data-type="1">Truyện ẩn</a></li>
 											<li><a href="#mShow" data-type="2">Truyện public</a></li>
 											<li><a href="#mAll" data-type="0">Tất cả</a></li>
 										</ul>
 									</div>        
 									<input type="text" id="name" name="name" class="form-control input-sm" name="x" placeholder="Search term...">
 									<input type="hidden" name="type" id="type" class="form-control" value="0">
 									<span class="input-group-btn">
 										<button id="LoadRecordsButton" type="submit" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-search"></span></button>
 									</span>
 								</div>
 							</div>
 						</form>
 					</div>
 				</small>
 				<br />
 				<div class="btn-group">
 					<div id="UserTableContainer" style="width: 100%;"></div>
 				</div>
 			</div>
 		</div>
 	</div>	
 	<script type="text/javascript">

 		$(document).ready(function () {

		    //Prepare jTable
		    $('#UserTableContainer').jtable({
		    	title: '<?=$lang['Manga_List']?>',
		    	paging: true,
		    	pageSize: 20,
		    	sorting: true,
		    	selecting: true,
		    	multiselect: true,
		    	selectingCheckboxes: true,
		    	defaultSorting: 'name ASC',
		    	actions: {
		    		listAction: '/app/manga/controllers/cont.user.mangaManagement.php?action=list'
		    	},
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
		    		deleteProggress: 'Xóa {0} của {1} chương. Đang sử lý...'
		    	},
		    	fields: {
		    		id: {
		    			key: true,
		    			create: false,
		    			edit: false,
		    			list: false
		    		},
		    		name: {
		    			title: 'Name',
		    			width: '20%',
		    			display: function(data) {
		    				if (data.record.hidden == 1) {
		    					return '<a style="font-weight:bold;color:red;text-decoration: line-through;font-size:12px;" target="_blank" href="/truyen-'+data.record.slug+'.html">'+data.record.name+'</a>';
		    				} else {
		    					return '<a style="font-weight:bold;color:green;font-size:12px;" target="_blank" href="/truyen-'+data.record.slug+'.html">'+data.record.name+'</a>';
		    				}
		    			}
		    		},
		    		last_chapter: {
		    			title: 'Chap cuối',
		    			width: '10%',
		    			sorting: false,
		    			display: function(data) {
		    				return '<a class="btn btn-xs btn-primary" href="/doc-'+data.record.slug+'-chuong-'+data.record.last_chapter+'.html" target="_blank">'+data.record.last_chapter+'</a>';
		    			}
		    		},
		    		last_update: {
		    			title: 'Đăng lúc',
		    			width: '20%'
		    		},
		    		MyButton: {
		    			title: '<?=$lang['Action']?>',
		    			width: '30%',
		    			sorting: false,
		    			display: function(data) {
		    				
		    				return '<div class="btn-group"><a href="/quan-ly/sua-truyen/'+data.record.id+'/'+data.record.slug+'.html" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-wrench"></i> <?=$lang['Edit'] ?></a><a href="/quan-ly/danh-sach-chuong/'+data.record.slug+'.html" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-list"></i> <?=$lang['Chapter_List']?></a><a href="/quan-ly/dang-chuong/'+data.record.slug+'.html" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> <?=$lang['Add_new']?> <?=$lang['Chapter']?></a></div>';
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
							url: '../app/manga/controllers/cont.mangaManagement.php?action=hidden',
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
							url: '../app/manga/controllers/cont.mangaManagement.php?action=show',
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
			//Re-load records when user click 'load records' button.
			        $('#LoadRecordsButton').click(function (e) {
				            e.preventDefault();
				            $('#UserTableContainer').jtable('load', {
					name: $('#name').val(),
					type: $('#type').val()
				            });
				$('#name').val('');
			        });
			 $('.search-panel .dropdown-menu').find('a').click(function(e) {
				e.preventDefault();
				var type = $(this).data('type');
				var text = $(this).text();
				$('.search-panel span#search_concept').text(text);
				$('.input-group #type').val(type);
			});
        //Load all records when page is first shown
        $('#LoadRecordsButton').click();
});

</script>