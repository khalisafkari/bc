<?php

include '../../../controllers/cont.main.php';


if (isset($_POST) && $_POST['active'] == 'showNoti' && MANGA) {
	$query_noti = $db->Query(APP_TABLES_PREFIX.'manga_notification', '*', array('user'=>$_SESSION['userId']),NULL,NULL,array('time'=>'DESC'),NULL);

	if (count($query_noti) > 0) {

		foreach ($query_noti as $noti) {
			$manga_info = $h0manga->manga_info('id', $noti['mid']);
			if ($noti['type'] == 5) {
				$avatar = '/'.$avtFolder.$_SESSION['thisUser']['avatar'];
			} else {
				$avatar = $manga_info['cover'];
			}
			?>
			<li id="<?=$noti['id']?>"<?=$noti['see'] ? '' : 'onclick="read_noti('.$noti['id'].')"'?> class="noti <?=$noti['see'] ? 'read-noti' : 'not-read'?>">
				<a class="cm" href="<?=$noti['url']?>">
					<span class="image">
						<div style="background-image:url('<?=$avatar?>');width: 60px;height: 60px;background-size: 60px;background-position: 50%;"></div>
					</span>
					<span>
						<span class="type-noti">
							<?php
							if ($noti['type'] == 1) {
								echo $lang['chapter-error'];
							} elseif ($noti['type'] == 2) {
								echo $lang['new-chapter'];
							} elseif ($noti['type'] == 3) {
								echo $lang['submit-chapter'];
							} elseif ($noti['type'] == 3.5) {
								echo $lang['submit-manga'];
							} elseif ($noti['type'] == 4) {
								echo $lang['Manga-is-deleted'];
							} elseif ($noti['type'] == 5) {
								echo $lang['comment'];
							}
							?>
						</span>
						<span class="time"><?=$huy->ago($noti['time'])?></span>
					</span>
					<span class="message"><?=$noti['content']?></span>
				</a>
			</li>
			<div class="clearfix"></div>
		<?php } 

	} else {
		echo '<li><span class="messege">'.$lang['comment-is-null'].'</span></li>';
	}

}
?>