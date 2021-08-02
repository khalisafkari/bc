<?php

    if(!isset($view)){ header("Location: index.php"); }

?>
  <!-- UCP From HuyKh么ng framework -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="lovehug.net">

    <title><?=$title?></title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/signin.css" rel="stylesheet">
    <link href="assets/css/custom.css" rel="stylesheet">

    <script type="text/javascript" language="javascript" src="assets/js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" language="javascript" src="assets/js/jquery.form.js"></script>
    <script type="text/javascript" language="javascript" src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" language="javascript" src="assets/js/ucp.js"></script>
  </head>

  <body>

    <div class="container">
       <?php include 'views/'.$view.'.php'; ?>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>