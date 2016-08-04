<?php 
session_start();
require('db.php');
require_once('functions.php');

//is a previously logged in user (session closed, cookie still good) visits this page, automatically log them in
if($_COOKIE['login'] == true){
	$_SESSION['logged_in'] = true;	
	$_SESSION['user_id'] = $_COOKIE['user_id'];
	$_SESSION['is_admin'] = $_COOKIE['is_admin'];
}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Admin Dashboard - Npalomares</title>

<link href="css/grid.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/admin_style.css" rel="stylesheet">
</head>

<body class="dashboard">
<?php
//make sure a logged in person is viewing this page!
if($_SESSION['logged_in'] == true){
	//WHO is logged in?
	$user_id = $_SESSION['user_id'];
 ?>

<header class="header" role="banner">
	<div class="container">
		<h1>Manage Your Blog</h1>
	    
	    <ul class="utilities">
	    	<li class="username">			
			<?php 
			//get the name of the logged in person for a welcome message
			$query_username = "SELECT user_name
								FROM users
								WHERE user_id = $user_id
								LIMIT 1";
			$result_username = mysql_query($query_username);
			$row_username = mysql_fetch_array($result_username);
			echo 'Welcome ' . $row_username['username'];
			?>
			<p><?php echo "hello, " . $row_username['username']; ?></p>
	        </li>
	        
	        <li class="viewblog"><a href="index.php">View Blog</a></li>
	        <li class="logout"><a href="login.php?action=logout">Log Out</a></li>
	    </ul>
	    
	    
	    
	    <ul class="nav">
	    	<li><a href="admin.php">Dashboard</a></li>
	        <li><a href="admin.php?page=write">Write Post</a></li>
	        <li><a href="admin.php?page=manage">Manage Posts</a></li>
	        <li><a>Manage Comments</a></li>
	        <li><a href="admin.php?page=profile">Edit Profile</a></li>
	    </ul>	
	</div>
</header><!-- closes header -->

<div class="wrapper">
	<div class="container">   
	    <div class="content">
	    	<?php
			//switch based upon which admin page to show
			//URL will look like admin.php?page=edit
			switch($_REQUEST['page']){
				case 'write':
					include('admin-write.php');
				break;
				case 'profile':
					include('admin-profile.php'); //upload script
				break;	
				case 'manage':
					include('admin-manage.php'); 
				break;
				case 'edit':
					include('admin-edit.php'); 
				break;					
				default:
					include('admin-dashboard.php');
			}
			 ?>
	    
	    </div><!-- closes content -->

	</div><!-- close container -->    
</div><!-- closes wrapper -->


<?php } //end if logged in
else{
	echo 'You must be <a href="login.php">logged in</a> to view this content';	
}?>


<?php include('includes/footer.php'); ?>
</body>
</html>




