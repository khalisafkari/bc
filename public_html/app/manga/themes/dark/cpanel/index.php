<?php	

include ROOT_DIR.'/app/manga/themes/dark/cpanel/views/cpanel.navbar.php';
$cpanel = isset($_GET['cpanel']) ? $_GET['cpanel'] : '';
switch ($cpanel) {
        case "upload-manga": include_once ROOT_DIR."/app/manga/themes/dark/cpanel/views/cpanel.add_manga.php";
        break;
        case "upload-chapter": include_once ROOT_DIR."/app/manga/themes/dark/cpanel/views/cpanel.add_chapter.php";
        break;
        case "manga-bookmark": include_once ROOT_DIR."/app/manga/themes/dark/cpanel/views/cpanel.bookmark.php";
        break;
        case "list-manga": include_once ROOT_DIR.'/app/manga/themes/dark/cpanel/views/cpanel.list_manga.php';
        break;
        case "list-manga-group": include_once ROOT_DIR.'/app/manga/themes/dark/cpanel/views/cpanel.list_manga_group.php';
        break;
        case "list-chapter" : include_once ROOT_DIR.'/app/manga/themes/dark/cpanel/views/cpanel.list_chapter.php'; 
        break;
        case "edit-manga" : include_once ROOT_DIR.'/app/manga/themes/dark/cpanel/views/cpanel.edit_manga.php'; 
        break;
        case "edit-chapter" : include_once ROOT_DIR.'/app/manga/themes/dark/cpanel/views/cpanel.edit_chapter.php'; 
        break;
        case "notification" : include_once ROOT_DIR.'/app/manga/themes/dark/cpanel/views/cpanel.noti.php'; 
        break;
        default : include_once ROOT_DIR.'/app/manga/themes/dark/cpanel/views/cpanel.bookmark.php';
}