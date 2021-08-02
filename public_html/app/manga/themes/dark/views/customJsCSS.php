<!-- This place is for you guys to add custom jquery and css, becarefull with your coding -->
	<script>
        $(document).ready(function() {
          $('#search').smartSuggest({
            src: '/app/manga/controllers/search.single.php'
          });
        });
        
    </script>
<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-TGZ3JZVMSZ"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-TGZ3JZVMSZ');
	</script>