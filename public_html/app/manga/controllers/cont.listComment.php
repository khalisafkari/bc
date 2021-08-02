<?php
include '../../../controllers/cont.main.php';

if ($_GET && $_GET['act'] == 'list_comment' && MANGA) {

	$poster = '';
	$manga = $_GET['manga'];

	$limit = 5;
	$page = (int)$_GET['page'];
	$start = (is_numeric($page) ? ($page - 1) * $limit : 0);
	$thisTotalComment = $db->Query(APP_TABLES_PREFIX.'manga_comments', 'COUNT(id) AS id', 'manga = '."$manga".' AND c_id = 0 AND chapter_id = 0', null, null, ['time'=>'DESC']);
	$total = $thisTotalComment[0]['id'];
	$query = $db->Query(APP_TABLES_PREFIX. 'manga_comments', '*', 'manga = '."$manga".' AND c_id = 0 AND chapter_id = 0', NULL, NULL, array('time'=>'DESC'), ['offset' => $start, 'rows' => $limit]);
	$config = [
		'total' => $total,
		'limit' => $limit
	];
	$data = [];
	if ($total >= $limit) {
		$pagination = new Pagination($config);
		$data['page_list'] = '<ul class="pagination pagination-v4 pull-right">'.$pagination->getPagination().'</ul>';
	}

	$thisManga = $huy->addSlashes($h0manga->manga_info('id', $manga));
	$result = $db->Query(APP_TABLES_PREFIX. 'manga_groups', 'user', array('id'=>$thisManga['group_uploader']));
	$row = explode(',', $result[0]['user']);
	
	foreach ($query as $thisComment) {
		$thisComment['content'] = str_replace('script','',$thisComment['content']);
		$thisComment['content'] = str_replace('popcash','',$thisComment['content']);
		$thisComment['content'] = str_replace('document.createElement','',$thisComment['content']);
		$thisComment['content'] = str_replace('document.getElement','',$thisComment['content']);
		$thisComment['content'] = str_replace('atob','',$thisComment['content']);
		$User = $user->info_user($thisComment['user_id']);
		if ($User['role'] == 2) {
			$admin = 'admin';
		} else {
			$admin = '';
		}
		$poster = '';
		if ($User['id'] === $thisManga['submitter']) {
			$poster = '<button class="btn btn-danger btn-xss">Poster</button>';
		} elseif ($thisManga['group_uploader'] > 0 && array_search($User['id'], $row) !== NULL) {
			$poster = '<button class="btn btn-success btn-xss">Uploader</button>';
		} elseif ($User['role'] == 3) {
			$poster = '<button class="btn btn-success btn-xss">Mod</button>';
		}
		$data['comment_list'] .= '<div id="comment_' .$thisComment['id']. '">
		<div class="col-md-12 col-sm-12 cm-body">
		<div class="avatar">
		<a href="/ucp"><img class="avatar1" src="/'.$avtFolder.$User['avatar'].'" alt="Avatar"/></a>
		<div class="user-info user'.$thisComment['id'].' hidden" data-id="'.$User['id'].'">'.$User['name'].'</div>
		</div>
		<div class="panel panel-default arrow left">
		<div class="panel-body comment-body">
		<header>
		<a href="/ucp" class="comment-user '.$admin.'"><i class="glyphicon glyphicon-user"></i> '.$User['name'].'</a> '.$poster.'
		<time class="text-muted" datetime="'.$thisComment['time'].'">'.$huy->ago($thisComment['time']).'</time>
		</header>
		<div class="comment-post" data-id="'.$thisComment['id'].'">'.$thisComment['content'].'</div>';
		if ($thisComment['delete_comment'] == 0) {
			if ($user->isLoggedIn()) {
				$data['comment_list'] .= '<div class="text-right">
				<a class="cm-reply btn-link btn-xs" data-id="'.$thisComment['id'].'"><i class="glyphicon glyphicon-comment"></i> Reply</a> ';
				if ($_SESSION['userId'] === $User['id'] || $thisUser['role'] == 2) {
					$data['comment_list'] .= '<a class="cm-delete btn-link btn-xs" data-id="'.$thisComment['id'].'" ><i class="glyphicon glyphicon-remove-circle"></i> Delete</a>
					<a class="cm-edit btn-link btn-xs" data-id="'.$thisComment['id'].'" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

				}
			}
		}

		$data['comment_list'] .= '</div>
		</div>
		</div>
		</div>
		<div class="clearfix"></div>
		</div>';

		$query1 = $db->Query(APP_TABLES_PREFIX. 'manga_comments', '*', array('manga'=>$manga, 'c_id'=>$thisComment['id']), NULL, NULL, array('time'=>'ASC'), NULL);

		foreach ($query1 as $thiscComment) {
			$thiscComment['content'] = str_replace('script','',$thiscComment['content']);
			$thiscComment['content'] = str_replace('popcash','',$thiscComment['content']);
			$thiscComment['content'] = str_replace('document.createElement','',$thiscComment['content']);
			$thiscComment['content'] = str_replace('document.getElement','',$thiscComment['content']);
			$thiscComment['content'] = str_replace('atob','',$thiscComment['content']);
			$c_User = $user->info_user($thiscComment['user_id']);
			if ($c_User['role'] == 2) {
				$admin = 'admin';
			} else {
				$admin = '';
			}
			$poster = '';
			if ($c_User['id'] === $thisManga['submitter']) {
				$poster = '<button class="btn btn-danger btn-xss">Poster</button>';
			} elseif ($thisManga['group_uploader'] > 0 && array_search($User['id'], $row) !== NULL) {
				$poster = '<button class="btn btn-success btn-xss">Uploader</button>';
			} elseif ($c_User['role'] == 3) {
				$poster = '<button class="btn btn-success btn-xss">Mod</button>';
			}
			if ($thiscComment > 0) {
				$data['comment_list'] .= '<div class="chil_comment" id="comment_' .$thiscComment['id']. '">
				<div class="col-md-12 col-sm-12 cm-body">
				<div class="avatar">
				<a href="/ucp"><img class="avatar1" src="/'.$avtFolder.$c_User['avatar'].'" alt="Avatar"/></a>
				<div class="user'.$thiscComment['id'].' hidden" data-id="'.$c_User['id'].'">'.$c_User['name'].'</div>
				</div>
				<div class="panel panel-default arrow left">
				<div class="panel-body comment-body">
				<header>
				<a href="/ucp" class="comment-user '.$admin.'"><i class="glyphicon glyphicon-user"></i> '.$c_User['name'].'</a> '.$poster.'
				<time class="text-muted" datetime="'.$thiscComment['time'].'">'.$huy->ago($thiscComment['time']).'</time>
				</header>
				<div class="comment-post"  data-id="'.$thiscComment['id'].'">'.$thiscComment['content'].'</div>';
				if ($thiscComment['delete_comment'] == 0) {
					if ($_SESSION['userId'] === $c_User['id'] || $thisUser['role'] == 2) {
						if ($user->isLoggedIn()) {
							$data['comment_list'] .= '<div class="text-right">
							<a class="cm-delete btn-link btn-xs" data-id="'.$thiscComment['id'].'" ><i class="glyphicon glyphicon-remove-circle"></i> Delete</a>
							<a class="cm-edit btn-link btn-xs" data-id="'.$thiscComment['id'].'" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>
							</div>';
						}
					}

				}

				$data['comment_list'] .= '</div>
				</div>
				</div>
				<div class="clearfix"></div>
				</div>
				';
			}
		}
	}
	echo json_encode($data);
} elseif ($_GET['act'] == 'list_comment_chapter') {
	$poster = '';
	$manga = $_GET['manga'];

	$limit = 5;
	$page = (int)$_GET['page'];
	$start = (is_numeric($page) ? ($page - 1) * $limit : 0);
	$thisTotalComment = $db->Query(APP_TABLES_PREFIX.'manga_comments', 'COUNT(id) AS id', 'manga = '."$manga".' AND c_id = 0 AND chapter = '.$_GET['chapter'], null, null, ['time'=>'DESC']);
	$total = $thisTotalComment[0]['id'];
	$query = $db->Query(APP_TABLES_PREFIX. 'manga_comments', '*', 'manga = '."$manga".' AND c_id = 0 AND chapter = '.$_GET['chapter'], NULL, NULL, array('time'=>'DESC'), ['offset' => $start, 'rows' => $limit]);
	$config = [
		'total' => $total,
		'limit' => $limit
	];
	$data = [];
	if ($total >= $limit) {
		$pagination = new Pagination($config);
		$data['page_list'] = '<ul class="pagination pagination-v4 pull-right">'.$pagination->getPagination().'</ul>';
	}

	$thisManga = $huy->addSlashes($h0manga->manga_info('id', $manga));
	$result = $db->Query(APP_TABLES_PREFIX. 'manga_groups', 'user', array('id'=>$thisManga['group_uploader']));
	$row = explode(',', $result[0]['user']);

	foreach ($query as $thisComment) {
		$thiscComment['content'] = str_replace('script','',$thiscComment['content']);
		$thiscComment['content'] = str_replace('popcash','',$thiscComment['content']);
		$thiscComment['content'] = str_replace('document.createElement','',$thiscComment['content']);
		$thiscComment['content'] = str_replace('document.getElement','',$thiscComment['content']);
		$thiscComment['content'] = str_replace('atob','',$thiscComment['content']);
		$User = $user->info_user($thisComment['user_id']);
		if ($User['role'] == 2) {
			$admin = 'admin';
		} else {
			$admin = '';
		}
		$poster = '';
		if ($User['id'] === $thisManga['submitter']) {
			$poster = '<button class="btn btn-danger btn-xss">Poster</button>';
		} elseif ($thisManga['group_uploader'] > 0 && array_search($User['id'], $row) !== NULL) {
			$poster = '<button class="btn btn-success btn-xss">Uploader</button>';
		} elseif ($User['role'] == 3) {
			$poster = '<button class="btn btn-success btn-xss">Mod</button>';
		}
		$poster .=  $thisComment['chapter'] ? '<button class="btn btn-default btn-xss">Chapter '.$thisComment['chapter'].'</button>' : '';
		$data['comment_list'] .= '<div id="comment_' .$thisComment['id']. '"><div class="col-md-12 col-sm-12 cm-body"><div class="avatar"><a href="/ucp"><img class="avatar1" src="/'.$avtFolder.$User['avatar'].'" alt="Avatar"/></a><div class="user-info user'.$thisComment['id'].' hidden" data-id="'.$User['id'].'">'.$User['name'].'</div></div><div class="panel panel-default arrow left"><div class="panel-body comment-body"><header><a href="/ucp" class="comment-user '.$admin.'"><i class="glyphicon glyphicon-user"></i> '.$User['name'].'</a> '.$poster.'<time class="text-muted" datetime="'.$thisComment['time'].'">'.$huy->ago($thisComment['time']).'</time></header><div class="comment-post" data-id="'.$thisComment['id'].'">'.$thisComment['content'].'</div>';
		if ($thisComment['delete_comment'] == 0) {
			if ($user->isLoggedIn()) {
				$data['comment_list'] .= '<div class="text-right"><a class="cm-reply btn-link btn-xs" data-id="'.$thisComment['id'].'"><i class="glyphicon glyphicon-comment"></i> Reply</a> ';
				if ($_SESSION['userId'] === $User['id'] || $thisUser['role'] == 2) {
					$data['comment_list'] .= '<a class="cm-delete btn-link btn-xs" data-id="'.$thisComment['id'].'" ><i class="glyphicon glyphicon-remove-circle"></i> Delete</a><a class="cm-edit btn-link btn-xs" data-id="'.$thisComment['id'].'" ><i class="glyphicon glyphicon-pencil"></i> Edit</a>';

				}
			}
		}

		$data['comment_list'] .= '</div></div><div class="clearfix"></div></div></div>';

		$query1 = $db->Query(APP_TABLES_PREFIX. 'manga_comments', '*', array('manga'=>$manga, 'c_id'=>$thisComment['id']), NULL, NULL, array('time'=>'ASC'), NULL);

		foreach ($query1 as $thiscComment) {
			$thiscComment['content'] = str_replace('script','',$thiscComment['content']);
			$thiscComment['content'] = str_replace('popcash','',$thiscComment['content']);
			$thiscComment['content'] = str_replace('document.createElement','',$thiscComment['content']);
			$thiscComment['content'] = str_replace('document.getElement','',$thiscComment['content']);
			$thiscComment['content'] = str_replace('atob','',$thiscComment['content']);
			$c_User = $user->info_user($thiscComment['user_id']);
			if ($c_User['role'] == 2) {
				$admin = 'admin';
			} else {
				$admin = '';
			}
			$poster = '';
			if ($c_User['id'] === $thisManga['submitter']) {
				$poster = '<button class="btn btn-danger btn-xss">Poster</button>';
			} elseif ($thisManga['group_uploader'] > 0 && array_search($User['id'], $row) !== NULL) {
				$poster = '<button class="btn btn-success btn-xss">Uploader</button>';
			} elseif ($c_User['role'] == 3) {
				$poster = '<button class="btn btn-success btn-xss">Mod</button>';
			}
			$poster .=  $thisComment['chapter'] ? '<button class="btn btn-default btn-xss">Chapter '.$thisComment['chapter'].'</button>' : '';
			if ($thiscComment > 0) {
				$data['comment_list'] .= '<div class="chil_comment" id="comment_' .$thiscComment['id']. '"><div class="col-md-12 col-sm-12 cm-body"><div class="avatar"><a href="/ucp"><img class="avatar1" src="/'.$avtFolder.$c_User['avatar'].'" alt="Avatar"/></a><div class="user'.$thiscComment['id'].' hidden" data-id="'.$c_User['id'].'">'.$c_User['name'].'</div></div><div class="panel panel-default arrow left"><div class="panel-body comment-body"><header><a href="/ucp" class="comment-user '.$admin.'"><i class="glyphicon glyphicon-user"></i> '.$c_User['name'].'</a> '.$poster.'<time class="text-muted" datetime="'.$thiscComment['time'].'">'.$huy->ago($thiscComment['time']).'</time></header><div class="comment-post"  data-id="'.$thiscComment['id'].'">'.$thiscComment['content'].'</div>';
				if ($thiscComment['delete_comment'] == 0) {
					if ($_SESSION['userId'] === $c_User['id'] || $thisUser['role'] == 2) {
						if ($user->isLoggedIn()) {
							$data['comment_list'] .= '<div class="text-right"><a class="cm-delete btn-link btn-xs" data-id="'.$thiscComment['id'].'" ><i class="glyphicon glyphicon-remove-circle"></i> Delete</a><a class="cm-edit btn-link btn-xs" data-id="'.$thiscComment['id'].'" ><i class="glyphicon glyphicon-pencil"></i> Edit</a></div>';
						}
					}

				}

				$data['comment_list'] .= '</div></div></div><div class="clearfix"></div></div>';
			}
		}
	}
	echo json_encode($data);
} elseif ($_GET['act'] == 'list_comment_chapter_only_view') {
	$poster = '';
	$manga = $_GET['manga'];

	$limit = 5;
	$page = (int)$_GET['page'];
	$start = (is_numeric($page) ? ($page - 1) * $limit : 0);
	$thisTotalComment = $db->Query(APP_TABLES_PREFIX.'manga_comments', 'COUNT(id) AS id', 'manga = '."$manga".' AND c_id = 0 AND chapter_id != 0', null, null, ['time'=>'DESC']);
	$total = $thisTotalComment[0]['id'];
	$query = $db->Query(APP_TABLES_PREFIX. 'manga_comments', '*', 'manga = '."$manga".' AND c_id = 0 AND chapter_id != 0', NULL, NULL, array('time'=>'DESC'), ['offset' => $start, 'rows' => $limit]);
	$config = [
		'total' => $total,
		'limit' => $limit
	];
	$data = [];
	if ($total >= $limit) {
		$pagination = new Pagination($config);
		$data['page_list'] = '<ul class="pagination pagination-v4 pull-right">'.$pagination->getPagination().'</ul>';
	}
	$thisManga = $huy->addSlashes($h0manga->manga_info('id', $manga));
	$result = $db->Query(APP_TABLES_PREFIX. 'manga_groups', 'user', array('id'=>$thisManga['group_uploader']));
	$row = explode(',', $result[0]['user']);

	foreach ($query as $thisComment) {
		$thiscComment['content'] = str_replace('script','',$thiscComment['content']);
		$thiscComment['content'] = str_replace('popcash','',$thiscComment['content']);
		$thiscComment['content'] = str_replace('document.createElement','',$thiscComment['content']);
		$thiscComment['content'] = str_replace('document.getElement','',$thiscComment['content']);
		$thiscComment['content'] = str_replace('atob','',$thiscComment['content']);
		$User = $user->info_user($thisComment['user_id']);
		if ($User['role'] == 2) {
			$admin = 'admin';
		} else {
			$admin = '';
		}
		$poster = '';
		if ($User['id'] === $thisManga['submitter']) {
			$poster = '<button class="btn btn-danger btn-xss">Poster</button>';
		} elseif ($thisManga['group_uploader'] > 0 && array_search($User['id'], $row) !== NULL) {
			$poster = '<button class="btn btn-success btn-xss">Uploader</button>';
		} elseif ($User['role'] == 3) {
			$poster = '<button class="btn btn-success btn-xss">Mod</button>';
		}
		$poster .=  $thisComment['chapter'] ? '<a class="btn btn-default btn-xss" href="/'.$thisComment['manga'].'/'.$thisComment['chapter_id'].'/">Chapter '.$thisComment['chapter'].'</a>' : '';
		$data['comment_list'] .= '<div id="comment_' .$thisComment['id']. '">
		<div class="col-md-12 col-sm-12 cm-body">
		<div class="avatar">
		<a href="/ucp"><img class="avatar1" src="/'.$avtFolder.$User['avatar'].'" alt="Avatar"/></a>
		<div class="user-info user'.$thisComment['id'].' hidden" data-id="'.$User['id'].'">'.$User['name'].'</div>
		</div>
		<div class="panel panel-default arrow left">
		<div class="panel-body comment-body">
		<header>
		<a href="/ucp" class="comment-user '.$admin.'"><i class="glyphicon glyphicon-user"></i> '.$User['name'].'</a> '.$poster.'
		<time class="text-muted" datetime="'.$thisComment['time'].'">'.$huy->ago($thisComment['time']).'</time>
		</header>
		<div class="comment-post" data-id="'.$thisComment['id'].'">'.$thisComment['content'].'</div>';

		$data['comment_list'] .= '</div>
		</div>
		</div>
		</div>
		<div class="clearfix"></div>
		</div>';

		$query1 = $db->Query(APP_TABLES_PREFIX. 'manga_comments', '*', array('manga'=>$manga, 'c_id'=>$thisComment['id']), NULL, NULL, array('time'=>'ASC'), NULL);

		foreach ($query1 as $thiscComment) {
			$thiscComment['content'] = str_replace('script','',$thiscComment['content']);
			$thiscComment['content'] = str_replace('popcash','',$thiscComment['content']);
			$thiscComment['content'] = str_replace('document.createElement','',$thiscComment['content']);
			$thiscComment['content'] = str_replace('document.getElement','',$thiscComment['content']);
			$thiscComment['content'] = str_replace('atob','',$thiscComment['content']);
			$c_User = $user->info_user($thiscComment['user_id']);
			if ($c_User['role'] == 2) {
				$admin = 'admin';
			} else {
				$admin = '';
			}
			$poster = '';
			if ($c_User['id'] === $thisManga['submitter']) {
				$poster = '<button class="btn btn-danger btn-xss">Poster</button>';
			} elseif ($thisManga['group_uploader'] > 0 && array_search($User['id'], $row) !== NULL) {
				$poster = '<button class="btn btn-success btn-xss">Uploader</button>';
			} elseif ($c_User['role'] == 3) {
				$poster = '<button class="btn btn-success btn-xss">Mod</button>';
			}
			$poster .=  $thisComment['chapter'] ? '<a class="btn btn-default btn-xss" href="/'.$thisComment['manga'].'/'.$thisComment['chapter_id'].'/">Chapter '.$thisComment['chapter'].'</a>' : '';
			if ($thiscComment > 0) {
				$data['comment_list'] .= '<div class="chil_comment" id="comment_' .$thiscComment['id']. '">
				<div class="col-md-12 col-sm-12 cm-body">
				<div class="avatar">
				<a href="/ucp"><img class="avatar1" src="/'.$avtFolder.$c_User['avatar'].'" alt="Avatar"/></a>
				<div class="user'.$thiscComment['id'].' hidden" data-id="'.$c_User['id'].'">'.$c_User['name'].'</div>
				</div>
				<div class="panel panel-default arrow left">
				<div class="panel-body comment-body">
				<header>
				<a href="/ucp" class="comment-user '.$admin.'"><i class="glyphicon glyphicon-user"></i> '.$c_User['name'].'</a> '.$poster.'
				<time class="text-muted" datetime="'.$thiscComment['time'].'">'.$huy->ago($thiscComment['time']).'</time>
				</header>
				<div class="comment-post"  data-id="'.$thiscComment['id'].'">'.$thiscComment['content'].'</div>';

				$data['comment_list'] .= '</div>
				</div>
				</div>
				<div class="clearfix"></div>
				</div>
				';
			}
		}
	}
	echo json_encode($data);
}