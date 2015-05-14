<?

$user_id = $_GET['user_id'];
$sql = "SELECT * FROM `user` WHERE user_id=$user_id";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);
$user_full_name = $row['user_fname'] . " " . $row['user_lname'];

if ($row['user_admin']==1) {
$admin_check = " checked";
$admin_name = " (Administrator)";
}

if ($msgid) {
echo "<center><div class=\"msg\">" . $msg[$_GET['msgid']] . "</div></center><br>";
}
?>

<div id="title"><?=$user_full_name . $admin_name?></div>
<form method="post" action="users2.php">
<table>
<tr>
<th>Admin?</th>
<td><input type="checkbox" name="user_admin"<?=$admin_check?>></td>
</tr>

<tr>
<th>Stores</th>
<td>
  <table>
<?
$sql = "SELECT * FROM `location` ORDER BY loc_name ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
$loc_id = $row['loc_id'];
$loc_name = $row['loc_name'];
  $usql = "SELECT * FROM `user_location` WHERE user_id=$user_id AND loc_id=$loc_id";
  $uresult = mysql_query($usql);

  // User HAS access to this restaurant
  if (mysql_num_rows($uresult)>0) {
  $perm = true;
  $ptext = "remove";
  $bgcolor = " bgcolor=\"#66CC66\"";
  }
  // User does not have access to this restaurant
  else {
  $perm = false;
  $ptext = "add";
  $bgcolor = " bgcolor=\"#ff6666\"";
  }
echo "<tr$bgcolor>";
echo "<td>[<a href=\"users2.php?curr_action=permissions&user_id=$user_id&loc_id=$loc_id&change=$ptext\">$ptext</a>]</td>";
echo "<td>$loc_name</td>";
echo "</tr>\n";
}
?>
  </table>
</td>
</tr>
<tr>
<td colspan="2">
<input type="hidden" name="curr_action" value="permissions">
<input type="hidden" name="user_id" value="<?=$user_id?>">
<input type="submit" value="Edit User">
</td>
</tr>

</table>

</form>
<br>

<strong>Reset Password</strong>
<form method="post" action="users2.php">
<table>
<tr>
<th>New Password: </th>
<td><input type="text" name="user_pass"></td>
</tr>
<tr><td colspan="2">
<input type="hidden" name="user_id" value="<?=$user_id?>">
<input type="hidden" name="curr_action" value="changepassword">
<input type="submit" value="Change Password">
</td></tr>
</table>
</form>

<br>

<a href="index.php?p=users">Back to Manage Users</a>