<?php
/*
Template Name: Promotion
*/
?>
<? 
require("functions/ws-js.php");
get_header();

if($_POST['send']) {
	/* ERROR CHECKING */
	if(strlen($_POST['field0a'])<2) {
		$error = "<li>You must provide Your First Name.</li>";
		$firstname_error = true; 
	}
	if(strlen($_POST['field0b'])<2) {
		$error = "<li>You must provide Your Last Name.</li>";
		$lastname_error = true; 
	}




	if(!validateEmail($_POST['field1'], 1)) {
		$error .= "<li>The email address you have provided is invalid or incomplete.</li>";
		$email_error = true;
	}
	
	if($error) {
		unset($_POST['send']);
	}
	else {
	/* PREVIOUS ENTRIES? */
	$exists = mysql_query("SELECT id FROM wp_promotions WHERE post_id='".$post->ID."' AND email='".$_POST['field1']."'");
	if(mysql_num_rows($exists)==0 && !$_POST['field4']) {
	/* ADD NEW ENTRY */
	mysql_query("INSERT INTO wp_promotions (id, post_id, first_name, last_name, email, notes) VALUES('', '".$post->ID."', '".mysql_real_escape_string($_POST['field0a'])."', '".mysql_real_escape_string($_POST['field0b'])."', '".$_POST['field1']."', '".mysql_real_escape_string($_POST['field2'])."')");
	/* EMAIL THE USER */
	
	//Adjust the timezone so times in the email are correct
	date_default_timezone_set('America/New_York');

	/* HTML MESSAGE */
	$html = get_post_meta($post->ID, '_customer_text', true);
	if($html) {
		$html = wordwrap($html, 75, "<br />
	");
		/* PLAIN TEXT MESSAGE */
		$plain = str_replace(array('<br />', '<strong>', '</strong>'), '', $html);
		$to = $_POST['field1'];
		$from = "Just Salad <comments@justsalad.com>";
		$replyto = $from;
		$subject = "Thanks!";
		$sent = multiMail($to, $subject, $plain, $html, $from, $replyto);
	}
	else {
		echo "NO MESSAGE";
	}
	}
	else {
		/* ALREADY ENTERED. DO NOTHING. */
	}
	}
}
 ?>

		<div id="container">
            <section id="content" role="main">
            
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
                <h1 class="hide-small"><?php the_title(); ?></h1>	
                    		
				<?php the_content('<p>Read the rest of this page &rarr;</p>'); ?>
                <?php link_pages('<p><strong>Pages:</strong> ', '</p>', 'number'); ?>
				
				<?php endwhile; endif; ?>


<form method="post" action="" name="contactform" id="contactform">

	<? if($error) {echo "<div id='error'><strong>Please use the form below to correct the following errors:</strong><ul>".$error."</ul></div>";}?>

    	

        <div class="formfield <? if($firstname_error) echo "error";?>" >
            <label for="field0a">Your First Name:</label><br />
            <input type="text" name="field0a" id="field0a" size="40" value="<?=stripslashes($_POST['field0a'])?>" /> 
        </div>
         <div class="formfield <? if($lastname_error) echo "error";?>" >
            <label for="field0b">Your Last Name:</label><br />
            <input type="text" name="field0b" id="field0b" size="40" value="<?=stripslashes($_POST['field0b'])?>" /> 
        </div>

        <div class="formfield <? if($email_error) echo "error";?>">
            <label for="field1">Your E-mail:</label><br />
            <input type="text" name="field1" id="field1" size="40" value="<?=stripslashes($_POST['field1'])?>" /> 
        </div>
        
       
	
    <?php if(get_post_meta($post->ID, '_show_notes', true)) {?>    
    <div class="clear formfield">
        <label for="field2">Notes:</label><br />
        <textarea name="field2" id="field2" rows="9" cols="38"><?=stripslashes($_POST['field2'])?></textarea>
    </div>
    <? }?>
          
    <div>
        <? if(!isset($_POST['field3'])){
            echo '<input type="hidden" name="field3" id="field3" value="'.$_SERVER['HTTP_REFERER'].'" />';
          } else {
            echo '<input type="hidden" name="field3" id="field3" value="'.$_POST['field3'].'" />';
          } ?>
         <label for="field4" class="contactfield">Robots Only</label>
         <input class="contactfield" type="text" size="2" name="field4" id="field4" />
    </div>
    
    <div class="clear formfield">
        <input class="button" type="submit" value="SUBMIT" name="send" />
    </div>

</form>
	
<? if($_POST['send']) {
	$ttitle=get_post_meta($post->ID, '_thanks_title', true);
	$ttext=get_post_meta($post->ID, '_thanks_text', true);
	?>
    <div id="csucc">
    <h1><?=$ttitle?></h1>
    <br />
    <p><?=$ttext?></p>
    <p><a href="<?php the_permalink(); ?>" title="Back to Promotion">CLOSE</a></p>
    </div>
    
<? }?>

            </section><!-- #content -->
			<?php get_sidebar('right'); ?>
		</div><!-- #container -->

<?php get_footer(); ?>