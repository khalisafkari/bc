<br />
<div class="col-md-8">
	<div class="tab_Comment" role="tabpanel">
		<ul id="myTab" class="nav nav-tabs" role="tablist">
			<li role="presentation" class="active"><a href="#tab1" ria-controls="tab1" role="tab" data-toggle="tab">Comment Manga</a></li>
			<li role="presentation"><a href="#tab2" ria-controls="tab2"  role="tab" data-toggle="tab">Comment Chapter</a></li>
		</ul>
		<div id="myTabContent" class="tab-content">
			<div role="tabpanel" class="tab-pane fade active in" id="tab1">
				<div class="card card-dark" id="commentbox">
					<div class="card-body bg-dark">
						<?php
						if ($user->isLoggedIn()) {
							?>
							<div class="panel panel-default bgc">
								<div class="panel-body body-cmt">
									<div class="comment">
										<form method="POST" role="form" class="formComment" id="formComment">
											<div class="form-group">
												<textarea id="txtcomment" class="form-control" rows="5"></textarea>
												<input type="hidden" name="manga" value="<?=$thisManga['id']?>">
											</div>
											<div style="padding-right: 10px;" class="pull-right">
												<div class="" id="loading"></div>
												<button type="submit" id="submit" class="btn btn-primary btn-sm"><i class="fa fa-paper-plane" aria-hidden="true"></i> Post</button>
												<button type="button" id="cancel" class="btn btn-default btn-sm">Cancel</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<?php
						} else {
							echo '<div class="panel panel-default arrow left">
							<div class="panel-heading right text-center">
							Please <a data-toggle="modal" href="#register"> <b>Register</b></a> or <a data-toggle="modal" href="#login"> <b>Login</b></a> to comment!
							</div></div>
							';
						}
						?>
						<div id="cmt-manga" class="list-comment">
							<div class="rows-cmt">
								<script type="text/javascript">
									load_Comment(<?=$thisManga['id']?>);
								</script>
							</div>
							<ul class="pagination-v4 pagination"></ul>
						</div>
					</div>
				</div>
			</div>
			<div role="tabpanel" class="tab-pane fade" id="tab2">
				<div class="card card-dark" id="commentbox">
					<div class="card-body bg-dark">
						<div id="cmt-chapter">
							<div class="rows-cmt">
								<script type="text/javascript">
									load_Comment_Chapter_Only_View(<?=$thisManga['id']?>);
								</script>
							</div>
							<ul class="pagination-v4 pagination"></ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<center>
		<!-- Ads -->
	</center>
</div>
<input type="hidden" name="manga" value="<?=$thisManga['id']?>">
