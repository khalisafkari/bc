<section id="rd-side_icon">
    <a class="rd_sd-button_item rd_top-left prev">
        <i class="fa fa-fast-backward" aria-hidden="true"></i>
    </a>
    <a id="rd-info_icon" data-affect="#rd_sidebar.chapters" class="rd_sd-button_item">
        <i class="fa fa-bars" aria-hidden="true"></i>
    </a>
    <a id="rd-info_noti" data-affect="#rd_sidebar.notis" class="rd_sd-button_item">
        <i class="glyphicon glyphicon-search" aria-hidden="true"></i>
    </a>
    <a class="rd_sd-button_item rd_top-right next">
        <i class="fa fa-fast-forward" aria-hidden="true"></i>
    </a>
    <a id="rd-info_noti" data-affect="#rd_sidebar.notis"></a>
</section>
<section id="chapters" class="rd_sidebar" style="display: none">
    <main class="rdtoggle_body">
        <header class="rd_sidebar-header clear">
            <a class="img" href="/<?=$row['id']?>/" style="background: url('<?=$thisManga['cover']?>') no-repeat"></a>
            <div class="rd_sidebar-name">
                <h5>
                    <a href="/<?=$thisManga['id']?>/"><?=$thisManga['name']?></a>
                </h5>
            </div>
        </header>
        <ul id="chap_list" class="unstyled">
            <?php
            if (!$huy->checkFile('chapter/chapterList-'.$thisManga['id'])) {
                $result = $db->Query(APP_TABLES_PREFIX.'manga_chapters', array('id', 'chapter', 'name', 'mid', 'manga', 'views', 'last_update'), array('manga'=>$thisManga['slug'], 'hidden'=>0), null, null, 'chapter DESC', null);
                $data = serialize($result);
                $huy->cacheSqlEnd('chapter/chapterList-'.$thisManga['id'], $data);
            } else {
                $result = unserialize($huy->cacheSqlEnd('chapter/chapterList-'.$thisManga['id']));
            }
            foreach ($result as $row) {
                $row = $huy->clearXss($huy->stripSlashes($row));
                ?>
                <li <?=($thisChapter['id'] == $row['id']) ? 'class="current"' : ''?>><a href="/<?=$thisManga['id']?>/<?=$row['id']?>/" title="<?=stripslashes($row['name'])?>">Chapter <?=$row['chapter']?>
                </a></li>
                <?php } ?>  
            </ul>
        </main>
        <div class="black-click" style="display:none"></div>
    </section>

    <section id="notis" class="rd_sidebar" style="display: none">
        <main class="rdtoggle_body">
         <form class="navbar-right" role="search" action="/manga-list.html">
            <button type="submit" class="btn-search"><i class="glyphicon glyphicon-search" aria-hidden="true"></i></button>
            <input type="text" id="search" rows="8" name="name" class="form-control" placeholder="Search by name, author...">
        </form>
    </main>
    <div class="white-click" style="display:none"></div>
</section>

<div class="btn-back-to-top">
    <i class="fa fa-angle-double-up"></i>
</div>