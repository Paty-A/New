<div id="title">Manage Vendors</div>
<script type="text/javascript">
var url = "vendors2.php";
var page_params = {
	curr_action: "edit",
	id: "",
	content: "",
	field: ""
};
var name_params = Object.clone(page_params);
var phone_params = Object.clone(page_params);
var fax_params = Object.clone(page_params);
var email_params = Object.clone(page_params);
var checkpayable_params = Object.clone(page_params);
var address_params = Object.clone(page_params);

name_params.field = "v_name";
phone_params.field = "v_phone";
fax_params.field = "v_fax";
email_params.field = "v_email";
checkpayable_params.field = "check_payable";
address_params.field = "v_address";
</script>
<table width="900" border="1" class="small_txt">
<tr>
<th><strong>Name</strong></th>
<th><strong>Phone</strong></th>
<th><strong>Fax</strong></th>
<th><strong>E-mail</strong></th>
<th><strong>Check Payable</strong></th>
<th><strong>Address</strong></th>
<th>&nbsp;</th>
</tr>

<?
$inlinecss ="font-size:10px;padding:1px 1px 1px 1px";

$sql = "SELECT * FROM vendor ORDER BY v_name ASC";
$result = mysql_query($sql);
while ($row=mysql_fetch_array($result)) {
$v_name = ($row[v_name]) ? $row[v_name] : "&nbsp;";
$v_phone = ($row[v_phone]) ? $row[v_phone] : "&nbsp;";
$v_fax = ($row[v_fax]) ? $row[v_fax] : "&nbsp;";
$v_email = ($row[v_email]) ? $row[v_email] : "&nbsp;";
$check_payable = ($row[check_payable]) ? $row[check_payable] : "&nbsp;";
$v_address = ($row[v_address]) ? $row[v_address] : "&nbsp;";
$hide = $row['hide'];
if ($hide==1) {
$bgcolor = " bgcolor=\"#CCCCCC\"";
}
else {
$bgcolor = "";
}

echo "<tr$bgcolor>";
echo "<td class='editinplace' style=\"$inlinecss\"><div id='a$row[vid]'>$v_name</div><script type='text/javascript'>makeEditable('a$row[vid]', url, name_params);</script></td>";
echo "<td class='editinplace' style=\"$inlinecss\"><div id='b$row[vid]'>$v_phone</div><script type='text/javascript'>makeEditable('b$row[vid]', url, phone_params);</script></td>";
echo "<td class='editinplace' style=\"$inlinecss\"><div id='c$row[vid]'>$v_fax</div><script type='text/javascript'>makeEditable('c$row[vid]', url, fax_params);</script></td>";
echo "<td class='editinplace' style=\"$inlinecss\"><div id='d$row[vid]'>$v_email</div><script type='text/javascript'>makeEditable('d$row[vid]', url, email_params);</script></td>";
echo "<td class='editinplace' style=\"$inlinecss\"><div id='e$row[vid]'>$check_payable</div><script type='text/javascript'>makeEditable('e$row[vid]', url, checkpayable_params);</script></td>";
echo "<td class='editinplace' style=\"$inlinecss\"><div id='f$row[vid]'>$v_address</div><script type='text/javascript'>makeEditable('f$row[vid]', url, address_params);</script></td>";
//echo "<td>[<a href=\"vendors2.php?curr_action=del&vid=$row[vid]\">del</a>]</td>";


echo "<td>";
if ($hide==1) {
  echo "[<a href=\"vendors2.php?curr_action=hide&vid=$row[vid]&hide=0\">Un-Hide</a>]";   
}
else {
  echo "[<a href=\"vendors2.php?curr_action=hide&vid=$row[vid]&hide=1\">Hide</a>]";   
}

echo "</td>";

echo "</tr>";
}
?>

<tr>
<td colspan="7">
<form method="post" action="vendors2.php"><br />

<table border="0" class="submit_table" style="border-width:0px">
<tr>
<td><strong>Vendor Name:</strong></td>
<td><input type="text" name="v_name"></td>
</tr>

<tr>
<td><strong>Vendor Phone:</strong></td>
<td> <input type="text" name="v_phone"></td>
</tr>

<tr>
<td><strong>Vendor Fax:</strong></td>
<td><input type="text" name="v_fax"></td>
</tr>

<tr>
<td><strong><strong>Vendor E-mail:</strong></strong></td>
<td><input type="text" name="v_email"></td>
</tr>

<tr>
<td colspan="2">
<input type="hidden" name="curr_action" value="add"><input type="hidden" value="index.php?p=items" name="current_url"><input class="submit" type="submit" value="Add Vendor">
</td>
</tr>
</table>
</form>
</td>
</tr>
</table>

