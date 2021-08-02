 <? if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } ?>

 <div class="col-lg-8">
 	<div class="panel panel-default">
 		<div class="panel-heading">
 			<h3 class="panel-title"><?=$lang['Manga_q_List']?></h3>
 		</div>
 		<div class="panel-body">
 			<div class="btn-group">
 				<a href="#" id="DeleteAllButton" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i> Delete</a>
 			</div>
 			<br /><br />
 			<div id="UserTableContainer" style="width: 100%;"></div>
 		</div>
 	</div>
 </div>	
 <script type="text/javascript">

 	$(document).ready(function () {

		    //Prepare jTable
		    $('#UserTableContainer').jtable({
		    	title: 'List of manga waiting for approval',
		    	paging: true,
		    	pageSize: 20,
		    	sorting: true,
		    	selecting: true,
		    	multiselect: true,
		    	selectingCheckboxes: true,
		    	defaultSorting: 'name ASC',
		    	actions: {
		    		listAction: '../app/manga/controllers/cont.mangaqManagement.php?action=list',
		    		deleteAction: '../app/manga/controllers/cont.mangaqManagement.php?action=delete'
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
		    		slug: {
		    			create: false,
		    			edit: false,
		    			list: false
		    		},
		    		name: {
		    			title: 'Name',
		    			width: '20%'
		    		},
		    		MyButton: {
		    			title: '<?=$lang['Action']?>',
		    			width: '30%',
		    			sorting: false,
		    			display: function(data) {
		    				return '<a href="app=mangaview=edit-mangaQ&mid='+data.record.id+'" class="btn btn-sm btn-success"><i class="glyphicon glyphicon-eye-open"></i> <?=$lang['Edit-accept']?></a>';
		    			}
		    		},
		    	}
		    });

			//Load person list from server
			$('#UserTableContainer').jtable('load');
//Delete selected mangas

    $('#DeleteAllButton').button().click(function () {
	var $selectedRows1 = $('#UserTableContainer').jtable('selectedRows');
	if ($selectedRows1.length <= 0) {
		alert('Select at least one option!');
	} else {
		$('#UserTableContainer').jtable('deleteRows', $selectedRows1);
	}
});
});

</script>