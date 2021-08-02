<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=$c_manga['manga_title']?></title>
  <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
      <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=0" />
  <meta charset="<?php echo $thisTheme['charset']; ?>">
  <meta name="description" content="<?=$c_manga['manga-meta-description']?>">
  <meta name="keywords" content="<?=$c_manga['manga-meta-keyword']?>">
  <meta name="author" content="<?=$c_manga['rel_author']?>">
  <meta property="fb:app_id" content="<?=$c_manga['fb_app']?>" />
  
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/dark/assets/css/<?=$thisTheme['skin']?>.css" media="screen">
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/dark/assets/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/dark/assets/css/rating.css" media="screen">
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/dark/assets/css/jquery.smartsuggest.css" />
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/dark/assets/css/base.css?v=1.6" media="screen">
  <link href="/favicon.ico" rel="icon" type="image/vnd.microsoft.icon">
  <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <link href="/favicon.ico" rel="icon" type="image/x-icon">
  
  <script src="/app/manga/themes/dark/assets/js/tinymce/tinymce.min.js"></script>
  <script src="/app/manga/themes/dark/assets/js/jquery.min.js"></script>

  <!-- Insert in <HEAD> TAG -->
  <script async src="https://a.spolecznosci.net/core/399f019c46e791a270e583325f93ac74/main.js"></script>
  
  <!--script async src="https://rtbcdn.andbeyond.media/prod-global-154348.js"></script-->

  <?php include 'views/customJsCSS.php'; ?>
  <script type="text/javascript">
    var siteURL = "<?=DOMAIN?>";
    var ttazPage = "manga";
    var userName = "<?=$_SESSION['userName']?>";
    var userId = "<?=$_SESSION['userId']?>";
  </script>
  <script src="/app/manga/themes/dark/assets/js/comment.js?v=1.5"></script>
  <!--script async src="https://storage.de.cloud.ovh.net/v1/AUTH_4b1b323ce19643f985895cf772add44b/sarsor/lovehug.js" defer></script-->
</head>
<body>

  <?php include ROOT_DIR.'/app/manga/themes/dark/views/navbar.php'; ?>

  <div class="col-md-12">
    <div class="container manga">
	<!--?php include ROOT_DIR.'/app/manga/themes/dark/ads/manga/header.php'; ?></br-->
      <div class="col-md-8 info-manga">
       <?php include ROOT_DIR.'/app/manga/themes/dark/widgets/manga.content.seo_manga.php'; ?>
       <?php include ROOT_DIR.'/app/manga/themes/dark/views/manga.content.php'; ?>
     </div>
     <div class="col-md-4">
      <?php include ROOT_DIR.'/app/manga/themes/dark/views/manga.sidebar.php'; ?>
    </div>
      <?php include ROOT_DIR.'/app/manga/themes/dark/views/home.section.php'; ?>
  </div>
</div>

<div class="col-md-12">
  <div class="container cmt">
      <?php include ROOT_DIR.'/app/manga/themes/dark/views/manga.comment.php'; ?> 
    </div>
  </div>  
</div>

<div class="end">      
  <?php include ROOT_DIR.'/app/manga/themes/dark/views/footer.php'; ?>
</div>
  <!--? include ROOT_DIR.'/app/manga/themes/dark/ads/home/sticky.php';?--> 
<style>
tr>td>a.chapter:visited {
  color: #772953;
}
</style>

<script src="/app/manga/themes/dark/assets/js/bootstrap.min.js"></script>
<script src="/app/manga/themes/dark/assets/js/rating.js"></script>
<script src="/app/manga/themes/dark/assets/js/function.js?v=1.5"></script>
</body>
</html>

