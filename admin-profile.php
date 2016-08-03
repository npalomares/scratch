<?php 
//only parse the image if the button is pressed
if($_REQUEST['did_upload'] == 1){
	
//file uploading stuff begins
	
	$target_path = "uploads/";
	
	
	
	
	// This is the temporary file created by PHP
$uploadedfile = $_FILES['uploadedfile']['tmp_name'];
// Capture the original size of the uploaded image
list($width,$height)=getimagesize($uploadedfile);

// For our purposes, I have resized the image to be
// 200 pixels wide, and maintain the original aspect
// ratio. This prevents the image from being "stretched"
// or "squashed". If you prefer some max width other than
// 200, simply change the $newwidth variable

if($width > 0 AND $height > 0){
//we have a winner

if($width >= 200){
	$newwidth=200;
	$newheight=($height/$width)*$newwidth;
}else{
	$newwidth=$width;
	$newheight=$height;
}


$filetype = $_FILES['uploadedfile']['type'];

switch($filetype){
	case 'image/gif':
		// Create an Image from it so we can do the resize
		$src = imagecreatefromgif($uploadedfile);
	break;
	case 'image/pjpeg':
    case 'image/jpg':
    case 'image/jpeg': 
		// Create an Image from it so we can do the resize
		$src = imagecreatefromjpeg($uploadedfile);
	break;
	case 'image/x-png':
		// Create an Image from it so we can do the resize
		
	break;
	case 'image/png':
		// Create an Image from it so we can do the resize
		$required_memory = Round($width * $height * $size['bits']);
		$new_limit=memory_get_usage() + $required_memory;
		ini_set("memory_limit", $new_limit);
		$src = imagecreatefrompng($uploadedfile);
		ini_restore ("memory_limit");
	break;
	default:
		
}




$tmp=imagecreatetruecolor($newwidth,$newheight);

// this line actually does the image resizing, copying from the original
// image into the $tmp image
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

// now write the resized image to disk. I have assumed that you want the
// resized, uploaded image file to reside in the ./images subdirectory.
$randomsha = sha1(microtime());
$filename = $target_path.'avatar_'.$randomsha.'.jpg';
//$filename = $target_path. $_FILES['uploadedfile']['name'];
$didcreate = imagejpeg($tmp,$filename,70);
//creates image and in the parameters has variables on how its made and the number is the percent of quality
imagedestroy($src);
imagedestroy($tmp); // NOTE: PHP will clean up the temp file it created when the request
// has completed.
	
	
}else{
	$didcreate = false;
}//width and height not greater than 0

	/* Add the original filename to our target path.  
	Result is "uploads/filename.extension" */
	//$target_path = $target_path . basename( $_FILES['uploadedfile']['name']); 
	
	if($didcreate) {
		//upload successful, update the DB for the logged in user
		$query_upload = "UPDATE users
						SET avatar_link = '$filename'
						WHERE user_id = $user_id";
		$result_upload = mysql_query($query_upload);
		
		//make sure it worked
		if( mysql_affected_rows() >= 1 ){
			$statusmsg .= 'Image added to Database';
			
		}
		
		$statusmsg .=  "The file ".  basename( $_FILES['uploadedfile']['name']). 
		" has been uploaded <br />";
	} else{
		$statusmsg = "There was an error uploading the file, please try again!<br />";
	}	
}//end if pressed the button
?>

<h2>Edit Your Avatar</h2>
<?php if( isset($statusmsg) ){
		echo $statusmsg;
}?>
<form action="admin.php?page=profile" method="post" enctype="multipart/form-data">
	<label for="uploadedfile">Choose an Image from your computer:</label>
    <input type="file" name="uploadedfile" id="uploadedfile" />
    
    <input type="submit" value="Update Avatar" />
    <input type="hidden" name="did_upload" value="1" />

</form>

<h2>Your Current Avatar:</h2>
<?php
//user_id is already set on admin.php if they are logged in
$query_avatar = "SELECT avatar_link
					FROM users
					WHERE user_id = $user_id
					LIMIT 1";
$result_avatar = mysql_query($query_avatar);
$row_avatar = mysql_fetch_array($result_avatar);
//do they have an avatar?
if($row_avatar['avatar_link'] == ''){
	$avatar = 'images/default.png';
}else{ //they do have an avatar
	$avatar = $row_avatar['avatar_link'];
}

?>
<img src="<?php echo $avatar; ?>" alt="Your Avatar" />



