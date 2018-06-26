<?php
class WC_Dropshipping_Admin {
	public $orders = null;
	public $product = null;
	public $csv = null;

	public function __construct() {
		require_once( 'class-wc-dropshipping-product.php' );
		require_once( 'class-wc-dropshipping-csv-import.php' );
		$this->product = new WC_Dropshipping_Product();
		$this->csv = new WC_Dropshipping_CSV_Import();

		// admin menu
		add_action('admin_enqueue_scripts', array( $this, 'admin_styles' ) );
		// admin dropship supplier
		add_action( 'create_term', array( $this, 'create_term' ), 5, 3 );
		add_action( 'delete_term', array( $this, 'delete_term' ), 5 );
		add_action( 'created_term', array( $this, 'save_category_fields' ), 10, 3 );
		add_action( 'edit_term', array( $this, 'save_category_fields' ), 10, 3 );
		add_action( 'dropship_supplier_add_form_fields', array( $this, 'add_category_fields' ) );
		add_action( 'dropship_supplier_edit_form_fields', array( $this, 'edit_category_fields' ), 10, 2 );
		add_action( 'wp_ajax_CSV_upload_form',array($this,'ajax_save_category_fields'));
		add_filter( 'manage_edit-dropship_supplier_columns', array($this, 'manage_columns'), 10, 1 );
		add_action( 'manage_dropship_supplier_custom_column', array($this, 'column_content'), 10 ,3);
		// woocommerce settings tab
		//add_filter( 'woocommerce_settings_tabs_array',array($this,'add_settings_tab'),50);
		//add_action( 'woocommerce_settings_tabs_dropship_manager', array($this,'dropship_manager_settings_tab') );
		//add_action( 'woocommerce_update_options_dropship_manager', array($this,'update_settings') );
		add_filter( 'woocommerce_get_sections_email',array($this,'add_settings_tab'),50);
		add_action( 'woocommerce_settings_email', array($this,'dropship_manager_settings_tab'),10,1);
		add_action( 'woocommerce_settings_save_email', array($this,'update_settings') );

	}

	public function admin_styles() {
		$base_name = explode('/',plugin_basename(__FILE__));
		wp_enqueue_script( 'wc_dropship_manager_scripts', plugins_url().'/'.$base_name[0].'/assets/js/wc_dropship_manager.js', array( 'jquery', 'jquery-blockui', 'jquery-ui-sortable', 'jquery-ui-widget', 'jquery-ui-core', 'jquery-tiptip' ));
		wp_enqueue_script( 'jquery-tiptip', plugins_url().'/woocommerce/assets/js/jquery-tiptip/jquery.tipTip.min.js', array( 'jquery' ), true );
		wp_enqueue_style( 'woocommerce_admin_styles', plugins_url().'/woocommerce/assets/css/admin.css', array() );
	}

	public function manage_columns($cols) {
		unset($cols['description']);
		unset($cols['slug']);
		unset($cols['posts']);
		//$cols['account_number'] = 'Account Number';
		$cols['order_email_addresses'] = 'Email Addresses';
		$cols['inventory'] = '';
		$cols['posts'] = 'Count';
		return $cols;
	}

	public function column_content($blank, $column_name, $term_id) {
		$ds = wc_dropshipping_get_dropship_supplier( intval( $term_id ) );
		switch($column_name)
		{
			case 'account_number':
				echo $ds['account_number'];
			break;
			case 'order_email_addresses':
				echo $ds['order_email_addresses'];
			break;
			case 'inventory':
				echo '<p><a title="Inventory Upload for '.$ds['name'].'" href="'.admin_url( 'admin-ajax.php' ).'?action=get_CSV_upload_form&width=600&height=350&term_id='.$term_id.'" class="thickbox button-primary csvwindow" term_id="'.$term_id.'" >Inventory CSV</a></p>';
			break;
		}
	}

	public function get_dropship_supplier_fields() {
		$meta = array(
			'account_number' => '',
			'order_email_addresses' => '',
			'csv_delimiter' => ',',
			'csv_column_indicator' => '',
			'csv_column_sku' => '',
			'csv_column_qty' => '',
			'csv_type' => '',
			'csv_quantity' => '',
			'csv_indicator_instock' => '',
		);
		return $meta;
	}

	public function add_category_fields() {
		$meta = $this->get_dropship_supplier_fields();
		$this->display_add_form_fields($meta);
	}

	public function edit_category_fields( $term, $taxonomy ) {
		$meta = get_woocommerce_term_meta( $term->term_id, 'meta',true );
		$this->display_edit_form_fields($meta);
	}

	public function display_add_form_fields($data) {
		add_thickbox();
		echo '<div class="form-field term-account_number-wrap">
				<label for="account_number" >Account #</label>
				<input type="text" size="40" name="account_number" value="'.$data['account_number'].'" />
				<p>Your store\'s account number with this dropshipper. Leave blank if you don\'t have an account number</p>
			</div>
			<div class="form-field term-order_email_addresses-wrap">
				<label for="order_email_addresses" >Email Addresses</label>
				<input type="text" size="40" name="order_email_addresses" value="'.$data['order_email_addresses'].'" required />
				<p>When a customer purchases product from you the dropshipper is sent an email notification. List the email addresses that should be notified when a new order is placed for this dropshipper.<p>
			</div>';

	}

	public function display_edit_form_fields($data) {
		$csv_types = array('quantity'=>'Quantity on Hand','indicator'=>'Indicator');
		echo	'<tr class="term-account_number-wrap">
						<th><label for="account_number" >Account #</label></th>
						<td><input type="text" size="40" name="account_number" value="'.$data['account_number'].'" />
						<p>Your store\'s account number with this dropshipper. Leave blank if you don\'t have an account number</p></td>
					</tr>
					<tr  class="term-order_email_addresses-wrap">
						<th><label for="order_email_addresses" >Email Addresses</label></th>
						<td><input type="text" size="40" name="order_email_addresses" value="'.$data['order_email_addresses'].'" required />
						<p>When a customer purchases product from you the dropshipper is sent an email notification. List the email addresses that should be notified when a new order is placed for this dropshipper.<p></td>
					</tr>
				</table>
				<h3>Supplier Inventory CSV Import Settings</h3>
				<p>(If you do not receive inventory statuses by CSV from this supplier then just leave these settings blank)</p>
				<table class="form-table">
					<tr  class="term-csv_delimiter-wrap">
						<th><label for="csv_delimiter" >CSV column delimiter</label></th>
						<td><input type="text" size="2" name="csv_delimiter" value="'.$data['csv_delimiter'].'" />
						<p>Please indicate what character is used to separate fields in the CSV. Normally this is a comma</p></td>
					</tr>
					<tr  class=" term-column_sku-wrap">
						<th><label for="csv_column_sku" >CSV sku column #</label></th>
						<td><input type="text" size="2" name="csv_column_sku" value="'.$data['csv_column_sku'].'" />
						<p>Please indicate which column in the CSV is the product SKU. This should be the manufacturers SKU. Dropship Manager Pro will append the SKU code for this suppler automatically when you upload</p></td>
					</tr>
					<tr  class=" term-csv_type-wrap">
						<th><label for="csv_type">CSV type</label></th>
						<td><select name="csv_type" id="csv_type" >';
								foreach($csv_types as $csv_type=>$description)
								{
									$selected = '';
									if ($data['csv_type'] === $csv_type) {$selected = 'selected';}
									echo '<option value="'.$csv_type.'" '.$selected.'>'.$description.'</option>';
								}
		echo			'</select>
						<p>Please indicate how the CSV data should be read. <Br />Quantity on hand - this means that the CSV contains a column showing the suppliers remaining stock</p></td>
					</tr>
					<tr  class="csv_quantity csv_types">
						<th><label for="csv_column_qty" >CSV quantity column #</label></th>
						<td><input type="text" size="2" name="csv_column_qty" value="'.$data['csv_column_qty'].'" />
						<p>If you are using a CSV to update in-stock status please indicate which column in the csv is the inventory quantity remaining</p></td>
					</tr>
					<tr  class="csv_indicator csv_types">
						<th><label for="csv_column_indicator" >CSV Indicator column #</label></th>
						<td><input type="text" size="2" name="csv_column_indicator" value="'.$data['csv_column_indicator'].'" />
						<p>If you are using a CSV to update in-stock status please indicate which column in the csv indicates the in-stock status</p></td>
					</tr>
					<tr  class="csv_indicator csv_types">
						<th><label for="csv_indicator_instock" >CSV Indicator In-stock value</label></th>
						<td><input type="text" size="2" name="csv_indicator_instock" value="'.$data['csv_indicator_instock'].'" />
						<p>If you are using a CSV to update in-stock status please indicate which column in the csv indicates the in-stock value</p></td>
					</tr>';
	}

	public function save_category_fields( $term_id, $tt_id, $taxonomy ) {
		// check for uploaded csv
		if(count($_FILES) > 0  && $_FILES['csv_file']['error'] == 0) {
			// we are saving an inventory form submit
			do_action('wc_dropship_manager_parse_csv');
		} else {
			// do update
			$meta = $this->get_dropship_supplier_fields();
			foreach ($meta as $key => $val) {
				if (isset($_POST[$key])) $meta[$key] = $_POST[$key];
			}
			update_woocommerce_term_meta( $term_id, 'meta', $meta );
		}
	}

	public function ajax_save_category_fields() {
		$this->save_category_fields( $_POST['term_id'], '', $_POST['taxonomy'] );
		if (defined('DOING_AJAX') && DOING_AJAX) {
			wp_die();
		}
	}

	/* Order term when created (put in position 0). */
	public function create_term( $term_id, $tt_id = '', $taxonomy = '' ) {
		if ( $taxonomy != 'product_cat' && ! taxonomy_is_product_attribute( $taxonomy ) )
			return;
		$meta_name = taxonomy_is_product_attribute( $taxonomy ) ? 'order_' . esc_attr( $taxonomy ) : 'order';
		update_woocommerce_term_meta( $term_id, $meta_name, 0 );
	}

	/* When a term is deleted, delete its meta. */
	public function delete_term( $term_id ) {
		$term_id = (int) $term_id;
		if ( ! $term_id )
				return;
		global $wpdb;
		$wpdb->query( "DELETE FROM {$wpdb->woocommerce_termmeta} WHERE `woocommerce_term_id` = " . $term_id );
	}

	/* Admin Settings Area */
	public function add_settings_tab( $settings_tabs ) {
		$settings_tabs['dropship_manager'] = __( 'Dropshipping Notifications', 'woocommerce-dropshipping' );
		return $settings_tabs;
	}

	public function dropship_manager_settings_tab() {
		global $current_section;
		if ($current_section == 'dropship_manager')
		{
			$this->display_settings();
		}
	}

	public function update_settings() {
		global $current_section;
		if ($current_section == 'dropship_manager') {
			$options = get_option( 'wc_dropship_manager' );
			foreach ($_POST as $key => $opt) {
				if ($key != 'submit') $options[$key] = $_POST[$key];
			}
			update_option( 'wc_dropship_manager', $options );
		}
	}

	public function display_settings() {
		// Tab to update options
		$options = get_option( 'wc_dropship_manager' );
		$woocommerce_url = plugins_url().'/woocommerce/';
		echo '<h3>Email Notifications</h3>
			<p>When an order switches to processing status, emails are sent to each supplier to notify them to ship the products. These options control the supplier email notification</p>
			<table>
				<tr>
					<td><label for="email_order_note">Email order note:</label></td>
					<td><img class="help_tip" data-tip="This note will appear on the email a supplier will receive with your order notification" src="'.$woocommerce_url.'assets/images/help.png" height="16" width="16"></td>
					<td><textarea name="email_order_note" cols="45" >'.$options['email_order_note'].'</textarea></td>
				</tr>
			</table>';
		echo '<h3>Packing slip</h3>
			<p>These options control the information on the generated packing slip that is sent to your supplier. <br />Talk to your supplier to make sure they print out and include this packing slip with each order so that your customer will see it</p>
			<table>
				<tr>
					<td><label for="packing_slip_url_to_logo" >Url to logo:</label></td>
					<td><img class="help_tip" data-tip="This logo will appear on the PDF packingslip" src="'.$woocommerce_url.'assets/images/help.png" height="16" width="16"></td>
					<td><input name="packing_slip_url_to_logo" value="'.$options['packing_slip_url_to_logo'].'" size="100" /></td>
				</tr>
				<tr>
					<td><label for="packing_slip_url_to_logo_width" >Logo Width:</label></td>
					<td><img class="help_tip" data-tip="Custom width of the logo in the PDF packingslip" src="'.$woocommerce_url.'assets/images/help.png" height="16" width="16"></td>
					<td><input name="packing_slip_url_to_logo_width" value="'.$options['packing_slip_url_to_logo_width'].'" size="5" /></td>
				</tr>
				<tr>
					<td><label for="packing_slip_company_name" >Company Name:</label></td>
					<td><img class="help_tip" data-tip="This address will appear on the PDF packingslip" src="'.$woocommerce_url.'assets/images/help.png" height="16" width="16"></td>
					<td><input name="packing_slip_company_name" value="'.$options['packing_slip_company_name'].'" size="100" /></td>
				</tr>
				<tr>
					<td><label for="packing_slip_address" >Address:</label></td>
					<td><img class="help_tip" data-tip="This address will appear on the PDF packingslip" src="'.$woocommerce_url.'assets/images/help.png" height="16" width="16"></td>
					<td><input name="packing_slip_address" value="'.$options['packing_slip_address'].'" size="100" /></td>
				</tr>
				<tr>
					<td><label for="packing_slip_customer_service_email" >Customer service email:</label></td>
					<td><img class="help_tip" data-tip="This email address will appear on the PDF packingslip" src="'.$woocommerce_url.'assets/images/help.png" height="16" width="16"></td>
					<td><input name="packing_slip_customer_service_email" value="'.$options['packing_slip_customer_service_email'].'" size="50" /></td>
				</tr>
				<tr>
					<td><label for="packing_slip_customer_service_phone">Customer service phone:</label></td>
					<td><img class="help_tip"  data-tip="This phone number will appear on the PDF packingslip" src="'.$woocommerce_url.'assets/images/help.png" height="16" width="16"></td>
					<td><input name="packing_slip_customer_service_phone" value="'.$options['packing_slip_customer_service_phone'].'" size="50" /></td>
				</tr><tr>
					<td ><label for="packing_slip_thankyou">Thank you mesage:</label></td>
					<td><img class="help_tip" data-tip="This message will appear on the PDF packingslip" src="'.$woocommerce_url.'assets/images/help.png" height="16" width="16"></td>
					<td><textarea name="packing_slip_thankyou" cols="45" >'.$options['packing_slip_thankyou'].'</textarea></td>
				</tr>
			</table>';
		echo '<h3>Inventory Stock Status Update</h3>
			<p>These options control how the importing of supplier inventory spreadsheets</p>
			<table>
				<tr>
					<td><label for="inventory_pad">Inventory pad:</label></td>
					<td><img class="help_tip" data-tip="If inventory stock falls below this number it will be considered out of stock. <br>Set to zero if you want to chance that your supplier will not have the item in stock by the time you submit your order." src="'.$woocommerce_url.'assets/images/help.png" height="16" width="16"></td>
					<td><input name="inventory_pad" value="'.$options['inventory_pad'].'" size="3" /></td>
				</tr>
				<!--<tr>
					<td valign="top"><label for="url_product_feed">Url to product feed:</label></td>
					<td><img class="help_tip" data-tip="After updating the in-stock/out of stock status this url will be called to regenerate your product feed. <br />(Just leave blank if you don\'t have a product feed)" src="'.$woocommerce_url.'assets/images/help.png" height="16" width="16"></td>
					<td>
						<input name="url_product_feed" value="'.$options['url_product_feed'].'" size="100" />
					</td>
				</tr>-->
			</table>';
	}
}
