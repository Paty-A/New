<?php
/**
 * The Newsletter Signup Sidebar.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

            	<h2 class="offscreen">Newsletter Signup</h2>
                <img class="news-signup" src="<?=bloginfo('template_url');?>/images/newsletter-heading.jpg" alt="Text: Newsletter Signup" />
                
<!-- Begin MailChimp Signup Form -->
<?php

$dr = explode(".", $_SERVER['SERVER_NAME']);
if($dr[0]=="hk") {
	$fact = "http://justsalad.us4.list-manage.com/subscribe/post?u=15aa09177d8609a49353def84&amp;id=d4d007888e";
}
else if($dr[0]=="sg") {
	$fact = "http://justsalad.us4.list-manage1.com/subscribe/post?u=ab3119037111da1d7f282060e&amp;id=f754d46463";
}
else {
	$fact = "http://justsalad.us1.list-manage.com/subscribe/post?u=b4ec00ae9a57d7956cc897bc8&amp;id=dc2d80bf0a";
}


?>

<link href="http://cdn-images.mailchimp.com/embedcode/slim-081711.css" rel="stylesheet" type="text/css">
<div id="mc_embed_signup">
<form action="<?=$fact?>" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank">
	<label for="mce-EMAIL">Subscribe to our mailing list</label>
	<input type="email" value="" name="EMAIL" class="email" id="mce-EMAIL" placeholder="Enter Email Address" required>
	<input type="image" src="<?=bloginfo('template_url');?>/images/go.png" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button2">
</form>
</div>

<!--End mc_embed_signup-->