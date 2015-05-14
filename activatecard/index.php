<?
require("config.php");






?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<title>
Just Salad Loyalty Card Activation
</title>

<!-- Meta Tags -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<!-- CSS -->
<link rel="stylesheet" href="css/structure.css" type="text/css" />
<link rel="stylesheet" href="css/form.css" type="text/css" />
<link rel="stylesheet" href="css/theme.css" type="text/css" />

<!-- JavaScript -->

<script language="JavaScript" src="gen_validatorv31.js" type="text/javascript"></script>
</head>

<body id="public">
	
<img id="top" src="images/top.png" alt="" />
<div id="container">

<h1 id="logo"><a>Wufoo</a></h1>

<form id="form4" name="form4" class="wufoo topLabel" autocomplete="off"
	enctype="multipart/form-data" method="post" action="#public">

<div class="info">
	<h2>Just Salad Loyalty Card Activation</h2>
	
<?
$form_submit = $_POST['form_submit'];
$email = $_POST['Field4'];
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
  $email_valid=true;
}
else {
  $email_valid=false;
  echo "Invalid E-mail, please re-try.";
}

if ($form_submit&&$email_valid) {
$card = $_POST['Field115'];
$fname = $_POST['Field2'];
$lname = $_POST['Field3'];
$gender = $_POST['Field113'];
$company = $_POST['Field117'];
$streetaddress = $_POST['Field5'];
$city = $_POST['Field7'];
$state = $_POST['Field8'];
$zip = $_POST['Field9'];
$country = $_POST['Field10'];
$favlocation = $_POST['Field119'];

// check to see if this loyalty card has been registered before
/*$sql = "SELECT * FROM `customer` WHERE card=$card";
//echo $sql;
$result = mysql_query($sql);
$rows = mysql_num_rows($result);
if ($rows>0) {
echo "It looks like you have already registered this loyalty card.  If you believe you are seeing this message in error, please send an e-mail to web@justsalad.com with your name, and loyalty card number.";
exit;
}
*/
// continue to register loyalty card

$sql = "
INSERT INTO `customer` (
card,
fname,
lname,
email,
gender,
company,
streetaddress,
city,
state,
zip,
country,
favlocation
)
VALUES (
'$card',
'$fname',
'$lname',
'$email',
'$gender',
'$company',
'$streetaddress',
'$city',
'$state',
'$zip',
'$country',
'$favlocation'
)
";

mysql_query($sql);

$to = $email;
$subject = "Your Just Salad Loyalty Card is now registered";
$from = "no-reply@justsalad.com";
$email_content = "Dear $fname,<br><br>";
$email_content .= "Thank you for registering your Just Salad Loyalty card.  Your card now entitles you to:<br><br>

<li>5% off your purchase in stores before 2PM.</li>
<li>10% off your purchase in stores after 2PM.</li>
<li>5% and 10% discounts for orders placed online at <a href=\"http://justsalad.com/2012/04/10/how-to-activate-link-your-loyalty-card/\">OrderJustSalad.com</a>.</li>
<li>Access to our monthly VIP promotions (see our <a href=\"http://www.justsalad.com/blog\">blog</a> for details).</li>

<br><br>
If you have any questions at all, please do not hesitate to e-mail us at <a href=\"mailto:comments@justsalad.com\">comments@justsalad.com</a>.  Thank you for being a loyal Just Salad customer.<br>

<br>

Sincerely,<br>
Team Just Salad<br><br>
Follow us: <a href=\"http://www.twitter.com/justsalad\">Twitter</a> | <a href=\"http://www.facebook.com/justsalad\">Facebook</a> | <a href=\"http://www.justsalad.com/blog\">Blog</a> | <a href=\"http://www.justsalad.com/newsletter\">Newsletter</a> | <a href=\"http://www.saladmatch.com\">SaladMatch</a>";



mail($to, $subject, $email_content,
     "From: $from\r\n" .
	 "Content-Type: text/html; charset=iso-8859-1\n" .
     "Reply-To: $from\r\n" .
     "X-Mailer: PHP/" . phpversion());


echo "Congratulations $fname, your Just Salad loyalty card has been activated. Thank you for participating in the Just Salad Stimulus Package!<br><br><a href=\"http://www.twitter.com/justsalad\"><img src=\"http://www.justsalad.com/email/twitter.gif\" border=\"0\"></a>&nbsp;&nbsp;<a href=\"http://www.twitter.com/justsalad\"> Follow us on Twitter</a><br><a href=\"http://www.justsalad.com/facebook\"><img src=\"http://www.justsalad.com/email/facebook.gif\" border=\"0\"></a>&nbsp;&nbsp;<a href=\"http://www.justsalad.com/facebook\"> Be our Fan on Facebook</a><br><br>  We look forward to seeing you soon!<br><br><a href=\"http://www.justsalad.com\">Back to JustSalad.com</a>";
echo "</div>";
exit;
} // end if submit
?>	
	
	<div>Welcome to the Just Salad Loyalty Card activation form.  Please fill in the fields below and click "finish."</div>
</div>

<ul>

	
<li id="foli115" class="   ">
	<label class="desc" id="title115" for="Field115">
Loyalty Card # (Last 5 Digits on back of card) </label>
	<div>
<input id="Field115" 	name="Field115" 	type="text" 	class="field text medium"  	value="" 	maxlength="5" 	tabindex="1" onkeyup="validateRange(115, 'digit');" />
<label for="Field115">Maximum Allowed: <var id="rangeMaxMsg115">5</var> digits.&nbsp;&nbsp;&nbsp; <em class="currently">Currently Used: <var id="rangeUsedMsg115">0</var> digits.</em></label>
	</div>
<p class="instruct" id="instruct115"><small>Please enter the last 5 digits of your loyalty card.  This can be found on the back of your loyalty card, and is in the format 21288-0000-XXXXX.</small></p>
	</li>


<li id="foli2" class="   ">
	<label class="desc" id="title2" for="Field2">
Name
	</label>
	<span>
<input id="Field2" 	name="Field2" 	type="text" 	class="field text" 	value="" 	size="8" 	tabindex="2" 	/>
<label for="Field2">First</label>
	</span>
	<span>
<input id="Field3" 	name="Field3" 	type="text" 	class="field text" 	value="" 	size="14" 	tabindex="3" 	/>
<label for="Field3">Last</label>
	</span>
	</li>


<li id="foli4" class="   ">
	<label class="desc" id="title4" for="Field4">
Email Address
	</label>
	<div>
<input id="Field4" 	name="Field4" 	type="text" 	class="field text medium" 	value="" 	maxlength="255" 	tabindex="4" 	/> 
	</div>
<p class="instruct" id="instruct4"><small>something@example.com</small></p>
	</li>


<li id="foli113" class="   ">
	<label class="desc" id="title113" for="Field113">
Gender
	</label>
	<div>
<select id="Field113" 	name="Field113" 	class="field select medium" 	tabindex="5"> 
<option value="Female" >
Female
	</option>
<option value="Male" selected="selected">
Male
	</option>
	</select>
	</div>
	</li>


<li id="foli117" class="   ">
	<label class="desc" id="title117" for="Field117">
Company Name
	</label>
	<div>
<input id="Field117" 	name="Field117" 	type="text" 	class="field text medium" 	value="" 	maxlength="255" 	tabindex="6" />
	</div>
<p class="instruct" id="instruct117"><small>Please enter the name of the company where you work.</small></p>
	</li>


<li id="foli5" class="   ">
	<label class="desc" id="title5" for="Field5">
Work Address
	</label>
	<div class="column">
<span class="full">
<input id="Field5" 	name="Field5" 	type="text" 	class="field text addr" 	value="" 	tabindex="7" 	/>
<label for="Field5">Street Address</label>
</span>
<span class="left">
<input id="Field7" 	name="Field7" 	type="text" 	class="field text addr" 	value="New York" 	tabindex="9" 	/>
<label for="Field7">City</label>
</span>
<span class="right">
<input id="Field8" 	name="Field8" 	type="text" 	class="field text addr" 	value="NY" 	tabindex="10" 	/>
<label for="Field8">State</label>
</span>
<span class="left">
<input id="Field9" 	name="Field9" 	type="text" 	class="field text addr" 	value="" 	maxlength="15" 	tabindex="11" 	/>
<label for="Field9">Zip Code</label>
</span>
<span class="right">
<select id="Field10" 	name="Field10" 	class="field select addr" 	tabindex="12" 	>
	<option value=""></option>

<option value="China">China</option>
<option value="Singapore">Singapore</option>
<option value="United States" selected="selected">United States</option>
</select>
<label for="Field10">Country</label>
</span>
	</div>
<p class="instruct" id="instruct5"><small>Please enter the address where you work.  If you get Just Salad delivered to your home, you may enter your home address.</small></p>
	</li>


<li id="foli119" class="   ">
	<label class="desc" id="title119" for="Field119">
Which Just Salad location do you visit most often?
	</label>
	<div>
<select id="Field119" 	name="Field119" 	class="field select medium" 	tabindex="13"> 

<option value="6" selected="selected">
706 6th Ave
	</option>
<option value="3">
100 Maiden Lane
	</option>
<option value="2" >
134 West 37th
	</option>
<option value="1" >
320 Park Ave
	</option>
            <option value="4">30 Rockefeller</option>
            <option value="5">600 Third Ave</option>
<option value="7">49th and 8th Ave (WWP)</option>
<option value="8">663 Lexington</option>
<option value="9">8th Street</option>
<option value="10">Park Slope</option>
<option value="11">83rd and 3rd</option>
	</select>
	</div>
	</li>


	
	<li class="buttons">
	<input type="hidden" name="form_submit" value="true">
<input id="saveForm" class="btTxt" type="submit" value="Activate Card" />
	</li>

	<li style="display:none">
<label for="comment">Do Not Fill This Out</label>
<textarea name="comment" id="comment" rows="1" cols="1"></textarea>
	</li>
</ul>
</form>
<script language="JavaScript" type="text/javascript">
 var frmvalidator = new Validator("form4");
 frmvalidator.addValidation("Field4","maxlen=60");
 frmvalidator.addValidation("Field4","req","Please enter your E-mail Address");
 frmvalidator.addValidation("Field4","email");
 
</script>


</div><!--container-->
<img id="bottom" src="images/bottom.png" alt="" />


	
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-75921-8");
pageTracker._trackPageview();
} catch(err) {}</script>   

<script type="text/javascript">
document.write(unescape("%3Cscript src='" + ((document.location.protocol=="https:")?"https://snapabug.appspot.com":"http://www.snapengage.com") + "/snapabug.js' type='text/javascript'%3E%3C/script%3E"));</script><script type="text/javascript">
SnapABug.addButton("8054a1c7-929d-4660-9b61-8e3d20d02e4d","1","0%", true);
</script>

</body>
</html>