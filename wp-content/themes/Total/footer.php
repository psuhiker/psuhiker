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
        
                <h3>Sign up for special discounts and offers</h3>
        
                <form class="form">
        
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="email address">
                        <input type="submit" class="form-submit">
                        <div class="clear"></div>
                    </div>
        
                </form>
        
            </div>
        
        </section>
        
        <footer id="footer">
            <div class="container">
        
                <div class="logo">
                    <div class="content">
                        <img src="<?php bloginfo('template_directory'); ?>/images/logo-white.png">
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
        
                        <div class="clear"><br></div>
        
                        <h4>Connect with Us</h4>
        
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
                <p>The statements made regarding these products have not been evaluated by the Food & Drug Administration. The efficacy of these products has not been confirmed by FDA approved research. These products are not intended to diagnose, treat, cure, or prevent any disease. All information presented here is not meants as a substitute for or alternative to information from healthcare practitioners. Please consult your healthcare professional about potential interactions or other possible complications before using any product. The Federal Food, Drug and Cosmetic Act requires this notice.</p>
        
                <p><strong>Allergies</strong></p>
                <p>Please be aware that certain products may contain soy, nut, essintial oils and/or infused with herbs. Please check to make sure you are not allergic to any of the ingredients.</p>
        
                <p><strong>Storage Suggestion</strong></p>
                <p>We recommend keepign products containing CBD or essential oils away from heat and direct sunlight.</p>
        
            </div>
        </section>
        
        <?php // wpex_hook_wrap_bottom(); ?>

    </div><!-- #wrap -->

    <?php wpex_hook_wrap_after(); ?>

</div><!-- .outer-wrap -->

<?php wpex_outer_wrap_after(); ?>

<?php wp_footer(); ?>

</body>
</html>