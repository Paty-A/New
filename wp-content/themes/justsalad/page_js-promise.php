<?php
/*
 * Template Name: JS Promise Page
 * 
 * A custom page template with left sidebar list-type menu, 3 buttons,
 * and a combination of static images and columns of text depending
 * on which button is pressed.
 * 
 * @package WordPress
 * @subpackage justsalad
 * @author Morgan T
 */

get_header();?>

		<div id="container" class="jsp-page">
            <section id="content" role="main">

	        	<div class="promise-list hide-small"> <!-- to regionalize: href="/food/region/?echo $pagename;?" -->
	            	<ul>
						<li>
							<a href="/promise/">The JS Promise</a>
						</li>
						<li>
							<a href="http://www.nutritionix.com/just-salad/portal">Nutrition</a>
						</li>
						<li>
							<a href="/culture/nutrition-fitness/">Ambassadors</a>
						</li>
						<li>
							<a href="/blog/">JS Blog</a>
						</li>
					</ul>
	            </div>
	        
	        	<?php if ($pagename == 'food') {echo '<a href="/promise/">';} //this screws up sizing, but...
	            echo get_the_post_thumbnail( $post->ID, array(819,200), array('class'=>'featured-jsp hide-small') );
	            if ($pageame == 'food') {echo '</a>';} ?>
            	             
				<!-- Consider #6 http://premium.wpmudev.org/blog/free-wordpress-tab-plugins/  - nvm -->
				<ul id="promise-info" class="page-menu" > 
					<li id="local" class="menu-item <?php if ($pagename == 'local-list') echo ' current-menu-item';?>">
						<a id="local-button" href="/food/local-list/">local list</a>
					</li>
					<li id="org" class="menu-item <?php if ($pagename == 'organic') echo ' current-menu-item';?>">
						<a id="org-button" href="/food/organic/">organic</a>
					</li>
					<li id="gmo" class="menu-item <?php if ($pagename == 'non-gmo') echo ' current-menu-item';?>">
						<a id="gmo-button" href="/food/non-gmo/">non-gmo</a>
					</li>
				</ul>	             
	             
	            <div id="jsp-content"> 
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); //maybe ?>

					<h1 class="offscreen"><?php the_title(); ?></h1>

					<?php the_content(); ?>

					<?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) );?>

				<?php endwhile; ?>
		
				<div class="col-fourth first">
                    <? get_sidebar('blog');?>
					<? get_sidebar('social');?>
                </div>
				
				</div>                
				<!--#jsp-content-->
			</section><!-- #content -->
		</div><!-- #container -->

<?php get_footer(); ?>
