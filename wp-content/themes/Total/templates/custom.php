<?php
/**
 * Template Name: Custom Page Template
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 * @version 3.3.2
 */
 ?>

<?php get_header(); ?>

	<?php if( have_rows('sections') ): ?>
		<?php while ( have_rows('sections') ) : the_row(); ?>
	
	        <?php if( get_row_layout() == 'marquee' ) { ?>
	
	        	<?php include (TEMPLATEPATH . '/includes/marquee.php' ); ?>
	
	        <?php } elseif( get_row_layout() == 'text' ) { ?>
	                
	            <?php include (TEMPLATEPATH . '/includes/text.php' ); ?>
	        
	        <?php } elseif( get_row_layout() == 'blocks' ) { ?>
	        
	        	<?php include (TEMPLATEPATH . '/includes/blocks.php' ); ?>
	
	        <?php } elseif( get_row_layout() == 'featured' ) { ?>
	                
	            <?php include (TEMPLATEPATH . '/includes/featured.php' ); ?>
	        
	        <?php } elseif( get_row_layout() == 'quotes' ) { ?>
	                
	            <?php include (TEMPLATEPATH . '/includes/quotes.php' ); ?>
	            
	        <?php } ?>
	
	    <?php endwhile; ?>
	<?php else : endif; ?>

<?php get_footer(); ?>