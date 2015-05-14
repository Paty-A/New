<?php
/**
 * Template Name: Archives
 *
 * A custom page template for blog archives.
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
            <section id="content" role="main">

                <h2>Browse By Month:</h2>
                    <ul>
                        <?php wp_get_archives('type=monthly'); ?>
                    </ul>
                    <h2>Browse By Category:</h2>
                    <ul>
                        <?php wp_list_categories('title_li=0'); ?>
                    </ul>

                    <h2>Browse By Tag:</h2>

					<? 		$theTags = get_tags();
                            if($theTags){
                    
                                foreach($theTags as $tag){
                                    // The Query
                                    $the_query = new WP_Query( 'tag_id='.$tag->term_id.'&cat=-6&posts_per_page=-1' );
                                    
                                    // The Loop
                                    if ($the_query->have_posts()) :
                                    
                                        $li .= "<li><a href='".get_bloginfo('url').'/tag/'.$tag->slug."'>".$tag->name."</a></li>";
                                    
                                    endif;
                    
                                
                                }
                                
                                if($li){
                                    echo '<ul>'.$li.'</ul>';			
                                }
                            }?>
            </section><!-- #content -->
			<?php get_sidebar('right'); ?>
		</div><!-- #container -->

<?php get_footer(); ?>