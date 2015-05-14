<?php

include("database-agzip.php");

$trimmed = trim($_GET['q']);
$query = mysql_query("SELECT city, state FROM zipcodes WHERE zipcode='$trimmed'") or die(mysql_error());
if($row=mysql_fetch_array($query)) {
	echo $row['city']."|__|".$row['state'];
}
else {
	echo 'false';
}

?>
