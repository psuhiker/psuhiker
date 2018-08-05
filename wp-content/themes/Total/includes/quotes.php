<section class="quotes">
	
	<?php if( have_rows('quotes_quote') ): ?>
	
		<?php 
			$counter = 1;
		?>
	
		<?php while ( have_rows('quotes_quote') ) : the_row(); ?>
			
			<div class="quote fade <?php if( $counter == 1 ) { ?>current<?php }; ?>" style="background-image: url(<?php the_sub_field('quotes_quote_bg'); ?>);">
				
				<div class="container">
		
					<div class="quote-text">
						<?php the_sub_field('quotes_quote_quote'); ?>
					</div>
					
					<?php if( get_sub_field('quotes_quote_source') ): ?>
						<div class="source">
							<?php the_sub_field('quotes_quote_source'); ?>
						</div>
					<?php endif; ?>
				
				</div>
				
			</div>
			
			<?php $counter++; ?>
				
		<?php endwhile; ?>
	<?php else : endif; ?>
	
	<div class="clearfix"></div>
	
</section>

<div class="clearfix"></div>

<script>
	var divs = $('.fade');
	
	function fade() {
	    var current = $('.current');
	    var currentIndex = divs.index(current),
	        nextIndex = currentIndex + 1;
	
	    if (nextIndex >= divs.length) {
	        nextIndex = 0;
	    }
	
	    var next = divs.eq(nextIndex);
	
	    next.stop().fadeIn(2000, function() {
	        $(this).addClass('current');
	    });
	
	    current.stop().fadeOut(2000, function() {
	        $(this).removeClass('current');
	        setTimeout(fade, 2500);
	    });
	}
	
	fade();
</script>
