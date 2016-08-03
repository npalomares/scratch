<?php 
//what post are we editing?
$post_id = $_REQUEST['post_id'];

//Parse the form IF they pressed the button
if( $_REQUEST['did_submit'] == 1){
	//clean up input data
	$title = clean_input($_REQUEST['title']);
	$body = clean_input($_REQUEST['body']);
	$category = clean_input($_REQUEST['category']);
	$allow_comments = clean_input($_REQUEST['allow_comments']);
	$is_published = clean_input($_REQUEST['is_published']);
	
	
	//VALIDATE:
	//if the boxes are not checked, set them to ZERO instead of null
	if($allow_comments != 1){
		$allow_comments = 0;		
	}
	
	if($is_published != 1){
		$is_published = 0;
	}
	
	//go! Update the post in the DB
	$query_update = "UPDATE posts
					SET title = '$title',
					body = '$body',
					category_id = $category,
					allow_comments = $allow_comments,
					is_published = $is_published
					WHERE post_id = $post_id ";
	$result_update = mysql_query($query_update);
	//make sure it worked
	if( mysql_affected_rows() >= 1 ){
		//success
		echo 'Post Successfully Edited';		
	}else{
		echo 'Something went wrong when saving your post. Try again.';	
	}
	
	
} //end if pressed the button
 
//look up info for this post to prefill the form
$query_post = "SELECT * FROM posts WHERE post_id = $post_id";
//run it
$result_post = mysql_query($query_post);
//format result as an array
$row_post = mysql_fetch_array($result_post);
 ?>


<h2>Edit Post:</h2>

<form method="post" action="admin.php?page=edit&amp;post_id=<?php echo $post_id; ?>">
	<label for="title">Title:</label>
    <input type="text" name="title" id="title" value="<?php echo stripslashes($row_post['title']) ?>" />
    
    <label for="body">Post Content:</label>
    <textarea name="body" id="body" cols="45" rows="5"><?php echo stripslashes($row_post['body']) ?></textarea>
   
    <label for="category">Category:</label> 
    <select name="category" id="category">
    	<?php 
		$query_cats = "SELECT * FROM categories";
		$result_cats = mysql_query($query_cats);
		while($row_cats = mysql_fetch_array($result_cats)){ 
		?>
        <option value="<?php echo $row_cats['category_id']; ?>" <?php 
			//if the category of the post matches the category shown, select it
			if( $row_post['category_id'] == $row_cats['category_id']){
				echo 'selected="selected"';
			} ?>>
			<?php echo $row_cats['name']; ?>
        </option>
        <?php } //end while categories ?>
    </select>
    
    <input type="checkbox" name="allow_comments" id="allow_comments" value="1" <?php if($row_post['allow_comments'] == 1){ echo 'checked="checked"'; } ?> />
    
    <label for="allow_comments">Allow comments?</label>
    
    <input type="checkbox" name="is_published" id="is_published" value="1" <?php if($row_post['is_published'] == 1){ echo 'checked="checked"'; } ?> />
    <label for="is_published">Make this post public?</label>
    
    <input type="submit" value="Save Post" />
    <input type="hidden" name="did_submit" value="1" />

</form>