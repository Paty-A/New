<?
$countsql = "SELECT count(*) AS total FROM `po`";
$result = mysql_query($countsql);
$row = mysql_fetch_array($result);
$num_orders = $row['total'];

?>

<div id="title">Main</div>

<table border="1" width="400">
<tr>
<th><strong>Total Orders:</strong></th>
<td><?=$num_orders?></td>
</tr>


</table>