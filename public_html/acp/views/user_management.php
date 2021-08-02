 <? if(!$user->isAdmin()){ header('Location: ../index.html'); } ?>

 <div class="col-lg-8">
	 <div class="panel panel-default">
	  <div class="panel-heading">
	    <h3 class="panel-title"><?=$l['User_Management']?></h3>
	  </div>
	  <div class="panel-body">
	   	<div id="UserTableContainer" style="width: 100%;"></div>
	  </div>
	</div>
 </div>	
 <script type="text/javascript">

		$(document).ready(function () {

		    //Prepare jTable
			$('#UserTableContainer').jtable({
				title: 'List Member',
				paging: true,
				pageSize: 20,
				sorting: true,
				defaultSorting: 'name ASC',
				actions: {
					listAction: '../controllers/cont.userManagement.php?action=list',
					createAction: '../controllers/cont.userManagement.php?action=create',
					updateAction: '../controllers/cont.userManagement.php?action=update',
					deleteAction: '../controllers/cont.userManagement.php?action=delete'
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
						width: '20%'
					},
					email: {
						title: 'Email',
						width: '20%'
					},
					role: {
						title: 'Role',
						width: '10%',
						options: { '0': '<?=$l['Unconfirmed']?>', '1':'<?=$l['Member']?>' ,'2':'<?=$l['Admin']?>','3':'<?=$l['Mod']?>' }
					},
					register_ip: {
						title: 'Register IP',
						width: '15%',
						create: false,
						edit: true,
					},
					register_date: {
						title: 'Register Date',
						width: '15%',
						create: false,
						edit: true,
						type: 'date',
					},
					password: {
						title: 'Password',
						create: true,
						edit: false,
						list: false
					}
				}
			});

			//Load person list from server
			$('#UserTableContainer').jtable('load');

		});

	</script>