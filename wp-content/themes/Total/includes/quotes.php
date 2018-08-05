<section class="quotes">
	
	<?php if( have_rows('quotes_quote') ): ?>
		<?php while ( have_rows('quotes_quote') ) : the_row(); ?>
			
			<div class="quote" style="background-image: url(<?php the_sub_field('quotes_quote_bg'); ?>);">
				
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
				
		<?php endwhile; ?>
	<?php else : endif; ?>
	
</section>