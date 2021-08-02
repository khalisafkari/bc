<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=$c_manga['manga_title']?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="<?php echo $thisTheme['charset']; ?>">
  <meta name="description" content="<?=$c_manga['manga-meta-description']?>">
  <meta name="keywords" content="<?=$c_manga['manga-meta-keyword']?>">
  <meta name="author" content="<?=$c_manga['rel_author']?>">
  <meta property="fb:app_id" content="<?=$c_manga['fb_app']?>" />
  
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/default/assets/css/<?=$thisTheme['skin']?>.css" media="screen">
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/default/assets/css/rating.css" media="screen">
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/default/assets/css/jquery.smartsuggest.css" />
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/default/assets/css/base.css" media="screen">
  <link href="/favicon.ico" rel="icon" type="image/vnd.microsoft.icon">
  <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <link href="/favicon.ico" rel="icon" type="image/x-icon">
  
  <script src="/app/manga/themes/default/assets/js/tinymce/tinymce.min.js"></script>
  <script src="/app/manga/themes/default/assets/js/jquery.min.js"></script>

  <?php include 'views/customJsCSS.php'; ?>
<script type="text/javascript">
        var siteURL = "<?=DOMAIN?>";
        var ttazPage = "manga";
        var userName = "<?=$_SESSION['userName']?>";
        var userId = "<?=$_SESSION['userId']?>";
    </script>
    <script src="/app/manga/themes/default/assets/js/comment.js"></script>
</head>
<body>

  <?php include ROOT_DIR.'/app/manga/themes/default/views/navbar.php'; ?>

  <div class="container manga">
   <div class="col-lg-8 col-sm-8 info-manga">
   <?php include ROOT_DIR.'/app/manga/themes/default/widgets/manga.content.seo_manga.php'; ?>
   <div class="well well-sm">
    <?php include ROOT_DIR.'/app/manga/themes/default/views/manga.content.php'; ?>
    <?php include ROOT_DIR.'/app/manga/themes/default/views/manga.comment.php'; ?>
  </div>
   </div>
   
  <div class="col-lg-4 col-sm-4">
    <?php include ROOT_DIR.'/app/manga/themes/default/views/manga.sidebar.php'; ?>
  </div>
</div>

<div class="end">      
  <?php include ROOT_DIR.'/app/manga/themes/default/views/footer.php'; ?>
</div> 
<style>
  tr>td>a.chapter:visited {
    color: #772953;
  }
</style>
<script src="/app/manga/themes/default/assets/js/bootstrap.min.js"></script>
<script src="/app/manga/themes/default/assets/js/tinymce/tinymce.min.js"></script>
<script src="/app/manga/themes/default/assets/js/rating.js"></script>
<script src="/app/manga/themes/default/assets/js/function.js"></script>
</body>
</html>

