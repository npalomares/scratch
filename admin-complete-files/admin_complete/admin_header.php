<?php
session_start();
require('db_config.php');
include_once('functions.php');

//if a returning user still has a valid cookie, re-create the session vars
if( $_COOKIE['logged_in'] == true ){
	$_SESSION['logged_in'] = true;
	$_SESSION['user_id'] = $_COOKIE['user_id'];
	
} 
//if viewer is not logged in, redirect to the login page
if($_SESSION['logged_in'] != true){
	header('location:login.php');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Panel</title>
<link type="text/css" rel="stylesheet" href="admin_style.css" />
</head>

<body>
<div id="wrapper">
	<div id="header">
		<h1>Admin Panel</h1>
        
        <ul class="utilities">
        	<li><a href="login.php?action=logout">Log Out</a></li>
            <li><a href="index.php">View Blog</a></li>
        </ul>
        
        <ul class="menu">
        	<li><a href="admin.php">Dashboard</a></li>
            <li><a href="admin.php?page=write">Write Post</a></li>
            <li><a href="admin.php?page=manage">Manage Posts</a></li>
            <li><a href="admin.php?page=comments">Manage Comments</a></li>
            <li><a href="admin.php?page=profile">Edit Profile</a></li>
        </ul>
    </div><!-- end #header -->