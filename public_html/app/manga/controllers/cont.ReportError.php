<?php
include '../../../controllers/cont.main.php';

// Kiểm tra xem các thông tin càn thiết có được PÓT lên không?
if ($_POST['mid'] && $_POST['content'] && $_POST['cid'] && MANGA) {

	// Loại bỏ tấn tông sql và xss
	$_POST = $huy->addSlashes($huy->stripSlashes($_POST));

	
	// Check xem báo lỗi đã được đọc chưa?
	if (!$huy->isExist(APP_TABLES_PREFIX. 'manga_notification', 'id', array('cid'=>$_POST['cid'], 'see'=>0))) {

		// lấy ra thông tin truyện
		$thisManga = $huy->addSlashes($h0manga->manga_info('id', $_POST['mid']));

		// Lấy ra thông tin chapter
		$thisChapter = $h0manga->chapter_info('id', $_POST['cid']);
		$_POST['content'] = sprintf($lang['noti-report-error'], $thisChapter['chapter'], $thisManga['name'], $_POST['content']);
		// Khởi tạo url đến chapter lỗi
		//$url = '/'.$lang['read_slug'].'-'.$thisManga['slug'].'-'.$lang['chapter_slug'].'-'.$thisChapter['chapter'].'.html';
		$url = '/'.$_POST['mid'].'/'.$_POST['cid'].'/';	
		// Kiểm tra xem truyện có thuộc nhóm uplaod trên site không? Và gửi thông báo cho thành viên nhóm
		if ($thisManga['group_uploader'] != 0) {

			// Lấy danh sách thành viên có trong nhóm
			$thisGroup = $h0manga->group_info($thisManga['group_uploader']);
			$User = explode(',', $thisGroup['user']);
			foreach ($User as $Mem) {
				// Lặp ra từng thành viên và gửi cho tất cả thông báo lỗi
				$db->Create(APP_TABLES_PREFIX.'manga_notification', array('type'=>1,'mid'=>$_POST['mid'],'cid'=>$_POST['cid'],'name'=>$thisManga['name'],'slug'=>$thisManga['slug'],'url'=>$url, 'chapter'=>$thisChapter['chapter'], 'group_uploader'=>$thisManga['group_uploader'], 'content'=>$_POST['content'], 'user'=>$Mem, 'time'=>$now));
			}

			// Kiểm tra Admin xem có trong nhóm upload hoặc là người đăng truyện hay không
			if ($thisManga['submitter'] != 1 && array_search('1', $User) === NULL) {

				// Nếu Admin không phải người đăng + không có trong nhóm đã đăng thì gửi cho admin 1 thông báo lỗi
				$db->Create(APP_TABLES_PREFIX.'manga_notification', array('type'=>1,'mid'=>$_POST['mid'],'cid'=>$_POST['cid'],'name'=>$thisManga['name'],'slug'=>$thisManga['slug'],'url'=>$url, 'chapter'=>$thisChapter['chapter'], 'group_uploader'=>$thisManga['group_uploader'], 'content'=>$_POST['content'], 'user'=>'1', 'time'=>$now));
			}
		} else {
			// Ngược lại nếu truyện không phải 1 nhóm upload đăng lên
			if ($thisManga['submitter'] != 1) {

				// Kiểm tra xem người đăng có phải admin không. Nếu không thì gửi cho 1 thông báo
				$db->Create(APP_TABLES_PREFIX.'manga_notification', array('type'=>1,'mid'=>$_POST['mid'],'cid'=>$_POST['cid'],'name'=>$thisManga['name'],'slug'=>$thisManga['slug'],'url'=>$url, 'chapter'=>$thisChapter['chapter'], 'group_uploader'=>$thisManga['group_uploader'], 'content'=>$_POST['content'], 'user'=>'1', 'time'=>$now));
			}
			// Và tất nhiên trường hợp cuối cùng là gửi thông báo cho user đăng truyện rồi ^^!
			$db->Create(APP_TABLES_PREFIX.'manga_notification', array('type'=>1,'mid'=>$_POST['mid'],'cid'=>$_POST['cid'],'name'=>$thisManga['name'],'slug'=>$thisManga['slug'],'url'=>$url, 'chapter'=>$thisChapter['chapter'], 'group_uploader'=>$thisManga['group_uploader'], 'content'=>$_POST['content'], 'user'=>$thisManga['submitter'], 'time'=>$now));
		}

		// Đố các bạn biết echo cái 3 chấm này ra làm gì =))
		echo '...';
	}
	
}
?>