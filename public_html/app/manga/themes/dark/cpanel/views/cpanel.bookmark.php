 <? if(!$user->isLoggedIn()){ header('Location: ../index.html'); } ?>

   <div class="col-lg-12">
     <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><?=$lang['Manga_bookmart']?></h3>
      </div>
      <div class="panel-body">
        <div class="btn-group col-lg-4 pull-right">
            <form  method="POST" role="form">
              <div class="form-group"> 
                <div class="input-group">
                  <div class="input-group-btn search-panel">
                    <button type="button" class="btn btn-success btn-sm dropdown-toggle" data-toggle="dropdown">
                      <span id="search_concept">Status</span> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#mHidden" data-type="1">Manga Hide</a></li>
                      <li><a href="#mShow" data-type="2">Manga Public</a></li>
                      <li><a href="#mAll" data-type="0">All Manga</a></li>
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
          defaultSorting: 'name ASC',
          actions: {
            listAction: '/app/manga/controllers/cont.user.mangaBookmark.php?action=list',
            deleteAction: '/app/manga/controllers/cont.user.mangaBookmark.php?action=delete'
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
		    		deleteProggress: 'Delete {0} of {1} chapter. Processing...',
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
                return '<a style="font-weight:bold;color:green;font-size:12px;" target="_blank" href="/'+data.record.manga+'/">'+data.record.name+'</a>';
              }
            },
            last_chapter: {
             title: 'Last Chapter',
             width: '20%',
             sorting: false,
             display: function(data) {
              return '<a class="btn btn-xs btn-primary" target="_blank" href="/'+data.record.manga+'/'+data.record.released+'/">'+data.record.last_chapter+'</a>';
            }
          },
          last_update: {
           title: 'Last Update',
           width: '20%'
         },
         m_status: {
           title: 'Status',
           width: '20%',
           sorting: false,
           options: { '1': '<div style="font-weight:bold;color:blue;">Completed</div>', '2':'<div style="font-weight:bold;color:red;">On going</div>' }
         }
       }
     });

      //Load person list from server
      $('#UserTableContainer').jtable('load');
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