<h3><?=$lang['Chapters']?></h3>
<div id="tab-chapper" class="tab">
	<hr>
	<div class="tab-text" style="overflow-y: auto; max-height: 450px">
		<table class="table table-hover">
			<tbody>
				<?php
				$result = $db->Query(APP_TABLES_PREFIX.'manga_chapters', '*', array('manga'=>$thisManga['slug'], 'hidden'=>0), null, null, 'chapter DESC', null);
				foreach ($result as $row) {
					$row = $huy->clearXss($huy->stripSlashes($row));
					?>

					<tr style ="background-color:#F2F2F2">
						<td><a class="chapter" href='<?=$lang['read_slug']?>-<?=$thisManga['slug']?>-<?=$lang['chapter_slug']?>-<?=$row['chapter']?>.html'><b><?=stripslashes($row['name'])?></b></a></td>
						<td><i><time><?=$huy->ago($row['last_update'])?></time></i></td>
						<td><?=$row['views']?> views</td>
					</tr>
					<? } ?>		
				</tbody>
			</table>
		</div>
	</div>