<?php 
//parse the for IF they pressed the button
if( $_REQUEST['did_submit'] == 1){
	//clean up the inputs
	$title = clean_input($_REQUEST['title']);
	$body = clean_input($_REQUEST['body']);
	$category = clean_input($_REQUEST['category']);
	$allow_comments = clean_input($_REQUEST['allow_comments']);
	$is_published = clean_input($_REQUEST['is_published']);
	//TODO: base this off of the login session info
	$user_id = 1;
	
	//VALIDATE:
	//if the boxes are not checked, set them to ZERO instead of null
	if($allow_comments != 1){
		$allow_comments = 0;		
	}
	
	if($is_published != 1){
		$is_published = 0;	
	}
	
	//GO! insert into DB
	$query_insert = "INSERT INTO posts
						(title, body, date, category_id, user_id, is_published, allow_comments)
						VALUES
						('$title', '$body', now(), $category, $user_id, $is_published, $allow_comments)";
	$result_insert = mysql_query($query_insert);
	//make sure it worked
	if( mysql_affected_rows() >= 1 ){
		//success
		echo 'Post Successfully Added';	
	}else{
		echo 'Something Went Wrong When Saving your Post. Try Again.';	
	}
}//end if pressed the button


?>

<h2>Write a New Post:</h2>


<div id="admin-form">
<form method="post" action="admin.php?page=write">
	<label for="title">Title:</label>
    <input type="text" name="title" id="title" />
    
    <label for="body">Post Content:</label>
    <textarea name="body" id="body" cols="45" rows="5"></textarea> 
    
    <label for="category">Category:</label>
    <select name="category" id="category">
    <?php 
	$query_cats = "SELECT * FROM Categories";
	//run it
	$result_cats = mysql_query($query_cats);
	//loop it
	while($row_cats = mysql_fetch_array($result_cats)){
	?>
    </div>
    
    
<div id="admin-form2">
    <option value="<?php echo $row_cats['category_id'];	?>">
    	<?php echo $row_cats['name']; ?>
    </option>
	<?php } //end while categories ?>
    </select>
	
    <input type="checkbox" name="allow_comments" id="allow_comments" value="1" />
    <label for="allow_comments">Allow Comments?</label>
	
    <input type="checkbox" name="is_published" id="is_published" value="1" />
    <label for="is_published">Make this post public?</label>
    
    <input type="submit" value="Save Post" />
    <input type="hidden" name="did_submit" value="1" />

</form>
</div>
