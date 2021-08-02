<? if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); } ?>
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
<div class="col-lg-8">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><b>List chapter waiting for approval</b></h3>
		</div>
		<div class="panel-body">
			<?=$user->alert('warning', $lang['Delete_chapter_warning'])?>
			<div class="btn-group">
				<a href="#" id="DeleteAllButton" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i> Delete</a>
			</div>
			<br /><br />
			<div class="modal fade" id="modal-preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Review!</h4>
						</div>
						<div class="modal-body modal-output">

						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div><div class="modal fade" id="modal-preview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Review!</h4>
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
	    	title: 'List chapter waiting for approval',
	    	paging: true,
	    	pageSize: 20,
	    	sorting: true,
	    	selecting: true,
		    multiselect: true,
		    selectingCheckboxes: true,
	    	defaultSorting: 'chapter ASC',
	    	actions: {
	    		listAction: '../app/manga/controllers/cont.chapterqManagement.php?action=list&manga=<?=isset($_GET['manga'])?>',
	    		deleteAction: '../app/manga/controllers/cont.chapterqManagement.php?action=delete&manga=<?=isset($_GET['manga'])?>'
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
	    		manga: {
	    			title: 'Manga',
	    			width: '20%'
	    		},
	    		chapter: {
	    			title: 'Chapter',
	    			width: '10%'
	    		},
	    		name: {
	    			title: 'Chapter name',
	    			width: '20%'
	    		},
	    		MyButton: {
	    			title: '<?=$lang['Action']?>',
	    			width: '30%',
	    			sorting: false,
	    			display: function(data) {
	    				return '<div class="btn-group"><a href="app=mangaview=edit-chapterQ&cid='+data.record.id+'" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-wrench"></i> <?=$lang['Edit-accept']?></a><a id="preview" data-id="'+data.record.id+'" onclick="load_img(this)" class="preview btn btn-danger btn-sm"><i class="glyphicon glyphicon-eye-open"></i> Review</a></div>';

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
	function load_img(cid) {
 		var id = cid.getAttribute("data-id");
 		$.ajax({
 		type: 'POST',
 		dataType: 'html',
 		url: '../app/manga/controllers/cont.chapterPreview.php?type=chapter',
 		data: {
 			id: id
 		}, success: function(data) {
 			$('#modal-preview').modal('show');
 			$('.modal-output').html(data);
 		}
 	});
 }
</script>
