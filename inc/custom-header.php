<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...
 * @package Clean Content
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses clean_content_header_style()
 * @uses clean_content_admin_header_style()
 * @uses clean_content_admin_header_image()
 *
 * @package Clean Content
 */
function clean_content_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'clean_content_custom_header_args', array(
		'default-image'          => '',
		'width'                  => 1100,
		'height'                 => 250,
		'flex-height'            => true,
		'wp-head-callback'       => 'clean_content_header_style',
		'admin-head-callback'    => 'clean_content_admin_header_style',
		'admin-preview-callback' => 'clean_content_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'clean_content_custom_header_setup' );

if ( ! function_exists( 'clean_content_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see clean_content_custom_header_setup().
 */
function clean_content_admin_header_image() {
	$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );
?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // clean_content_admin_header_image
