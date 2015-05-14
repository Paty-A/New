<?php
/**
 * The template for displaying Tag Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		<div id="container">
            <section id="content" role="main">

            <h1><?php echo single_tag_title( '', false )?></h1>
				<?php
                /* Run the loop for the tag archive to output the posts
                * If you want to overload this in a child theme then include a file
                * called loop-tag.php and that will be used instead.
                */
                get_template_part( 'loop', 'tag' );
                ?>
            </section><!-- #content -->
			<?php get_sidebar('right'); ?>
		</div><!-- #container -->

<?php get_footer(); ?>
