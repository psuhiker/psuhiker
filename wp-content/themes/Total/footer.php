<?php
/**
 * The template for displaying the footer.
 *
 * @package Total WordPress Theme
 * @subpackage Templates
 * @version 4.0
 */ ?>

            <?php wpex_hook_main_bottom(); ?>

        </main><!-- #main-content -->
                
        <?php wpex_hook_main_after(); ?>
        
        <section class="subscribe">
        
            <div class="container">
				
				<div class="social">
					
					<h3>Connect with Us</h3>
					
					<ul class="social">
					    <li>
					        <a href="http://www.twitter.com/cbd_connection" target="_blank">
					            <img src="<?php bloginfo('template_directory'); ?>/images/social-icon-twitter-blue.png">
					        </a>
					    </li>
					    <li>
					        <a href="http://www.facebook.com/cbdconnectionresource" target="_blank">
					            <img src="<?php bloginfo('template_directory'); ?>/images/social-icon-facebook-blue.png">
					        </a>
					    </li>
					    <li>
					        <a href="http://www.instagram.com/cbdconnection" target="_blank">
					            <img src="<?php bloginfo('template_directory'); ?>/images/social-icon-instagram-blue.png">
					        </a>
					    </li>
					</ul>
					
				</div>
				
				<div class="email">
        
	                <h3>Sign up for special discounts and offers</h3>
	        
	                <form action="https://bioluxe.us17.list-manage.com/subscribe/post?u=573907f4515bac5749dc6956d&amp;id=6dd691ce7b" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate form" target="_blank" novalidate>
	        
	                    <div class="form-group">
							<input type="email" value="" name="EMAIL" class="form-control required email" id="mce-EMAIL"placeholder="email address">
							<div id="mce-responses" class="clear" style="display: none;">
								<div class="response" id="mce-error-response" style="display:none"></div>
								<div class="response" id="mce-success-response" style="display:none"></div>
							</div>
							<div style="display:  none;" aria-hidden="true"><input type="text" name="b_573907f4515bac5749dc6956d_6dd691ce7b" tabindex="-1" value=""></div>
							<input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe" class="button form-submit">
	                        <div class="clear"></div>
	                    </div>
	        
	                </form>
				
				</div>
				
				<div class="clear"></div>
        
            </div>
        
        </section>
        
        <footer id="footer">
            <div class="container">
        
                <div class="logo">
                    <div class="content">
                        <img src="<?php bloginfo('template_directory'); ?>/images/logo-white.png">
						<div class="clear"><br></div>
						
						                <ul class="social">
						                    <li>
						                        <a href="http://www.twitter.com/cbd_connection" target="_blank">
						                            <img src="<?php bloginfo('template_directory'); ?>/images/social-icon-twitter.png">
						                        </a>
						                    </li>
						                    <li>
						                        <a href="http://www.facebook.com/cbdconnectionresource" target="_blank">
						                            <img src="<?php bloginfo('template_directory'); ?>/images/social-icon-facebook.png">
						                        </a>
						                    </li>
						                    <li>
						                        <a href="http://www.instagram.com/cbdconnection" target="_blank">
						                            <img src="<?php bloginfo('template_directory'); ?>/images/social-icon-instagram.png">
						                        </a>
						                    </li>
						                </ul>
                    </div>
                </div>
        
                <div class="contact">
                    <div class="content">
        
                        <h4>Contact Us</h4>
                        <p class="small">Can't find what you're looking for? Contact us and we'll try to find it for you!</p>
                        <p class="no-margin link">
                            <a href="mailto:info@cbdconnection.net">
                                info@cbdconnection.net
                            </a>
                        </p>
                        <!--<p class="link">
                            <a href="#">
                                Help & Support
                            </a>
                        </p>-->
        
                    </div>
                </div>
        
                <div class="links">
                    <div class="content">
        
                        <?php 
                        	wp_nav_menu( 
                        		array( 
                        			'theme_location' => 'footer_menu' 
                        		) 
                        	); 
                        ?>
        
                        <p class="copyright">Copyright &copy; <?php echo date('Y'); ?>  Bioluxe LLC | All Rights Reserved</p>
        
                    </div>
                </div>
        
                <div class="clear"></div>
        
            </div>
        </footer>
        
        <section id="disclaimer">
            <div class="container">
        
                <p><strong>FDA Disclosure</strong></p>
                <p>The statements made regarding these products have not been evaluated by the Food & Drug Administration. The efficacy of these products has not been confirmed by FDA approved research. These products are not intended to diagnose, treat, cure, or prevent any disease. All information presented here is not meant as a substitute for or alternative to information from healthcare practitioners. Please consult your healthcare professional about potential interactions or other possible complications before using any product. The Federal Food, Drug and Cosmetic Act requires this notice.</p>
        
                <p><strong>Allergies</strong></p>
                <p>Please be aware that certain products may contain soy, nuts, essential oils and/or infused with herbs. Please check to make sure you are not allergic to any of the ingredients.</p>
        
                <p><strong>Storage Suggestion</strong></p>
                <p>We recommend keeping products containing CBD or essential oils away from heat and direct sunlight.</p>
        
            </div>
        </section>
        
        <?php // wpex_hook_wrap_bottom(); ?>

    </div><!-- #wrap -->

    <?php wpex_hook_wrap_after(); ?>

</div><!-- .outer-wrap -->

<?php wpex_outer_wrap_after(); ?>

<?php wp_footer(); ?>

<!-- Mobile Primary Menu -->
<script>
	$(".mobileToggle").on("click", function() {
	    $("body").toggleClass("active");
	});
	$(".toggleSearch").on("click", function() {
	    $("#search-wrapper").toggleClass("active");
	});
</script>

<!-- Equal Height Divs -->
<script>
	$(document).ready(function () {
	
	    "use strict";
	    $('.featured-products').each(function () {
	        var highestBox = 0;
	
	        $(this).find('.product-inner').each(function () {
	            if ($(this).height() > highestBox) {
	                highestBox = $(this).height();
	            }
	        });
	
	        $(this).find('.product-inner').height(highestBox);
			
	    });
		
		$('.featured-products').each(function () {
		        var highestBox = 0;
		
		    $(this).find('.woocommerce-loop-product__title').each(function () {
		        if ($(this).height() > highestBox) {
		            highestBox = $(this).height();
		        }
		    });
		
		    $(this).find('.woocommerce-loop-product__title').height(highestBox);
		});
		
		
		
	});
	
	$(window).resize(function() {
		
		$('.woocommerce-loop-product__title').css('height','inherit');
		
		$('.featured-products').each(function () {
	        var highestBox = 0;
	
	        $(this).find('.woocommerce-loop-product__title').each(function () {
	            if ($(this).height() > highestBox) {
	                highestBox = $(this).height();
	            }
	        });
	
	        $(this).find('.woocommerce-loop-product__title').height(highestBox);
	        
	    });
		
	});
	
	$(window).resize(function() {
		
		$('.product-inner').css('height','inherit');
		
		$('.featured-products').each(function () {
	        var highestBox = 0;
	
	        $(this).find('.product-inner').each(function () {
	            if ($(this).height() > highestBox) {
	                highestBox = $(this).height();
	            }
	        });
	
	        $(this).find('.product-inner').height(highestBox);
	        
	    });
		
	});
	
	
</script>

<script>
	$('.product-inner .button').each(function() {
	    var text = $(this).text();
	    $(this).text(text.replace('Add to cart', 'Shop')); 
	    var text = $(this).text();
	    $(this).text(text.replace('Select options', 'Shop')); 
	});
</script>

</body>
</html>