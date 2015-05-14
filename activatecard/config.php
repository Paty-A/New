<?
// Config Page

// DB Setup
$hostname = "localhost";
$databasename = "salad_pub";
$username = "salad_pub";
$password = "JS2008";


function showerror() {
  die("Error " . mysql_errno() . " : " . mysql_error());
}

if (!($connection = @ mysql_connect($hostname,$username,$password)))
  die("Could not connect to database");

if (!mysql_select_db($databasename, $connection))
  showerror();
  

  


?>