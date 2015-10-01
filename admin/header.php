<?php
session_start();
if(!isset($_SESSION['admin']) OR $_SESSION['admin'] == 0) {
header("location:login.php");
}
error_reporting(E_ERROR);
include('../include/config.php');
include('../include/database.php');
include('../include/pagination.class.php');
include('classes/general.class.php');
include('inc/functions.php');
$general = new General;
if (isset($_GET['do'])) {$do = $_GET['do'];} else {$do = '';}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/admin.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript" src="js/jquery_checkall.js"></script>
<script type="text/javascript" src="js/jquery.imagetick.min.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
<title>RSS Aggregator Contol Panel</title>
</head>
<body>
<div class="container">
<div class="menu">
<ul>
<li><a href="index.php">Index</a></li>
<li><a href="categories.php">Feed Categories</a></li>
<li><a href="feeds.php">Feed Sources</a></li>
<li><a href="feeditems.php">Feed Items</a></li>
<li class="right"><a href="login.php?do=logout">Logout</a></li>
<li class="right"><a href="changepassword.php">Change Password</a></li>
<li class="right"><a href="setting.php">Setting</a></li>
</ul>
</div>
<div class="header">
<h1>Rss Aggregator Script</h1>
</div>
<div class="content">