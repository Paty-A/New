<?php
/*~~~	TEST ME!	~~~*/
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

		<?php 
			global $blog_id;
			if($blog_id==2) { $cursite="Hong Kong";}
			else if($blog_id==3) { $cursite="Singapore"; }
			else if($blog_id==4) { $cursite="UAE"; }
			else {$cursite="NY/NJ"; }
			
			//$date = date('Y');
		?>
        <?
			$nei = "<ul id=\"%1\$s\" class=\"%2\$s\">%3\$s<li class=\"hide-lg\">$cursite<a id=\"change-region\"><strong>(change)</strong></a><ul id=\"change-box\" class=\"unbulleted\">"; //<a id=\"change-region\"><strong>(change)</strong></a><ul id=\"change-box\">
			if($blog_id!=1) {$nei .= "<li><a href=\"http://justsalad.com\">NY/NJ</a></li>";}
        	if($blog_id!=2) {$nei .= "<li><a href=\"http://hk.justsalad.com\">Hong Kong</a></li>"; }
			if($blog_id!=4) {$nei .= "<li><a href=\"http://dubai.justsalad.com\">UAE</a></li>"; }
            $nei .= "</ul></li></ul>";
		?>
        <?/*
			$nei = "<ul><li><strong>Change Region</strong><select id=\"change-box\">";
			<option value="volvo">NY/NJ</option>
			<option value="saab">Saab</option>
			<option value="opel">Opel</option>
			<option value="audi">Audi</option>
			</select>
			if($blog_id!=1) {$nei .= "<li><a href=\"http://justsalad.com\">NY/NJ</a></li>";}
        	if($blog_id!=2) {$nei .= "<li><a href=\"http://hk.justsalad.com\">Hong Kong</a></li>"; }
			if($blog_id!=4) {$nei .= "<li><a href=\"http://dubai.justsalad.com\">UAE</a></li>"; }
            $nei .= "</ul></li>%3\$s</ul>";
		*/?>
        
        
        <div class="fright">
            <?php wp_nav_menu( array( 'container' => false, 'theme_location' => 'footer-menu', 'items_wrap' => $nei) ); ?>
            <p>&copy; <?=date('Y')?> Just Salad, LLC</p>
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
