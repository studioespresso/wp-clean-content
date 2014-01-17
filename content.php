<?php
/**
 * @package Clean Content
 */
?>

<article  id="post-<?php the_ID(); ?>" <?php post_class('content article'); ?>>
	<header class="entry-header">
		<?php if ( has_post_format( 'link' )): ?>
			<h2 class="entry-title linked-list-item"><a href="<?php echo get_post_meta($post->ID, 'standard_link_url_field', true); ?>" title="<?php printf( esc_attr__( 'Link to %s', 'clean-content' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark"><?php the_title(); ?> &rarr;</a></h2>
		<?php elseif ( has_post_format( 'quote' )): ?>
		<?php else: ?>
			<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php endif; ?>
		<?php if ( !has_post_format( 'quote' )): ?>
		<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php clean_content_posted_on(); ?>
				<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
					<?php clean_content_meta_categories(); ?>
				<?php endif; // End if 'post' == get_post_type() ?>

			</div><!-- .entry-meta -->
		<?php endif; ?>
	<?php endif; ?>
	</header><!-- .entry-header -->

	<?php if ( is_search() ) : // Only display Excerpts for Search ?>
	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div><!-- .entry-summary -->
	<?php else : ?>
		<?php if ( has_post_thumbnail()) : ?>
		  <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" >
		  <?php the_post_thumbnail('full'); ?>
		  </a>
		<?php endif; ?>
	<div class="entry-content">
	<?php if ( has_post_format( 'quote' )): ?>
<blockquote class="quote">
<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'clean-content' ) ); ?>
<small class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></small>
</blockquote>
	<?php else: ?>
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'clean-content' ) ); ?>

	<?php endif; ?>



		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'clean-content' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<?php endif; ?>
	<?php if ( !has_post_format( 'quote' )): ?>
	<footer class="entry-meta">
	<?php if ( has_post_format( 'link' )): ?>
		<span class="permalink-title"><a href="<?php the_permalink(); ?>" rel="bookmark">&infin;</a></span>
	<?php endif; ?>
		<?php if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search ?>
			<?php
				/* translators: used between list items, there is a space after the comma */
				$tags_list = get_the_tag_list( '', __( ' / ', 'clean-content' ) );
				if ( $tags_list ) :
			?>
			<span>
				<?php printf( __( '%1$s |', 'clean-content' ), $tags_list ); ?>
			</span>
			<?php endif; // End if $tags_list ?>
		<?php endif; // End if 'post' == get_post_type() ?>

		<?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
		<span class="comments-link"> <?php comments_popup_link( __( 'Leave a comment', 'clean-content' ), __( '1 Comment', 'clean-content' ), __( '% Comments', 'clean-content' ) ); ?></span>
		<?php endif; ?>

		<?php edit_post_link( __( 'Edit', 'clean-content' ), '<span class="edit-link">| ', '</span>' ); ?>
	</footer><!-- .entry-meta -->
<?php endif; ?>
</article><!-- #post-## -->
