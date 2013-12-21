<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Clean Content
 */

get_header(); ?>

	<div id="single-post" class="page">
		<div id="main" class="main left" role="main">

		<?php while ( have_posts() ) : the_post(); ?>
			

			<?php get_template_part( 'content', 'single' ); ?>

			<?php clean_content_post_nav(); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() ) :
					comments_template();
				endif;
			?>

		<?php endwhile; // end of the loop. ?>

		</div><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>