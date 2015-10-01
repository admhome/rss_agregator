<?php 
include('header.php');
echo '<div class="block_head"><h3>Change Password</h3></div>';
	
		if (isset($_POST['submit'])) {
		$password = $_POST['password'];
		$re_password = $_POST['re_password'];
		if (empty($password) OR empty($re_password)) {
		echo $general->notification('error','Fill All Fields Please.');
		} elseif ($password != $re_password) {
		echo $general->notification('error','The Password Does not Match The Confirmation.');
		} else {
		$pass = md5(md5($password));
		$update = mysql_query("UPDATE admin SET password='$pass' WHERE id='1'");
		if ($update) {
		echo $general->notification('success','Your Password Changed Successfully.');
		} else {
		echo $general->notification('error','Error Happened.');
		}
		}
		}
		echo '<form method="POST" action="">
				<table width="100%" cellpadding="5" cellspacing="0">
					<tr>
						<td class="label_td" width="200">Your New Password</td>
						<td class="input_td"><input type="password" name="password" size="40" /></td>
					</tr>
					<tr>
						<td class="label_td">New Password Confirmation</td>
						<td class="input_td"><input type="password" name="re_password" size="40" /></td>
					</tr>
					<tr>
						<td colspan="2"><input type="submit" name="submit" class="inputbutton grey" value="Change Password" /></td>
					</tr>
				</table>
			</form>';
include('footer.php'); 
?>  