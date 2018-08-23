<?php 
	$count = count(get_sub_field('text_blocks')); 
	if ($count == 1) {
		$layout = 'one column';
	} elseif ($count == 2) {
		$layout = 'two column';
	} elseif ($count == 3) {
		$layout = 'three column';
	}
?>

<section class="text <?php echo $layout; ?>">
    <div class="container">
		
		<?php if( get_sub_field('text_headline') ): ?>
			<h3 class="headline"><?php the_sub_field('text_headline'); ?></h3>
		<?php endif; ?>
		
		<?php if( have_rows('text_blocks') ): ?>
		
			<?php while ( have_rows('text_blocks') ) : the_row(); ?>
		
		        <div class="column">
		            <div class="content">
						
						<?php the_sub_field('text_blocks_block'); ?>
						
						<?php if( get_sub_field('text_blocks_link') ): ?>
							<p>
								<a href="<?php the_sub_field('text_blocks_link'); ?>" class="button">Learn More</a>
							</p>
						<?php endif; ?>
						
					</div>
				</div>
		
		    <?php endwhile; ?>
		
		<?php else : endif; ?>
		
		<div class="clear"></div>
		
	</div>
</section>

<div class="clear"></div>

<!--<section class="text">
    <div class="container">

        <div class="column">
            <div class="content">

                <h3>What is CBD?</h3>
                <p>CBD is a compound found in the cannabis sativa plant that has shown to have significant medical benefits and healing properties and is being used throughout the world as an alternative to traditional medicine or therapies. CBD does not create the “high” of marijuana and thus is being used by people of all ages and their pets.</p>
                <p>
                    <a href="https://www.cbdconnection.net/what-is-cbd/" class="button">
                        Learn More
                    </a>
                </p>

            </div>
        </div>

        <div class="column">
            <div class="content">

                <h3>Why Buy From Us?</h3>

                <div class="column">
                    <p>CBD Connection is your trusted resource to buy the best CBD and hemp products online. Our team has carefully curated a collection of the most superior, innovative, and ethically-sourced products available.</p>
                </div>

                <div class="column">
                    <p>Through our strong connections with researchers, scientists, and developers, we are your go-to specialists in this emerging CBD market. We continuously stay on top of developing trends, provide you with the latest research and bring you trusted, third-party tested and innovative products.</p>
                </div>

            </div>
        </div>

        <div class="clear"></div>

    </div>
</section>-->