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
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">

<!-- JQuery -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

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
						<a href="<?php echo site_url(); ?>">
							<img src="<?php bloginfo('template_directory'); ?>/images/logo.png" alt="CBD Connection" class="logo-img" data-no-retina="" width="681" height="151">
						</a>
					</div>
					
					<div id="menu-customer">
						<?php if ( is_user_logged_in() ) { ?>
							<?php 
								wp_nav_menu( 
									array( 
										'theme_location' => 'customer' 
									) 
								); 
							?>
							<ul class="cart">
								<?php global $woocommerce; ?>
								<li>
									<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">
										<i class="fa fa-shopping-cart" aria-hidden="true"></i>
										<span class="badge">
											<?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?>
										</span>
									</a>
								</li>
							</ul>
						<?php } else { ?>
							<ul>
								<?php global $woocommerce; ?>
								<li>
									<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">
										<i class="fa fa-shopping-cart" aria-hidden="true"></i>
										<span class="badge">
											<?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?>
										</span>
									</a>
								</li>
								<li>
									<a href="<?php echo site_url(); ?>/your-account/">Log In</a>
								</li>
							</ul>
						<?php } ?>
					</div>
					
					<div id="navigation">
					
						<div id="search-wrapper">
							<i class="fa fa-search toggleSearch" aria-hidden="true"></i>
							<div class="search">
								<form class="form" action="<?php echo site_url(); ?>/" method="get">
								    <div class="form-group">
										<i class="fa fa-close toggleSearch" aria-hidden="true"></i>
								        <input type="text" class="form-control" placeholder="Search CBD Connection" name="s" id="search" value="<?php the_search_query(); ?>">
								        <input type="submit" class="form-submit" >
								        <div class="clear"></div>
								    </div>
								</form>
							</div>
						</div>
					
						<div class="button mobileToggle">
						    <i class="fas fa-bars"></i>
						</div>
						
						<div id="mobile-navigation">
				
				            <div class="button mobileToggle">
				                <i class="fas fa-times"></i>
				            </div>
				
				            <div class="content">
				
				                <div id="mobile-search">
				                    <form class="form" action="<?php echo site_url(); ?>/" method="get">
				                        <div class="form-group">
				                            <input type="text" class="form-control" placeholder="Search CBD Connection" name="s" id="search" value="<?php the_search_query(); ?>">
				                            <input type="submit" class="form-submit" >
				                            <div class="clear"></div>
				                        </div>
				                    </form>
				                </div>
				
				                <div id="mobile-menu-shop">
				                    <h3>Shop</h3>
				                    <?php 
				                    	wp_nav_menu( 
				                    		array( 
				                    			'theme_location' => 'shop' 
				                    		) 
				                    	); 
				                    ?>
				                </div>
				
				                <div id="mobile-menu-customer">
				                    <h3>My Account</h3>
				                    <?php if ( is_user_logged_in() ) { ?>
				                    	<?php 
				                    		wp_nav_menu( 
				                    			array( 
				                    				'theme_location' => 'customer' 
				                    			) 
				                    		); 
				                    	?>
				                    	<ul class="cart">
				                    		<?php global $woocommerce; ?>
				                    		<li>
				                    			<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">
				                    				My Cart <i class="fa fa-shopping-cart" aria-hidden="true"></i>
				                    				<span class="badge">
				                    					<?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?>
				                    				</span>
				                    			</a>
				                    		</li>
				                    	</ul>
				                    <?php } else { ?>
				                    	<ul>
				                    		<?php global $woocommerce; ?>
				                    		<li>
				                    			<a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>">
				                    				My Cart <i class="fa fa-shopping-cart" aria-hidden="true"></i>
				                    				<span class="badge">
				                    					<?php echo sprintf(_n('%d', '%d', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?>
				                    				</span>
				                    			</a>
				                    		</li>
				                    		<li>
				                    			<a href="<?php echo site_url(); ?>/your-account/">Log In</a>
				                    		</li>
				                    	</ul>
				                    <?php } ?>
				                </div>
				
				                <div id="mobile-menu-content">
				                    <h3>About CBD</h3>
				                    <?php 
				                    	wp_nav_menu( 
				                    		array( 
				                    			'theme_location' => 'content' 
				                    		) 
				                    	); 
				                    ?>
				                </div>
				
				            </div>
				
				        </div>
					
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
