<?
// Config Page

// DB Setup
$hostname = "localhost";
$databasename = "salad_salad";
$username = "salad_salad";
$password = "js2007";

// Get them cookies
//$login = $_COOKIE['login'];
//$UserID = $_COOKIE['UserID'];
//$md5_password = $_COOKIE['password'];
//$FirstPageView = $_COOKIE['FirstPageView'];


function showerror() {
  die("Error " . mysql_errno() . " : " . mysql_error());
}

if (!($connection = @ mysql_connect($hostname,$username,$password)))
  die("Could not connect to database");

if (!mysql_select_db($databasename, $connection))
  showerror();
  

  


?>