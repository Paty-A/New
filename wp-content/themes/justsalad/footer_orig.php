<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten_Five 
 * @since Twenty Ten Five 1.0
 */
?>
	</div><!-- #main -->
    <div class="push"></div>
</div><!-- #wrapper -->

<footer role="contentinfo">
	<div id="wrapperB">

        
        
        <div class="fright">
            <?php wp_nav_menu( array( 'container' => 'false', 'theme_location' => 'footer-menu' ) ); ?>
            <p>&copy; <?=date('Y');?> Just Salad, LLC</p>
        </div>

	</div>
</footer><!-- #footer -->



<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>

</body>
</html>
