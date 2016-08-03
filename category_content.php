<?php  //which category are we trying to show?
//url looks like index.php?page=category&category_id=x
$category_id = $_REQUEST['category_id'];
//get the category name for this category

$query_catname = "SELECT *
					FROM categories
					WHERE category_id = $category_id
					LIMIT 1";
					
//run it
$results_catname = mysql_query($query_catname);
//check to see if a category was found
if(mysql_num_rows($results_catname) == 1){
	$row_catname = mysql_fetch_array($results_catname);
?>
<h2 class="cat_title">All Blog Posts in the Category <?php echo $row_catname['name']; ?></h2>
  <?php
  //get 2 latest published posts from the database
  $query_latest = "SELECT posts.*, categories.*
  					FROM posts, categories
					WHERE posts.is_published = 1
					AND posts.category_id = categories.category_id
					AND posts.category_id = $category_id
					ORDER BY posts.date DESC";
   //run the query. hold on to the results
   $result_latest = mysql_query($query_latest);
   //loop through the rows of results
   while($row_latest = mysql_fetch_array($result_latest)){
  ?>
  
  <div class="post">
  <h2>
  <a href="index.php?page=single&amp;post_id=<?php echo $row_latest['post_id'];?>">
  <?php echo $row_latest['title']; ?></a></h2>
  
  <div class="meta"><span class="date"><?php echo convert_date($row_latest['date']); ?></span><span class="cat"> in category <?php echo $row_latest['name'] ?></span></div><!--END meta-->
  <div class="entry"><?php echo $row_latest['body']; ?>
  </div><!--END ENTRY-->
  <hr />
  </div> <!--END POST-->
  <?php } //end --while-- loop 
  
}//end if category is found
else{
	echo 'Sorry, no posts matched your criteria, try the search bar';
}?> 
  
 