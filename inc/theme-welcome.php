<?php
/**
 * Theme Welcome
 *
 * @description: Adds a welcome message pointer when the user activates the theme
 * @sources:
 * http://wordimpress.com/create-wordpress-theme-activation-popup-message/
 * http://www.wpexplorer.com/making-themes-plugins-more-usable/
 */

function thsp_enqueue_pointer_script_style( $hook_suffix ) {

	// Assume pointer shouldn't be shown
	$enqueue_pointer_script_style = false;

	// Get array list of dismissed pointers for current user and convert it to array
	$dismissed_pointers = explode( ',', get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

	// Check if our pointer is not among dismissed ones
	if( !in_array( 'thsp_settings_pointers', $dismissed_pointers ) ) {
		$enqueue_pointer_script_style = true;

		// Add footer scripts using callback function
		add_action( 'admin_print_footer_scripts', 'thsp_pointer_print_scripts' );
	}

	// Enqueue pointer CSS and JS files, if needed
	if( $enqueue_pointer_script_style ) {
		wp_enqueue_style( 'wp-pointer' );
		wp_enqueue_script( 'wp-pointer' );
	}

}
add_action( 'admin_enqueue_scripts', 'thsp_enqueue_pointer_script_style' );

function thsp_pointer_print_scripts() {

	$pointer_content  = "<h3>Welcome to Clean Content</h3>";
	$pointer_content .= "<p>Here is where you can customize the theme.</p>";
	?>

	<script type="text/javascript">
	//<![CDATA[
	jQuery(document).ready( function($) {
		$('#menu-appearance').pointer({
			content:		'<?php echo $pointer_content; ?>',
			position:		{
								edge:	'left', // arrow direction
								align:	'center' // vertical alignment
							},
			pointerWidth:	350,
			close:			function() {
								$.post( ajaxurl, {
										pointer: 'thsp_settings_pointers', // pointer ID
										action: 'dismiss-wp-pointer'
								});
							}
		}).pointer('open');
	});
	//]]>
	</script>

<?php
}