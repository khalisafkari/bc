 <? if(!$user->isLoggedIn()){ header('Location: ../index.html'); }
 $db->Update(APP_TABLES_PREFIX.'manga_notification', array('user'=>$_SESSION['userId']), array('see'=>'1'));
 ?>

 <div class="col-lg-12">
 	<div class="panel panel-default">
 		<div class="panel-heading">
 			<h3 class="panel-title">Danh sách thông báo</h3>
 		</div>
 		<div class="panel-body">
 		<button id="DeleteAllButton" role="button" class="btn btn-danger btn-sm pull-right"><span class="glyphicon glyphicon-trash"></span> Xóa</button>
 			<br /><br />
 			<div id="UserTableContainer" style="width: 100%;"></div>
 		</div>
 	</div>
 </div>	
 <script type="text/javascript">

 	$(document).ready(function () {

		    //Prepare jTable
		    $('#UserTableContainer').jtable({
		    	title: 'Danh sách thông báo',
		    	paging: true,
		    	pageSize: 20,
		    	sorting: true,
		    	selecting: true,
		    	multiselect: true,
		    	selectingCheckboxes: true,
		    	defaultSorting: 'time DESC',
		    	actions: {
		    		listAction: '/app/manga/controllers/cont.user.noti.php?action=list',
		    		deleteAction: '/app/manga/controllers/cont.user.noti.php?action=delete'
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
		    			width: '30%',
		    			sorting: false,
		    			display: function(data) {
		    				if (data.record.type == 4) {
		    					return 'Truyện (Chap) bị loạt từ chối';
		    				} else if (data.record.type == 3.5) {
		    					return '<a style="font-weight:bold;color:green;font-size:12px;" target="_blank" href="'+data.record.url+'">'+data.record.name+'</a>';
		    				} else {
		    					return '<a style="font-weight:bold;color:green;font-size:12px;" target="_blank" href="'+data.record.url+'">'+data.record.name+' chap '+data.record.chapter+'</a>';
		    				}
		    				
		    			}
		    		},
		    		content: {
		    			title: 'Nội dung',
		    			width: '40%',
		    			sorting: false
		    		},
		    		time: {
		    			title: 'Báo lúc',
		    			width: '10%',
		    			display: function(data) {
		    				return '<i><time>'+data.record.time+'</time></i>';
		    			}
		    		},
		    		MyButton: {
		    			title: '<?=$lang['Action']?>',
		    			width: '10%',
		    			sorting: false,
		    			display: function(data) {
		    				if (data.record.type == 1) {
		    					return '<div class="btn-group"><a href="sua-chuong/'+data.record.cid+'/'+data.record.slug+'.html" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-wrench"></i> <?=$lang['Edit']?></a></div>';
		    				} else if (data.record.type == 2 || data.record.type == 3 || data.record.type == 3.5) {
		    					return '<div class="btn-group"><a href="'+data.record.url+'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-arrow-right"></i> <?=$lang['Go']?></a></div>';
		    				}
		    				
		    			}
		    		},
		    	}
		    });

			//Load person list from server
			$('#UserTableContainer').jtable('load');
			//Delete selected students
			    $('#DeleteAllButton').button().click(function () {
				            var $selectedRows = $('#UserTableContainer').jtable('selectedRows');
				if ($selectedRows.length <= 0) {
					alert('Bạn chưa chọn bất kì một trường nào!');
				} else {
					$('#UserTableContainer').jtable('deleteRows', $selectedRows);
				}
				            
			        });
		});

	</script>