	<!-- Before images -->
	<br />
	<br />
	<ul class="chapter-before sl-c chapter_select">
		<li>

			<div class="chapter-select">
				<a class='btn btn-info prev'><span class='glyphicon glyphicon-chevron-left'></span> <?=$lang[Previous_chapter]?></a>
				<div class="select-chapter">
					<? chapter_select($thisChapter); ?>
				</div>
				<a class='btn btn-info next'><?=$lang[Next_chapter]?> <span class='glyphicon glyphicon-chevron-right'></span></a>
			</div>
		</li>
	</ul>