<?php
if (preg_match('#(18\+|Ecchi|Adult)#is', $thisManga['genres'])) {
    if (empty($_SESSION['warning'][$thisManga['id']])) {
        ?>
        <div class="modal fade" id="modal-1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">

                        <h4 class="modal-title bold"><span style="color:red;" class ="glyphicon glyphicon-exclamation-sign"></span> Age warning</h4>
                    </div>
                    <div class="modal-body">
                        <p> The story you are about to see has sensitive content, only suitable for ages 18 and older. Please consider when continuing. </p>

                        <p class = "bold mt10"> At this page, we completely reject all influences, statutes and laws to you and to us. </p>

                        <p class = "mt10"> If it affects any individual or organization, when requested, we will consider and remove it. Wish you have comfortable moments. </p>
                                         </div>
                    <div class="modal-footer">
                        <a href="/" class="btn btn-primary"><span class="glyphicon glyphicon-home"></span> Go Back Home</a>
                        <button type="button" data-dismiss="modal" id="close" class="btn btn-warning"><span class="glyphicon glyphicon-forward"></span> I Know</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    $_SESSION['warning'][$thisManga['id']] = 1;
}
?>
<script>
    $(window).on('load',function(e){
        $('#modal-1').modal('show');
    });
    $(function () {
      $('#modal-1').modal('hide');
  });
</script>