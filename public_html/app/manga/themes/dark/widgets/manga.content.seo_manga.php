<ol itemscope="" itemtype="http://schema.org/BreadcrumbList" class="breadcrumb"> 
	<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
		<a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="<?=DOMAIN?>/">
			<span itemprop="name"><?=$lang['Home']?></span>
		</a>
		<meta itemprop="position" content="1">
	</li> 
	<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
		<a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="<?=DOMAIN?>/<?=$lang['list_slug']?>.html">
			<span itemprop="name"><?=$lang['List_manga']?></span>
		</a>
		<meta itemprop="position" content="2">
	</li> 
	<li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
		<a itemscope="" itemtype="http://schema.org/Thing" itemprop="item" href="<?=DOMAIN?>/<?=$thisManga['id']?>/" title="<?=$thisManga['name']?>">
			<!--span itemprop="name"><!?=$thisManga['name']?></span-->
			<img itemprop="image" src="<?=$thisManga['cover']?>" alt="<?=$thisManga['name']?>" class="hide">
		</a>
		<meta itemprop="position" content="3">
	</li>
</ol>