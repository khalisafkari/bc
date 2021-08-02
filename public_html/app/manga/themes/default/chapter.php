<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?=$c_manga['chapter_title']?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="<?php echo $thisTheme['charset']; ?>">
    <meta name="description" content="<?=$c_manga['chapter-meta-description']?>">
    <meta name="keywords" content="<?=$c_manga['chapter-meta-keyword']?>">
    <meta name="author" content="<?=$c_manga['rel_author']?>">
    <meta property="fb:app_id" content="<?=$c_manga['fb_app']?>" />
    
    <link rel="stylesheet" href="/app/manga/themes/default/assets/css/<?=$thisTheme['skin']?>.css" media="screen">
    <link rel="stylesheet" href="/app/manga/themes/default/assets/css/base.css" media="screen">
    <link rel="stylesheet" href="/app/manga/themes/default/assets/css/chapter.css" media="screen">
    <link rel="stylesheet" href="/app/manga/themes/default/assets/css/idangerous.swiper.css" media="screen">
    
    <link href="/favicon.ico" rel="icon" type="image/vnd.microsoft.icon">
    <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
    <link href="/favicon.ico" rel="icon" type="image/x-icon">
    
    
    <script src="/app/manga/themes/default/assets/js/jquery.min.js"></script>
    <script src="/app/manga/themes/default/assets/js/idangerous.swiper-2.1.min.js"></script>

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
         include ROOT_DIR.'/app/manga/themes/default/views/chapter.navbar.php';

        // BODY

            // CONTENT
            include ROOT_DIR.'/app/manga/themes/default/views/chapter.content.after.php';
            include ROOT_DIR.'/app/manga/themes/default/views/chapter.content.php';
        ?>
    <script src="/app/manga/themes/default/assets/js/bootstrap.min.js"></script>
    <script src="/app/manga/themes/default/assets/js/function.js"></script>
    <script src="/app/manga/themes/default/assets/js/google-proxy.js?v=1.4"></script>
  </body>
</html>

