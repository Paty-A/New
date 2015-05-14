<?php
/*
Template Name: Sitemap
*/
?>

<?php get_header(); ?>

		<div id="container">
            <section id="content" role="main">

            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        
                <h1><?php the_title(); ?></h1>
        
                    <h2>By Page</h2>
                    <ul>
                        <?php wp_list_pages('title_li='); ?>
                    </ul>

                    <h2>By Post</h2>
                    <ul>
                        <?php wp_get_archives('type=alpha'); ?>
                    </ul>

                    <h2>By Date</h2>
                    <ul>
                        <?php wp_get_archives('type=monthly'); ?>
                    </ul>

                    <h2>By Category</h2>
                    <ul>
                        <?php wp_list_categories('title_li=0'); ?>
                    </ul>

                    <? $theTags = get_tags();
                    if($theTags){
                        echo "<h2>By Tag</h2>
                        <ul>";
                            foreach($theTags as $tag){
                                echo '<li><a href="'.get_the_bloginfo('url').'/tag/'.$tag->slug.'">'.$tag->slug.'</a></li>';
                            }
                        echo "</ul>";
                    }?>


                    <h2>By RSS Feed</h2>
                    <ul>
                        <li><a href="<?php bloginfo('rdf_url'); ?>" alt="RDF/RSS 1.0 feed" rel="nofollow"><acronym title="Resource Description Framework">RDF</acronym>/<acronym title="Really Simple Syndication">RSS</acronym> 1.0 feed</a></li>
                        <li><a href="<?php bloginfo('rss_url'); ?>" alt="RSS 0.92 feed" rel="nofollow"><acronym title="Really Simple Syndication">RSS</acronym> 0.92 feed</a></li>
                        <li><a href="<?php bloginfo('rss2_url'); ?>" alt="RSS 2.0 feed" rel="nofollow"><acronym title="Really Simple Syndication">RSS</acronym> 2.0 feed</a></li>
                        <li><a href="<?php bloginfo('atom_url'); ?>" alt="Atom feed" rel="nofollow">Atom feed</a></li>
                    </ul>
            
            <?php endwhile; endif; ?>

            </section><!-- #content -->
			<?php get_sidebar('right'); ?>
		</div><!-- #container -->

<?php get_footer(); ?>