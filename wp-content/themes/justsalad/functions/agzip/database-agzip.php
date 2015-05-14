<?
//include("functions/agzipfinder.php");
/**
 * Connect to the mysql database.
 */
$conn = mysql_connect("localhost", "zipfinder", "fnSYbC7q2z2UBELp") or die(mysql_error());
mysql_select_db('alleghenygraphics', $conn) or die(mysql_error());
?>