<?php 
//put this function at the top of ANY page that works with session vars
session_start();
include_once('functions.php');
require('db_config.php');

//extract the values from the form
if( $_POST['did_login'] == true ){
	//sanitize the data
	$input_username = clean_input($_POST['username']);
	$input_password = clean_input($_POST['password']);
	$sha_password = sha1($input_password);
	
	//check to see if username and password are long enough
	if(strlen($input_username) >= $min_username_length
	AND strlen($input_password) >= $min_password_length){
		
		//look for a matching username and password in the DB
		$query = "SELECT username, user_id, is_admin
					FROM users
					WHERE username = '$input_username'
					AND password = '$sha_password'
					LIMIT 1";
		$result = mysql_query($query);
		//if one row comes back in the result, log them in!
		if( mysql_num_rows($result) == 1 ){
			//SUCCESS - log them in
			$row = mysql_fetch_array($result);
			
			$_SESSION['logged_in'] = true;
			setcookie('logged_in', true, time() + 60 * 60 * 24 * 14);
			
			$_SESSION['user_id'] = $row['user_id'];
			setcookie('user_id', $row['user_id'], time() + 60 * 60 * 24 * 14);
			//redirect the user to the secret profile page
			header('location:admin.php');
		} //end if one result
		else{
			//error - no match!
			$login_error = true;	
		}
		
	}else{
		//error - too short!
		$logged_in = false;
		$login_error = true;
	}
}

//if the user pressed the logout button
if( $_GET['action'] == 'logout' ){
	session_destroy();
	unset( $_SESSION['logged_in'] );
	setcookie('logged_in', '');
	
	unset( $_SESSION['user_id'] );
	setcookie('user_id', '');
}
//if the user is returning and the cookie is still valid, rebuild the session
elseif( $_COOKIE['logged_in'] == true ){
	$_SESSION['logged_in'] = true;
	$_SESSION['user_id'] = $_COOKIE['user_id'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Log in to your account</title>
</head>

<body>
<?php
//hide the form if successful login
if( $_SESSION['logged_in'] != true ){
	 
	//show an error if there is a problem
	if( $login_error == true ){
		echo '<div class="error"> Your username and password do not match. Try again.  </div>';
	}
	 ?>
	<form action="login.php" method="post">
		<label for="username">Username:</label>
		<input type="text" name="username" id="username" />
		
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" />
		
		<input type="submit" value="Sign In" />
		<input type="hidden" name="did_login" value="true" />
	</form>

<?php 
}else{
?>
	<h1>You are logged in</h1>
    <a href="login.php?action=logout">Sign Out</a>
<?php	
}?>
</body>
</html>