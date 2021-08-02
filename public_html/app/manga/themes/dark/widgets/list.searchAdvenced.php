<div class="col-md-8 bg-container">
   <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="breadcrumb"> 
    <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="/" title="Home | lovehug.net"><span itemprop="name"><?=$lang['Home']?></span></a>
        <meta itemprop="position" content="1"></li> 
        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="/search" title="Search manga | lovehug.net"><span itemprop="name"><?=$lang['Search']?></span></a>
            <meta itemprop="position" content="2"></li> 
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="/search" title="Search manga | lovehug.net"><span itemprop="name">
            </span></a><meta itemprop="position" content="4"></li>
        </ol>
        <div id="hopNangCao" class="well well-sm">

            <div class="title"><h3 class="text-center bold h2title"><?=$lang['Search_advenced']?></h3>
                <a href="/search" class="btn btn-primary btn-sm pull-right"><i class="glyphicon glyphicon-refresh"></i> Reset</a>
            </div>
            <fieldset>
                <legend><?=$lang['select-genres']?></legend>
                <p><span class="icon-tick"></span> <?=$lang['in-genres']?></p>
                <p><span class="icon-cross"></span> <?=$lang['un-genres']?></p>
                <p><span class="icon-checkbox"></span> <?=$lang['maybe-genres']?></p>
            </fieldset>
            <form class="form-horizontal" id="TimNangCao" action="/manga-list.html" style="margin-top:20px">
                <label for="danhcho">Genres:</label>
                <div id="chontheloai" class="webkit-md-col4 webkit-sm-col4 webkit-xs-col3">
                    <ul class="row">
                        <?php 
                        $listGenre = $db->Query(APP_TABLES_PREFIX.'manga_genres', 'id, name, content, slug');
                        foreach ($listGenre as $key => $row) {
                            echo '<li class="item col-sm-4 col-xs-6 pointer" title="'.$row['content'].'" data-genres="'.$row['slug'].'"><span class="icon-checkbox"></span>'.$row['name'].'</li>';
                        }
                         ?>
                        
                    </ul>
                </div>


                <div class="form-group">
                   <div class="col-md-3">
                    <label for="TinhTrang">Status:</label>
                    <select id="TinhTrang" name="m_status" class="form-control">
                       <option value="" selected=""><?=$lang['any']?></option>
                       <option value="2"><?=$lang['Completed']?></option>
                       <option value="1"><?=$lang['On_going']?></option>
                       <option value="3">Drop</option>
                   </select>
               </div>
           </div>
           <div class="form-group">
            <div class="col-md-6">
                <label for="TacGia" class="sr-only"><?=$lang['Authors']?>:</label>
                <input type="text" name="author" value="" placeholder="<?=$lang['Authors']?>" class="form-control">
            </div>
            <div class="col-md-6">
                <label for="Nguon" class="sr-only"><?=$lang['source']?>:</label>
                <input type="text" name="group" value="" placeholder="<?=$lang['source']?>" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-9">
                <label for="q" class="sr-only"><?=$lang['Name']?></label>
                <input type="text" name="name" value="" placeholder="<?=$lang['Name']?>" class="form-control">
            </div>
            <input type="hidden" name="genre" value="" />
            <input type="hidden" name="ungenre" value="" />
            <div class="col-md-3 text-center">
                <button type="submit" class="btn btn-warning"><i class="glyphicon glyphicon-search" aria-hidden="true"></i> Search</button>
            </div>
        </div>


    </form>
</div>
</div>
<script type="text/javascript">
	$(function () {
        $("#chontheloai .item").click(function () {
            var CategoryID = $(this).attr("data-genres");
            var icon_ele = $(this).find("span");
            var cssclass = $(icon_ele).attr("class");
            var txtCategorySelected = $("input[name=genre]");
            var txtCategoryExcluded = $("input[name=ungenre]");

            if (cssclass == "icon-checkbox") {
                $(icon_ele).attr("class", "icon-tick");
                var ids = $(txtCategorySelected).val() + ',' + CategoryID;
                $(txtCategorySelected).val(ids.replace(/^,/, '').replace(/,$/, ''));
            }
            else if (cssclass == "icon-tick") {
                $(icon_ele).attr("class", "icon-cross");
                var ids = ',' + $(txtCategorySelected).val() + ',';
                ids = ids.replace(',' + CategoryID + ',', ',').replace(/^,/, '').replace(/,$/, '');
                $(txtCategorySelected).val(ids);

                ids = $(txtCategoryExcluded).val() + ',' + CategoryID;
                $(txtCategoryExcluded).val(ids.replace(/^,/, '').replace(/,$/, ''));
            }
            else {
                $(icon_ele).attr("class", "icon-checkbox");
                var ids = ',' + $(txtCategoryExcluded).val() + ',';
                ids = ids.replace(',' + CategoryID + ',', ',').replace(/^,/, '').replace(/,$/, '');
                $(txtCategoryExcluded).val(ids);
            }
        });
    });
</script>