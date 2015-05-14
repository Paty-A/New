<?php
/**
 * The Template for displaying all single posts.
 *
 * @package WordPress
 * @subpackage Twenty_Ten_Five
 * @since Twenty Ten Five 1.0
 */

get_header(); ?>

		<div id="container">
            <section id="content" role="main">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>

                <div class="meta-info">
                    <?php twentyten_posted_on(); ?>
                </div><!-- .meta-info -->

				<?php the_content(); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>
            </article><!-- #post-## -->

            <nav id="nav-below" class="navigation">
                <div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '', 'Previous post link', 'twentyten' ) . '</span> %title' ); ?></div>
                <div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '', 'Next post link', 'twentyten' ) . '</span>' ); ?></div>
            </nav><!-- #nav-below -->

            <?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>

            </section><!-- #content -->
			<?php get_sidebar('right'); ?>
		</div><!-- #container -->

<?php get_footer(); ?>
