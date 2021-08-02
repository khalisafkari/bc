<?
	include '../../../controllers/cont.main.php';
    header('Content-Type: text/html; charset='.$thisTheme['charset']);
	if(isset($_POST)){
		$result = $db->Query(APP_TABLES_PREFIX.' manga_mangas', '*', array('slug'=>$_POST['slug']),NULL,NULL,NULL,1);
		$row = $result[0];
 		$description = strip_tags(stripslashes(substr($row['description'], 0, 200))).'....';
 		$popover = "<div style='float:right; text-align:right; width: 670px;direction:rtl;'>
	                <img class='img-thumbnail lazy' style='float:right; width:150px; margin: 10px' src='$row[cover]'>
	                <small>$row[other_name]<br />
	                <strong>Authors</strong>: $row[authors] <br />
	                <strong>Artists</strong>: $row[artists]  <br />
	                <strong >Genres</strong>: $row[genres] <br />
	                <blockquote>$description</blockquote>
	                </small>
	              </div>";
	    }