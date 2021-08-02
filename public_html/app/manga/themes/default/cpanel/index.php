<?php	

include ROOT_DIR.'/app/manga/themes/default/cpanel/views/cpanel.navbar.php';
$cpanel = isset($_GET['cpanel']) ? $_GET['cpanel'] : '';
switch ($cpanel) {
        case "dang-truyen": include_once ROOT_DIR."/app/manga/themes/default/cpanel/views/cpanel.add_manga.php";
        break;
        case "dang-chuong": include_once ROOT_DIR."/app/manga/themes/default/cpanel/views/cpanel.add_chapter.php";
        break;
        case "truyen-theo-doi": include_once ROOT_DIR."/app/manga/themes/default/cpanel/views/cpanel.bookmark.php";
        break;
        case "danh-sach-truyen": include_once ROOT_DIR.'/app/manga/themes/default/cpanel/views/cpanel.list_manga.php';
        break;
        case "danh-sach-truyen-cua-nhom": include_once ROOT_DIR.'/app/manga/themes/default/cpanel/views/cpanel.list_manga_group.php';
        break;
        case "danh-sach-chuong" : include_once ROOT_DIR.'/app/manga/themes/default/cpanel/views/cpanel.list_chapter.php'; 
        break;
        case "sua-truyen" : include_once ROOT_DIR.'/app/manga/themes/default/cpanel/views/cpanel.edit_manga.php'; 
        break;
        case "sua-chuong" : include_once ROOT_DIR.'/app/manga/themes/default/cpanel/views/cpanel.edit_chapter.php'; 
        break;
        case "thong-bao" : include_once ROOT_DIR.'/app/manga/themes/default/cpanel/views/cpanel.noti.php'; 
        break;
        default : include_once ROOT_DIR.'/app/manga/themes/default/cpanel/views/cpanel.bookmark.php';
}