<?php //make sure the user submitted the register form
if($_POST['did_register'] == 1){
	//extract and clean data
	$input_username = clean_input($_POST['username']);
	$input_password = clean_input($_POST['password']);
	$input_repassword = clean_input($_POST['repassword']);
	$input_email = clean_input($_POST['email']);
	$input_policy = clean_input($_POST['policy']);
	//encrypted version of the password
	$sha_password = sha1($input_password);
	
	//validate!
	$valid = true;
	
	//policy was not checked
	if( $input_policy != 1 ){
		$valid = false;
		$error_msg = 'You must agree to the terms of service and privacy policy. <br />';
	}
	
	//password does not match password confirmation
	if( $input_password != $input_repassword ){
		$valid = false;
		$error_msg .='The passwords provided do not match.<br />';
	}
	
	//check to see if username and password are the correct length
	if( strlen($input_username) >= $min_username_length 
	AND strlen($input_password) >= $min_password_length ){
		//check to see if the username is already taken
		$query_un = "SELECT username
					FROM users
					WHERE username = '$input_username'
					LIMIT 1";
		//run it
		$result_un = mysql_query($query_un);
		
		//if one row comes back in the result, username is taken. 
		if( mysql_num_rows($result_un) == 1 ){
			$valid = false;
			$error_msg .= 'Sorry, That username is already taken. Try again<br />';
		}
	}else{
		$valid = false;
		$error_msg .= "Username must be at least $min_username_length characters long. Password must be at least $min_password_length characters long.<br /> ";	
	}
	
	//check for valid email format before looking up email in the db
	if( check_email_address($input_email) ){
		//look for existing email in DB
		$query_email = "SELECT email
						FROM users
						WHERE email = '$input_email'
						LIMIT 1";
		$result_email = mysql_query($query_email);
		if( mysql_num_rows($result_email) == 1 ){
			$valid = false;
			$error_msg .= 'That email address already exists. Try logging in.<br />';			
		}
	}else{
		//bad email format
		$valid = false;
		$error_msg .= 'Please provide a valid email address.<br />';	
	}
	
	//if the form passed all the tests, SUCCESS. add the user to the DB
	if( $valid == true ){
		$query_insert = "INSERT INTO users
						(username, email, password, join_date, is_admin)
						VALUES
				('$input_username', '$input_email', '$sha_password', now(), 0)";
		$result_insert = mysql_query($query_insert);
		if( mysql_affected_rows() == 1 ){
			//success! log them in
			$_SESSION['logged_in'] = true;
			setcookie('logged_in', true, time() + 60 * 60 * 24 * 14);
			//redirect the user to the secret profile page
			header('location:admin.php');
		}else{
			$error_msg = 'An error occurred during account creation.';	
		}
	}
	
}// end if user submitted form