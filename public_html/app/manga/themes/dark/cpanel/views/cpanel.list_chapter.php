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
 			<h3 class="panel-title"><b>List Chapter <?=$_GET['manga']?></b></h3>
 		</div>
 		<div class="panel-body">
 			<?=$user->alert('danger', $lang['Delete_chapter_warning'])?>
 			<p>
 				<div class="btn-group">
 					<a href="/manage/upload-chapter/<?=$_GET['manga']?>.html" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-plus"></i> <?=$lang['Add_new']?> <?=$lang['Chapter']?></a>
 				</div>
 				<div class="btn-group">
 					<button id="dropdownMenu1" type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
 						<i class="glyphicon glyphicon-adjust"></i> Hide / Show
 						<span class="caret"></span>
 					</button>
 					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
 						<li><a id="HiddenAllButton"> Hide</a></li>
 						<li><a id="ShowAllButton"> Show</a></li>
 					</ul>
 				</div>
 				<br /><br />
 			</p>
 			<div class="modal fade" id="modal-preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
 				<div class="modal-dialog" role="document">
 					<div class="modal-content">
 						<div class="modal-header">
 							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
 							<h4 class="modal-title">Preview!</h4>
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
		    	title: 'List Chapter',
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
		    		serverCommunicationError: 'An error occurred while connecting to the database',
		    		loadingMessage: 'Loading...',
		    		noDataAvailable: 'No data!',
		    		addNewRecord: 'Add the new members',
		    		editRecord: 'Edit members',
		    		areYouSure: 'Are you sure?',
		    		deleteConfirmation: 'Delete this chapter. Are you sure?',
		    		save: 'Save',
		    		saving: 'Saving',
		    		cancel: 'Cancel',
		    		deleteText: 'Delete',
		    		deleting: 'Deleting',
		    		error: 'Error',
		    		close: 'Close',
		    		cannotLoadOptionsFor: 'Cannot load options for {0}',
		    		pagingInfo: 'Page {0}-{1} of {2}',
		    		pageSizeChangeLabel: 'The number of rows',
		    		gotoPageLabel: 'Go to page',
		    		canNotDeletedRecords: 'Cannot delete {0} of {1} chapter!',
		    		deleteProggress: 'Delete {0} of {1} chapter. Processing...'
		    	},
		    	fields: {
		    		id: {
		    			key: true,
		    			create: false,
		    			edit: false,
		    			list: false
		    		},
		    		chapter: {
		    			title: 'Chapter',
		    			width: '20%',
		    			display: function(data) {
		    				if (data.record.hidden == 1) {
		    					return '<a style="text-decoration: line-through;background-color:red;border-color:red" class="btn btn-xs btn-primary" href="/'+data.record.mid+'/'+data.record.id+'/" target="_blank">'+data.record.chapter+'</a>';
		    				} else {
		    					return '<a class="btn btn-xs btn-primary" href="/'+data.record.mid+'/'+data.record.id+'/" target="_blank">'+data.record.chapter+'</a>';
		    				}
		    				
		    			}
		    		},
		    		name: {
		    			title: 'Name of chapter',
		    			width: '20%'
		    		},
		    		MyButton: {
		    			title: '<?=$lang['Action']?>',
		    			width: '30%',
		    			sorting: false,
		    			display: function(data) {
		    				return '<div class="btn-group"><a href="/manage/edit-chapter/'+data.record.id+'/<?=$_GET['manga']?>.html" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-wrench"></i> EDIT</a><a id="preview" data-id="'+data.record.id+'" onclick="load_img('+data.record.id+')" class="preview btn btn-danger btn-xs"><i class="glyphicon glyphicon-eye-open"></i> Preview</a></div>';
		    			}
		    		},
		    	}
		    });
			//Load person list from server
			$('#UserTableContainer').jtable('load');
			$('#HiddenAllButton').click(function () {
				var $selectedRows1 = $('#UserTableContainer').jtable('selectedRows');
				if ($selectedRows1.length <= 0) {
					alert('Select at least one option!');
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
					alert('Select at least one option!');
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