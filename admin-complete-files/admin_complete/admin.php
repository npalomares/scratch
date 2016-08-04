<?php include('admin_header.php'); ?>
 
    <div id="content">
    	<?php
		$page = $_GET['page'];
		switch($page){
			case 'write':
				include('admin_write.php');
			break;
			case 'manage':
				include('admin_manage.php');
			break;
			case 'edit':
				include('admin_edit.php');
			break;
			default:
				include('admin_dashboard.php');	
		}
		?>
    
    </div><!-- end #content -->
    
<?php include('admin_footer.php'); ?>
   