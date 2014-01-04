<?php
/**
 * The Template for displaying all single posts.
 *
 * @package Clean Content
 */

get_header(); ?>

<?php if ( has_post_format( 'image' )): ?>
	<div id="main" class="main" role="main">
<?php else: ?>
		<div id="main" class="main left" role="main">
		<?php endif; ?>

			<div id="single-post" class="page">

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
		<?php if ( !has_post_format( 'image' )): ?>
			<?php get_sidebar(); ?>
		<?php endif; ?>
		<?php get_footer(); ?>