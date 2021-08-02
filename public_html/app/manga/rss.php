<?php
  // MAIN CONTROLLER
  include '../../controllers/cont.main.php';
  include 'includes/rss.php';
  header( "Content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>  
<rss version="2.0">  
<channel>  
<title>'.$c_manga['rss_title'].'</title>  
<description>'.$c_manga['rss_description'].'</description>  
<link>'.$c_manga['rss_url'].'</link>';  
$get_mangas = "SELECT id, name, description, slug, last_chapter, DATE_FORMAT(last_update,'%a, %e %b %Y %T') as formatted_date FROM ".APP_TABLES_PREFIX."manga_mangas WHERE hidden = '0' ORDER BY last_update DESC LIMIT ".$c_manga['rss_item']."";  
  
$mangas = mysqli_query($db->Connect(),$get_mangas);
  
while ($manga = mysqli_fetch_assoc($mangas)){  
        
    echo '  
       <item>  
          <title>'.$manga['name'].'</title>
		  <category>Last Chapter: '.$manga[last_chapter].'</category>
          <description><![CDATA[  
          '.strip_tags($manga['description']).'  
          ]]></description>  
          <link>'.$c_manga['rss_url'].'/'.$manga[id].'/'.$h0manga->chapter_id($manga['id'], $manga['last_chapter']).'/</link><br /> 
          <pubDate>'.$manga['formatted_date'].' GMT</pubDate>  
      </item>';  
}  
echo '</channel>  
</rss>';  
?>