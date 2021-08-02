		<?php

			
        $WHERE = NULL;
        $cache = 'list_abc';
        $artist = isset($_GET['artist']) ? addslashes($_GET['artist']) : NULL;
        if(isset($artist)){ $WHERE = "AND artists LIKE '%".$artist."%'"; $cache = 'list_'.$artist; }
        $author = isset($_GET['author']) ? addslashes($_GET['author']) : NULL;
        if(isset($author)){ $WHERE = "AND authors LIKE '%".$author."%'"; $cache = 'list_'.$author; }
        $group = isset($_GET['group']) ? addslashes($_GET['group']) : NULL;
        if(isset($group)){ $WHERE = "AND trans_group LIKE '%".$group."%'"; $cache = 'list_'.$group; }
        $genre = isset($_GET['genre']) ? addslashes($_GET['genre']) : NULL;
        if(isset($genre)){ $WHERE = "AND genres LIKE '%".$genre."%'"; $cache = 'list_'.$genre; }
        $m_status = isset($_GET['m_status']) ? (int)$_GET['m_status'] : NULL;
			$WHERE = isset($_GET['m_status']) ? "AND m_status = '".$m_status."' ": NULL;


		?>
		<div class="btn-group btn-block">
		    <button class="btn btn-sm btn-info" disabled><?=$lang['STYLE-LIST']?></button>
		    <a href="manga-list.html?listType=allABC" class="btn btn-sm btn-info <?php echo $listType == 'allABC' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-th"></i> <?=$lang['ALL-IN-ONE-PAGE']?></a>
		    <a href="manga-list.html?listType=pagination" class="btn btn-sm btn-info <?php echo $listType == 'pagination' ? 'active' : ''; ?>"><i class="glyphicon glyphicon-th-list"></i> <?=$lang['PAGINATION']?></a>
		</div>
		<div class="btn-group btn-block">
		    <button class="filter btn btn-sm btn-primary" disabled>Pass the first character</button>
		    <button class="filter btn btn-sm btn-danger" data-filter="all">All</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_special">#</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_a">A</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_b">B</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_c">C</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_d">D</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_e">E</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_f">F</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_g">G</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_h">H</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_i">I</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_j">J</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_k">K</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_l">L</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_m">M</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_n">N</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_o">O</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_p">P</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_q">Q</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_r">R</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_s">S</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_t">T</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_u">U</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_v">V</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_w">W</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_x">X</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_y">Y</button>
		    <button class="filter btn btn-sm btn-primary" data-filter="c_z">Z</button>
		</div>

			<script>
			$(function(){
	     		$('#Character').mixitup({
				    targetSelector: '.char',
				    filterSelector: '.filter',
				    sortSelector: '.sort',
				    buttonEvent: 'click',
				    effects: ['fade','scale'],
				    listEffects: null,
				    easing: 'smooth',
				    layoutMode: 'grid',
				    targetDisplayGrid: 'inline-block',
				    targetDisplayList: 'block',
				    gridClass: '',
				    listClass: '',
				    transitionSpeed: 600,
				    showOnLoad: 'all',
				    sortOnLoad: false,
				    multiFilter: false,
				    filterLogic: 'or',
				    resizeContainer: true,
				    minHeight: 0,
				    failClass: 'fail',
				    perspectiveDistance: '3000',
				    perspectiveOrigin: '50% 50%',
				    animateGridList: true,
				    onMixLoad: null,
				    onMixStart: null,
				    onMixEnd: null
				});
			});
			</script>
			

	<div class="row">
	 	

	<div id="Character">

	<!-- NUMBER AND SPECIAL CHARACTER -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_special">
		<h3>#</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name NOT REGEXP '^[[:alpha:]]' ".$WHERE." AND hidden = '0' ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- A -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_a">
		<h3>A</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'A%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- B -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_b">
		<h3>B</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'B%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>


	<!-- C -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_c">
		<h3>C</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'C%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- D -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_d">
		<h3>D</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'D%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- E -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_e">
		<h3>E</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'E%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- F -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_f">
		<h3>F</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'F%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- G -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_g">
		<h3>G</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'G%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- H -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_h">
		<h3>H</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'H%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- I -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_i">
		<h3>I</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'I%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- J -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_j">
		<h3>J</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'J%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- K -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_k">
		<h3>K</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'K%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>

	</div>

	<!-- L -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_l">
		<h3>L</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'L%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- M -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_m">
		<h3>M</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'M%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- N -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_n">
		<h3>N</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'N%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- O -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_o">
		<h3>O</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'O%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- P -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_p">
		<h3>P</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'P%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- Q -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_q">
		<h3>Q</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'Q%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- R -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_r">
		<h3>R</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'R%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- S -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_s">
		<h3>S</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'S%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- T -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_t">
		<h3>T</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'T%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- U -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_u">
		<h3>U</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'U%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- V -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_v">
		<h3>V</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'V%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- W -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_w">
		<h3>W</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'W%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- X -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_x">
		<h3>X</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'X%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- Y -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_y">
		<h3>Y</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'Y%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	<!-- Z -->
	<div class="char col-lg-4 col-sm-6 .col-xs-12 none c_z">
		<h3>Z</h3>
		<hr>
		<? 
			$list = @mysqli_query($db->Connect(),"SELECT name,slug,m_status FROM ".APP_TABLES_PREFIX."manga_mangas WHERE name LIKE 'Z%' ".$WHERE." AND hidden = 0 ORDER BY name ASC");
			while($row = @mysqli_fetch_array($list)){
				echo '<span data-toggle="mangapop" manga-slug="'.$row['slug'].'" data-placement="top" data-original-title="'.$row['name'].'" class="manga-'.$row['m_status'].'"><b><a href="'.$lang['manga_slug'].'-'.$row['slug'].'.html">'.$row['name'].'</a></b></span>';     
				echo '<br />';
			}
		?>
	</div>

	</div>

	<script>
	</script>