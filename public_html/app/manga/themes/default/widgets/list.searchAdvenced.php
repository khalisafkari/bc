<div class="col-md-8 bg-container">
 <ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="breadcrumb"> 
<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="/" title="Trang chủ đọc truyện | Truyentranhaz.net"><span itemprop="name"><?=$lang['Home']?></span></a>
<meta itemprop="position" content="1"></li> 
<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="/search" title="Trang tìm kiếm truyện | Truyentranhaz.net"><span itemprop="name"><?=$lang['Search']?></span></a>
<meta itemprop="position" content="2"></li> 
<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem"><a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="/search" title="Trang tìm kiếm truyện | Truyentranhaz.net"><span itemprop="name">
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
<form class="form-horizontal" id="TimNangCao" action="/danh-sach-truyen.html" style="margin-top:20px">
<label for="danhcho">Genres:</label>
<div id="chontheloai" class="webkit-md-col4 webkit-sm-col4 webkit-xs-col3">
<ul class="row">
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loai này chỉ chứa những truyện dành cho người dùng trên 18 tuổi. Nên ai chưa đủ 18 tuổi thì không nên vào chuyên mục này -_-!" data-genres="18"><span class="icon-checkbox"></span>18+</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loai này có những truyện dành cho lứa tuổi trên 16, Nếu ai chưa đủ 16 tuổi thì Get out!." data-genres="16"><span class="icon-checkbox"></span>16+</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loai này thường có nội dung về đánh nhau, bạo lực, hỗn loạn, với diễn biến nhanh." data-genres="Action"><span class="icon-checkbox"></span>Action</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loại có đề cập đến vấn đề nhạy cảm, chỉ dành cho lứa tuổi 17+." data-genres="Adult"><span class="icon-checkbox"></span>Adult</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loại phiêu lưu, mạo hiểm, thường là hành trình của các nhân vật." data-genres="Adventure"><span class="icon-checkbox"></span>Adventure</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Những chuyện đã được chuyển thành Amine." data-genres="Anime"><span class="icon-checkbox"></span>Anime</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loại có nội dung trong sáng và cảm động, thường có tình tiết gây cười, xung đột nhẹ nhàng." data-genres="Comedy"><span class="icon-checkbox"></span>Comedy</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Truyện tranh Châu Âu và Châu Mĩ." data-genres="Comic"><span class="icon-checkbox"></span>Comic</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loại truyện được phóng tác do fan hay có thể cả những Mangaka khác với tác giả truyện gốc. Tác giả vẽ Doujinshi thường dựa trên những nhân vật gốc để viết ra những câu chuyện theo sở thích của mình." data-genres="Doujinshi"><span class="icon-checkbox"></span>Doujinshi</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loại mang đến cho người xem những cảm xúc khác nhau: buồn bã, căng thẳng thậm chí là bi phẫn" data-genres="Drama"><span class="icon-checkbox"></span>Drama</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Đam mỹ chính là một thể loại Yaoi Trung Quốc. Đa số lấy bối cảnh cổ trang thời phong kiến, gồm có vua chúa, võ lâm giang hồ... Là thể loại truyện Nam (đẹp) yêu Nam (vô cùng đẹp)" data-genres="Đam Mỹ"><span class="icon-checkbox"></span>Đam Mỹ</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thường có những tình huống nhạy cảm nhẹ nhàng nhằm lôi cuốn người xem" data-genres="Ecchi"><span class="icon-checkbox"></span>Ecchi</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loại xuất phát từ trí tưởng tượng phong phú, từ pháp thuật đến thế giới trong mơ thậm chí là những câu chuyện thần tiên" data-genres="Fantasy"><span class="icon-checkbox"></span>Fantasy</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Là một thể loại trong đó giới tính của nhân vật bị lẫn lộn: nam hoá thành nữ, nữ hóa thành nam..." data-genres="Gender Bender"><span class="icon-checkbox"></span>Gender Bender</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loại truyền tình cảm, lãng mạn mà trong đó nhiều nhân vật nữ thích một nam nhân vật chính." data-genres="Harem"><span class="icon-checkbox"></span>Harem</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loại có liên quan đến thời xa xưa." data-genres="Historical"><span class="icon-checkbox"></span>Historical</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Horror = rùng rợn, nghe cái tên là biết thể loại này có nội dung như thế nào. Nó làm cho bạn kinh hãi, khiếp sơ, ghê tởm, có thể gây sock - một loại không dùng cho người yếu tim." data-genres="Horror"><span class="icon-checkbox"></span>Horror</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Là một thể loại của manga hay anime được sáng tác chủ yếu bởi phụ nữ cho những độc giả nữ từ 18 đến 30. Josei manga có thể miêu tả những lãng mạn thực tế , nhưng trái ngược với hầu hết các kiểu lãng mạn lí tưởng của Shoujo manga với cốt truyện rõ ràng, chín chắn." data-genres="Josei"><span class="icon-checkbox"></span>Josei</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Truyện đã được chuyển thể thành phim." data-genres="Live action"><span class="icon-checkbox"></span>Live action</li>
<li class="item col-sm-4 col-xs-6 pointer" title="la the loai lien quan den phep thuat nhu la suc manh sieu nhien hay gay phep va vong tron ma thuat" data-genres="Magic"><span class="icon-checkbox"></span>Magic</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Truyện tranh Trung Quốc." data-genres="Manhua"><span class="icon-checkbox"></span>Manhua</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Truyện tranh Hàn Quốc, đọc từ trái sang phải." data-genres="Manhwa"><span class="icon-checkbox"></span>Manhwa</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Giống với tên gọi, bất cứ gì liên quan đến võ thuật trong truyện từ các trận đánh nhau, tự vệ đến các môn võ thuật như akido, karate, judo hay taekwondo, kendo, các cách né tránh." data-genres="Martial Arts"><span class="icon-checkbox"></span>Martial Arts</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loại dành cho lứa tuổi 17+ bao gồm các pha bạo lực, máu me, chém giết, tình dục ở mức độ vừa." data-genres="Mature"><span class="icon-checkbox"></span>Mature</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Mecha, còn được biết đến dưới cái tên meka hay mechs, là thể loại nói tới những cỗ máy biết đi (thường là do phi công cầm lái)." data-genres="Mecha"><span class="icon-checkbox"></span>Mecha</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loại thường xuất hiện những điều bí ấn không thể lí giải được và sau đó là những nỗ lực của nhân vật chính nhằm tìm ra câu trả lời thỏa đáng." data-genres="Mystery"><span class="icon-checkbox"></span>Mystery</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Những truyện ngắn, thường là 1 chapter." data-genres="One shot"><span class="icon-checkbox"></span>One shot</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loại liên quan đến những vấn đề về tâm lý của nhân vật ( tâm thần bất ổn, điên cuồng ...)" data-genres="Psychological"><span class="icon-checkbox"></span>Psychological</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thường là những câu chuyện về tình yêu. Ớ đây chúng ta sẽ lấy ví dụ như tình yêu giữa một người con trai và con gái, bên cạnh đó đặc điểm thể loại này là kích thích trí tưởng tượng của bạn về tình yêu." data-genres="Romance"><span class="icon-checkbox"></span>Romance</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Trong thể loại này, ngữ cảnh diễn biến câu chuyện chủ yếu ở trường học." data-genres="School Life"><span class="icon-checkbox"></span>School Life</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Bao gồm những chuyện khoa học viễn tưởng, đa phần chúng xoay quanh nhiều hiện tượng mà liên quan tới khoa học, công nghệ, tuy vậy thường thì những câu chuyện đó không gắn bó chặt chẽ với các thành tựu khoa học hiện thời, mà là do con người tưởng tượng ra." data-genres=">Sci-fi"><span class="icon-checkbox"></span>Sci-fi</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Là một thể loại của manga thường nhằm vào những đối tượng nam 18 đến 30 tuổi, nhưng người xem có thể lớn tuổi hơn, với một vài bộ truyện nhắm đến các doanh nhân nam quá 40. Thể loại này có nhiều phong cách riêng biệt , nhưng thể loại này có những nét riêng biệt, thường được phân vào những phong cách nghệ thuật rộng hơn và phong phú hơn về chủ đề, có các loại từ mới mẻ tiên tiến đến khiêu dâm." data-genres="Seinen"><span class="icon-checkbox"></span>Seinen</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Đối tượng hướng tới của thể loại này là phái nữ. Nội dung của những bộ manga này thường liên quan đến tình cảm lãng mạn, chú trọng đầu tư cho nhân vật (tính cách,...)." data-genres="Shoujo"><span class="icon-checkbox"></span>Shoujo</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loại quan hệ hoặc liên quan tới đồng tính nữ, thể hiện trong các mối quan hệ trên mức bình thường giữa các nhân vật nữ trong các manga, anime." data-genres="Shoujo"><span class="icon-checkbox"></span>Shoujo Ai</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Đối tượng hướng tới của thể loại này là phái nam. Nội dung của những bộ manga này thường liên quan đến đánh nhau và/hoặc bạo lực (ở mức bình thường, không thái quá)." data-genres="Shounen"><span class="icon-checkbox"></span>Shounen</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Là một thể loại của anime hoặc manga có nội dung về tình yêu giữa những chàng trai trẻ, mang tính chất lãng mạn nhưng ko đề cập đến quan hệ tình dục." data-genres="Shounen Ai"><span class="icon-checkbox"></span>Shounen Ai</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Nói về cuộc sống đời thường." data-genres="Slice of life"><span class="icon-checkbox"></span>Slice of life</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Những truyện có nội dung hơi nhạy cảm, đặc biệt là liên quan đến tình dục" data-genres="Smut"><span class="icon-checkbox"></span>Smut</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Boy x Boy. Nặng hơn Shounen Ai tí." data-genres="Soft Yaoi"><span class="icon-checkbox"></span>Soft Yaoi</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Girl x Girl. Nặng hơn Shoujo Ai tí." data-genres="Soft Yuri"><span class="icon-checkbox"></span>Soft Yuri</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Đúng như tên gọi, những môn thể thao như bóng đá, bóng chày, bóng chuyền, đua xe, cầu lông,... là một phần của thể loại này." data-genres="Sports"><span class="icon-checkbox"></span>Sports</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể hiện những sức mạnh đáng kinh ngạc và không thể giải thích được, chúng thường đi kèm với những sự kiện trái ngược hoặc thách thức với những định luật vật lý." data-genres="Supernatural"><span class="icon-checkbox"></span>Supernatural</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Tạp chí online về manga anime v.v..." data-genres="Tạp chí truyện tranh"><span class="icon-checkbox"></span>Tạp chí truyện tranh</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Thể loại chứa đựng những sự kiện mà dẫn đến kết cục là những mất mát hay sự rủi ro to lớn." data-genres="Tragedy"><span class="icon-checkbox"></span>Tragedy</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Tuyển tập các truyện tranh màu. Xem bằng smartphone sẽ rất đẹp" data-genres="Truyện màu"><span class="icon-checkbox"></span>Truyện màu</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Các truyện được scan lên." data-genres="Truyện scan"><span class="icon-checkbox"></span>Truyện scan</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Truyện tranh Việt Nam!" data-genres="VnComic"><span class="icon-checkbox"></span>VnComic</li>
<li class="item col-sm-4 col-xs-6 pointer" title="Truyện tranh Việt Nam!" data-genres="Webtoon"><span class="icon-checkbox"></span>Webtoon</li>
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