<script type="text/javascript" language="javascript">
function confirmSubmit(){
	var agree = confirm('Are you sure? This is permanent, there is no undo!');
	if(agree){
		return true;
	}else{
		return false;
	}
}
</script>
<?php 
if($_REQUEST['did_delete'] == 1){
	//grab the list of posts checked
	$delete_array = $_REQUEST['delete'];
	
	//if any boxes were checked
	if( $delete_array != '' ){
		//delete each checked post, one by one
		foreach( $delete_array as $post_id ){
			//delete query
			$query_delete = "DELETE FROM posts
							WHERE post_id = $post_id
							LIMIT 1";
							
			//run it
			$result_delete = mysql_query($query_delete);
				
		}
	}
}
?>

<h2>Manage Posts</h2>

<form method="post" action="admin.php?page=manage">
	<ul>
    	<?php
		//get all posts by the logged in user
		$query_manage = "SELECT title, post_id
						 FROM posts
						 WHERE user_id = $user_id
						 ORDER BY date DESC";
		$result_manage = mysql_query($query_manage);
		//make sure they have posts
		if(mysql_num_rows($result_manage) >= 1){
			//loop it
			while($row_manage = mysql_fetch_array($result_manage)){
		 ?>
    
    	<li><input type="checkbox" name="delete[<?php echo $row_manage['post_id']?>]" id="delete<?php echo $row_manage['post_id']?>" value="<?php echo $row_manage['post_id']?>" />  
<a class="edit" href="admin.php?page=edit&amp;post_id=<?php echo $row_manage['post_id']; ?>"><?php echo stripslashes($row_manage['title']); ?></a></li>
        
		<?php 
			} // end while
		}else{
			echo '<li>You do not have any posts yet!</li>';	
		}?>
    </ul>
    <input type="submit" value="Delete Checked" class="warn" onclick="return confirmSubmit()" />

	<input type="hidden" name="did_delete" value="1" />


</form>