<?php
/**
 * Creates the admin panel and custom CSS output
 *
 * @package Total WordPress Theme
 * @subpackage Framework
 * @version 4.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'WPEX_Custom_CSS_Panel' ) ) {

	class WPEX_Custom_CSS_Panel {

		/**
		 * Start things up
		 *
		 * @since 1.6.0
		 */
		public function __construct() {
			add_action( 'admin_menu', array( 'WPEX_Custom_CSS_Panel', 'add_page' ), 20 );
			add_action( 'admin_bar_menu', array( 'WPEX_Custom_CSS_Panel', 'adminbar_menu' ), 999 );
			add_action( 'admin_init', array( 'WPEX_Custom_CSS_Panel','register_settings' ) );
			add_action( 'admin_enqueue_scripts', array( 'WPEX_Custom_CSS_Panel','scripts' ) );
			add_action( 'admin_notices', array( 'WPEX_Custom_CSS_Panel', 'notices' ) );
		}

		/**
		 * Add sub menu page for the custom CSS input
		 *
		 * @since 1.6.0
		 */
		public static function add_page() {
			add_submenu_page(
				WPEX_THEME_PANEL_SLUG,
				__( 'Custom CSS', 'total' ),
				__( 'Custom CSS', 'total' ),
				'administrator',
				WPEX_THEME_PANEL_SLUG .'-custom-css',
				array( 'WPEX_Custom_CSS_Panel', 'create_admin_page' )
			);
		}

		/**
		 * Add custom CSS to the adminbar since it will be used frequently
		 *
		 * @since 1.6.0
		 */
		public static function adminbar_menu( $wp_admin_bar ) {
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}
			$url  = admin_url( 'admin.php?page='. WPEX_THEME_PANEL_SLUG .'-custom-css' );
			$args = array(
				'id'    => 'wpex_custom_css',
				'title' => esc_html__( 'Custom CSS', 'total' ),
				'href'  => $url,
				'meta'  => array(
				'class' => 'wpex-custom-css',
				)
			);
			$wp_admin_bar->add_node( $args );
		}

		/**
		 * Load scripts
		 *
		 * @since 1.6.0
		 */
		public static function scripts( $hook ) {

			// Only load script when needed
			if ( WPEX_ADMIN_PANEL_HOOK_PREFIX . '-custom-css' != $hook ) {
				return;
			}

			// Remove any currently registered ace editor scripts
			wp_deregister_script( 'ace-editor' );

			// Enqueue ace editor script
			wp_enqueue_script(
				'wpex-ace-editor',
				wpex_asset_url( 'lib/ace-editor/ace.js' ),
				array( 'jquery' ),
				true
			);

		}

		/**
		 * Register a setting and its sanitization callback.
		 *
		 * @since 1.6.0
		 */
		public static function register_settings() {
			register_setting( 'wpex_custom_css', 'wpex_custom_css', array( 'WPEX_Custom_CSS_Panel', 'sanitize' ) );
		}

		/**
		 * Displays all messages registered to 'wpex-custom_css-notices'
		 *
		 * @since 1.6.0
		 */
		public static function notices() {
			settings_errors( 'wpex_custom_css_notices' );
		}

		/**
		 * Sanitization callback
		 *
		 * @since 1.6.0
		 */
		public static function sanitize( $option ) {

			// Sanitize and save theme mod
			if ( ! empty( $option ) ) {

				if ( function_exists( 'wp_get_custom_css' ) ) {
					
					wp_update_custom_css_post( $option );

				} else {

					set_theme_mod( 'custom_css', wp_strip_all_tags( $option ) );

				}

			} else {

				if ( function_exists( 'wp_get_custom_css' ) ) {

					wp_update_custom_css_post( '' );

				} else {

					remove_theme_mod( 'custom_css' );

				}

			}

			// Return notice
			add_settings_error(
				'wpex_custom_css_notices',
				esc_attr( 'settings_updated' ),
				__( 'Settings saved.', 'total' ),
				'updated'
			);

			// Lets save the custom CSS into a standard option as well for backup
			return $option;
		}

		/**
		 * Settings page output
		 *
		 * @since 1.6.0
		 */
		public static function create_admin_page() { ?>

			<div class="wrap">

				<h2><?php esc_html_e( 'Custom CSS', 'total' ); ?></h2>
				<p><?php esc_html_e( 'Click command/control + shift to display searchform while working in the editor. You can also go to Appearance > Customize > Additional CSS to make changes and see them live.', 'total' ); ?></p>

				<?php
				// Get custom CSS
				if ( function_exists( 'wp_get_custom_css' ) && ! wpex_get_mod( 'custom_css', null ) ) {
					$custom_css = wp_get_custom_css();
				} else {
					$custom_css = wpex_get_mod( 'custom_css', null );
				} ?>

				<div>
					<form method="post" action="options.php">
						<?php settings_fields( 'wpex_custom_css' ); ?>
						<table class="form-table">
							<tr valign="top">
								<td style="padding:0;">
									<textarea rows="40" cols="50" id="wpex_custom_css" style="display:none;" name="wpex_custom_css"><?php echo wp_strip_all_tags( $custom_css ); ?></textarea>
									<pre id="wpex_custom_css_editor" style="width:100%;height:800px;font-size:14px; border: 1px solid #bababa;"><?php echo wp_strip_all_tags( $custom_css ); ?></pre>
								</td>
							</tr>
						</table>
						<?php submit_button(); ?>
					</form>
				</div>

			</div><!-- .wrap -->

			<script>
				( function( $ ) {
					"use strict";
					jQuery( document ).ready( function( $ ) {

						// Start ace editor
						var $css_editor       = $( '#wpex_custom_css_editor' ),
							$css_editor_input = $( '#wpex_custom_css' ),
							$editor           = ace.edit( 'wpex_custom_css_editor' );

						$editor.getSession().setUseWorker(false);
						$editor.getSession().setMode( 'ace/mode/css' );
						$editor.setTheme( 'ace/theme/chrome' );

						$editor.find('needle',{
							backwards: false,
							wrap: false,
							caseSensitive: false,
							wholeWord: false,
							regExp: false
						} );

						$editor.findNext();
						$editor.findPrevious();

						// Add val to hidden field
						$editor.on('input', function() {
							$css_editor_input.val( $editor.getValue() );
						} );

					} );
				} ) ( jQuery );
			</script>

		<?php }

	}

}
new WPEX_Custom_CSS_Panel();