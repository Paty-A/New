<?php
/*
Template Name: Homepage
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Twenty_Ten_Five 
 * @since Twenty Ten Five 1.0
 */


get_header(); ?>
		<div id="container">
            <section id="content-wide" role="main" class="front">

				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

					<?php the_content(); ?>
                    <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>

				<?php endwhile; ?>

                <div class="col-fourth first">
                    <? get_sidebar('newsletter');?>
                    <? get_sidebar('blog');?>
					<? get_sidebar('social');?>
                </div>
                
                <div class="col-fourth">
                    <? $queryH1 = new WP_Query('post_type=ag_custom_box&ag_box_cat=home-b1&orderby=rand&posts_per_page=1');
					// The Loop
					while ( $queryH1->have_posts() ) : $queryH1->the_post();
						the_content();
					endwhile;?>
                </div>
                
                <div class="col-fourth">
                    <? $queryH2 = new WP_Query('post_type=ag_custom_box&ag_box_cat=home-b2&orderby=rand&posts_per_page=1');
					// The Loop
					while ( $queryH2->have_posts() ) : $queryH2->the_post();
						the_content();
					endwhile;?>
                </div>
                
                <div class="col-fourth last">
                    <? $queryH3 = new WP_Query('post_type=ag_custom_box&ag_box_cat=home-b3&orderby=rand&posts_per_page=1');
					// The Loop
					while ( $queryH3->have_posts() ) : $queryH3->the_post();
						the_content();
					endwhile;?>
                </div>

            </section><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
