 <? if(!$user->isAdmin()){ header('Location: ../index.html'); } ?>

 <div class="col-lg-8">
 	<div class="panel panel-default">
 		<div class="panel-heading">
 			<h3 class="panel-title"><?=$lang['Manga_List']?> Uploader</h3>
 		</div>
 		<div class="panel-body">
 			<?=$user->alert('danger', $lang['Delete_warning'])?>
 			<p>
 				<div class="btn-group">
 					<a href="app=mangaview=add-manga" class="btn btn-success btn-sm"><i class="glyphicon glyphicon-plus"></i> <?=$lang['Add_new']?> <?=$lang['Manga']?></a>
 					<button type="button" class="btn btn-danger btn-sm dropdown-toggle"  id="dropdownMenu2" data-toggle="dropdown">
 						<i class="glyphicon glyphicon-import"></i> Grabbing
 						<span class="caret"></span>
 					</button>
 					<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
 						<?	if ($handle = opendir(ROOT_DIR.'/app/manga/acp/views/')) {
 							while (false !== ($entry = readdir($handle))) {
 								if ($entry != "." && $entry != ".." && strpos($entry, 'rab.manga.')) {
 									$entry = substr($entry, 0, -4);
 									$name = ucfirst(str_replace('.',' ',str_replace('manga','Manga',$entry)));
 									echo '<li><a href="app=mangaview='.$entry.'">'.$name.'</a></li>';
 								}
 							}
 							closedir($handle);
 						}
 						?>
 					</ul>
				
 				</div>
 				<div class="btn-group">
 					<a href="#" id="DeleteAllButton" class="btn btn-danger btn-sm"><i class="glyphicon glyphicon-trash"></i> Xóa</a>
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
 			<div id="UserTableContainer" style="width: 100%;"></div>
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
		    	//selectOnRowClick: false,
		    	defaultSorting: 'name ASC',
		    	actions: {
		    		listAction: '../app/manga/controllers/cont.userpost_mangaManagement.php?action=list',
		    		deleteAction: function (postData) {
		    			console.log("deleting from custom function...");
		    			return $.Deferred(function ($dfd) {
		    				$.ajax({
		    					url: '../app/manga/controllers/cont.userpost_mangaManagement.php?action=delete',
		    					type: 'POST',
		    					dataType: 'json',
		    					data: postData,
		    					success: function (data) {
		    						$dfd.resolve(data);
		    					},
		    					error: function () {
		    						$dfd.reject();
		    					}
		    				});
		    			});
		    		},
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
		    					return '<a style="font-weight:bold;color:green;text-decoration: line-through;font-size:12px;" target="_blank" href="/truyen-'+data.record.slug+'.html">'+data.record.name+'</a>';
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
		    				return '<a class="btn btn-xs btn-primary" href="/'+data.record.id+'/'+data.record.released+'/">'+data.record.last_chapter+'</a>';
		    			}
		    		},
		    		MyButton: {
		    			title: '<?=$lang['Action']?>',
		    			width: '30%',
		    			sorting: false,
		    			display: function(data) {

		    				return '<div class="btn-group"><a href="app=mangaview=edit-manga&mid='+data.record.id+'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-wrench"></i> <?=$lang['Edit'] ?></a><a href="app=mangaview=chapter_management&manga='+data.record.slug+'" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-list"></i> <?=$lang['Chapter_List']?></a><a href="app=mangaview=add-chapter&manga='+data.record.slug+'" class="btn btn-xs btn-info"><i class="glyphicon glyphicon-plus"></i> <?=$lang['Add_new']?> <?=$lang['Chapter']?></a><div class="btn-group"><button type="button" class="btn btn-xs btn-danger dropdown-toggle" data-toggle="dropdown">Grab<span class="caret"></span></button><ul class="dropdown-menu"><?	if ($handle = opendir(ROOT_DIR.'/app/manga/acp/views/')) {while (false !== ($entry = readdir($handle))) {if ($entry != "." && $entry != ".." && strpos($entry, 'rab.chapter.')) {$entry = substr($entry, 0, -4);$name = ucfirst(str_replace('.',' ',str_replace('chapter','Chapter',$entry)));echo '<li><a href="app=mangaview='.$entry.'&manga=\'+data.record.slug+\'">'.$name.'</a></li>';}}closedir($handle);}?></ul></div></div>';
		    			}
		    		},
		    	},
		    });

			//Load person list from server
			$('#UserTableContainer').jtable('load');

		    //Delete selected mangas

		    $('#DeleteAllButton').button().click(function () {
			var $selectedRows1 = $('#UserTableContainer').jtable('selectedRows');
			if ($selectedRows1.length <= 0) {
				alert('Bạn chưa chọn bất kì một trường nào!');
			} else {
				$('#UserTableContainer').jtable('deleteRows', $selectedRows1);
			}
		});
		$('#HiddenAllButton').click(function () {
			var $selectedRows1 = $('#UserTableContainer').jtable('selectedRows');
			if ($selectedRows1.length <= 0) {
				alert('Bạn chưa chọn bất kì một trường nào!');
			} else {
				for (var i = 0; i < $selectedRows1.length; i ++) {
					id = $selectedRows1[i].dataset.recordKey;
					$.ajax({
						url: '../app/manga/controllers/cont.userpost_mangaManagement.php?action=hidden',
						type: 'POST',
						dataType: 'json',
						data: {
							id: id
						}, success: function(data) {
						}
					})
				}
				$('#UserTableContainer').jtable('load');
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
						url: '../app/manga/controllers/cont.userpost_mangaManagement.php?action=show',
						type: 'POST',
						dataType: 'json',
						data: {
							id: id
						}, success: function(data) {
						}
					})
				}
				$('#UserTableContainer').jtable('load');
				$('#UserTableContainer').jtable('load');
			}
		});
		    
	});
</script>