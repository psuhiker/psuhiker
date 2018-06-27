<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 * @version 4.2
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?><?php wpex_schema_markup( 'html' ); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>

<!-- Additional Styles -->
<link href="<?php bloginfo('template_directory'); ?>/css/custom.css?<?php echo rand(0,99999); ?>" type="text/css" rel="stylesheet">

</head>

<!-- Begin Body -->
<body <?php body_class(); ?>>

<?php wpex_outer_wrap_before(); ?>

<div id="outer-wrap" class="clr">

	<?php wpex_hook_wrap_before(); ?>

	<div id="wrap" class="clr">

		<?php wpex_hook_wrap_top(); ?>

		<?php wpex_hook_main_before(); ?>

		<main id="main" class="site-main clr"<?php wpex_schema_markup( 'main' ); ?><?php wpex_aria_landmark( 'main' ); ?>>

			<?php wpex_hook_main_top(); ?>