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
	
	        	<section class="marquee text-center" style="background-image: url(<?php the_sub_field('marquee_bg'); ?>);">
					
					<div class="overlay--black"></div>
					
					<div class="vertical-align">
						<div class="vertical-align--content">
					
							<?php if( get_sub_field('marquee_headline') ): ?>
								<h1><?php the_sub_field('marquee_headline'); ?></h1>
							<?php endif; ?>
							
							<?php if( get_sub_field('marquee_subheadline') ): ?>
								<?php the_sub_field('marquee_subheadline'); ?>
							<?php endif; ?>
							
							<?php if( get_sub_field('marquee_cta') ): ?>
								<?php $post_object = get_sub_field('marquee_cta'); if( $post_object ): $post = $post_object; setup_postdata( $post ); ?>
								    <a href="<?php the_permalink(); ?>" class="button">
								    	<?php the_sub_field('marquee_cta_label'); ?>
								    </a>
								    <?php wp_reset_postdata(); ?>
								<?php endif; ?>
							<?php endif; ?>
							
						</div>
					</div>
					
				</section>
	
	        <?php //} elseif( get_row_layout() == 'download' ) { ?>
	
	        <?php } ?>
	
	    <?php endwhile; ?>
	<?php else : endif; ?>

<?php get_footer(); ?>