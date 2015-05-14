<?php
/**
 * Template Name: SINGLE Location
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

<div style="clear: both;">


<div class="location-info">
<?
	$lettervar = "A";

 $xml = simplexml_load_file($_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/markers.xml');
 for($i=0; $i<count($xml); $i++) {
 	 if($_SERVER["REQUEST_URI"]==trim($xml->marker[$i]->url)) {
	 	$thisloc = $xml->marker[$i];
		break;
	 }
 }
	 
	 
	 ?>
	<h3><?=$thisloc->name?></h3>
    <?=$thisloc->address?><br />
    <?=$thisloc->details?>

		<h4>Hours:</h4>
        <?=$thisloc->hours?><br />
        <?=$thisloc->hours2?>

        <h4>Phone:</h4>
        <?=$thisloc->phone?>
        
        <div id="buttons">
            <a href="<?=$thisloc->menu?>" class="button">Menu</a>
            <a style="clear: both; margin-top: 8px;" href="https://www.orderjustsalad.com/" class="button">Order Online</a>
        </div>
        
       	<a href="/locations/" class="arrow-back">Back to Locations</a>
</div>
<div class="location-infoB">



    
				<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

					<h1 class="offscreen"><?php the_title(); ?></h1>

					<?php the_content(); ?>
                    <?php wp_link_pages( array( 'before' => '<div class="page-link">' . __( 'Pages:', 'twentyten' ), 'after' => '</div>' ) ); ?>

                    <?php comments_template( '', true ); ?>

				<?php endwhile; ?>
                
</div>     
</div>          
			</section><!-- #content -->
			<?php get_sidebar('right'); ?>
		</div><!-- #container -->

<?php get_footer(); ?>
