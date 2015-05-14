<?
/*
## Just Salad Purchase Order System
## Copyright (c) Matt Silverman 2007
## matt@mattsilv.com
## www.mattsilv.com
*/ 

require_once("config.php");


// Functions

// function nice_date parses date from format YYYYMMDD to MM/DD/YYYY
function nice_date($inputdate) {
$nice_date = substr($inputdate,4,2) . "/" . substr($inputdate,6,2) . "/"  . substr($inputdate,0,4);
return $nice_date;
}

// GET SETTINGS

function getSetting($sname) {
$sql = "SELECT * FROM `setting` WHERE sname='$sname'";
$result = mysql_query($sql);
$srow = mysql_fetch_array($result);
$svalue = $srow['svalue'];
return $svalue;
}

//


// Get Variables
$p = $_GET['p'];
$msgid = $_GET['msgid'];

// SET Admin Users
$users = array("rob","nick","admin","temp","ken");
if ( in_array( $_SERVER[ 'REMOTE_USER' ], $users ) ) {
$admin_login = true;
}
else {
$admin_login = false;
}

// Action Messages
$msg = array(
1 => "Item Added",
2 => "Item Removed",
3 => "Vendor Added",
4 => "Settings Updated",
5 => "Order Unlocked",
6 => "Order Voided",
7 => "Order Un-Voided",
8 => "Store Added",
9 => "Item Hidden",
10 => "Item Unhidden",
11 => "User Disabled",
12 => "Password Changed"
);
///////////////////

// find out the domain:
$domain = $_SERVER['HTTP_HOST'];
// find out the path to the current file:
$path = $_SERVER['SCRIPT_NAME'];
// find out the QueryString:
$queryString = $_SERVER['QUERY_STRING'];
// put it all together:
$current_url = $path . "?" . $queryString;

/*
function logincheck($user_id,$user_pass) {
$sql = "SELECT * FROM `user` WHERE user_id = $user_id AND user_pass = $user_pass";
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);
if ($numrows != 1) {
  header("Location: index.php?login=1");
}
else {
$logged_in = true;
}

}// end logincheck
*/




//function alertmsg($msgtxt) {
//$current_url = str_replace("&msgid=$msgid", "", $current_url);
//echo "<div class=\"msg\">$msgtxt [<a href=\"index.php?p=$p\">X</a>]</div>";
//}


// Page Navigation
/* Add entry for each new page that is made */

switch ($p) {

case "vendors": 
$inc_page = "vendors.php";
break;
case "items": 
$inc_page = "items.php";
break;
case "create": 
$inc_page = "create.php";
break;
case "vieworder": 
$inc_page = "vieworder.php";
break;
case "view": 
$inc_page = "view.php";
break;
case "order": 
$inc_page = "order.php";
break;
case "checkin": 
$inc_page = "checkin.php";
break;
case "completeorder": 
$inc_page = "completeorder.php";
break;
case "vendors": 
$inc_page = "vendors.php";
break;
case "reports": 
$inc_page = "reports.php";
break;
case "settings": 
$inc_page = "settings.php";
break;
case "inventory": 
$inc_page = "inventory.php";
break;
case "finalorder": 
$inc_page = "finalorder.php";
break;
case "viewreport": 
$inc_page = "viewreport.php";
break;
case "users": 
$inc_page = "users.php";
break;
case "stores": 
$inc_page = "stores.php";
break;
case "edituser": 
$inc_page = "edituser.php";
break;
case "commissary": 
$inc_page = "commissary.php";
break;
case "comm_editfinal": 
$inc_page = "comm_editfinal.php";
break;
case "comm_costs": 
$inc_page = "comm_costs.php";
break;
case "comm_editfinal2": 
$inc_page = "comm_editfinal2.php";
break;

// REPORTS
case "r_foodcostpct": 
$inc_page = "r_foodcostpct.php";
break;
case "r_itempricefluc": 
$inc_page = "r_itempricefluc.php";
break;
case "r_locationinvoicetotal": 
$inc_page = "r_locationinvoicetotal.php";
break;
case "r_locationinvoicetotal2": 
$inc_page = "r_locationinvoicetotal2.php";
break;
case "r_vendor_invoice_total": 
$inc_page = "r_vendor_invoice_total.php";
break;




default:
$inc_page = "main.php";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>JustSalad - Purchase Order System</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<style type="text/css">

body{ 
background-color:#dc8;
font-size:16px; 
margin:0; 
padding:0; 
}

a, a:visited {
color: black;
}

#center td, select, input, #center {
font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 14px;
}

#center input {
padding: 2px 0px 2px 0px;
}

#center td {
padding: 3px 3px 3px 3px;
}


#header{ 
background-color:#333;
height:130px;
padding: 0px 0px 0px 20px;
}

#left{ 
clear: left;
float:left;
width:200px;
background-color:#dc8; 
min-height:650px; /* for modern browsers */
height:auto !important; /* for modern browsers */
height:650px; /* for IE5.x and IE6 */
}

#left a,#left a:visited {
font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 16px;
text-decoration: none;
font-weight: bold;
color: black;
}

#left a:hover {
color: #996600;
}

#left li {
list-style-type: square;
padding: 10px 0px 0px 0px;
}

#center { 
margin-left:200px;
background-color:#eec; 
min-height:650px; /* for modern browsers */
height:auto !important; /* for modern browsers */
height:650px; /* for IE5.x and IE6 */
padding: 15px 0px 0px 15px;
}

#center td, #center table, #center th {
border-width: 1px;
border-color: black;
border-style: solid;
border-collapse: collapse;
padding: 4px 4px 4px 4px
}

#center th {
text-align: left;
padding: 4px 4px 4px 4px;
background: #333333;
color: #CCCCCC;
}

#footer { 
clear:both;
background-color:#333;
height:15px;
}

.msg {
border-color: #993300;
border-style: solid;
border-width: 1px;
font-family: "Trebuchet MS",verdana;
font-size: 16px;
font-weight: bold;
color: black;
padding: 5px 10px 5px 10px;
}

#logo {
float: left;
}

#po {
float: left;
font-family: "Trebuchet MS", verdana;
color: white;
font-size: 32px;
padding: 50px 0px 0px 18px;
font-weight: bold;
}

#title {
font-weight: bold;
font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 18px;
padding: 0px 0px 20px 0px;
}

.submit {
font-family: "Trebuchet MS", verdana;
font-size: 14px;
font-weight: bold;
}

.editable{
     color: #000;
     background-color: #ffffd3;
     cursor: text;
     width: 100%;
 }

 
 .editinplace input {
 padding: 0px 0px 0px 0px;
 border-width: 1px;
 border-color: black;
 border-style: solid;
 }
 
 #complete_button {
 font-size: 16px;
 font-weight: bold;
 background: #006600;
 color: white;
 font-weight: bold;
 padding: 15px 0px 0px 0px;
 }
 
 .submit_table, .submit_table td {
 border-width: 0px;
 }
 
 .small_link a{
 font-size: 10px;
 }
 
 .small_txt, .small_txt td,.small_txt input,.small_txt table td,.small_txt th, .small_txt table td input {
 font-size: 10px;
 }
 
 #small_txt {
 font-size: 10px;
 }
 
  .initial { background-color: #DDDDDD; color:#000000 }
  .normal { background-color: #eec }
  .highlight { background-color: #dc8 }
  
  .larger {
  font-size: larger;
  font-weight: bold;
  }
  
  .warning {
  width: 500px;
  border-color: #990000;
  border-width: 1px;
  border-style: solid;
  background: #FF6666;
  font-size: 16px;
  padding: 4px 4px 4px 4px;
  }
  

</style>
<script src="prototype.js" type="text/javascript"></script>
<script src="editinplace.js" type="text/javascript"></script> 

<script language="JavaScript">
function nav()
   {
   var w = document.vendorform.vid.selectedIndex;
   var url_add = document.vendorform.vid.options[w].value;
   window.location.href = url_add;
   }
</script>

<script language="Javascript">
 <!--

 function doClear(theText) 
{
     if (theText.value == theText.defaultValue)
 {
         theText.value = ""
     }
 }
 //-->
 </script>

</head>
<body>
<a name="top"></a>
<div id="header">
<div id="logo"><a href="index.php"><img src="img/logo.gif" border="0" /></a></div>
<div id="po">Purchase Order System</div>
</div>
<div id="left">
<ul>
<li><a href="index.php?p=create">Create Order</a></li>
<li><a href="index.php?p=view">View Order</a></li>
<? if ($admin_login) { ?>
<li><a href="index.php?p=inventory">Inventory</a></li>
<li><a href="index.php?p=items">Items</a></li>
<li><a href="index.php?p=vendors">Vendors</a></li>
<li><a href="index.php?p=commissary">Commissary</a></li>
<li><a href="index.php?p=stores">Stores</a></li>
<li><a href="index.php?p=users">Users</a></li>
<li><a href="index.php?p=reports">Reports</a></li>
<li><a href="index.php?p=settings">Settings</a></li>
<? } // end IF admin login?>
</ul>
	</div>
<div id="center">
<?

require_once($inc_page);

?>
	</div>
<div id="footer">
	</div>
</body>
</html>

