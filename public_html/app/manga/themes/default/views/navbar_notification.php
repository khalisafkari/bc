<?php 
$c_noti = $db->Query(APP_TABLES_PREFIX.'manga_notification', 'count(id) as count', array('see'=>0, 'user'=>$_SESSION['userId']));
$query_noti = $db->Query(APP_TABLES_PREFIX.'manga_notification', '*', array('user'=>$_SESSION['userId']),NULL,NULL,array('time'=>'DESC'),NULL);
?>
<li role="presentation" class="now dropdown">
  <a href="#" class="dropdown-toggle info-number icon-noti" data-toggle="dropdown" aria-hidden="false">
    <span class="glyphicon glyphicon-globe" style="font-size: 18px"></span>
    <? if ($c_noti[0]['count']) { ?>
    <span class="badge bg-green"><?=$c_noti[0]['count']?></span>
    <? } ?>
  </a>
  <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
    <header>
    <?=$_SESSION['userName']?>
      <a id="view-all" href="/quan-ly/thong-bao.html">View all</a>
      <a id="tickAll">Mark all</a>
    </header>
    <div class="scroll-noti">

    </div>
    <div class="text-center footerNoti">
    <a href="/quan-ly/thong-bao.html">View all</a>
    </div>
    </ul>

</li>