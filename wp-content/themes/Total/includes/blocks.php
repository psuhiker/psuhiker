<section class="blocks">

    <?php if( get_sub_field('blocks_headline') or get_sub_field('blocks_intro') ) { ?>

        <div class="container">

            <div class="row lg-margin--bottom">
                <div class="text-center">
                    <?php if( get_sub_field('blocks_headline') ) { ?>
                        <h2><?php the_sub_field('blocks_headline'); ?></h2>
                    <?php } ?>
                    <?php if( get_sub_field('blocks_intro') ) { ?>
						<div class="intro">
							<?php the_sub_field('blocks_intro'); ?>
						</div>
                    <?php } ?>
                </div>
            </div>

        </div>

    <?php } ?>
	
	<div class="clearfix"></div>

    <?php if( have_rows('blocks_row') ): ?>
        <?php while ( have_rows('blocks_row') ) : the_row(); ?>

            <div class="row block-row">

                <?php if( have_rows('blocks_block') ): ?>
                    <?php while ( have_rows('blocks_block') ) : the_row(); ?>

						<a href="<?php the_sub_field('blocks_block_url'); ?>">
	                        <div class="block-wrapper">
	
	                            <div class="block" style="background-image: url(<?php the_sub_field('blocks_block_background_image'); ?>);">
	
	                                <div class="block-outline--top"></div>
	                                <div class="block-outline--bottom"></div>
	
	                                <div class="block-overlay"></div>
	
	                                <div class="vertical-align block-content">
	                                    <div class="vertical-align--content">
	
	                                        <h3>
	                                            <?php the_sub_field('blocks_block_title'); ?>
	                                        </h3>
	                                        <p class="description"><?php the_sub_field('blocks_block_description'); ?></p>
	
	                                    </div>
	                                </div>
	
	                            </div>
	
	                        </div>
						</a>

                    <?php endwhile; ?>
                <?php else : endif; ?>

            </div>

        <?php endwhile; ?>

    <?php else : endif; ?>
	
	<div class="clear"></div>

</section>
