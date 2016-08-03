<?php
//establish the use of sessions
session_start();
//connect to db
require('db.php');
require_once('functions.php');

	
	//after they press the button, compare with what they typed in to the correct values
	
	if( $_POST['did_login'] == true ){
		//extract the values they typed
		$input_username = clean_input($_POST['username']);
		$original_password = clean_input($_POST['password']);
		$sha_password = sha1($original_password);
		
		//make sure inputs meet minimum requirements
		if( strlen( $input_username ) >= 5 AND strlen( $original_password ) >= 5 ){
			//look in the DB for a matching username and pasword
			$query_login = "SELECT user_id, is_admin FROM users
							WHERE user_name = '$input_username'
							AND password = '$sha_password'
							LIMIT 1";
							
		//run it
		$result_login = mysql_query($query_login);
		
		//if one result is found, log them in
		if( mysql_num_rows($result_login) == 1 ){
				$row_login = mysql_fetch_array($result_login);
				
				$expire = time() + 60 * 60 * 24 * 7;
				
				//log them in store info in session and cookie
				$_SESSION['logged_in'] = true;
				setcookie( 'login', 'true', time() + 60 * 5 );
				
				//who is logged in?
				$_SESSION['user_id'] = $row_login['user_id'];
				setcookie( 'user_id' , $row_login['user_id'] , $expire );
				
				//what level are they
				$_SESSION['is_admin'] = $row_login['is_admin'];
				setcookie('is_admin', $row_login['is_admin'], $expire );
				
				//redirect to their profile
				header('Location:admin.php');
				
			}else{
				//did not match, show error!
				$error = true;
			}
		}//end if met minimum lengths
		else{
			$error = true;	
		}
		
		
	}// end if they pressed the button
	
	//if they want to log out
	if( $_GET['action'] == 'logout' ){
			//manually remove sessions and cookies
			unset( $_SESSION['logged_in'] );
			unset( $_SESSION['user_id'] );
			unset($_SESSION['is_admin'] );
			setcookie( 'login', '' );
			setcookie( 'user_id', '' );
			setcookie( 'is_admin', '' );
			session_destroy();
	}
	
//if the session closed, but the cookie is still good, log them back in.
//recreate ALL session vars

elseif ($_COOKIE['login'] == true){
	$_SESSION['logged_in'] = true;
	$_SESSION['user_id'] = $_COOKIE['user_id'];
	$_SESSION['is_admin'] = $_COOKIE['id_admin'];
	
	header('Location:admin.php');
		
}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login to your account</title>
<link href="format.css" rel="stylesheet" type="text/css" />
</head>

<body>

<?php if( $_SESSION['logged_in'] != true ){ //if not logged in ?>

<div id="log_header">
<h1>Login To Your Account</h1>

<div id="log_content">
<?php
//if there is an error message, show it
if($error == true){
	echo '<h2>Incorrect Username or Password, Try again.</h2>';	
}
?>

<form action="login.php" method="post" id="log_form">

	<label for="username">Username:</label>
    <input type="text" name="username" id="username" class="username" />
    
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" class="password" />
    <input type="submit" value="Login"  class="button" />
    <input type="hidden" name="did_login" value="true" />
    
</form>
</div>
</div>
<?php }else{ //end if not logged in?>  


   <h1>Welcome! <?php echo $_SESSION['user']; ?> You are logged in!</h1>
	<p><a href="login.php?action=logout">Log Out</a></p>
    <p><a href="protected.php?</a></p>
    
   
    
<?php } ?>

</div>
</body>
</html>