<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=$title?><?=$_GET['page'] ? ' trang '. $_GET['page'] : ''?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="<?php echo $thisTheme['charset']; ?>">
  <meta name="description" content="<?=$desc?>">
  <meta name="keywords" content="<?=$keywords?>">
  <meta name="author" content="<?=$c_manga['rel_author']?>">

  <link rel="stylesheet" type="text/css" href="/app/manga/themes/default/assets/css/pace.min.css">
  <link rel="stylesheet" type="text/css" href="app/manga/themes/default/assets/css/jquery.smartsuggest.css" />
  <link rel="stylesheet" href="/app/manga/themes/default/assets/css/<?=$thisTheme['skin']?>.css" media="screen">
  <link rel="stylesheet" href="/app/manga/themes/default/assets/css/base.css" media="screen">

  <link href="/favicon.ico" rel="icon" type="image/vnd.microsoft.icon">
  <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <link href="/favicon.ico" rel="icon" type="image/x-icon">

  <script src="/app/manga/themes/default/assets/js/jquery.min.js"></script>

  <?php include 'views/customJsCSS.php'; ?>

   <script type="text/javascript">
        var siteURL = "<?=DOMAIN?>";
        var ttazPage = "list";
        var userName = "<?=$_SESSION['userName']?>";
        var userId = "<?=$_SESSION['userId']?>";
    </script>

  <style>
    .none {
      display: none;
      opacity: 0;
    }
  </style>
</head>
<body>

 <?php 

 $listType = isset($_GET['listType']) ? $_GET['listType'] : $thisTheme['listType'];
        // NAVBAR
 include ROOT_DIR.'/app/manga/themes/default/views/navbar.php';

        // BODY
 echo '<div class="container list">';
            // CONTENT
 if ($_GET['act'] == 'search') {
   include ROOT_DIR.'/app/manga/themes/default/widgets/list.searchAdvenced.php';
   echo '<div class="col-md-4">';
   include ROOT_DIR.'/app/manga/themes/default/widgets/manga.sidebar.topAll.php';
   include ROOT_DIR.'/app/manga/themes/default/widgets/manga.sidebar.list_genres.php';
   echo '</div>';
 } else {
   include ROOT_DIR.'/app/manga/themes/default/widgets/list.'.$listType.'.php';
 }
echo '<div class="clearfix visible-xs visible-lg visible-md"></div>';
echo '</div>';
echo '</div>';
echo '<div class="end">';
include ROOT_DIR.'/app/manga/themes/default/views/footer.php';
echo '</div>';  

?>
  <script src="/app/manga/themes/default/assets/js/bootstrap.min.js"></script>
  <script src="/app/manga/themes/default/assets/js/jquery.mixitup.js"></script>
  <script src="/app/manga/themes/default/assets/js/function.js"></script>
</body>
</html>

