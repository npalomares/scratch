<?php 
session_start();
require('db_config.php');
include_once('functions.php');
require('register_parse.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Sign up for an account</title>

<style type="text/css">
input[type=text],
input[type=password],
input[type=submit]
{
	display:block;
	margin:5px 0 10px;	
}
</style>

</head>

<body>
<h1>Create your Account</h1>
<?php 
if( isset($error_msg) ){
	echo $error_msg;
}
?>

<form action="register.php" method="post">
	<label for="username">Choose a Username</label>
    <input type="text" name="username" id="username" value="<?php echo $input_username; ?>" />
    
    <label for="email">Email Address:</label>
    <input type="text" name="email" id="email" />
    
    <label for="password">Choose a Password:</label>
    <input type="password" name="password" id="password" />
    
    <label for="repassword">Repeat Password:</label>
    <input type="password" name="repassword" id="repassword" />
    
    <input type="checkbox" name="policy" id="policy" value="1" />
    <label for="policy">I agree to the Terms of Service and Privacy Policy</label>
    
    <input type="submit" value="Sign Up" />
    <input type="hidden" name="did_register" value="1" />
</form>
</body>
</html>