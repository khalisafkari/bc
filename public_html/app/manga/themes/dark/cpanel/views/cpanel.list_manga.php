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
 						<a href="/upload-manga.html" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-plus"></i> <?=$lang['Add_new']?> <?=$lang['Manga']?></a>
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
 					<div class="btn-group col-lg-4 pull-right">
 						<form  method="POST" role="form">
 							<div class="form-group"> 
 								<div class="input-group">
 									<div class="input-group-btn search-panel">
 										<button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
 											<span id="search_concept">Status</span> <span class="caret"></span>
 										</button>
 										<ul class="dropdown-menu" role="menu">
 											<li><a href="#mHidden" data-type="1">Hidden Manga</a></li>
 											<li><a href="#mShow" data-type="2">Public Manga</a></li>
 											<li><a href="#mAll" data-type="0">All</a></li>
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
		    			width: '20%',
		    			display: function(data) {
		    				if (data.record.hidden == 1) {
		    					return '<a style="font-weight:bold;color:red;text-decoration: line-through;font-size:12px;" target="_blank" href="/'+data.record.id+'/">'+data.record.name+'</a>';
		    				} else {
		    					return '<a style="font-weight:bold;color:green;font-size:12px;" target="_blank" href="/'+data.record.id+'/">'+data.record.name+'</a>';
		    				}
		    			}
		    		},
		    		last_chapter: {
		    			title: 'Last Chapter',
		    			width: '10%',
		    			sorting: false,
		    			display: function(data) {
		    				return '<a class="btn btn-xs btn-primary" href="/'+data.record.id+'/'+data.record.released+'/" target="_blank">'+data.record.last_chapter+'</a>';
		    			}
		    		},
		    		last_update: {
		    			title: 'Post Time',
		    			width: '20%'
		    		},
		    		MyButton: {
		    			title: '<?=$lang['Action']?>',
		    			width: '30%',
		    			sorting: false,
		    			display: function(data) {
		    				
		    				return '<div class="btn-group"><a href="/manage/edit-manga/'+data.record.id+'/'+data.record.slug+'.html" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-wrench"></i> <?=$lang['Edit'] ?></a><a href="/manage/list-chapter/'+data.record.slug+'.html" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-list"></i> <?=$lang['Chapter_List']?></a><a href="/manage/upload-chapter/'+data.record.slug+'.html" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> <?=$lang['Add_new']?> <?=$lang['Chapter']?></a></div>';
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
					alert('Select at least one option!');
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