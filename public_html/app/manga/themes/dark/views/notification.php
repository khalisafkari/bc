<script>

  Messenger.options = {
          extraClasses: 'messenger-fixed messenger-on-top messenger-on-right',
        }

        // <? 
        // if($user->isLoggedIn()){
        // $noti = $db->Query(APP_TABLES_PREFIX.'manga_notification','id, type, message, url', array('user'=>$_SESSION['userId']));
        // if(count($noti) > 0){
        //   foreach($noti as $row){
        // ?>
        //   var msg;
        //     msg = Messenger().post({
        //       message: '<?=$row['message']?>',
        //       type: '<?=$row['type']?>',
        //       actions: {
        //         <? if($row['url'] != NULL){ ?>
        //         go: {
        //            label: '<?=$lang['Go']?>',
        //            action: function() {
        //             $.post('app/manga/controllers/cont.dellNoti.php', { id: '<?=$row['id']?>' },
        //               function(data) {
        //               });
        //              window.location.href = "<?=$row['url']?>";
        //              return msg.update({
        //               message: '<?=$lang['Redirecting']?>',
        //               type: 'success',
        //               actions: false
        //             });
        //           }
        //         },
        //         <? } ?>
        //         cancel: {
        //           label: '<?=$lang['I-know']?>',
        //           action: function() {
        //             $.post('app/manga/controllers/cont.dellNoti.php', { id: '<?=$row['id']?>' },
        //               function(data) {
        //               });
        //             return msg.hide({
        //             });
        //           }
        //         }
        //       }
        //     });
        // <?
        //     }
        //   }
        // }
        // ?>
        <? if(isset($_GET['ref']) && $_GET['ref'] == 'submit1'){ ?>
          var msg;
            msg = Messenger().post({
              message: '<?=$lang['Submit-success']?>',
              actions: {
                cancel: {
                  label: '<?=$lang['I-know']?>',
                  action: function() {
                    return msg.hide({
                    });
                  }
                }
              }
            });
        <? } ?>  

      
</script>