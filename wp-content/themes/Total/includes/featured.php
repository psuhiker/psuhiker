<section class="featured-products">
	
	<div class="container text-center">
		
		<h2><?php the_sub_field('headline'); ?></h2>
		
	</div>
		
		<ul>
		
			<?php
				$args = array(
			    	'post_type' => 'product',
			    	'posts_per_page' => 12,
			    	'tax_query' => array(
			            array(
			                'taxonomy' => 'product_visibility',
			                'field'    => 'name',
			                'terms'    => 'featured',
			            ),
			        ),
			    );
			    $loop = new WP_Query( $args );
			    if ( $loop->have_posts() ) { 
			    while ( $loop->have_posts() ) : $loop->the_post(); 
			?>
			
				<?php wc_get_template_part( 'content', 'product' ); ?>
			
			<?php 
				endwhile;
				} else {
			    	echo __( 'No products found' );
				}
				wp_reset_postdata();
			?>
		
		</ul>
		
		<div class="clear"></div>
		
	</div>
</section>
