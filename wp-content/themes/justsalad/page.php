<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Ten_Five 
 * @since Twenty Ten Five 1.0
 */

get_header(); ?>

		<div id="container">
            <section id="content" role="main">

	             <?php echo get_the_post_thumbnail( $post->ID, 'featured', array('class'=>'featured') ); ?> 

				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

					<h1 class="offscreen"><?php the_title(); ?></h1>

					<?php the_content(); ?>
                    <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>

                    <?php comments_template( '', true ); ?>

					<?php 
						if($post->post_parent) {
							$permalink = get_permalink($post->post_parent); ?>
							<a class="arrow-back" href="<?php echo $permalink; ?>">Back to <?=get_the_title($post->post_parent)?></a>
					<?php }?>

				<?php endwhile; ?>
                
<!--</div>                -->
			</section><!-- #content -->
			<?php get_sidebar('right'); ?>
		</div><!-- #container -->

<?php get_footer(); ?>
