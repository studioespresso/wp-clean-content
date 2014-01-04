<?php
/**
 * @package Clean Content
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">

		<?php if ( has_post_format( 'link' )): ?>
			<h1 class="entry-title linked-list-single">
				<a href="<?php echo get_post_meta($post->ID, 'standard_link_url_field', true); ?>" title="Link to <?php the_title_attribute(); ?>"><?php the_title(); ?> &rarr;</a></h1>
			<?php elseif ( has_post_format( 'quote' )): ?>
			<?php else: ?>
				<h1 class="entry-title"><?php the_title(); ?></h1>
			<?php endif; ?>
			<?php if ( !has_post_format( 'quote' )): ?>
			<div class="entry-meta">
				<?php clean_content_posted_on(); ?>
			</div><!-- .entry-meta -->
		<?php endif; ?>
		</header><!-- .entry-header -->
	<?php 
	if ( has_post_thumbnail()) {
	  $large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large');
	  the_post_thumbnail('full');
	}
	?>
	<div class="entry-content">
	<?php if ( has_post_format( 'quote' )): ?>
<blockquote>
		<?php the_content(); ?>
		<small class="entry-title"><?php the_title(); ?></small>

		</blockquote>
	<?php else: ?>
	<?php the_content(); ?>
<?php endif; ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'clean-content' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-meta">
		<?php

			/* date posted */
			$posted_on = clean_content_posted_on();
			/* translators: used between list items, there is a space after the comma */
			$category_list = get_the_category_list( __( ', ', 'clean-content' ) );

			/* translators: used between list items, there is a space after the comma */
			$tag_list = get_the_tag_list( '', __( ', ', 'clean-content' ) );

			if ( ! clean_content_categorized_blog() ) {
				// This blog only has 1 category so we just need to worry about tags in the meta text
				if ( '' != $tag_list ) {
					$meta_text = __( 'This entry was tagged %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'clean-content' );
				} else {
					$meta_text = __( 'Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'clean-content' );
				}

			} else {
				// But this blog has loads of categories so we should probably display them here
				if ( '' != $tag_list ) {
					$meta_text = __( ' in %2$s and tagged %3$s. Bookmark the <a href="%4$s" rel="bookmark">permalink</a>.', 'clean-content' );
				} else {
					$meta_text = __( ' in %2$s. Bookmark the <a href="%3$s" rel="bookmark">permalink</a>.', 'clean-content' );
				}

			} // end check for categories on this blog

			printf(

				$meta_text,
				$posted_on,
				$category_list,
				$tag_list,
				get_permalink()
			);
		?>

		<?php edit_post_link( __( 'Edit', 'clean-content' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->
</article><!-- #post-## -->
