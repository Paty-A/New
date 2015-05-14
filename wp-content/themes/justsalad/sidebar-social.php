<?php
/**
 * The Social Media Sidebar.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

           <div class="blogfloat"> <h2 class="offscreen">Keep Up With Us</h2>
            <img src="<?=bloginfo('template_url');?>/images/social_button_header.png" alt="text: Keep Up With Us"/><br />
            <?php dynamic_sidebar('right-bottom-widget-area')?></div>
