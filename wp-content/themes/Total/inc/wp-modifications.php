<?php

// Modifies Admin Bar

	// Adds Additional Menus on Admin Bar 
	
	function add_sumtips_admin_bar_link() {
		global $wp_admin_bar;
		
		    $site_url = site_url();
		
		    if ( ! is_admin() ) {
		        $wp_admin_bar->add_menu( array(
		        'id' => 'admin_bar_switch_view',
		        'title' => __( 'Go to Dashboard'),
		        'href' => __(''.$site_url.'/wp-admin/'),
		        ) );
		    } else  {
		        $wp_admin_bar->add_menu( array(
		        'id' => 'admin_bar_switch_view',
		        'title' => __( 'Go to Website'),
		        'href' => __(site_url()),
		        ) );
		    }
	
	}
	add_action('admin_bar_menu', 'add_sumtips_admin_bar_link',25);
	
	// Removes Some Default Links
	
	function remove_admin_bar_links() {
		global $wp_admin_bar;
		$wp_admin_bar->remove_menu('wp-logo');
		$wp_admin_bar->remove_menu('updates');
		$wp_admin_bar->remove_menu('site-name');
		$wp_admin_bar->remove_menu('new-content');
		$wp_admin_bar->remove_menu('comments');
		$wp_admin_bar->remove_menu('search');
	}
	add_action( 'wp_before_admin_bar_render', 'remove_admin_bar_links' );
	
	// Modifies 'Howdy' Content
	
	add_filter( 'body_class', 'twentyeleven_body_classes' );
	add_filter('gettext', 'change_howdy', 10, 3);
	function change_howdy($translated, $text, $domain) {
	if (false !== strpos($translated, 'Howdy'))
	return str_replace('Howdy,', 'My Account:', $translated);
	return $translated;
	}
	
	// Hides Admin Bar for Everyone But Admins
	
	add_action('after_setup_theme', 'remove_admin_bar');
	
	function remove_admin_bar() {
		if (!current_user_can('administrator') && !is_admin()) {
		  show_admin_bar(false);
		}
	}


// Adds Style to Admin

add_action('admin_head', 'my_custom_logo');

function my_custom_logo() {
echo '
    <link href="'.get_bloginfo('template_directory').'/css/admin.css" type="text/css" rel="stylesheet">
<meta name="viewport" content="width=1100, initial-scale=0.5">
';
}



// Changing the Admin Menu

require_once('wp-admin-menu-classes.php');
add_action('admin_menu','my_admin_menu');
function my_admin_menu() {

    // Removes Sections
    remove_admin_menu_section('Links');
    remove_admin_menu_section('Appearance');
    remove_admin_menu_section('Tools');
    //remove_admin_menu_section('Blog');
    remove_admin_menu_section('Media');
    remove_admin_menu_section('edit-comments.php');
    //remove_admin_menu_section('plugins.php');
    remove_admin_menu_section('themes.php');
    remove_admin_menu_section('options-writing.php');
    remove_admin_menu_section('Profile');
    
}