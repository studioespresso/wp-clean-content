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
			<?php do_action( 'clean_content_credits' ); ?>
			<a href="http://wordpress.org/"><?php printf( __( 'Proudly powered by %s', 'clean-content' ), 'WordPress' ); ?></a>
 			<span class="onedge"><?php printf( __( '%1$s by %2$s', 'clean-content' ), '<a href="http://on-edge.github.io/wp-clean-content/">Clean Content</a>', '<a href="http://onedge.be/" rel="designer">On Edge</a>' ); ?> <br />(Way of the future)</span>

 			
		</div><!-- .site-info -->

	</footer><!-- #colophon -->
</div><!-- #masthead -->

<?php wp_footer(); ?>
</body>
</html>