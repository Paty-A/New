<script type="text/javascript">
var url = "users2.php";
var params = {
	id: "",
	content: "",
	field: "",
	curr_action: "edit"
};
var lname_params = Object.clone(params);
var fname_params = Object.clone(params);
var username_params = Object.clone(params);
var email_params = Object.clone(params);
var cell_params = Object.clone(params);

lname_params.field = "user_lname";
fname_params.field = "user_fname";
username_params.field = "username";
email_params.field = "user_email";
cell_params.field = "user_cell";
</script>

<div id="title">Manage Users</div>

<?
if ($_GET['show']!="all") {
echo "<div class=\"small_link\"><a href=\"index.php?p=users&show=all\">Show All Users</a></div>";
}
?><br />

<table width="700">
<tr>
<th>Last</th>
<th>First</th>
<th>UserName</th>
<th>E-mail</th>
<th>Cell</th>
<th>Permissions</th>
</tr>

<?
if ($_GET['show']=="all") {
//
}
else {
$sqladd = " WHERE user_disable!=1";
}

$sql = "SELECT * FROM user$sqladd ORDER BY user_lname ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
$user_lname = ($row[user_lname]) ? $row[user_lname] : "&nbsp;";
$user_fname = ($row[user_fname]) ? $row[user_fname] : "&nbsp;";
$username = ($row[username]) ? $row[username] : "&nbsp;";
$user_email = ($row[user_email]) ? $row[user_email] : "&nbsp;";
$user_cell = ($row[user_cell]) ? $row[user_cell] : "&nbsp;";

if ($row['user_disable']==1) {
$bgcolor = " bgcolor=\"#CCCCCC\"";
} 

echo "<tr$bgcolor>";
echo "<td class='editinplace'><div id='a$row[user_id]'>$user_lname</div><script type='text/javascript'>makeEditable('a$row[user_id]', url, lname_params);</script></td>";
echo "<td class='editinplace'><div id='b$row[user_id]'>$user_fname</div><script type='text/javascript'>makeEditable('b$row[user_id]', url, fname_params);</script></td>";
echo "<td class='editinplace'><div id='c$row[user_id]'>$username</div><script type='text/javascript'>makeEditable('c$row[user_id]', url, username_params);</script></td>";
echo "<td class='editinplace'><div id='d$row[user_id]'>$user_email</div><script type='text/javascript'>makeEditable('d$row[user_id]', url, email_params);</script></td>";
echo "<td class='editinplace'><div id='e$row[user_id]'>$user_cell</div><script type='text/javascript'>makeEditable('e$row[user_id]', url, cell_params);</script></td>";

echo "<td align=\"center\">[<a href=\"index.php?p=edituser&user_id=$row[user_id]\">Edit</a>]</td>";
echo "</tr>";
}
?>

</table>
<br />

<strong>Add User</strong>

<form method="post" action="users3.php"><br />

<table border="0" class="submit_table" style="border-width:0px">
<tr>
<th>First Name:</th>
<td><input type="text" name="user_fname"></td>
</tr>

<tr>
<th>Last Name:</th>
<td> <input type="text" name="user_lname"></td>
</tr>

<tr>
<th>UserName:</th>
<td><input type="text" name="username"></td>
</tr>

<tr>
<th>E-mail:</th>
<td><input type="text" name="user_email"></td>
</tr>






<tr>
<td colspan="2">
<input type="hidden" name="curr_action" value="add"><input type="hidden" value="index.php?p=users" name="current_url"><input class="submit" type="submit" value="Add User">
</td>
</tr>
</table>
<br /><br /><br />
</form>