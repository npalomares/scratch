<?php include('db.php');?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Slideshow</title>
<script type="text/javascript" language="javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.cycle.all.js"></script>
<script type="text/javascript" language="javascript">
$('.slideshow').cycle({
	fx: 'scrollHorz',
	speed: 'fast',
	pause: 1,
	next: '.next',
	prev: '.prev',
	
	
	});



</script>
</head>

<body>
<a href="javascript:;" class="prev">PREVIOUS</a>
<a href="javascript:;" class="next">NEXT</a>
<div class="slideshow">
	<?php $query = "SELECT avatar_link
					FROM users"; 
	$result = mysql_query($query);
	while($row = mysql_fetch_array($result)){
		//only show it if they have an avatar
		if($row['avatar_link'] != ''){
	?>
    <img src ="<?php echo $row['avatar_link']; ?>" alt="userpic" />
   <?php 
   }//end if
}//end while
?>

</div>

</body>
</html>