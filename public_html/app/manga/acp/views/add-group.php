 <? if(!($user->isAdmin() || $user->isMod())){ header('Location: ../index.html'); }
 $listUser = $db->Query(APP_TABLES_PREFIX.'user', 'id, name', 'role != 0');
 ?>
 <div class="col-lg-8">
 	<div class="panel panel-default">
 		<div class="panel-heading">
 			<h3 class="panel-title"><?=$lang['Add']?> <?=$lang['Group']?></h3>
 		</div>
 		<div class="panel-body">
 			<div id="UserTableContainer" style="width: 100%;">
 				<div id="addGroup_output"></div>
 				<form id="addGroup_form" role="form" method="POST" action="../app/manga/controllers/cont.addGroup.php">
 					<div class="form-group">
 						<label for="exampleInputEmail1"><?=$lang['Name']?></label>
 						<input type="text" id="name_group" class="form-control" name="name_group">
 					</div>

 					<div class="form-group">
 						<label for="exampleInputEmail1"><?=$lang['member']?></label>
 						<select name="user[]" data-placeholder="Select a member of the group" class="js-example-basic-multiple form-control" multiple="multiple" tabindex="4">
 							<option value=""></option>
 							<?php
 							foreach ($listUser as $key => $isUser) {
 								echo '<option value="'.$isUser[id].'">'.$isUser[name].'</option>';
 							}
 							?>
 						</select>
 					</div>
 					<button type="submit" class="btn btn-default"><?=$l['Submit']?></button>
 				</form>

 			</div>
 		</div>
 	</div>
 </div>
 <?=$user->ajaxForm('addGroup','app=mangaview=group_management')?>
 <script type="text/javascript">
 	$(document).ready(function() {
    $('.js-example-basic-multiple').select2({
    	with: '100%',
    });
});
 </script>
