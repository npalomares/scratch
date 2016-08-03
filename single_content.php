<?php //figure out which post to show. URL looks like index.php?page=single&post_id=2
$post_id = $_GET['post_id'];

//PARSE COMMENT FORM
if($_REQUEST['did_comment'] == 1){
	//extract and clean up the inputs
	$name = clean_input($_REQUEST['name']);
	$email = clean_input($_REQUEST['email']);
	$url = clean_input($_REQUEST['url']);
	$comment = clean_input($_REQUEST['comment']);
	
	//TODO: validate goes here
	
	//go! insert into database
	$query_insert = "INSERT INTO comments
					(name, email, url, body, post_id, date, is_approved)
					VALUES
					('$name', '$email', '$url', '$comment', $post_id, now(), 1)";
	//run it
	$result_insert = mysql_query($query_insert);
	//if the comments table was affected, show a success message
	if( mysql_affected_rows() == 1){
		$message = 'Thank you for your comment!';
	}else{
		//error
		$message = 'There was a problem with your comment. Try Again.';	
	}
	
}

//set up query.  get this post, make sure it is published
$query_post = "SELECT posts.*, categories.*
				FROM posts, categories
				WHERE posts.post_id = $post_id
				AND posts.is_published = 1
				AND posts.category_id = categories.category_id
				LIMIT 1";
				
//run it
$result_post = mysql_query($query_post);

//make sure one post was found
if( mysql_num_rows($result_post) == 1 ){
	//loop it
	while( $row_post = mysql_fetch_array($result_post) ){
?>
<div id="single_content">
<div class="post">
	<h2><?php echo $row_post['title']; ?></h2>
	<div class="entry">
    	<?php echo $row_post['body']; ?>
    </div>
       
    <div class="meta">
    	Posted on <?php echo $row_post['date']; ?> in the category <a href="index.php?page=category&amp;category_id=<?php 
		echo $row_post['category_id']; ?>"><?php echo $row_post['name'] ?></a>
    </div>	
<hr />    
</div>
<!---close post------>


<div class="comments">
<?php
//count the comments on this post
$query_count = "SELECT COUNT(*) AS comment_count 
				FROM comments
				WHERE post_id = $post_id
				AND is_approved = 1";
//run it
$result_count = mysql_query($query_count);
//no loop necessary just for a count
$row_count = mysql_fetch_array($result_count);
?>

<h2 class="comment_count">
<?php 
if($row_count['comment_count'] == 1){
	echo '1 comment';
}else{
	echo $row_count['comment_count'].' comments';
	
}?></h2>

<?php
//set up query to get all approved comments about THIS post
$query_comments = "SELECT name, body, date, url
					FROM comments
					WHERE post_id = $post_id
					AND is_approved = 1
					ORDER BY date ASC";
//run it
$result_comments = mysql_query($query_comments);
//check to see if there are comments
if( mysql_num_rows($result_post) >= 1 ){
	//loop it
	while( $row_comments = mysql_fetch_array($result_comments) ){
?>
	<div class="one-comment">    	
            <h3><?php echo $row_comments['name']; ?> said:</h3>                                      
        	<p><?php echo $row_comments['body']; ?></p>            
       		<span class="comment-date"><?php echo $row_comments['date']; ?></span> 
		   	<hr />
 </div>
 <!---close comments------>
 <?php 
	}//closes while there are comments
 } //closes if there are comments ?>   
        
</div>
<!---close post------>

<?php 
//only show this form if allow_comments is 1
if( $row_post['allow_comments'] == 1 ){
?>

<h3 class="leavecomment">Leave a Comment</h3>
<a name="leavecomment"></a>

<?php //show the message if there is one
if( isset($message) ){
	echo $message;
		
}
?>

<form id="commentform" action="#leavecomment" method="post">
	<label for="name">Your Name:</label>
    <input type"text" name="name" class="username" />
    
    <label for="email">Your Email:</label>
    <input type"text" name="email" class="email" />
    
    <label for="url">Your Website:</label>
    <input type"text" name="url" class="url" placeholder="http://" />
    
    <hr />
    
    <label for="comment">Your Comment:</label>
    <textarea name="comment" class="comment" cols="45" rows="5"></textarea>
    
    <input type="submit" value="Submit Comment" />
    <input type="hidden" name="did_comment" value="1" />
</form>



<?php
		}//end if allow comments
	}//end while there is a post
} //end if one post found 
else{
	echo 'Sorry, no posts matched your criteria. Try the search bar. ';	
}
?>
</div>
<!----close content---->