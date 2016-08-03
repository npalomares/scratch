 <aside class="sidebar col-sm-4" role="complementary">
 
	<div class="widget">
 		<h3 class="widget-title"><a href="rss.php">Subscribe to RSS Feed</a></h3>
	</div>

	<div class="widget">
		<h3 class="widget-title">Search</h3>	
		<form id="searchform" action="index.php" method="get"> 
			<input name="phrase" type="text" id="phrase" placeholder="Search Posts" />
			<input type="submit"  value="search" />
			<input type="hidden" name="page" value="search" />
		</form>
	</div>

	<div class="widget">    
  		<h3 class="widget-title">Latest Posts</h3>
  		<ul>
	  		<?php //get the 5 latest published posts, title and ID
			$query_posts = "SELECT title, post_id
							FROM posts
							WHERE is_published = 1
							ORDER BY date DESC
							LIMIT 5";
			//run it
			$results_post = mysql_query($query_posts);
			//loop it
			while($row_posts = mysql_fetch_array($results_post)){				 ?>
	  		<li>
				<a href="index.php?page=single&amp;post_id=<?php echo $row_posts['post_id'];?>">
				<?php echo $row_posts['title'] ?></a>
			</li>    		
			<?php } ?>
  		</ul>
  	</div>

  	<div class="widget">
  		<h3 class="widget-title">Categories</h3>
		<ul>
		<?php //get the 5 latest published posts, title and ID
			$query_categories = "SELECT *
								FROM categories";
			//run it
			$results_categories = mysql_query($query_categories);
			//loop it
			while($row_categories = mysql_fetch_array($results_categories)) {
				//which category is showing?
				$category_id = $row_categories['category_id'];
				//count the number of posts in this category
				$query_count = "SELECT COUNT(*) AS count
									 FROM posts
									 WHERE category_id = $category_id
									 AND is_published = 1
									 LIMIT 1";
									 
				$results_count = mysql_query($query_count);
				$row_count = mysql_fetch_array($results_count);	
					
				//if there are posts in this category, show it
				if($row_count['count'] >= 1) { ?>
		  		<li><a href="index.php?page=category&amp;category_id=<?php 
				echo $row_categories['category_id']; ?>">
				<?php echo $row_categories['name']; ?></a> (<?php echo $row_count['count']; ?>)</li>
		        <?php 
					}//end if has posts
				}//end while categories ?>
		  	</ul>
  	</div>

  	<div class="widget">  
  		<h3 class="widget-title">Links</h3>
	    <ul>
			<?php
			$query_links = "SELECT *
			  					FROM links";
								
			$results_links = mysql_query($query_links);
			while($row_links = mysql_fetch_array($results_links)) { ?>				

			<li><a href="<?php echo $row_links['url'] ?>" target="_blank"><?php echo $row_links['link_title'] ?></a></li>
			<?php } ?>
	  	</ul>
	  </div>
	  
</aside><!--END SIDEBAR-->





