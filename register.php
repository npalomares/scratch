<?php
session_start();
require('db.php');
require_once('functions.php');

//parse the form if they pressed the button
if($_REQUEST['did_register'] == 1){
	
	//clean all inputs
	$input_username = clean_input($_REQUEST['username']);
	$input_email = clean_input($_REQUEST['email']);
	
	//un-encrypted password
	$original_password = clean_input($_REQUEST['password']);
	
	//encrypted password and repeat password
	$sha_password = sha1($original_password);
	$sha_repassword = sha1(clean_input($_REQUEST['repassword']));
	$input_policy = clean_input($_REQUEST['policy']);
	
	//validate!
	$valid = true;
	
	//did they forget to check the policy box?
	if( $input_policy != 1 ){
		$valid = false;
		$msg = 'You must accept the terms and privacy policy. <br />';
	}
	
	//typed in mismatched passwords
	if( $sha_password != $sha_repassword ){
		$valid = false;
		$msg .= 'The two passwords provided must match. <br />';
	}
	
	//username and password meet the minimum requirements
	if( strlen($input_username) >= 5 AND strlen($original_password) >= 5 ){
		//check to see if the username is taken		
		$query_username = "SELECT user_name
							FROM users
							WHERE user_name == '$input_username'
							LIMIT 1";
		//run it
		$result_username = mysql_query($query_username);
		//if one result found, username is already taken
		if( mysql_num_rows($result_username) >= 1 ){
			$valid = false;
			$msg .= 'That username is already taken, try another. <br />';
			
		}
							
	}else{ // min requirements not met
		$valid = false;
		$msg .= 'Username and Password must be at least 5 characters long. <br />';
		
	}
	
	//check for valid email
	if( check_email_address($input_email) == true ){
		//Check DB if email is already taken
		$query_email = "SELECT email
						FROM users
						WHERE email = '$input_email'
						LIMIT 1";
		//run it
		$result_email = mysql_query($query_email);
		//if one result found, email is already taken
		if( mysql_num_rows($result_email) >= 1 ){
			$valide = false;
			$msg .= 'Looks like that email is already registered. Login? <br />';
			
		}
		
	}else{//invalid email
		$valid = false;
		$msg .= 'You must provide a valide email address. <br />';
	}
	//if the data is valid, GO! Add user to DB and log them in
	if($valid == true){
		$query_insert = "INSERT INTO users
						(user_name, email, password, join_date, is_admin)
						VALUES
						('$input_username', '$input_email', '$sha_password', now(), 0 )";
	//run it
		$result_insert = mysql_query($query_insert);
		//make sure the query worked, give user feedback
		if( mysql_affected_rows() >= 1){
			//log em in
			$_SESSION['logged_in'] = true;
			//who is logged in? get the last added user_id
			$_SESSION['user_id'] = mysql_insert_id();	
			
			setcookie('login', true, time() + 60*60*24*7 );
			setcookie('user_id', $_SESSION['user_id'], time() + 60*60*24*7 );
			
			//what level are they
				$_SESSION['is_admin'] = 1;
				setcookie('is_admin', 1, $expire );
				
			//redirect to admin panel
			header('Location:index.php');
			
		}else{
			//insert failed
			$msg .= 'An error occurred during account creation. Try again. ';	
		}
		
		
	}
	
}//end if pressed the button
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Registration</title>
<link href="format.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="reg-header">
<h1>Sign up for an Account</h1>

<div id="reg-content">
<?php
if( isset($msg) ){
	echo $msg;	
}
?>

<form method="post" action="register.php" id="reg_form">
	<label for="username">Create a Username:</label>
    <input type="text" name="username" class="username" />
    <label for="email">Your Email Address:</label>
    <input type="text" name="email" class="email" />
    <label for="password">Create a Password:</label>
    <input type="password" name="password" class="password" />
    <label for="repassword">Retype Your Password:</label>
    <input type="password" name="repassword" class="repassword" />
    
    <input type="checkbox" name="policy" class="policy" value="1" />
    <label for="policy">Yes, I have read and agree to the<br /> <a href="#">terms of service and privacy policy</a>. </label>
    
    <input type="submit" value="Register" class="button" />
    <input type="hidden" name="did_register" value="1" />

</form>
</div><!--close content-->
</div><!--close header-->

</body>
</html>