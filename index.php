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

<script src="js/jquery-3.1.0.min.js"></script>
<script src="js/custom.js"></script>
</head>

<body class="<?php echo $page; ?>">


<!-- Include the Header -->
<?php include('includes/header.php'); ?>

<section class="slideshow">
	<div class="container text-center">
		<h1>Welcome to NPalomares Scratch</h1>
		<p>This is where all my future PHP / MySQL work will go.</p>
	</div>
</section>
 
  
<div class="wrapper"> 
	<div class="container">
		<main class="content col-sm-8">
			<?php
			//switch to determine what content to show
			//url will look something like index.php?page=blog
			switch($page){
					case 'blog':
					include('blog_content.php');
					break;
					case 'single':
					include('single_content.php');
					break;
					case 'category':
					include('category_content.php');
					break;
					case 'search':
					include('search.php');
					break;
					default:
					include('home_content.php');
				
			}
			?>
		</main><!--END CONTENT-->
		
		<?php include ('includes/aside.php') ?>
	</div><!-- close container --> 
</div><!-- close wrapper -->


<!-- include the footer -->
<?php include('includes/footer.php'); ?>

  
</div>
<!--END WRAPPER-->
</body>
</html>