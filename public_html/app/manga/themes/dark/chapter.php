<!DOCTYPE html>
<html lang="en">
<head>
    <title><?=$c_manga['chapter_title']?></title>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=0" />
    <meta charset="<?php echo $thisTheme['charset']; ?>">
    <meta name="description" content="<?=$c_manga['chapter-meta-description']?>">
    <meta name="keywords" content="<?=$c_manga['chapter-meta-keyword']?>">
    <meta name="author" content="<?=$c_manga['rel_author']?>">
    <meta property="fb:app_id" content="<?=$c_manga['fb_app']?>" />
    
    <link rel="stylesheet" href="/app/manga/themes/dark/assets/css/<?=$thisTheme['skin']?>.css" media="screen">
    <link rel="stylesheet" type="text/css" href="/app/manga/themes/dark/assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="/app/manga/themes/dark/assets/css/base.css?v=1.5" media="screen">
    <link rel="stylesheet" href="/app/manga/themes/dark/assets/css/chapter.css" media="screen">
    <link rel="stylesheet" href="/app/manga/themes/dark/assets/css/idangerous.swiper.css" media="screen">
    
    <link href="/favicon.ico" rel="icon" type="image/vnd.microsoft.icon">
    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="/favicon.ico" rel="icon" type="image/x-icon">
    
    <!-- cdnjs -->
    <script src="https://cdn.jsdelivr.net/npm/js-base64@3.6.0/base64.min.js"></script>

    <script src="/app/manga/themes/dark/assets/js/jquery.min.js"></script>
    <script src="/app/manga/themes/dark/assets/js/idangerous.swiper-2.1.min.js"></script>
    <script src="/app/manga/themes/dark/assets/js/tinymce/tinymce.min.js"></script>
    <script src="/app/manga/themes/dark/assets/js/comment.js?v=1.5"></script>
	<script src="/app/manga/lazysizes/lazysizes.min.js" async=""></script>
	
	    <!-- Insert in <HEAD> TAG Tri-table-->
     <script async src="https://a.spolecznosci.net/core/399f019c46e791a270e583325f93ac74/main.js"></script>
	
     <?php 
		include 'views/customJsCSS.php'; 
		//include ROOT_DIR.'/app/manga/themes/dark/views/head.tag.php'; 
		//include ROOT_DIR.'/app/manga/themes/dark/ads/chapter/auto.php'; 
		//include ROOT_DIR.'/app/manga/themes/dark/ads/chapter/dynamic.php'; 
	 ?>
     <script type="text/javascript">
        var siteURL = "<?=DOMAIN?>";
        var ttazPage = "chapter";
        var userName = "<?=$_SESSION['userName']?>";
        var userId = "<?=$_SESSION['userId']?>";
    </script>
</head>
<body>

    <?php 

        // NAVBAR
    include ROOT_DIR.'/app/manga/themes/dark/views/chapter.navbar.php';

        // BODY

            // CONTENT
    include ROOT_DIR.'/app/manga/themes/dark/views/chapter.content.before.php';
    include ROOT_DIR.'/app/manga/themes/dark/views/chapter.content.php';

		//Ads Video
    //include ROOT_DIR.'/app/manga/themes/dark/ads/chapter/videoads.php';
    ?>
    <script src="/app/manga/themes/dark/assets/js/bootstrap.min.js"></script>
    <script src="/app/manga/themes/dark/assets/js/function.js?v=1.3"></script>

    <!-- Insert before end of <BODY> TAG -->
      <script type="text/javascript">
        var _qasp = _qasp || [];
        _qasp.push(['setPAID']);
    </script>
	<script>
		function aload(t){"use strict";var e="data-aload";return t=t||window.document.querySelectorAll("["+e+"]"),void 0===t.length&&(t=[t]),[].forEach.call(t,function(t){t["LINK"!==t.tagName?"src":"href"]=t.getAttribute(e),t.removeAttribute(e)}),t}
				window.onload = function () {
		  aload();
		};
	</script>

</body>
</html>

