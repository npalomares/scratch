
   <?php
  //get 2 latest published posts from the database
  $query_latest = "SELECT posts.*, categories.*
  					FROM posts, categories
					WHERE posts.is_published = 1
					AND posts.category_id = categories.category_id
					ORDER BY posts.date DESC
					LIMIT 2";
   //run the query. hold on to the results
   $result_latest = mysql_query($query_latest);
   //loop through the rows of results
   while($row_latest = mysql_fetch_array($result_latest)){
  ?>

  	<div class="post">
  
          <h2 class="post-title"><a href="index.php?page=single&amp;post_id=<?php echo $row_latest['post_id'];?>">
          <?php echo $row_latest['title']; ?></a></h2>
          
          <div class="meta"><span class="date"><?php echo convert_date($row_latest['date']); ?> |
            </span> in category <a href="index.php?page=category&amp;category_id=<?php 
                echo $row_latest['category_id']; ?>"><?php echo $row_latest['name'] ?></a>
          </div><!--END meta-->

          <div class="entry"><?php echo $row_latest['body']; ?></div><!--END ENTRY-->

    </div> <!--END POST--><?php } //end --while-- loop ?> 
    <a href="index.php?page=blog">Read All Posts</a>
 
  		
  		<div class="author">
          <h2>About The Author</h2>
          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
          </p>
		</div>