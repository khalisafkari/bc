 <?php if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } ?>

 <div class="col-lg-8">
	 <div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?php echo 'Magazine Management'; ?></h3>
	  </div>
	  <div class="panel-body">
	  <p>
	  <div class="btn-group">
	  	<a href="app=mangaview=add-magazine" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-plus"></i>Add Magazine</a>
	  </div>
	  </p>
	   	<div id="UserTableContainer" style="width: 100%;"></div>
	  </div>
	</div>
 </div>	
 <script type="text/javascript">

		$(document).ready(function () {

		    //Prepare jTable
			$('#UserTableContainer').jtable({
				title: 'Magazine Management',
				paging: true,
				pageSize: 20,
				sorting: true,
				defaultSorting: 'name ASC',
				actions: {
					listAction: '../app/manga/controllers/cont.magazineManagement.php?action=list',
					deleteAction: '../app/manga/controllers/cont.magazineManagement.php?action=delete'
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
						list: false,
					},
					name: {
						create: false,
						edit: false,
						list: true,
						title: 'Name',
						width: '20%',
					},
					slug: {
						title: 'Link',
						width: '20%',
					},
					content: {
						title: 'Description',
						width: '40%',
					},
					MyButton: {
               			title: '<?=$lang['Action']?>',
               			create: false,
               			width: '20%',
               			sorting: false,
                		display: function(data) {
                     	
                     	return '<div class="btn-group"><a href="app=mangaview=edit-magazine&id='+data.record.id+'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-wrench"></i> <?=$lang['Edit'] ?></a></div>';
                 }
           			},
				}
			});

			//Load person list from server
			$('#UserTableContainer').jtable('load');

		});

	</script>