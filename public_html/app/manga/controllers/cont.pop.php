<?
include '../../../controllers/cont.main.php';
header('Content-Type: text/html; charset='.$thisTheme['charset']);
if($_GET['action'] == 'pop' && !empty($_GET['id']) && MANGA){
	$mid = (int)$_GET['id'];
	$row = $db->Query(APP_TABLES_PREFIX.'manga_mangas', array('name','other_name','authors','cover','genres','description','last_update','views'), array('id'=>$mid),NULL,NULL,NULL,null);
	$row = $huy->stripSlashes($row[0]);
	$description = strip_tags(substr($row['description'], 0, 250)).'....';
	?>
	<div class="pop_title"><?=$row['name']?></div>
	<div class="pop_info clearfix">
		<img src="<?=$row['cover']?>" alt="<?=$row['name']?>" width="100" height="140">
		<div class="group">
		<small><p><strong><?=$lang['Other_name']?>:</strong> <?=$row['other_name']?></p>
		<p><strong><?=$lang['Genres']?>:</strong> <?=$h0manga->splitGenre($row['genres'], $lang)?></p>
			<p><strong><?=$lang['Authors']?>:</strong ><?=$row['authors']?></p>
			<p><strong><?=$lang['Last_update']?>:</strong><span> <?=$huy->ago($row['last_update'])?></span></p>
			<p><strong><?=$lang['Views']?>:</strong><span> <?=$row['views']?></span></p></small>
			
		</div>
	</div>
	<div class="pop_noidung">
		<strong><?=$lang['Description']?>: </strong><br><?=$description?></div>
		<?php } ?>