<?php
   header("Status: 301 Moved Permanently");
   header("Location:/");
?>
<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		<div id="container">
            <section id="content" role="main">
                <hgroup>
                    <h1>Page Not Found</h1>
                        <h2>The Page You Were Looking For Could Not Be Found.</h2>
                </hgroup>
                    <p>Somehow, you ended up in the wrong place. Please try one of the following:</p>
                    <ul>
                        <li>Hit the "back" button on your browser.</li>
                        <li>Go to the <a href="<?php bloginfo('url'); ?>">home page</a>.</li>
                        <li>Use the navigation menu at the top of the page.</li>
                        <li>Try using the search form.</li>
                    </ul>
                    <?php get_search_form(); ?>
            </section><!-- #content -->
			<?php get_sidebar('right'); ?>
		</div><!-- #container -->

	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php get_footer(); ?>