<?

include 'cont.main.php';

$slug = $_POST['slug'];
$slug = addslashes($slug);

if ($_POST['action'] == "show"){
	if (!isset($_SESSION['h0_ratings'])){
		$_SESSION['h0_ratings'] = array();
	}

	if (!array_key_exists($slug, $_SESSION['h0_ratings'])){
		
			$sql = "SELECT vote_count, total FROM ".APP_TABLES_PREFIX."h0_ratings WHERE slug='$slug'";
			
			$result = mysqli_query($db->Connect(),$sql);

			if (@mysqli_num_rows($result) > 0){
				$page = mysqli_fetch_object($result);
				$rating = ceil(5*($page->total/($page->vote_count*5)));
			}else{
				$rating = 0;
			}

		for ($i = 1; $i <= $rating; $i++){
			echo "<a class=\"h0_ratings_on h0_ratings_active\" href=\"javascript:\" rel=\"".$i."\"></a>";
		}
		
		for ($i = ($rating+1); $i <= 5; $i++){
			echo "<a class=\"h0_ratings_off h0_ratings_active\" href=\"javascript:\" rel=\"".$i."\"></a>";
		}
	}else{
		$rating = $_SESSION['h0_ratings'][$slug];
		
		for ($i = 1; $i <= $rating; $i++){
			echo "<a class=\"h0_ratings_on h0_ratings_inactive\" href=\"javascript:\" rel=\"".$i."\"></a>";
		}
		
		for ($i = ($rating+1); $i <= 5; $i++){
			echo "<a class=\"h0_ratings_off h0_ratings_inactive\" href=\"javascript:\" rel=\"".$i."\"></a>";
		}
	}
}

//
// Register a vote
//

else if ($_POST['action'] == "vote" && is_numeric($_POST['rating'])){
	$_SESSION['h0_ratings'][$slug] = $_POST['rating'];
		$sql = "SELECT id FROM ".APP_TABLES_PREFIX."h0_ratings WHERE slug='$slug'";
		$exists = mysqli_query($db->Connect(),$sql);
		if (@mysqli_num_rows($exists) > 0){
			$sql = "UPDATE ".APP_TABLES_PREFIX."h0_ratings SET vote_count=(vote_count+1), total=(total+'$_POST[rating]') WHERE slug='$slug'";
		}else{
			$sql = "INSERT INTO ".APP_TABLES_PREFIX."h0_ratings (vote_count, total, slug) VALUES (1, '$_POST[rating]', '$slug')";
		}
		
		mysqli_query($db->Connect(),$sql);

	for ($i = 1; $i <= $_POST['rating']; $i++){
		echo "<a class=\"h0_ratings_on h0_ratings_inactive\" href=\"javascript:\" rel=\"".$i."\"></a>";
	}
	
	for ($i = ($_POST['rating']+1); $i <= 5; $i++){
		echo "<a class=\"h0_ratings_off h0_ratings_inactive\" href=\"javascript:\" rel=\"".$i."\"></a>";
	}
}

?>