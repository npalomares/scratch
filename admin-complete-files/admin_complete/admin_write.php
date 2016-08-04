<?php 
//parse the form if they submitted it
if( $_POST['did_post'] == 1 ){
	//extract and clean the data
	$title = clean_input($_POST['title']);
	$body = clean_input($_POST['body']);
	$category = clean_input($_POST['category']);
	$allow_comments = clean_input($_POST['allow_comments']);
	$is_published = clean_input($_POST['is_published']);
	
	$user_id = $_SESSION['user_id'];
	
	//validate goes here
	
	//make sure unchecked boxes pass a value of 0
	if( $allow_comments == '' ){
			$allow_comments = 0;
	}
	if( $is_published == '' ){
			$is_published = 0;
	}
	
	//go! insert new post in DB
	$query_insert = "INSERT INTO posts
	(title, date, body, is_published, allow_comments, user_id, category_id)
					VALUES
('$title', now(),'$body', $is_published, $allow_comments, $user_id, $category)";
	$result_insert = mysql_query($query_insert);
	
	//make sure one row went into the DB
	if( mysql_affected_rows() == 1 ){
		echo 'Post successfully created.';
	}else{
		echo 'Something went wrong when saving your post. Try again.';
	}
	
	
}//end form parse
?>

<h2>Write Post:</h2>

<form action="admin.php?page=write" method="post">
	<label for="title">Title:</label>
    <input type="text" name="title" id="title" />
    
    <label for="body">Post Body:</label>
    <textarea name="body" id="body" rows="10" cols="45"></textarea>
    
    <select name="category">
    	<?php
		//get all the categories
		$query_cats = "SELECT *
						FROM categories";
		$result_cats = mysql_query($query_cats);
		while($row_cats = mysql_fetch_array($result_cats)){
		?>
       		 <option value="<?php echo $row_cats['category_id']; ?>">
			 <?php echo $row_cats['name']; ?>
             </option>
        <?php } //end while there are categories ?>
        
    </select>
    
    <input type="checkbox" name="is_published" id="is_published" value="1" />
    <label for="is_published">Make this post public?</label>
    
   <input type="checkbox" name="allow_comments" id="allow_comments" value="1" />
   	<label for="allow_comments">Allow comments on this post?</label>
    
    <input type="submit" value="Save Post" />
    <input type="hidden" name="did_post" value="1" />
    
</form>