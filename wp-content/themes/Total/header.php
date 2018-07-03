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
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

</head>

<!-- Begin Body -->
<body <?php body_class(); ?>>
	
	<?php wpex_outer_wrap_before(); ?>
	
	<div id="outer-wrap" class="clr">
	
		<?php wpex_hook_wrap_before(); ?>
	
		<div id="wrap" class="clr">
	
			<?php //wpex_hook_wrap_top(); ?>
			
			<header id="header">
				<div class="container">
				
					<div id="logo">
						<a href="">
							<img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="CBD Connection" class="logo-img" data-no-retina="" width="681" height="151">
						</a>
					</div>
					
					<!--<div id="search">
						Search
					</div>
					
					<div id="menu-customer">
						Customer Menu
					</div>-->
					
					<div id="navigation">
					
						<div id="menu-shop">
							<?php 
								wp_nav_menu( 
									array( 
										'theme_location' => 'shop' 
									) 
								); 
							?>
						</div>
						
						<div id="menu-content">
							<?php 
								wp_nav_menu( 
									array( 
										'theme_location' => 'content' 
									) 
								); 
							?>
						</div>
						
						<div class="clearfix"></div>
					
					</div>
					
					<div class="clearfix"></div>
				
				</div>
			</header>
	
			<?php wpex_hook_main_before(); ?>
	
			<main id="main" class="site-main clr"<?php wpex_schema_markup( 'main' ); ?><?php wpex_aria_landmark( 'main' ); ?>>
	
				<?php wpex_hook_main_top(); ?>
