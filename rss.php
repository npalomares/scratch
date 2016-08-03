<?php
include('db.php'); 
//change this if you move the website

$siteroot = 'http://localhost/nick_morning_web/blog_02';

//converts datetime tp RFC 2822 timestamp
function convTimestamp($date){
  $year   = substr($date,0,4);
  $month  = substr($date,5,2);
  $day    = substr($date,8,2);
  $hour   = substr($date,11,2);
  $minute = substr($date,14,2);
  $second = substr($date,17,2);
  $stamp =  date('D, d M Y H:i:s O', mktime($hour, $min, $sec, $month, $day, $year));
  return $stamp;
}

echo '<?xml version="1.0" encoding="utf-8"?>'; ?>
<rss version="2.0">
<channel>
<title>Radical Blog</title>
<link><?php echo $siteroot; ?></link>
<webmaster>nicholaspalomares@gmail.com</webmaster>
<managingEditor>nicholaspalomaresn@gmail.com</managingEditor>
<description>bla bla bla</description>
<image>
	<url><?php echo $siteroot; ?>/images/ocean.jpg</url>
	<title>Screenshot of my blog</title>
	<link>http://localhost/nick_morning_web/blog_02/index.php</link>
	</image>
	<category>News</category>
	<docs>http://www.blogs.law.harvard.edu/tech/rss</docs>
	<pubDate><?php echo date('r'); ?></pubDate>
	<lastBuildDate><?php echo date('r'); ?></lastBuildDate>
	<language>en-us</language>
    <?php 
	$query = "SELECT title, post_id, date, body
				FROM posts
				WHERE is_published = 1
				ORDER BY date DESC
				LIMIT 10";
	
	$result = mysql_query($query);
	while( $row = mysql_fetch_array($result)){
	?>
	<item>
	<title><?php echo $row['title']; ?></title>
	<link><?php echo $siteroot; ?>/index.php?page=single&amp;post_id=<?php echo $row['post_id']; ?></link>
	<guid><?php echo $siteroot; ?>/index.php?page=single&amp;post_id=<?php echo $row['post_id']; ?></guid>
	<pubDate><?php echo convTimestamp($row['date']); ?></pubDate>
	<description><?php echo htmlentities($row['body']); ?></description>
	</item>
    <?php } ?>
</channel>
</rss>