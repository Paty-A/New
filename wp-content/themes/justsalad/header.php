<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten_Five 
 * @since Twenty Ten Five 1.0
 */
?>
<?
session_start();
if(!isset($_SESSION['mobile']) || (isset($_GET['full']) && $_GET['full']==0)) {
	$_SESSION['mobile']=1;
}
else if ($_GET['full']==1) {
	$_SESSION['mobile']=0;
}
?>
<!DOCTYPE html>
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<meta name="description" content="Just Salad is a quick and healthy restaurant chain with locations in NYC, Hong Kong, and Singapore. Serving up fresh salads, wraps, soups, frozen yogurt, and smoothies. Keywords: just salad, salad, frozen yogurt, smoothies, franchise, qsr" />

 <!-- Mobile viewport optimized: j.mp/bplateviewport -->
  <? if($_SESSION['mobile']) {?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<? } ?>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<script type="text/javascript" src="http://use.typekit.com/npw1ymb.js"></script>
<script type="text/javascript">try{Typekit.load();}catch(e){}</script>
<link rel="stylesheet" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>?v=6" />
<!-- Media Queries //-->
<? if($_SESSION['mobile']) {?>
<link rel="stylesheet" type="text/css" media="screen and (max-width: 480px)" href="<?=bloginfo( 'template_url' );?>/small.css?v=5" />  
<? } else {?>
<link rel="stylesheet" type="text/css" href="<?=bloginfo( 'template_url' );?>/interim.css?v=4" />  
<? }?>
<!--[if lte IE 7]>
<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/ie7.css" />
<![endif]-->
<script>
if(document.documentMode && document.documentMode < 8) {
	document.write('<link rel="stylesheet" type="text/css" href="http://justsalad.com/wp-content/themes/justsalad/ie7.css" />');
}
</script>

<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script src="<? bloginfo('url');?>/wp-content/themes/justsalad/js/infobubble.js" type="text/javascript"></script>
<script type="text/javascript" src="<? bloginfo('url');?>/wp-content/themes/justsalad/js/markers.js"></script>

<script src="<? bloginfo('url');?>/wp-content/themes/justsalad/js/modernizr-custom.js" type="text/javascript"></script>
   <!-- <script src="<? bloginfo('url');?>/wp-content/themes/justsalad/js/polyfiller.js" type="text/javascript"></script>
//-->

<? if($_POST['send']){?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery( "#csucc" ).dialog({
					width: 460,
					modal: true,
					draggable: false,
					resizable: false,
					position: ['center', 'center']
				});
			jQuery('.ui-widget-overlay').live("click", function() {
         //Close the dialog
         jQuery("#csucc").dialog("close");
jQuery("#field0").val("");
jQuery("#field1").val("");
jQuery("#field2").val("");
 		
      });
			});				
        </script>
	<? }?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-9965705-9']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


</head>

<body <?php body_class(); ?>>
<!--[if lte IE 8 ]>
<noscript><strong>JavaScript is required for this website to be displayed correctly. Please enable JavaScript before continuing...</strong></noscript>
<![endif]-->

<div id="wrapper" class="hfeed">
	<header>
		<section id="masthead">

        	<ul class="top-menu">
		    <?php wp_nav_menu( array( 'container' => false, 'menu_class' => 'top-menu', 'theme_location' => 'top-menu', 'items_wrap' => '%3$s' ) ); ?>
            	<?php 
					global $blog_id;
					if($blog_id==2) { $cursite="Hong Kong";}
					else if($blog_id==3) { $cursite="Singapore"; }
					else if($blog_id==4) { $cursite="UAE"; }
					else {$cursite="NY/NJ"; }
					
				?>
				<li><?=$cursite?> <a id="change-region"><strong>(change)</strong></a>
                   	<ul id="change-box">
						<? if($blog_id!=1) {?><li><a href="http://justsalad.com">NY/NJ</a></li><? }?>
                        <? if($blog_id!=2) {?><li><a href="http://hk.justsalad.com">Hong Kong</a></li><? }?>
						<? if($blog_id!=4) {?><li><a href="http://dubai.justsalad.com">UAE</a></li><? }?>
                        
                    </ul>
                </li>
            </ul>
<a class="viewmobile" href="?full=0">View Mobile Version</a>
            <div id="logo" role="banner">
				<?php if(is_home() || is_front_page()){ echo "<h1 class='home'>";}?>
                    <a href="<?php bloginfo('url')?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
	                    <img src="<?php bloginfo('template_url')?>/images/logo.png" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?> Logo">
                    </a>
	            <?php if(is_home() || is_front_page()){ echo "</h1>";}?>                        
            </div><!-- #logo -->
	   		<nav id="access" role="navigation">
			  <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
				<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentyten' ); ?>"><?php _e( 'Skip to content', 'twentyten' ); ?></a></div>
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
				<?php wp_nav_menu( array( 'container' => 'false', 'menu_class' => 'menu-header', 'theme_location' => 'main-menu', 'walker' => new agcustom_walker() ) ); ?>
                <?php 
                if($blog_id!=4) {
   					wp_nav_menu( array( 'container' => 'false', 'menu_class' => 'menu-mobile', 'theme_location' => 'mobile-menu' ) );
                } else {
   					wp_nav_menu( array( 'container' => 'false', 'menu_class' => 'menu-mobile', 'theme_location' => 'mobile-menu', 'items_wrap' => '<ul id="%1$s" class="%2$s"><li class="menu-item menu-item-type-post_type menu-item-object-page"><a href="http://dubai.justsalad.com/locations/">Locations</a></li>%3$s</ul>' ) ); 
				}
				?>
			</nav><!-- #access -->
		</section><!-- #masthead -->
		<div class="clear"></div>
	</header><!-- #header -->

	<div id="main">
