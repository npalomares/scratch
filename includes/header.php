<?php 
require('db.php');
require_once('functions.php');
//figure out what page to show
$page = $_GET['page'];
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>NPalomares - Home Page</title>
<link href="css/grid.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
</head>

<body class="<?php echo $page; ?>">


<header class="header" role="banner">
	<div class="container">
		<div class="logo col-sm-5">
			<h1><a href="index.php">Npalomares - Scratch</a></h1>
		</div>

		<div class="col-sm-7">
			<nav class="nav" role="navigation">
				<ul class="pull-right">
					<li><a href="index.php">Home</a></li>
					<li><a href="about.php">About</a></li>
					<li><a href="index.php?page=blog">Blog</a></li>
					<li><a href="contact.php">Contact</a></li>
					<li><a href="register.php" class="register">Register</a></li>
				</ul>
			</nav>

		</div>
	</div><!-- close container -->   
</header><!--END HEADER-->
