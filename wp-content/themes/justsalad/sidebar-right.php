<?php
/**
 * The Right Sidebar containing the right widget area.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>

<div id="sidebar-right">

   	<? if(is_archive() || is_single() || is_search() || is_home()){

		if(is_single()) {?>
			<div class="backwardlink"><a href="/blog">Back to Blog</a></div>
		<? }
	?>
		<h2>Topics</h2>
		<ul class="unbulleted dotted">
			<?php wp_list_categories('title_li=0'); ?>
		</ul>

		<h2>Archives</h2>
		<ul class="unbulleted">
			<?php wp_get_archives('type=monthly&limit=10'); ?>
			<li><div class="forwardlink"><a href="/blog/blog-archives">See All</a></div></li>
		</ul>
	<? }?>

	<? $queryS1 = new WP_Query('post_type=ag_custom_box&ag_box_cat=sidebar-b1&orderby=rand&posts_per_page=1');
	if($queryS1){
		while ( $queryS1->have_posts() ) : $queryS1->the_post();
			echo '<div class="box">'.get_the_content().'</div>';
		endwhile;
	}

	$queryS2 = new WP_Query('post_type=ag_custom_box&ag_box_cat=sidebar-b2&orderby=rand&posts_per_page=1');
	if($queryS2){
		while ( $queryS2->have_posts() ) : $queryS2->the_post();
			echo '<div class="box">'.get_the_content().'</div>';
		endwhile;
	}?>


	<?php if ( is_active_sidebar( 'right-widget-area' ) ) : ?>
		<div class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'right-widget-area' ); ?>
		</div><!-- #secondary .widget-area -->
	<?php endif; ?>

	<? get_sidebar('newsletter');?>
    
   	<? if(!is_archive() && !is_single() && !is_search() && !is_home()){
		get_sidebar('blog');
	}?>

	<? get_sidebar('social');?>

    
</div>