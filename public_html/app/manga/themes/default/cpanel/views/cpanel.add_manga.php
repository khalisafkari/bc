<div class="container">
  <?php
  $m_id = isset($_GET['mid']) ? (int)$_GET['mid'] : NULL;
  $c_id = isset($_GET['cid']) ? (int)$_GET['cid'] : NULL;
  $thisGroup = $db->Query(APP_TABLES_PREFIX.'user', 'group_uploader', array('id'=>$_SESSION['userId']));

  if($_GET['type'] == 'manga'){
    if($_SESSION['thisUser']['role'] == 2) {
      header('Location: /acp/app=mangaview=add-manga');
    } elseif ($_SESSION['thisUser']['role'] == 1) {
      ?>
      <div class="col-lg-12">
       <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><?=$lang['Submit']?> <?=$lang['Manga']?></h3>
        </div>
        <div class="panel-body">
          <div id="UserTableContainer" style="width: 100%;">
            <form id="addManga_form" role="form" method="POST" action="/app/manga/controllers/cont.user.addManga.php">
              <div class="form-group">
                <label for="exampleInputEmail1"><?=$lang['Name']?></label>
                <input type="text" class="form-control" name="name">
              </div>
              <div class="form-group">
               <label for="exampleInputEmail1"><?=$lang['Other_name']?></label>
               <input type="text" class="form-control" name="other_name" placeholder="Tên khác của chuyện (Tên nước ngoài)">
             </div>
             <div class="form-group">
               <label for="exampleInputEmail1"><?=$lang['Authors']?></label>
               <input type="text" class="form-control" name="authors" placeholder="<?=$lang['Authors_ex']?>">
             </div>
             <div class="form-group">
               <label for="exampleInputEmail1"><?=$lang['Artists']?></label>
               <input type="text" class="form-control" name="artists" placeholder="<?=$lang['Artists_ex']?>">
             </div>
             <div class="form-group">
               <label for="exampleInputEmail1"><?=$lang['Released']?></label>
               <input type="text" class="form-control" name="released">
             </div>
             <div class="form-group">
               <label for="exampleInputEmail1"><?=$lang['Genres']?></label>
               <input type="text" class="form-control" name="genres" placeholder="<?=$lang['Genres_ex']?>">
             </div>
             <div class="form-group">
               <label for="exampleInputEmail1" ><?=$lang['Group']?></label>
               <input type="text" name="trans_group" class="form-control" placeholder="<?=$lang['Groups_ex']?>">
             </div>
             <div class="form-group">
               <label for="exampleInputEmail1"><?=$lang['Description']?></label>
               <textarea id="description" class="tiny form-control" name="description" cols="100%" rows="5"></textarea>
             </div>
             <div class="form-group">
               <input type="hidden" name="token" value="<?=$_SESSION['token']?>">
               <input type="hidden" name="id_group" value="<?=$thisGroup[0]['group_uploader']?>"> 
               <label for="exampleInputEmail1" ><?=$lang['Status']?></label>
               <select name="status" class="form-control">
                <option value="1"><?=$lang['Completed']?></option>
                <option value="2"><?=$lang['On_going']?></option>
                <option value="3"><?=$lang['Pause']?></option>
              </select>
            </div>
            <div class="form-group">
             <label for="exampleInputEmail1"><?=$lang['Cover']?></label>
             <input type="text" id='cover' name='cover' class="form-control" placeholder="<?=$lang['Cover_ex']?>">
           </div>
           <div id="addManga_output"></div>
           <button type="submit" class="btn btn-default"><?=$l['Submit']?></button>
         </form>

       </div>
     </div>
   </div>
 </div>
</div>
<?php
if ($thisGroup[0]['group_uploader'] != 0) {
  $user->ajaxForm('addManga','/quan-ly/danh-sach-truyen.html');
} else {
  $user->ajaxForm('addManga','/quan-ly.html?ref=submit1');
}
}
}
?>