<?php
/*
Template Name: Contact Us
*/
?>
<? 
require("functions/ws-js.php");


if($_POST['send']) {
	/* ERROR CHECKING */
	if(strlen($_POST['field0'])<2) {
		$error = "<li>You must provide Your Name.</li>";
		$fullname_error = true; 
	}



	if(!validateEmail($_POST['field1'], 1)) {
		$error .= "<li>The email address you have provided is invalid or incomplete.</li>";
		$email_error = true;
	}
	
	if(strlen($_POST['field2'])<10) {
		$error .= "<li>You must provide your Comments.</li>";
		$message_error = true;
	}
	if($error) {
		unset($_POST['send']);
	}
	else {
	/* PROCESSING CODE */
		/* WS PROCESSING VARS */
		$ws_input['ws_filename'] = basename($_SERVER['PHP_SELF']);
		$ws_input['ws_ip'] = $_SERVER['REMOTE_ADDR'];
		$ws_input['ws_domain'] = $_SERVER['HTTP_HOST'];
		$ws_input['ws_message'] = ws_catArray($_POST, "send");
		$ws_input['ws_email'] = $_POST["field1"];

		/* EMAIL VARS */
		$locemail=false;
		$xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/markers.xml');
 		for($i=0; $i<count($xml); $i++) {
			if($_POST['fieldloc']==$xml->marker[$i]->name && $xml->marker[$i]->contactemail!="") {
				$locemail = $xml->marker[$i]->contactemail;
				break;
			}
		}
		if($locemail) {
			$to = $locemail;
		}
		else {
			$to = $config["recipient"]["pass"];
		}
		$from = $_POST["field1"];
		$replyto = $from;
		$subject = "From ".str_replace("www.","",$_SERVER['HTTP_HOST']);
		
		
		if($_POST["field1"]){		
			$email = $_POST["field1"]."<br />
";
		}
		else{$email = '';}

	
	
		//Adjust the timezone so times in the email are correct
		date_default_timezone_set('America/New_York');

		/* HTML MESSAGE */
		$html = "The following message was sent through the website, ".date("F j, Y, g:i a").":<br />
<br />
<strong>MESSAGE</strong><br />
".stripslashes($_POST["field2"])."<br />
<br />
<strong>FROM:</strong><br />
".stripslashes($_POST["field0"])."<br />
".$email."<br /><br />
<strong>SELECTED LOCATION</strong><br />
".stripslashes($_POST["fieldloc"])."";

		$html = wordwrap($html, 75, "<br />
");

		/* PLAIN TEXT MESSAGE */
		$plain = str_replace(array('<br />', '<strong>', '</strong>'), '', $html);
		
		$http_response=false;
		//Uncomment to Call the WebsiteSpam Checker
		//$http_response = ws_checkIt($ws_input);

			
		if($http_response){
			$ws_test_results = ws_procStatCode($http_response);
			if(!$ws_test_results && $config["recipient"]["admin"]){
				ws_notify($config["recipient"]["admin"],"Warning: Unknown Return Value","The script could not understand value returned by the anti-spam system. The following value was returned: ".$http_response.". You may need to modify your script to interpret this value. Development help can be found at http://www.websitespam.com.");
			}
			$sent = multiMail($ws_test_results["recipient"], $ws_test_results["subject"].$subject, $plain, $html, $from, $replyto);
		}

		else{
			$sent = multiMail($to, $subject, $plain, $html, $from, $replyto);
		}
	}
}
get_header(); ?>

		<div id="container">
            <section id="content" role="main">
            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
                <h1 class="hide-small offscreen"><?php the_title(); ?></h1>	
                    		
				<?php the_content('<p>Read the rest of this page &rarr;</p>'); ?>
                <?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
				
				<?php endwhile; endif; ?>

<div id="contact-info-small">
    Contact us via email at<br />
    <a href="mailto:comments@justsalad.com">comments@justsalad.com</a><br />
    or by phone at<br />
    <span>212-244-1111</span>
</div>



<form method="post" action="" name="contactform" id="contactform">

	<? if($error) {echo "<div id='error'><strong>Please use the form below to correct the following errors:</strong><ul>".$error."</ul></div>";}?>

    	<div class="formfield <? if($fullname_error) echo "error";?>" >
            <label for="fieldloc">Select Location:</label><br />
            <div class="styled-select-0"><select name="fieldloc" id="fieldloc">
				<option value="-1">-- Please Select --</option>
				
				<? $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/markers.xml');
 				for($i=0; $i<count($xml); $i++) {
					if($xml->marker[$i]->region==2) { 
						$region="HK - ";
						if(substr($xml->marker[$i]->name,0,5)==$region) { $region=""; }

						$toscreen2.= '<option value="'.$xml->marker[$i]->name.'" ';
						if($_POST['fieldloc']==$xml->marker[$i]->name) { $toscreen2.= "selected"; }
						$toscreen2.= '>'.$region.$xml->marker[$i]->name.'</option>';
					}
					/*else if($xml->marker[$i]->region==3) { 
						$region="SG - ";
						if(substr($xml->marker[$i]->name,0,5)==$region) { $region=""; }

						$toscreen3.= '<option value="'.$xml->marker[$i]->name.'" ';
						if($_POST['fieldloc']==$xml->marker[$i]->name) { $toscreen3.= "selected"; }
						$toscreen3.= '>'.$region.$xml->marker[$i]->name.'</option>'; 
					}*/
					else if($xml->marker[$i]->region==5) { 
						$region="UAE - ";
						if(substr($xml->marker[$i]->name,0,5)==$region) { $region=""; }

						$toscreen4.= '<option value="'.$xml->marker[$i]->name.'" ';
						if($_POST['fieldloc']==$xml->marker[$i]->name) { $toscreen4.= "selected"; }
						$toscreen4.= '>'.$region.$xml->marker[$i]->name.'</option>'; 
					}
					else { 
						$region="US - "; 
						if(substr($xml->marker[$i]->name,0,5)==$region) { $region=""; }

						$toscreen1.= '<option value="'.$xml->marker[$i]->name.'" ';
						if($_POST['fieldloc']==$xml->marker[$i]->name) { $toscreen1.= "selected"; }
						$toscreen1.= '>'.$region.$xml->marker[$i]->name.'</option>';
					}
					


						
				 }
				echo $toscreen1.$toscreen2.$toscreen3.$toscreen4;
?>
<option value="-1">Any</option>
			</select></div>
        </div>

        <div class="formfield <? if($fullname_error) echo "error";?>" >
            <label for="field0">Your Name:</label><br />
            <input type="text" name="field0" id="field0" size="40" value="<?=stripslashes($_POST['field0'])?>" /> 
        </div>

        <div class="formfield <? if($email_error) echo "error";?>">
            <label for="field1">Your E-mail:</label><br />
            <input type="text" name="field1" id="field1" size="40" value="<?=stripslashes($_POST['field1'])?>" /> 
        </div>
        
       
	
        
    <div class="clear formfield <? if($message_error) echo "error";?>">
        <label for="field2">Comments:</label><br />
        <textarea name="field2" id="field2" rows="9" cols="38"><?=stripslashes($_POST['field2'])?></textarea>
    </div>
          
    <div>
        <? if(!isset($_POST['field3'])){
            echo '<input type="hidden" name="field3" id="field3" value="'.$_SERVER['HTTP_REFERER'].'" />';
          } else {
            echo '<input type="hidden" name="field3" id="field3" value="'.$_POST['field3'].'" />';
          } ?>
         <label for="field4" class="contactfield">Robots Only</label>
         <input class="contactfield" type="text" size="2" name="field4" id="field4" />
    </div>
    
    <div class="fright">
        <input class="button" type="submit" value="SUBMIT" name="send" />
    </div>

</form>
	
<? if($_POST['send']) {?>
    <div id="csucc">
    <h1>Thanks for your submission!</h1>
    <br />
    <p>We will get back to you as soon as possible.</p>
    <p><a href="<? bloginfo('url');?>/contact-us/" title="Contact Us">CLOSE</a></p>
    </div>
    
<? }?>

            </section><!-- #content -->
			<?php get_sidebar('right'); ?>
		</div><!-- #container -->

<?php get_footer(); ?>