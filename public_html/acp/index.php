<?php
if(!isset($view) && !isset($app_view)){ header("Location: index.php"); }

?>
<!DOCTYPE html>
<html lang="en">
<head><meta http-equiv="Content-Type" content="text/html">
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="author" content="Huy Khong">

  <title><?=$title?> <?php echo isset($subtitle) ? $subtitle : ''; ?></title>

  <!-- Bootstrap core CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="assets/css/signin.css" rel="stylesheet">
  <link href="assets/css/custom.css" rel="stylesheet">
  <link href="assets/css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
  <link href="assets/js/jtable/themes/lightcolor/blue/jtable.css" rel="stylesheet" type="text/css" />
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
  <link href="assets/css/uploadifive.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/css/bootstrap-dialog.min.css"> 

  <script type="text/javascript" language="javascript" src="assets/js/jquery-2.1.3.min.js"></script>
  <script type="text/javascript" language="javascript" src="assets/js/tinymce/tinymce.min.js"></script>
  <script src="assets/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
  <script type="text/javascript" language="javascript" src="assets/js/jquery.form.js"></script>
  <script type="text/javascript" language="javascript" src="assets/js/bootstrap.min.js"></script>
  <script src="assets/js/jtable/jquery.jtable.js" type="text/javascript"></script>
  <script src="assets/js/jquery.textareaCounter.plugin.js" type="text/javascript"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
  <script src="assets/js/jquery.uploadifive.js" type="text/javascript"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap3-dialog/1.34.7/js/bootstrap-dialog.min.js"></script>  
  <script src="assets/js/acp.js" type="text/javascript"></script>
   <script type="text/javascript">
        var siteURL = "<?=DOMAIN?>";
        var ttazPage = "acp";
        var userName = "<?=$_SESSION['userName']?>";
        var userId = "<?=$_SESSION['userId']?>";
    </script>
</head>

<body>

  <? if(!($user->isAdmin() || $user->isMod())){ header('Location: ../ucp/'); exit; } ?>

  <div class="container-fluid">
   <? include 'views/sidebar.php'; ?>
   <? if(isset($view)){ include 'views/'.$view.'.php'; } ?>
   <? if(isset($app_view)){ include ROOT_DIR.'/app/'.$app.'/acp/views/'.$app_view.'.php'; } ?>
 </div> <!-- /container -->
 
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
  </html>
