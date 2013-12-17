<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Clean Content
 */
?>

	</div><!-- #content -->

	<footer class="footer" role="contentinfo">
		<div class="site-info">
		FOOTER
			<?php do_action( 'clean_content_credits' ); ?>
			<a href="http://wordpress.org/" rel="generator"><?php printf( __( 'Proudly powered by %s', 'clean-content' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php printf( __( 'Theme: %1$s by %2$s.', 'clean-content' ), 'Clean Content', '<a href="http://underscores.me/" rel="designer">Underscores.me</a>' ); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #masthead -->

<?php wp_footer(); ?>
</body>
</html>