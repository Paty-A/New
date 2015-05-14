<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten_Five 
 * @since Twenty Ten Five 1.0
 */

get_header(); ?>

		<div id="container">
            <section id="content" role="main">

            <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentyten' ), '<span>' . get_search_query() . '</span>' ); ?></h1>

				<?php if ( have_posts() ) : ?>
					<?php
                    /* Run the loop for the search to output the results.
                     * If you want to overload this in a child theme then include a file
                     * called loop-search.php and that will be used instead.
                     */
                     get_template_part( 'loop', 'search' );
                    ?>
                <?php else : ?>
                    <h2><?php _e( 'Not Found', 'twentyten' ); ?></h2>
                        <p><?php _e( 'There were no results that matched your search criteria. Please try again with different search terms.', 'twentyten' ); ?></p>
                        <?php get_search_form(); ?>
                <?php endif; ?>
            </section><!-- #content -->
			<?php get_sidebar('right'); ?>
		</div><!-- #container -->

<?php get_footer(); ?>
