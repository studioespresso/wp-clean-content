<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Clean Content
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="masthead">
	<?php do_action( 'before' ); ?>
	<div class="container blue">
	<header  class="site-header" role="banner" <?php echo ( get_theme_mod( 'cc_sticky_menu' ) ) ? "style='position:fixed;'" : "" ?>>
			<h1 id="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			<h2 class="site-description"<?php echo ( get_theme_mod( 'cc_show_tagline' ) ) ? "style='display:none;'" : "" ?>><?php bloginfo( 'description' ); ?></h2>

		<nav id="site-navigation" class="main-navigation" role="navigation">
<!-- 			<h1 class="menu-toggle"><?php _e( 'Menu', 'clean-content' ); ?></h1>
 --><!-- 			<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'clean-content' ); ?></a>
 -->
			<?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
		</nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	
