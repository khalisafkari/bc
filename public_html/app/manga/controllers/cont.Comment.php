<?php
include '../../../controllers/cont.main.php';

if (!$user->isLoggedIn()) {
	header('Location: ../index.html');
	exit;
} else {
	$_POST = $huy->addSlashes($huy->clearXss($_POST));

	$thisUser = $user->info_user($_SESSION['userId']);

	if ($_POST && $_GET['act'] == 'add_comment' && MANGA && $_SESSION['userId']) {
		$pcontent = $_POST['content'];
		$pcontent = $huy->clearXss($pcontent);
		$pcontent = str_replace('script','',$pcontent);
		$pcontent = str_replace('popcash','',$pcontent);
		$pcontent = str_replace('document.createElement','',$pcontent);
		$pcontent = str_replace('document.getElement','',$pcontent);
		$pcontent = preg_replace('#atob(.*)#imsU', '', $pcontent);
		$pcontent = str_replace('atob','',$pcontent);
		$inputInfo = array(
			'manga' => $_POST['manga'],
			'content' => $_POST['content'],
			'user_id' => $_SESSION['userId'],
			'c_id' => (int)$_POST['c_id'] ? (int)$_POST['c_id'] : 0,
			'chapter_id' => (int)$_POST['chapter_id'] ? (int)$_POST['chapter_id'] : 0,
			'chapter' => $_POST['chapter'] ? $_POST['chapter'] : 0,
			'time' => $now
		);
		$id_comment = $db->Create(APP_TABLES_PREFIX.'manga_comments', $inputInfo);
		$query = $db->Query(APP_TABLES_PREFIX.'manga_comments', '*', array('id'=>$id_comment));
		$thisComment = $query[0];

		$thisManga = $huy->addSlashes($h0manga->manga_info('id', $_POST['manga']));
		$thisChapter = $huy->addSlashes($h0manga->chapter_info('id', $_POST['chapter_id']));

		if ($_POST['c_id']) {
			if ($thisComment) {
				echo '<div class="chil_comment" id="comment_' .$id_comment. '">

				<div class="col-md-12 col-sm-12 cm-body">
				<div class="avatar">
				<a href="/ucp" target="_blank"><img class="avatar1" src="/'.$avtFolder.$thisUser['avatar'].'" alt="Avatar"/></a>
				<div class="user'.$thisComment['id'].' hidden" data-id="'.$thisUser['id'].'">'.$thisUser['name'].'</div>
				</div>
				
				<div class="panel panel-default arrow left">
				<div class="panel-body comment-body">
				<header>
				<a href="/ucp" target="_blank" class="comment-user"><i class="glyphicon glyphicon-user"></i> '.$thisUser['name'].'</a>
				<time class="text-muted" datetime="'.$thisComment['time'].'">just now!</time>
				</header>
				<div class="comment-post" data-id="'.$thisChapter['id'].'">'.$thisComment['content'].'</div>
				<div class="text-right">
				<a class="cm-delete btn-link btn-xs" data-id="'.$id_comment.'" ><i class="glyphicon glyphicon-remove-circle"></i> Delete</a>
				<a class="cm-edit btn-link btn-xs" data-id="'.$id_comment.'" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				</div>
				</div>
				</div>
				</div>
				<div class="clearfix"></div>
				</div>
				';
			}
			if ($_SESSION['userId'] !== $_POST['user']) {
				if($_POST['chapter_id']) {
						$urlm = '/' .$thisManga['id']. '/'.$thisChapter['id'].'/#comment_'. $id_comment;
						$contentm = 'Member '.$thisUser['name']. ' answered your comment in <b>'.$thisManga['name'].' chapter '.$thisChapter['chapter'].'</b>!';
					} else {
						$urlm = '/' .$thisManga['id']. '/#comment_'. $id_comment;
						$contentm = 'Member '.$thisUser['name']. ' answered your comment in <b>'.$thisManga['name'].'</b>!';		 
					}
					$inputInfo = array(
						'type' => 5,
						'mid' => $thisManga['id'],
						'cid' => $thisChapter['id'],
						'name' => $thisManga['name'],
						'slug' => $thisManga['slug'],
						'chapter' => $_POST['chapter'] ? $_POST['chapter'] : 0,
						'url' => $urlm,
						'content' => $contentm,
						'user' => $_POST['user'],
						'time' => $now
					);
				if (!$huy->isExist(APP_TABLES_PREFIX. 'manga_notification', 'id', array('mid'=>$inputInfo['mid'], 'cid'=>$inputInfo['cid'], 'user'=>$inputInfo['user'], 'content'=>$inputInfo['content'], 'see'=>0))) {
					$noti = $db->Create(APP_TABLES_PREFIX. 'manga_notification', $inputInfo);
				}
			}
		} else {
			if ($thisComment) {

				echo '<div id="comment_' .$id_comment. '">
				<div class="col-md-12 col-sm-12 cm-body">
				<div class="avatar">
				<a href="/ucp" target="_blank"><img class="avatar1" src="/'.$avtFolder.$thisUser['avatar'].'" alt="Avatar"/></a>
				</div>
				<div class="user'.$thisComment['id'].' hidden" data-id="'.$thisUser['id'].'">'.$thisUser['name'].'</div>
				<div class="panel panel-default arrow left">
				<div class="panel-body comment-body">
				<header>
				<a href="/ucp" target="_blank" class="comment-user"><i class="glyphicon glyphicon-user"></i> '.$thisUser['name'].'</a>
				<time class="text-muted" datetime="'.$thisComment['time'].'">just now!</time>
				</header>
				<div class="comment-post" data-id="' .$id_comment. '">'.$thisComment['content'].'</div>
				<div class="text-right">
				<a class="cm-reply btn-link btn-xs" data-id="'.$id_comment.'"><i class="glyphicon glyphicon-comment"></i> Reply</a>
				<a class="cm-delete btn-link btn-xs" data-id="'.$id_comment.'" ><i class="glyphicon glyphicon-remove-circle"></i> Delete</a>
				<a class="cm-edit btn-link btn-xs" data-id="'.$id_comment.'" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				</div>
				</div>
				</div>
				</div>
				<div class="clearfix"></div>
				</div>
				';
			} 
			if ($id_comment) {
/*	if ($thisManga['group_uploader'] > 0) {
	$result = $db->Query(APP_TABLES_PREFIX. 'manga_groups', 'user', array('id'=>$thisManga['group_uploader']));

	$row = explode(',', $result[0]['user']);
	if (array_search($_SESSION['userId'], $row) === NULL) {
		foreach ($row as $user) {
			$inputInfo = array(
				'type' => 5,
				'mid' => $thisManga['id'],
				'name' => $thisManga['name'],
				'slug' => $thisManga['slug'],
				'url' => '/'. $lang['manga_slug']. '-' .$thisManga['slug']. '.html#comment_'. $id_comment,
				'content' => 'Thành viên '.$thisUser['name']. ' đã bình luận trong truyện <b>'.$thisManga['name'].'</b> của nhóm bạn!',
				'user' => $user,
				'time' => $now
				);
			if (!$huy->isExist(APP_TABLES_PREFIX. 'manga_notification', 'id', array('mid'=>$inputInfo['mid'], 'user'=>$inputInfo['user'], 'content'=>$inputInfo['content'], 'see'=>0))) {
				$noti = $db->Create(APP_TABLES_PREFIX. 'manga_notification', $inputInfo);
			}
		}
	}
} else */ if($_SESSION['userId'] != $thisManga['submitter']) {
			if($_POST['chapter_id']) {
				$urlm = '/' .$thisManga['id']. '/'.$thisChapter['id'].'/#comment_'. $id_comment;
				$contentm = 'Member '.$thisUser['name']. ' commented on <b>'.$thisManga['name'].' chapter '.$thisChapter['chapter'].'</b>!';
			} else {
				$urlm = '/' .$thisManga['id']. '/#comment_'. $id_comment;
				$contentm = 'Member '.$thisUser['name']. ' commented on <b>'.$thisManga['name'].'</b>!';		 
			}
			$inputInfo = array(
				'type' => 5,
				'mid' => $thisManga['id'],
				'cid' => $thisChapter['id'],
				'name' => $thisManga['name'],
				'slug' => $thisManga['slug'],
				'chapter' => $_POST['chapter'] ? $_POST['chapter'] : 0,
				'url' => $urlm,
				'content' => $contentm,
				'user' => $thisManga['submitter'],
				'time' => $now
			);
	if (!$huy->isExist(APP_TABLES_PREFIX. 'manga_notification', 'id', array('mid'=>$inputInfo['mid'], 'cid'=>$inputInfo['cid'], 'user'=>$inputInfo['user'], 'content'=>$inputInfo['content'], 'see'=>0))) {
		$noti = $db->Create(APP_TABLES_PREFIX. 'manga_notification', $inputInfo);
	}
}
}
}
} elseif ($_GET['act'] == 'delete_comment') {
	if ($huy->isExist(APP_TABLES_PREFIX. 'manga_comments', 'id', array('user_id'=>$_SESSION['userId'], 'id'=>$_POST['id'])) || $thisUser['role'] == 2) {
		$txtdelete = '<i style="color:red">This comment has been removed by <b>'.$thisUser['name'].'</b></i>';
		$db->Update(APP_TABLES_PREFIX.'manga_comments', array('id'=>$_POST['id']), array('content'=>$txtdelete, 'delete_comment'=>1));
		echo $txtdelete;
	} else {
		echo 'You do not have permission to delete this comment!';
	}
} elseif ($_GET['act'] == 'show_content') {
	$id = $_POST['id'];
	$query = $db->Query(APP_TABLES_PREFIX. 'manga_comments', 'content', array('id'=>$id));
	$thisComment = $query[0];
	echo $thisComment['content'];
} elseif ($_GET['act'] == 'edit_comment') {

	$id = $_POST['id'];
	$content = $_POST['txtEditText'];
	if ($huy->isExist(APP_TABLES_PREFIX. 'manga_comments', 'id', array('id'=>$id, 'user_id'=>$_SESSION['userId'])) || $_SESSION['thisUser']['role'] == 2) {
		$db->Update(APP_TABLES_PREFIX. 'manga_comments', array('id'=>$id), array('content'=>$content, 'edited'=>1));
		$query = $db->Query(APP_TABLES_PREFIX. 'manga_comments', '*', array('id'=>$id, 'delete_comment'=>0));
		$thisComment = $query[0];
		$e_User = $user->info_user($thisComment['user_id']);
		$chil = $thisComment['c_id'] ? 'class="chil_comment"' : '';
		echo '<div '.$chil.' id="comment_' .$thisComment['id']. '">
		<div class="col-md-12 col-sm-12 cm-body">
		<div class="avatar">
		<a href="/ucp" target="_blank"><img class="avatar1" src="/'.$avtFolder.$e_User['avatar'].'" alt="Avatar"/></a>
		<div class="user'.$thisComment['id'].' hidden" data-id="'.$e_User['id'].'">'.$e_User['name'].'</div>
		</div>
		<div class="panel panel-default arrow left">
		<div class="panel-body comment-body">
		<header>
		<a href="/ucp" target="_blank" class="comment-user"><i class="glyphicon glyphicon-user"></i> '.$e_User['name'].'</a>
		<time class="text-muted" datetime="'.$thisComment['time'].'">'.$huy->ago($thisComment['time']).'</time>
		</header>
		<div class="comment-post" data-id="'.$thisComment['id'].'">'.$thisComment['content'].'</div>
		<div class="text-right">
		<div class="text-right">
		<a class="cm-reply btn-link btn-xs" data-id="'.$thisComment['id'].'"><i class="glyphicon glyphicon-comment"></i> Reply</a>
		<a class="cm-delete btn-link btn-xs" data-id="'.$thisComment['id'].'" ><i class="glyphicon glyphicon-remove-circle"></i> Delete</a>
		<a class="cm-edit btn-link btn-xs" data-id="'.$thisComment['id'].'" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>
		</div>
		</div>
		</div>
		</div>
		<div class="clearfix"></div>
		</div>';
	} else {
		exit('You do not have permission to edit this comment!');
	}
}
}
