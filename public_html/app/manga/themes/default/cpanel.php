<?php
if(!$user->isLoggedIn()){
	header('Location: ../ucp');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title><?=$c_manga['list_title']?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta charset="<?php echo $thisTheme['charset']; ?>">
  <meta name="description" content="<?=$c_manga['list-meta-description']?>">
  <meta name="keywords" content="<?=$c_manga['list-meta-keyword']?>">
  <meta name="author" content="<?=$c_manga['rel_author']?>">
  <link href="/acp/assets/css/redmond/jquery-ui-1.8.16.custom.css" rel="stylesheet" type="text/css" />
  <link href="/acp/assets/js/jtable/themes/lightcolor/orange/jtable.min.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/default/assets/css/pace.min.css">
  <link rel="stylesheet" href="/app/manga/themes/default/assets/css/<?=$thisTheme['skin']?>.css" media="screen">
  <link rel="stylesheet" href="/app/manga/themes/default/assets/css/messenger.css" media="screen">
  <link rel="stylesheet" href="/app/manga/themes/default/assets/css/messenger-theme-<?=$thisTheme['noti']?>.css" media="screen">
  <link rel="stylesheet" type="text/css" href="/app/manga/themes/default/assets/css/jquery.smartsuggest.css" />
  <link rel="stylesheet" href="/app/manga/themes/default/assets/css/cpanel.css" media="screen">
  <link href="/favicon.ico" rel="icon" type="image/vnd.microsoft.icon">
  <link href="/favicon.ico" rel="shortcut icon" type="image/x-icon">
  <link href="/favicon.ico" rel="icon" type="image/x-icon">

  <script src="/app/manga/themes/default/assets/js/jquery.min.js"></script>
  <script src="/acp/assets/js/jquery-ui-1.10.3.custom.min.js" type="text/javascript"></script>
  <script src="/acp/assets/js/tinymce/tinymce.min.js" type="text/javascript"></script>
  <script src="/acp/assets/js/jtable/jquery.jtable.min.js" type="text/javascript"></script>
  <script src="/app/manga/themes/default/assets/js/bootstrap.min.js"></script>
  <script src="/app/manga/themes/default/assets/js/pace.min.js"></script>
  <script src="/app/manga/themes/default/assets/js/jquery.form.js"></script>
  <script src="/app/manga/themes/default/assets/js/jquery.smartsuggest.js"></script>
  <script src="/app/manga/themes/default/assets/js/messenger.min.js"></script>
  <script src="/app/manga/themes/default/assets/js/messenger-theme-future.js"></script>
  <script src="/app/manga/themes/default/assets/js/jquery.base64.js"></script>
  <script src="/app/manga/themes/default/assets/js/headroom.min.js"></script>
  <script src="/app/manga/themes/default/assets/js/jquery.headroom.js"></script>
    <script type="text/javascript">
        var siteURL = "<?=DOMAIN?>";
        var ttazPage = "cpanel";
        var userName = "<?=$_SESSION['userName']?>";
        var userId = "<?=$_SESSION['userId']?>";
    </script>
</head>
<body>
  <script type="text/javascript">
  // Tinymce setup
  tinymce.init({
    selector: 'textarea.tiny',
    language : 'vi_VN',
    entity_encoding: "raw",
    oninit: "setPlainText",
    height: 300,
    theme: 'modern',
    menubar: false,
    plugins: [
    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
    'searchreplace wordcount visualblocks visualchars code fullscreen',
    "emoyahoo, emobabysoldier, emoonion, media, emobafu, emothobua, emothotuzki, emoyoyo, emopanda, emotrollface",
    'insertdatetime media nonbreaking save table contextmenu directionality',
    'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc help'
    ],
    toolbar1: 'undo redo | insert styleselect | bold italic | alignleft aligncenter | alignright alignjustify | bullist numlist | link image',
    toolbar2: 'preview media | forecolor backcolor | emoonion emobafu | emothobua emothotuzki | emoyoyo emopanda | emotrollface emobabysoldier | emoyahoo',
    image_advtab: true,
    setup: function (ed) {
      ed.on('change', function (e) {
        tinyMCE.triggerSave();
        $('textarea#description').valid();  
      });
    },
    paste_auto_cleanup_on_paste: true,
    force_br_newlines: true,
    force_p_newlines: false,
    save_onsavecallback: 'onSavePluginCallback',
  });
</script>
<?php include ROOT_DIR.'/app/manga/themes/default/views/navbar.php'; ?>

<?php  include ROOT_DIR.'/app/manga/themes/default/views/header.php'; ?>
<div class="container">
  <div class="col-lg-12">
    <?php include ROOT_DIR.'/app/manga/themes/default/cpanel/index.php';  ?>	
    <div class="clearfix visible-xs visible-lg visible-md"></div>
  </div>
</div>
<div class="end">
 <?php  include ROOT_DIR.'/app/manga/themes/default/views/footer.php'; ?>
</div>

<?php include 'views/notification.php'; ?>
<script>
  $(document).ready(function() {
    $('#search').smartSuggest({
      src: '/app/manga/controllers/search.single.php'
    });
  });

</script>
<script src="/app/manga/themes/default/assets/js/function.js"></script>
</body>
</html>

