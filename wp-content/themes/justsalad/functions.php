<?php

/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

include(TEMPLATEPATH.'/functions/email_functions.php');
/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */

add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists( 'twentyten_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'featured', '9999', '287', false ); // @Morgan
	//add_image_size( 'featured-jsp', '819', '200', true ); //

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in two locations.
	if ( function_exists( 'register_nav_menus' ) ):
		register_nav_menus( array(
			'top-menu' => __( 'Top Menu', 'twentyten' ),
			'mobile-menu' => __( 'Mobile Menu', 'twentyten' ),
			'main-menu' => __( 'Main Menu', 'twentyten' ),
			'footer-menu' => __( 'Footer Menu', 'twentyten' ),
			
		) );
	endif;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function twentyten_widgets_init() {
	// Area1, located in the right sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Right Side Widget Area', 'twentyten' ),
		'id' => 'right-widget-area',
		'description' => __( 'Add Widgets below the image boxes in the right sidebar', 'twentyten' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );

	// Area 2, located in the footer. Empty by default.
	register_sidebar( array(
		'name' => __( 'Footer Widget Area', 'twentyten' ),
		'id' => 'footer-widget-area',
		'description' => __( 'Left-aligned footer content', 'twentyten' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );

// Area 3, located in the right sidebar. Empty by default.
	register_sidebar( array(
		'name' => __( 'Right Bottom Widget Area', 'twentyten' ),
		'id' => 'right-bottom-widget-area',
		'description' => __( 'Add widgets below ALL right sidebar content', 'twentyten' ),
		'before_widget' => '<div id="%1$s" class="widget-container %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h2>',
		'after_title' => '</h2>',
	) );


}
/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'twentyten_widgets_init' );

/**
 * Sets the post excerpt length to 100 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 100;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'read more', 'twentyten' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {

	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
		<div class="comment-author vcard">
			<?php echo get_avatar( $comment, 40 ); ?>
			<?php printf( __( '%s <span class="says">says:</span>', 'twentyten' ), sprintf( '<cite class="fn">%s</cite>', get_comment_author_link() ) ); ?>
		</div><!-- .comment-author .vcard -->
		<?php if ( $comment->comment_approved == '0' ) : ?>
			<em><?php _e( 'Your comment is awaiting moderation.', 'twentyten' ); ?></em>
			<br />
		<?php endif; ?>

		<div class="comment-meta commentmetadata"><a href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
			<?php
				/* translators: 1: date, 2: time */
				printf( __( '%1$s at %2$s', 'twentyten' ), get_comment_date(),  get_comment_time() ); ?></a><?php edit_comment_link( __( '(Edit)', 'twentyten' ), ' ' );
			?>
		</div><!-- .comment-meta .commentmetadata -->

		<div class="comment-body"><?php comment_text(); ?></div>

		<div class="reply">
			<?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
		</div><!-- .reply -->
	</div><!-- #comment-##  -->

	<?php
			break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'twentyten' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __('(Edit)', 'twentyten'), ' ' ); ?></p>
	<?php
			break;
	endswitch;
}
endif;


/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;




/**
 * TwentyTen Five functions and definitions
 *
 * This additional code adds in HTML5 functionality to the TwentyTen theme.
 * You will still require the orginal functions.php (above) which has not
 * been altered.
 *
 * The code below overwrites or extends some of the TwentyTen functionality.
 *
 * For more information on see 
 * http://www.smashingmagazine.com/2011/02/22/using-html5-to-transform-wordpress-twentyten-theme/
 *
 * and
 * http://twentytenfive.com
 *
 * @package WordPress
 * @subpackage Twenty_Ten_Five
 * @since TwentyTen Five 1.0.1
 */



/**
 * Modernizr.js
 * 
 * Load up modernizr.min.js using the WordPress wp_enqueue_script function
 *
 * @since TwentyTen Five 1.0.1
 */
 
 wp_enqueue_script( 'modernizr', get_bloginfo('template_directory').'/js/modernizr-1.6.min.js');
 
wp_enqueue_script( 'jquery');

wp_enqueue_script( 'jquery-ui-core' );
    wp_enqueue_script( 'jquery-ui-dialog' );
    
    wp_enqueue_style (  'wp-jquery-ui-dialog');
    
 wp_enqueue_script( 'additional', get_bloginfo('template_directory').'/js/additional.js');


/**
 * The TwentyTen Five Caption shortcode.
 * added by Richard Shepherd to include HTML5 goodness
 *
 * The supported attributes for the shortcode are 'id', 'align', 'width', and
 * 'caption'.
 *
 * @since TwentyTen Five 1.0
 */

add_shortcode('wp_caption', 'twentyten_img_caption_shortcode');
add_shortcode('caption', 'twentyten_img_caption_shortcode');

function twentyten_img_caption_shortcode($attr, $content = null) {

	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''
	), $attr));

	if ( 1 > (int) $width || empty($caption) )
		return $content;


if ( $id ) $idtag = 'id="' . esc_attr($id) . '" ';

  return '<figure ' . $idtag . 'aria-describedby="figcaption_' . $id . '" style="width: ' . (10 + (int) $width) . 'px">' 
  . do_shortcode( $content ) . '<figcaption id="figcaption_' . $id . '">' . $caption . '</figcaption></figure>';
}



/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since TwentyTen Five 1.0
 */
function twentyten_posted_on() {
		printf( __( '%3$s | %2$s', 'twentyten' ),
			'meta-prep meta-prep-author',
			sprintf( '<a href="%1$s" rel="bookmark"><time datetime="%2$s" pubdate>%3$s</time></a>',
			get_permalink(),
			get_the_date('c'),
			get_the_date('m.d.y').' @ '.get_the_date('g:i A')
		),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s">%3$s</a></span>',
			get_author_posts_url( get_the_author_meta( 'ID' ) ),
			sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
			get_the_author()
		)
	);
}



/**
 * Customise the TwentyTen Five comments fields with HTML5 form elements
 *
 *	Adds support for 	placeholder
 *						required
 *						type="email"
 *						type="url"
 *
 * @since TwentyTen Five 1.0
 */
function twentytenfive_comments() {

	$req = get_option('require_name_email');

	$fields =  array(
		'author' => '<p class="comment-form-author">' . '<label for="author">' . __( 'Name' ) . '</label><br />' .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ( $req ? ' required' : '' ) . '/></p>',
		            
		'email'  => '<p class="comment-form-email"><label for="email">' . __( 'Email' ) . '</label><br />' .
		            '<input id="email" name="email" type="email" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ( $req ? ' required' : '' ) . ' /></p>',
		            
		'url'    => '<p class="comment-form-url"><label for="url">' . __( 'Website' ) . '</label><br />' .
		            '<input id="url" name="url" type="url" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p><div class="clear"></div>'

	);
	return $fields;
}


function twentytenfive_commentfield() {	

	$commentArea = '<p class="comment-form-comment"><label for="comment">' . _x( 'Comment', 'noun' ) . '</label><br />
<textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';
	
	return $commentArea;

}


add_filter('comment_form_default_fields', 'twentytenfive_comments');
add_filter('comment_form_field_comment', 'twentytenfive_commentfield');




/* Remove the WordPress Custom Field Panel */
/*function remove_post_custom_fields() {
	remove_meta_box( 'postcustom' , 'page' , 'normal' ); 
}
add_action( 'admin_menu' , 'remove_post_custom_fields' );*/

/* Define the custom box */

// WP 3.0+
add_action('add_meta_boxes', 'myplugin_add_custom_box');

// backwards compatible
//add_action('admin_init', 'myplugin_add_custom_box', 1);

/* Do something with the data entered */
add_action('save_post', 'myplugin_save_postdata');

/* Adds a box to the main column on the Page edit screens */
function myplugin_add_custom_box() {
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
	$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
	if ($template_file == 'home.php'){
    	add_meta_box( 'myplugin_sectionid', __( 'Homepage Categories', 'myplugin_textdomain' ), 
                'myplugin_inner_custom_box', 'page', 'normal', 'high' );
	}
}

/* Prints the box content */
function myplugin_inner_custom_box() {

  // Use nonce for verification
  wp_nonce_field( plugin_basename(__FILE__), 'myplugin_noncename' );

  // The actual fields for data entry
  $old_text = get_post_meta($_GET['post'], "cat_ids", true);
  echo '<label for="myplugin_new_field">' . __("Enter the category id numbers for the categories to be displayed on the homepage in a comma separated list.", 'myplugin_textdomain' ) . '</label><br />';
  echo '<textarea id="myplugin_new_field" name="myplugin_new_field" cols="40" rows="3">'.$old_text.'</textarea>';
}

/* When the post is saved, saves our custom data */
function myplugin_save_postdata( $post_id ) {

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['myplugin_noncename'], plugin_basename(__FILE__) )) {
    return $post_id;
  }

  // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
  // to do anything
  if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
    return $post_id;

  
  // Check permissions
  if ( 'page' == $_POST['post_type'] ) {
    if ( !current_user_can( 'edit_page', $post_id ) )
      return $post_id;
  } else {
    if ( !current_user_can( 'edit_post', $post_id ) )
      return $post_id;
  }

  // OK, we're authenticated: we need to find and save the data

  $mydata = $_POST['myplugin_new_field'];

  // Do something with $mydata 
  // probably using add_post_meta(), update_post_meta(), or 
  // a custom table (see Further Reading section below)

	add_post_meta( $post_id, 'cat_ids', $mydata, true ) or update_post_meta( $post_id, 'cat_ids', $mydata );
	
   return $mydata;
}

function twentyten_clear_comment_form() {
	echo '<div class="clear"></div>';
}
add_action('comment_form', 'twentyten_clear_comment_form');

class agcustom_walker extends Walker_Nav_Menu {
	function display_element( $element, &$children_elements, $max_depth, $depth=0, $args, &$output ) {

		if ( !$element )
			return;

		$id_field = $this->db_fields['id'];

		//display this element
		if ( is_array( $args[0] ) )
			$args[0]['has_children'] = ! empty( $children_elements[$element->$id_field] );

		//Adds the 'parent' class to the current item if it has children               
		if( ! empty( $children_elements[$element->$id_field] ) && $depth == 0 )
				array_push($element->classes,'parent');

		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'start_el'), $cb_args);

		$id = $element->$id_field;

		// descend only when the depth is right and there are childrens for this element
		if ( ($max_depth == 0 || $max_depth > $depth+1 ) && isset( $children_elements[$id]) ) {

			foreach( $children_elements[ $id ] as $child ){

				if ( !isset($newlevel) ) {
					$newlevel = true;
					//start the child delimiter
					$cb_args = array_merge( array(&$output, $depth), $args);
					call_user_func_array(array(&$this, 'start_lvl'), $cb_args);
				}
				$this->display_element( $child, $children_elements, $max_depth, $depth + 1, $args, $output );
			}
			unset( $children_elements[ $id ] );
		}

		if ( isset($newlevel) && $newlevel ){
			//end the child delimiter
			$cb_args = array_merge( array(&$output, $depth), $args);
			call_user_func_array(array(&$this, 'end_lvl'), $cb_args);
		}

		//end this element
		$cb_args = array_merge( array(&$output, $element, $depth), $args);
		call_user_func_array(array(&$this, 'end_el'), $cb_args);
	}
	
	function walk( $elements, $max_depth) {

		$args = array_slice(func_get_args(), 2);
		$output = '';

		if ($max_depth < -1) //invalid parameter
			return $output;

		if (empty($elements)) //nothing to walk
			return $output;

		$id_field = $this->db_fields['id'];
		$parent_field = $this->db_fields['parent'];

		// flat display
		if ( -1 == $max_depth ) {
			$empty_array = array();
			foreach ( $elements as $e )
				$this->display_element( $e, $empty_array, 1, 0, $args, $output );
			return $output;
		}

		/*
		 * need to display in hierarchical order
		 * separate elements into two buckets: top level and children elements
		 * children_elements is two dimensional array, eg.
		 * children_elements[10][] contains all sub-elements whose parent is 10.
		 */
		$top_level_elements = array();
		$children_elements  = array();
		foreach ( $elements as $e) {
			if ( 0 == $e->$parent_field )
				$top_level_elements[] = $e;
			else
				$children_elements[ $e->$parent_field ][] = $e;
		}

		/*
		 * when none of the elements is top level
		 * assume the first one must be root of the sub elements
		 */
		if ( empty($top_level_elements) ) {

			$first = array_slice( $elements, 0, 1 );
			$root = $first[0];

			$top_level_elements = array();
			$children_elements  = array();
			foreach ( $elements as $e) {
				if ( $root->$parent_field == $e->$parent_field )
					$top_level_elements[] = $e;
				else
					$children_elements[ $e->$parent_field ][] = $e;
			}
		}

		$current_element_markers = array( 'current-menu-item' );

		foreach ( $top_level_elements as $e ) {
            // descend only on current tree
            $descend_test = array_intersect( $current_element_markers, $e->classes );
//			echo"<br />Descend Test "; print_r($descend_test);

			// descend on news/blog page if it is a single, archive or new/blog page & the top level menu item has a class of blogitem
			if(is_single() || is_archive() || is_home()){
				if(in_array('blogitem', $e->classes)){
					if(!empty($children_elements[$e->ID])){
						if($args[0]->show_heading){$output .='<li class="heading">'.$e->title.'<ul class="sub-menu">';}
						foreach($children_elements[$e->ID] as $childitem){
							$this->display_element($childitem, $children_elements, $max_depth, 0, $args, $output );				
						}
						if($args[0]->show_heading){$output .= "</ul></li>\n";}
						$descend_test = array();
					}
				}
			 }

        /*    if (empty($descend_test)){
				$max_depth = 1;
			}
			else {
				$max_depth = 0;				
			}*/
			$this->display_element( $e, $children_elements, $max_depth, 0, $args, $output );
		}

		/*
		 * if we are displaying all levels, and remaining children_elements is not empty,
		 * then we got orphans, which should be displayed regardless
		 */
/*		if ( ( $max_depth == 0 ) && count( $children_elements ) > 0 ) {
			$empty_array = array();
			foreach ( $children_elements as $orphans )
				foreach( $orphans as $op )
					$this->display_element( $op, $empty_array, 1, 0, $args, $output );
		 }*/

		 return $output;
	}
}

//  TinyMCE Button Adjustments 

add_filter( 'mce_buttons', 'my_mce_buttons' );

function my_mce_buttons( $buttons ) {
	$buttonsreplace = array('|', 'cut', 'copy', 'paste', '|' );
	array_splice($buttons, 15, 0, $buttonsreplace);
    return $buttons;
}

add_filter( 'mce_buttons_2', 'my_mce_buttons_2' );

function my_mce_buttons_2( $buttons2 ) {
	$buttonsreplace = array('styleselect' );
	array_splice($buttons2, 1, 0, $buttonsreplace);
    return $buttons2;
}

//  TinyMCE List of Styles to select from

add_filter( 'tiny_mce_before_init', 'my_mce_before_init' );

function my_mce_before_init( $settings ) {

    $style_formats = array(
    	array(
    		'title' => 'Abstract',
    		'selector' => 'p',
    		'classes' => 'abstract'
    	),
		array(
    		'title' => 'Green Button',
    		'selector' => 'a',
    		'classes' => 'cButton'
    	)
    );

    $settings['style_formats'] = json_encode( $style_formats );

    return $settings;

}

/*******DYNAMIC LOCATIONS - AG **********/
/******* AG CUSTOM BOXES *******/

function create_post_type() {
	register_post_type( 'ag_location',
		array(
			'labels' => array(
				'name' => __( 'Locations' ),
				'singular_name' => __( 'Location' ),
				'add_new' => __( 'Add New Location' ),
				'add_new_item'  => 'Add New Location',
            	'edit_item' => __( 'Edit Location' ),
            	'new_item' => __( 'New Location' ),
            	'view_item' => __( 'View Location' ),
            	'search_items' => __( 'Search Locations' ),
          	 	'not_found' => __( 'No Locations found' ),
           		'not_found_in_trash' => __( 'No Locations found in Trash' )
			),
		'public' => true,
		'rewrite' => true,
		'menu_icon' => get_bloginfo('template_url').'/images/map.png',
		'has_archive' => false,
		'supports' => array(
            'title'
            )
    ));
}
global $blog_id;
if($blog_id==1) {

// register the post type 
add_action( 'init', 'create_post_type' );
// Hook into WordPress
add_action( 'admin_init', 'add_location_metabox' );
add_action( 'save_post', 'save_location_data' );
}

/**
 * Add meta box
 */
function add_location_metabox() {
	add_meta_box( 'location-metabox', __( 'Location Details' ), 'location_custom_metabox', 'ag_location', 'normal', 'high' );
}

/**
 * Display the metabox
 */
function location_custom_metabox() {
	global $post;
	$id = get_post_meta( $post->ID, 'id', true );
	$region = get_post_meta( $post->ID, 'region', true );
	$lname = get_post_meta( $post->ID, 'lname', true );
	$address = get_post_meta( $post->ID, 'address', true );
	$address2 = get_post_meta( $post->ID, 'address2', true );
	$city = get_post_meta( $post->ID, 'city', true );
	$state = get_post_meta( $post->ID, 'state', true );
	$zip = get_post_meta( $post->ID, 'zip', true );
	$country = get_post_meta( $post->ID, 'country', true );
	$details = get_post_meta( $post->ID, 'details', true );
	$hours = get_post_meta( $post->ID, 'hours', true );
	$hours2 = get_post_meta( $post->ID, 'hours2', true );
	$hours3 = get_post_meta( $post->ID, 'hours3', true );
	$phone = get_post_meta( $post->ID, 'phone', true );
	$phonedirect = get_post_meta( $post->ID, 'phonedirect', true );
	$fax = get_post_meta( $post->ID, 'fax', true );
	$email = get_post_meta( $post->ID, 'email', true );
    $contactemail = get_post_meta( $post->ID, 'contactemail', true );
	$url = get_post_meta( $post->ID, 'url', true );
	$menu = get_post_meta( $post->ID, 'menu', true );
	$mobilemenu = get_post_meta( $post->ID, 'mobilemenu', true );
	$order = get_post_meta( $post->ID, 'order', true );
	$range = get_post_meta( $post->ID, 'range', true );
	$lat = get_post_meta( $post->ID, 'lat', true );
	$lon = get_post_meta( $post->ID, 'lon', true );
 ?>

	<p><label for="id">Location ID<br />
		<input id="id" size="4" name="id" value="<?php if( $id ) { echo $id; } ?>" /></label></p>
    <p><label for="region">Region<br />
		<select name="region">
        	<option value="1" <? if($region==1) echo "selected"; ?>>US-NY</option>
			<option value="4" <? if($region==4) echo "selected"; ?>>US-NJ</option>
			<option value="6" <? if($region==6) echo "selected"; ?>>US-Chi</option>
            <option value="2" <? if($region==2) echo "selected"; ?>>HK</option>
            <option value="3" <? if($region==3) echo "selected"; ?>>SG</option>
			<option value="5" <? if($region==5) echo "selected"; ?>>UAE</option>
					

        </select></label></p>
	<p><label for="lname">Nickname<br />
		<input size="60" id="lname" name="lname" value="<?php if( $lname ) { echo $lname; } ?>" /></label></p>
   	<p><label size="60" for="address">Address Line 1<br />
		<input size="60" id="address" name="address" value="<?php if( $address ) { echo $address; } ?>" /></label></p>
    <p><label for="address2">Address Line 2<br />
		<input size="60" id="address2" name="address2" value="<?php if( $address2 ) { echo $address2; } ?>" /></label></p>
    <p><label for="city">City<br />
		<input size="60" id="city" name="city" value="<?php if( $city ) { echo $city; } ?>" /></label></p>
    <p><label for="state">State<br />
		<input size="4" id="state" name="state" value="<?php if( $state ) { echo $state; } ?>" /></label></p>
     <p><label for="zip">Zipcode (US Only)<br />
		<input size="10" id="zip" name="zip" value="<?php if( $zip ) { echo $zip; } ?>" /></label></p>
<p><label for="country">Country<br />
		<input size="60" id="country" name="country" value="<?php if( $country ) { echo $country; } ?>" /></label></p>
 <p><label for="details">Details/Cross Streets<br />
		<input size="60" id="details" name="details" value="<?php if( $details ) { echo $details; } ?>" /></label></p>
<p><label for="hours">Hours (Line 1)<br />
		<input size="60" id="hours" name="hours" value="<?php if( $hours ) { echo $hours; } ?>" /></label></p>
<p><label for="hours2">Hours (Line 2)<br />
		<input size="60" id="hours2" name="hours2" value="<?php if( $hours2 ) { echo $hours2; } ?>" /></label></p>
<p><label for="hours3">Hours (Line 3)<br />
		<input size="60" id="hours3" name="hours3" value="<?php if( $hours3 ) { echo $hours3; } ?>" /></label></p>
<p><label for="phone">Phone<br />
		<input size="60" id="phone" name="phone" value="<?php if( $phone ) { echo $phone; } ?>" /></label></p>
<p><label for="phonedirect">Direct Phone<br />
		<input size="60" id="phonedirect" name="phonedirect" value="<?php if( $phonedirect ) { echo $phonedirect; } ?>" /></label></p>
<p><label for="fax">Fax<br />
		<input size="60" id="fax" name="fax" value="<?php if( $fax ) { echo $fax; } ?>" /></label></p>
<p><label for="email">Manager Email<br />
		<input size="60" id="email" name="email" value="<?php if( $email ) { echo $email; } ?>" /></label></p>
<p><label for="contactemail">Comments Email (contact form sends to this address)<br />
		<input size="60" id="contactemail" name="contactemail" value="<?php if( $contactemail ) { echo $contactemail; } ?>" /></label></p>
<p><label for="url">Bio Page Url (/locations/<em>location-name</em>/)<br />
		<input size="60" id="url" name="url" value="<?php if( $url ) { echo $url; } ?>" /></label></p>
<p><label for="menu">Menu URL<br />
		<input size="60" id="menu" name="menu" value="<?php if( $menu ) { echo $menu; } ?>" /></label></p>
<p><label for="mobilemenu">Mobile Menu URL<br />
		<input size="60" id="mobilemenu" name="mobilemenu" value="<?php if( $mobilemenu ) { echo $mobilemenu; } ?>" /></label></p>
 <p><label for="order">Order Link<br />
		<input size="60" id="order" name="order" value="<?php if( $order ) { echo $order; } ?>" /></label></p>
 <p><label for="range">Order Range<br />
		<input size="60" id="range" name="range" value="<?php if( $range ) { echo $range; } ?>" /></label></p>
<p><label for="lat">Latitude (for more precise map locating)<br />
		<input size="60" id="lat" name="lat" value="<?php if( $lat ) { echo $lat; } ?>" /></label></p>
 <p><label for="lon">Longitude (for more precise map locating)<br />
		<input size="60" id="lon" name="lon" value="<?php if( $lon ) { echo $lon; } ?>" /></label></p>

<?php
}

/**
 * Process the custom metabox fields
 */
function save_location_data( $post_id ) {
	global $post;	
// verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

	if( $_POST ) {
if(isset($_POST['lname']) && $_POST['lname'] != "") {
	//SAVE LOCATION DATA TO WP DATABASE
	update_post_meta( $post->ID, 'id', $_POST['id'] );
	update_post_meta( $post->ID, 'region', $_POST['region'] );
	update_post_meta( $post->ID, 'lname', $_POST['lname'] );
	update_post_meta( $post->ID, 'address', $_POST['address'] );
	update_post_meta( $post->ID, 'address2', $_POST['address2'] );
	update_post_meta( $post->ID, 'city', $_POST['city'] );
	update_post_meta( $post->ID, 'state', $_POST['state'] );
	update_post_meta( $post->ID, 'zip', $_POST['zip'] );
	update_post_meta( $post->ID, 'country', $_POST['country'] );
	update_post_meta( $post->ID, 'details', $_POST['details'] );
	update_post_meta( $post->ID, 'hours', $_POST['hours'] );
	update_post_meta( $post->ID, 'hours2', $_POST['hours2'] );
	update_post_meta( $post->ID, 'hours3', $_POST['hours3'] );
	update_post_meta( $post->ID, 'phone', $_POST['phone'] );
	update_post_meta( $post->ID, 'phonedirect', $_POST['phonedirect'] );
	update_post_meta( $post->ID, 'fax', $_POST['fax'] );
	update_post_meta( $post->ID, 'email', $_POST['email'] );
    update_post_meta( $post->ID, 'contactemail', $_POST['contactemail'] );
	update_post_meta( $post->ID, 'url', $_POST['url'] );
	update_post_meta( $post->ID, 'menu', $_POST['menu'] );
	update_post_meta( $post->ID, 'mobilemenu', $_POST['mobilemenu']);
	update_post_meta( $post->ID, 'order', $_POST['order'] );
	update_post_meta( $post->ID, 'range', $_POST['range'] );
	update_post_meta( $post->ID, 'lat', $_POST['lat'] );
	update_post_meta( $post->ID, 'lon', $_POST['lon'] );
	
	//REGENERATE THE XML FILE

$data='<?xml version="1.0"?><markers>';
$args = array( 'post_type' => 'ag_location', 'orderby' => 'meta_value_num', 'meta_key' => 'id', 'order' => 'ASC', 'posts_per_page' => -1 );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();
	$id = get_post_meta( $post->ID, 'id', true );
	$region = htmlspecialchars(get_post_meta( $post->ID, 'region', true ));
	$lname = htmlspecialchars(get_post_meta( $post->ID, 'lname', true ));
	$address = htmlspecialchars(get_post_meta( $post->ID, 'address', true ));
	$address2 = htmlspecialchars(get_post_meta( $post->ID, 'address2', true ));
	$city = htmlspecialchars(get_post_meta( $post->ID, 'city', true ));
	$state = htmlspecialchars(get_post_meta( $post->ID, 'state', true ));
	$zip = htmlspecialchars(get_post_meta( $post->ID, 'zip', true ));
	$country = htmlspecialchars(get_post_meta( $post->ID, 'country', true ));
	$details = htmlspecialchars(get_post_meta( $post->ID, 'details', true ));
	$hours = htmlspecialchars(get_post_meta( $post->ID, 'hours', true ));
	$hours2 = htmlspecialchars(get_post_meta( $post->ID, 'hours2', true ));
	$hours3 = htmlspecialchars(get_post_meta( $post->ID, 'hours3', true ));
	$phone = htmlspecialchars(get_post_meta( $post->ID, 'phone', true ));
	$phonedirect = htmlspecialchars(get_post_meta( $post->ID, 'phonedirect', true ));
	$fax = htmlspecialchars(get_post_meta( $post->ID, 'fax', true ));
	$email = htmlspecialchars(get_post_meta( $post->ID, 'email', true ));
    $contactemail = htmlspecialchars(get_post_meta( $post->ID, 'contactemail', true ));
	$url = htmlspecialchars(get_post_meta( $post->ID, 'url', true ));
	$menu = htmlspecialchars(get_post_meta( $post->ID, 'menu', true ));
	$mobilemenu = htmlspecialchars(get_post_meta( $post->ID, 'mobilemenu', true ));
	$order = htmlspecialchars(get_post_meta( $post->ID, 'order', true ));
	$range = htmlspecialchars(get_post_meta( $post->ID, 'range', true ));
	$lat = htmlspecialchars(get_post_meta( $post->ID, 'lat', true ));
	$lon = htmlspecialchars(get_post_meta( $post->ID, 'lon', true ));

if($id) {
	$data.="\n<marker>\n";
	
	$data.="<id>".$id."</id>\n";
	$data.="<region>".$region."</region>\n";
	$data.="<name>".$lname."</name>\n";
	$data.="<address>".$address."</address>\n";
	$data.="<address2>".$address2."</address2>\n";
	$data.="<city>".$city."</city>\n";
	$data.="<state>".$state."</state>\n";
	$data.="<zip>".$zip."</zip>\n";
	$data.="<country>".$country."</country>\n";
	$data.="<details>".$details."</details>\n";
	$data.="<hours>".$hours."</hours>\n";
	$data.="<hours2>".$hours2."</hours2>\n";
	$data.="<hours3>".$hours3."</hours3>\n";
	$data.="<phone>".$phone."</phone>\n";
	$data.="<phonedirect>".$phonedirect."</phonedirect>\n";
	$data.="<fax>".$fax."</fax>\n";
	$data.="<email>".$email."</email>\n";
    $data.="<contactemail>".$contactemail."</contactemail>\n";
	$data.="<url>".$url."</url>\n";
	$data.="<menu>".$menu."</menu>\n";
	$data.="<mobilemenu>".$mobilemenu."</mobilemenu>\n";
	$data.="<order>".$order."</order>\n";
	$data.="<range>".$range."</range>\n";
	$data.="<lat>".$lat."</lat>\n";
	$data.="<lng>".$lon."</lng>\n";

	$data.="</marker>\n\n";
}
	
endwhile;
wp_reset_postdata();
$data.='</markers>';

   $fh = fopen($_SERVER['DOCUMENT_ROOT']."/wp-content/uploads/markers.xml", "w") or die('cannot open');
   fwrite($fh, $data);
   fclose($fh);
	
	}
}
}

/**
 * Get and return the values for the URL and description
 */
function get_location_data() {
	global $post;
	/*$urllink = get_post_meta( $post->ID, 'urllink', true );
	$ftype = get_post_meta( $post->ID, 'ftype', true );

	return array( $urllink, $ftype );*/
}

/******* AG CUSTOM BOXES *******/
// register the post type 
add_action( 'init', 'ag_custom_box_type' );
function ag_custom_box_type() {
	$custom_box_args            = array (
		'public'           => true,
		'query_var'        => 'ag_exceptions',
		'exclude_from_search' => true,
//		'menu_position' => 15,
		'labels'           => array(
			'name'          => 'Custom Boxes',
			'singular_name' => 'Custom Box',
			'add_new'       => 'Add New Custom Box',
			'add_new_item'  => 'Add New Custom Box',
			'edit_item'     => 'Edit Custom Box',
			'new_item'      => 'New Custom Box',
			'view_item'     => 'View Custom Boxes',
			'search_items'  => 'Search Custom Boxes',
			'not_found'     => 'No Custom Boxes Found'
		),
		'show_in_nav_menus ' => true,
		'menu_icon' => get_bloginfo('template_url').'/images/photo.png',
	);
	
	register_post_type( 'ag_custom_box', $custom_box_args );
}

// register custom taxonomies for custom box categorization
add_action( 'init', 'ag_custom_box_register_tax' );
function ag_custom_box_register_tax() {
	$tax_args             = array(
		'hierarchical'    => true,
		'query_var'       => 'ag_box_cat',
		'labels'          => array(
			'name'         => 'Custom Box Categories',
			'edit_item'    => 'Edit Category',
			'add_new_item' => 'Add New Custom Box Category',
			'all_items'    => 'All Custom Box Categories'
		),
		'show_in_nav_menus ' => true,
		'rewrite' => array( 'slug' => 'rates' )
	);
	register_taxonomy( 'ag_box_cat', array( 'ag_custom_box' ), $tax_args );
}

/* Remove the WordPress Custom Field Panel */
function agremove_post_custom_fields() {
	remove_meta_box( 'postcustom' , 'ag_custom_box' , 'normal' ); 
}
add_action( 'admin_menu' , 'agremove_post_custom_fields' );

/* ADD CUSTOM MENU SHORTCODE */
function print_menu_shortcode($atts, $content = null) {
    extract(shortcode_atts(array( 'name' => null, ), $atts));
    return wp_nav_menu( array( 'menu' => $name, 'echo' => false ) );
}
add_shortcode('menu', 'print_menu_shortcode');

/*DISABLE UPGRADE CORE*/
add_filter( 'pre_site_transient_update_core', create_function( '$a', "return null;" ) );

/* ADD CUSTOM META FOR NOTES ON PROMOTIONS */
add_action('admin_init','promo_init');

function promo_init()
{
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'] ;
	$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);

	// check for a template type
	if ($template_file == 'promo.php')
	{
		add_meta_box('promo', 'Promotion Details', 'promo_setup', 'page', 'side', 'low');
	}
	add_action('save_post','promo_save');
}

function promo_setup()
{
    global $post;
  
    // using an underscore, prevents the meta variable
    // from showing up in the custom fields section
    $meta = get_post_meta($post->ID,'_show_notes',TRUE);
	$metatitle = get_post_meta($post->ID,'_thanks_title',TRUE);
	if(!$metatitle) { $metatitle="Thanks for your submission!"; }
	$metatext = get_post_meta($post->ID,'_thanks_text',TRUE);
	if(!$metatext) { $metatext="We will get back to you as soon as possible."; }
	$metacustomer = get_post_meta($post->ID,'_customer_text',TRUE);
	if(!$metacustomer) { $metacustomer="Thank You for signing up!"; }
	  
    echo "<p><input type='checkbox' id='_show_notes' name='_show_notes' value='1'";
	if($meta) echo " checked";
	echo "/> <label for='_show_notes'>Display Notes Field?</label></p>";
	
	echo "<p><label for='_thanks_title'>Thank You Message Title</label><br />
	<input style='width: 258px;' type='text' id='_thanks_title' name='_thanks_title' value='".$metatitle."'";
	echo "/> </p>";
	
	echo "<p><label for='_thanks_text'>Thank You Message Text</label><br />
	<textarea style='width: 258px;' id='_thanks_text' name='_thanks_text' rows='3'>".$metatext."</textarea></p>";
	
	echo "<p><label for='_customer_text'>Customer Email Message</label><br /><em>If blank, no email is sent.</em><br />
	<textarea style='width: 258px;' id='_customer_text' name='_customer_text' rows='10'>".$metacustomer."</textarea></p>";
  
    // create a custom nonce for submit verification later
    echo '<input type="hidden" name="promo_noncename" value="' . wp_create_nonce(__FILE__) . '" />';
}
  
function promo_save($post_id) 
{
    // authentication checks
 
    // make sure data came from our meta box
    if (!wp_verify_nonce($_POST['promo_noncename'],__FILE__)) return $post_id;
 
    // check user permissions
    if ($_POST['post_type'] == 'page') 
    {
        if (!current_user_can('edit_page', $post_id)) return $post_id;
    }
    else
    {
        if (!current_user_can('edit_post', $post_id)) return $post_id;
    }
 
    // authentication passed, save data
 
    // var types
    // single: _my_meta[var]
    // array: _my_meta[var][]
    // grouped array: _my_meta[var_group][0][var_1], _my_meta[var_group][0][var_2]
 
    $current_data = get_post_meta($post_id, '_show_notes', TRUE);  
	$current_data1 = get_post_meta($post_id, '_thanks_title', TRUE); 
	$current_data2 = get_post_meta($post_id, '_thanks_text', TRUE); 
	$current_data3 = get_post_meta($post_id, '_customer_text', TRUE); 
  
    $new_data = $_POST['_show_notes'];
	$new_data1 = $_POST['_thanks_title'];
	$new_data2 = $_POST['_thanks_text'];
	$new_data3 = $_POST['_customer_text'];
 
    if ($current_data) 
    {
        if (is_null($new_data)) delete_post_meta($post_id,'_show_notes');
        else update_post_meta($post_id,'_show_notes',$new_data);
    }
    elseif (!is_null($new_data))
    {
        add_post_meta($post_id,'_show_notes',$new_data,TRUE);
    }
	
	if ($current_data1) 
    {
        if (is_null($new_data1)) delete_post_meta($post_id,'_thanks_title');
        else update_post_meta($post_id,'_thanks_title',$new_data1);
    }
    elseif (!is_null($new_data1))
    {
        add_post_meta($post_id,'_thanks_title',$new_data1,TRUE);
    }
	
	if ($current_data2) 
    {
        if (is_null($new_data2)) delete_post_meta($post_id,'_thanks_text');
        else update_post_meta($post_id,'_thanks_text',$new_data2);
    }
    elseif (!is_null($new_data2))
    {
        add_post_meta($post_id,'_thanks_text',$new_data2,TRUE);
    }
	if ($current_data3) 
    {
        if (is_null($new_data3)) delete_post_meta($post_id,'_customer_text');
        else update_post_meta($post_id,'_customer_text',$new_data3);
    }
    elseif (!is_null($new_data3))
    {
        add_post_meta($post_id,'_customer_text',$new_data3,TRUE);
    }
 
    return $post_id;
}

if($blog_id==1) {
add_action('admin_menu', 'register_custom_menu_page');
}

function register_custom_menu_page() {
   add_menu_page('Promotion Entries', 'Promo Entries', 'add_users', 'promos', 'promo_page',   '', 21);
}

function promo_page(){
	?>
   <h2>Promotion Entries</h2>
   <table class="wp-list-table widefat fixed pages" cellspacing="0">
<thead><tr><th>Promotion Title</th><th width="150"># Entries</th><th width="150">Export</th></tr></thead>
<tfoot><tr><th>Promotion Title</th><th># Entries</th><th>Export</th></tr></tfoot>
<tbody id="the-list">
<?
$pages = get_pages(array(
    'meta_key' => '_wp_page_template',
    'meta_value' => 'promo.php',
	'post_status' => 'publish,draft,private'
));
foreach($pages as $page){
	$entries = mysql_query("SELECT * FROM wp_promotions WHERE post_id='".$page->ID."'");
    echo "<tr height='50'><td><strong>".$page->post_title."</strong><br /><a href='".get_permalink($page->ID)."'>Edit Page</a></td><td>".mysql_num_rows($entries)."</td><td>";
	if(mysql_num_rows($entries)>0) { echo "<a href='".get_bloginfo("url")."/promocsv/export.php?expo=".$page->ID."'>CSV</a>";
	} else {
		echo "---";
	}
	echo "</td></tr>";
}
?>
</tbody>
</table>
<? }

?>
