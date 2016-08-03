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
<link href="format.css" rel="stylesheet" type="text/css" />
</head>
<body class="<?php echo $page; ?>">
<div id="wrapper">
	<?php include('includes/header.php'); ?>
 
  	
  	<?php include ('sidebar.php') ?>
  
 
  <div id="content" class="cf">
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
</div><!--END CONTENT-->

 
  <div id="footer">
&copy; <?php echo Date('Y'); ?> Nicholas Palomares |  Powered by PHP &amp; MYSQL
   </div><!--END FOOTER--> 
  
</div>
<!--END WRAPPER-->
</body>
</html>