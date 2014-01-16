<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package Clean Content
 */

get_header(); ?>

		<div id="main " class="main left" role="main">


		<?php if ( have_posts() ) : ?>

			<header class="page-header">
				<h2 class="page-title"><?php printf( __( 'Search Results for: %s', 'clean-content' ), '<span>' . get_search_query() . '</span>' ); ?></h2>
				<hr>
			</header><!-- .page-header -->

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'search' ); ?>

			<?php endwhile; ?>

			<?php clean_content_paging_nav(); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

		</div><!-- #main -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
