<?php 


// Adds Support for Menus

add_theme_support( 'menus' );

register_nav_menus( array(  
    'shop' => __( 'Shopping Menu' ), 
    'customer' => __( 'Customer Menu' ),    
    'content' => __( 'Content Menu' ), 
) );