<?php
session_start();
error_reporting(E_ALL);
include('../include/config.php');
include('../include/database.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="css/admin.css" />
<title>Login To RSS Aggregator ContolPanel</title>
</head>
<body>
<?php
if (isset($_GET['do'])) {$do = $_GET['do'];} else {$do = '';}
switch ($do) {
case 'logout';
unset($_SESSION['admin']);
echo "<meta http-equiv='refresh' content='0;URL=login.php'>";
break;
default;
echo '<div class="login">
<h3>Login To RSS Aggregator Control Panel</h3>';
if (isset($_POST['login'])) {
$admin_name = strip_tags(trim(addslashes(mysql_real_escape_string($_POST['admin_name']))));
$admin_pass = strip_tags(trim(addslashes(mysql_real_escape_string($_POST['admin_pass']))));
$query = mysql_query("SELECT * FROM admin WHERE admin='$admin_name'");
$check = mysql_num_rows($query);
if ($check == 0) {
$message = '<p class="notification">You Have Entered Wrong Data</p>';
} else {
$row = mysql_fetch_assoc($query);
if (md5(md5($admin_pass)) == $row['password']) {
$_SESSION['admin'] = 1;
echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
} else {
$message = '<p class="notification">You Have Entered Wrong Data</p>';
}
}
}
?>
<form method="POST" action="">
<table class="login_table">
<?php if (isset($message)) { ?>
<tr>
<td colspan="2"><?php echo $message; ?></td>
</tr>
<?php } ?>
<tr>
<td class="login_td">Username</td>
<td class="login_td"><input type="text" name="admin_name" size="30" /></td>
</tr>
<tr>
<td class="login_td">Password</td>
<td class="login_td"><input type="password" name="admin_pass" size="30" /></td>
</tr>
<tr>
<td class="no_border"><input type="submit" name="login" class="inputbutton grey" value="Login" /></td>
<td align="right" class="no_border"></td>
</tr>
</table>
</form>
</div>
<?php
}
?>
</body>
</html>