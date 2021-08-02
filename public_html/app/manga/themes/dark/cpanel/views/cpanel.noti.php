 <? if(!$user->isLoggedIn()){ header('Location: ../index.html'); }
 $db->Update(APP_TABLES_PREFIX.'manga_notification', array('user'=>$_SESSION['userId']), array('see'=>'1'));
 ?>

 <div class="col-lg-12">
 	<div class="panel panel-default">
 		<div class="panel-heading">
 			<h3 class="panel-title">Notification(s)</h3>
 		</div>
 		<div class="panel-body">
 		<button id="DeleteAllButton" role="button" class="btn btn-danger btn-sm pull-right"><span class="glyphicon glyphicon-trash"></span> Delete</button>
 			<br /><br />
 			<div id="UserTableContainer" style="width: 100%;"></div>
 		</div>
 	</div>
 </div>	
 <script type="text/javascript">

 	$(document).ready(function () {

		    //Prepare jTable
		    $('#UserTableContainer').jtable({
		    	title: 'Notification(s)',
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
		    		name: {
		    			title: 'Name',
		    			width: '30%',
		    			sorting: false,
		    			display: function(data) {
		    				if (data.record.type == 4) {
		    					return 'Manga (Chapter) was rejected';
		    				} else if (data.record.type == 3.5) {
		    					return '<a style="font-weight:bold;color:green;font-size:12px;" target="_blank" href="'+data.record.url+'">'+data.record.name+'</a>';
		    				} else {
		    					return '<a style="font-weight:bold;color:green;font-size:12px;" target="_blank" href="'+data.record.url+'">'+data.record.name+' chap '+data.record.chapter+'</a>';
		    				}
		    				
		    			}
		    		},
		    		content: {
		    			title: 'Content',
		    			width: '40%',
		    			sorting: false
		    		},
		    		time: {
		    			title: 'Notice Time',
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
		    					return '<div class="btn-group"><a href="edit-chapter/'+data.record.cid+'/'+data.record.slug+'.html" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-wrench"></i> <?=$lang['Edit']?></a></div>';
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
					alert('Select at least one option!');
				} else {
					$('#UserTableContainer').jtable('deleteRows', $selectedRows);
				}
				            
			        });
		});

	</script>