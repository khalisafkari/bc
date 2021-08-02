<?php
      // MAIN CONTROLLER
    include '../../controllers/cont.main.php';
	
		if(!$user->isLoggedIn()){
			header('Location: https:///');
		}

      // INCLUDE INDEX IN [THEME] 

    $c_manga['list_title'] = preg_replace('/{site_title}/i', $c_manga['site_title'], $c_manga['list_title']);

    if ($_GET['m_status'] == 1) {
      $status = 'Completed';
    } else if($_GET['m_status'] == 2) {
      $status = 'On going';
    } else if($_GET['m_status'] == 3) {
      $status = 'Pause';
    }

    $list_array = array(
      'genre' => $_GET['genre'],
      'status' => $status,
      'author' => $_GET['author'],
      'group' => $_GET['group']

      );
    if ($list_array['genre']) {
      $title = 'Manga List '.$list_array['genre'];
      $desc = 'Manga List Genre '.$list_array['genre'].', Manga Genre '.$list_array['genre'].', Manga '.$list_array['genre'].' | Read Manga Online LoveHug.Net';
      $keywords = 'Manga List Genre '.$list_array['genre'].', Manga '.$list_array['genre'].' Read Manga Online, Read Manga';
    }elseif ($list_array['status']) {
      $title = 'Manga List '.$list_array['status'];
      $desc = 'Manga List '.$list_array['status'].', Manga '.$list_array['status'].', Manga '.$list_array['status'].' | Read Manga Online LoveHug.Net';
      $keywords = 'Manga List '.$list_array['status'].', Manga '.$list_array['status'].' Manga '.$list_array['status'].' Read Manga Online LoveHug.Net';
    } elseif ($list_array['author']) {
     $title = 'Manga List '.$list_array['author'];
     $desc = 'Manga List of Author '.$list_array['author'].', Manga of Author '.$list_array['author'].', Manga '.$list_array['author'].' | Read Manga Online LoveHug.Net';
     $keywords = 'Manga List of Author '.$list_array['author'].', Manga of Author '.$list_array['author'].' Manga '.$list_array['author'].' Read Manga Online LoveHug.Net';
    } elseif ($list_array['group']) {
     $title = 'Manga List '.$list_array['group'];
     $desc = 'Manga List of Group '.$list_array['group'].', Manga of Group '.$list_array['group'].', Manga '.$list_array['group'].' | Read Manga Online LoveHug.Net';
     $keywords = 'Manga List of Group '.$list_array['group'].', Manga of Group '.$list_array['group'].' Manga'.$list_array['group'].' Read Manga Online LoveHug.Net';
    } else {
      $title = $c_manga['list_title'];
      $desc = $c_manga['list-meta-description'];
      $keywords = $c_manga['list-meta-keyword'];
    }
    include 'themes/'.$c_manga['theme'].'/post.php';


