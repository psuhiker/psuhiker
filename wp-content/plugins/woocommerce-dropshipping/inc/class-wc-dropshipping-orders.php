<?php
class WC_Dropshipping_Orders {
	public function __construct() {
		$this->init();
	}

	public function init() {
		// order processing
		add_filter('wc_dropship_manager_send_order_email_html',array($this,'send_order_email_html'));
		add_filter('wc_dropship_manager_send_order_attachments',array($this,'send_order_attach_packingslip'),10,3);
		add_action('woocommerce_order_actions',array( $this,'add_order_meta_box_order_processing'));
		add_action('woocommerce_order_status_processing',array($this,'order_processing'));
		add_action('woocommerce_order_action_resend_dropship_supplier_notifications',array($this,'order_processing'));
		add_action('wc_dropship_manager_send_order',array($this,'send_order'),10, 2);
	}

	public function add_order_meta_box_order_processing( $actions ) {
		$actions['resend_dropship_supplier_notifications'] = 'Resend Dropship Supplier Notifications';
		return $actions;
	}

	/* Notify Suppliers */
	// perform all tasks that happen once an order is set to processing
	public function order_processing( $order_id ) {
		$order = new WC_Order( $order_id ); // load the order from woocommerce
		$this->notify_warehouse($order); // notify the warehouse to ship the order
	}

	// parse the order, build pdfs, and send orders to the correct suppliers
	public function notify_warehouse( $order ) {
		$order_info = $this->get_order_info($order);
		$supplier_codes = $order_info['suppliers'];
		// for each supplier code, loop and send email with product info
		foreach($supplier_codes as $code => $supplier_info) {
			do_action('wc_dropship_manager_send_order',$order_info,$supplier_info);
		}
	}

	public function get_order_shipping_info($order) {
		$keys = explode(',','shipping_first_name,shipping_last_name,shipping_address_1,shipping_address_2,shipping_city,shipping_state,shipping_postcode,shipping_country,billing_phone,shipping_company');
		$info =  array();
                $info['name'] = $order->shipping_first_name.' '.$order->shipping_last_name;
                $info['phone'] = $this->formatPhone($order->billing_phone);
		$info['shipping_method'] = $order->get_shipping_method();
		foreach($keys as $key) {
			$info[$key] = $order->$key;
		}
		return $info;
	}

	public function get_order_billing_info($order) {
		$keys = explode(',','billing_first_name,billing_last_name,billing_address_1,billing_address_2,billing_city,billing_state,billing_postcode,billing_country,billing_phone,billing_email,billing_company');
		$info =  array();
                $info['name'] = $order->billing_first_name.' '.$order->billing_last_name;
                $info['phone'] = $this->formatPhone($order->billing_phone);
		foreach($keys as $key) {
			$info[$key] = $order->$key;
		}
		return $info;
	}

	public function get_order_product_info($item,$product) {
		$info = array();
		$info['sku'] = $product->get_sku();
                $info['qty'] = $item['qty'];
		$info['name'] = $item['name'];
		$product_attributes = maybe_unserialize( get_post_meta( $product->id, '_product_attributes', true ) );
		$info['product_attribute_keys'] = array();
		if(is_array($product_attributes)) {
			$info['product_attribute_keys'] = array_keys($product_attributes);
			foreach($product_attributes as $key=>$data) {
				$info[$key] = $data['value'];
			}
		}


		// Product Variations
		$info['variation_data'] = [];
		if($product->variation_id)
		{
			$info['variation_data'] = $product->get_variation_attributes();
		}
		// Product Add-Ons Plugin
		//$info['order_item_meta'] = [];
		$info['order_item_meta'] = $item->get_formatted_meta_data();
      if(function_exists('get_product_addons'))
                {
			//$info['order_item_meta'] = $item->get_formatted_meta_data();
			$info['product_addons'] = get_product_addons($product);
			/*for($i=0;$i<count($info['product_addons']);$i++)
			{
				$addon = $info['product_addons'][$i];
				$addon['key'] = $this->get_addon_key_string($addon);
				$info['product_addons'][$i] = $addon;
			}*/
			foreach($info['order_item_meta'] as $key=>$item_meta)
                        {
				$info['order_item_meta'][$key]->display_label = $this->get_addon_display_label($info['order_item_meta'][$key]);
			}
		}
		//$info['shipping_methods'] = $order->get_shipping_methods();
		//$info['meta_html'] = wc_display_item_meta($item);
		//$info['item'] = $item;
		//$info['product'] = $product;
		return $info;
	}

	private function get_addon_display_label($item_meta)
	{
		$d = $item_meta->display_key;
		// remove the price from the meta display name
		return trim(preg_replace('/\(\$\d.*\)/','',$d));
	}

	/*private function get_addon_key_string($addon)
	{
		$key = $addon['name'];
                if ( $addon['price'] > 0 && apply_filters( 'woocommerce_addons_add_price_to_name', true ) ) {
                	$key .= ' (' . strip_tags( wc_price( get_product_addon_price_for_display( $addon['price'], $values['data'], true ) ) ) . ')';
                }
		return $key;
	}*/

	public function get_order_info($order) {
		// gather some of the basic order info
		$order_info = array();
		$order_info['id'] = $order->get_order_number();
		$order_info['number'] = $order->get_order_number();
		$order_info['options'] = get_option( 'wc_dropship_manager' );
		$order_info['shipping_info'] = $this->get_order_shipping_info($order);
		$order_info['billing_info'] = $this->get_order_billing_info($order);
		$order_info['order'] = $order;
		// for each item determine what products go to what suppliers.
		// Build product/supplier lists so we can send send out our order emails
		$order_info['suppliers'] = array();
		$items = $order->get_items();
		if ( count( $items ) > 0 ) {
			foreach( $items as $item_id => $item ) {
				$ds = wc_dropshipping_get_dropship_supplier_by_product_id( intval( $item['product_id'] ) );
				if ($ds['id'] > 0) {
					$product = $order->get_product_from_item( $item ); // get the product obj
					$prod_info = $this->get_order_product_info($item,$product);
					if(!array_key_exists($ds['slug'],$order_info['suppliers']))
					{
						$order_info['suppliers'][$ds['slug']] = $ds;  // ...add newly found dropship_supplier to the supplier array
						$order_info[$ds['slug']] = array(); // ... and create an empty array to store product info in
					}
					$order_info[$ds['slug']][] = $prod_info;
					//$order_info[$ds['slug'].'_raw'][] = $product;
				}
			}
		} else {
			// how did we get here?
			//$this->sendAlert('No Products found for order #'.$order_info['id'].'!');
			//die;
		}
		return $order_info;
	}

	public function formatPhone($pnum) {
		return preg_replace('~.*(\d{3})[^\d]*(\d{3})[^\d]*(\d{4}).*~', '($1) $2-$3', $pnum);
	}

	public function get_from_name() {
		return wp_specialchars_decode(get_option( 'woocommerce_email_from_name' ));
	}

	public function get_from_address() {
		return get_option( 'woocommerce_email_from_address' );
	}

	public function get_content_type() {
		return " text/html";
	}

	// for sending failure notifications
	public function sendAlert($text) {
		wp_mail( get_bloginfo('admin_email'), 'Alert from '.get_bloginfo('name'), $text );
	}

	public function make_directory( $path ) {
		$upload_dir = wp_upload_dir();
		$order_dir = $upload_dir['basedir'].'/'.$path;
		if( ! file_exists( $order_dir ) )
    			wp_mkdir_p( $order_dir );
		return $order_dir;
	}

	// generate packingslip PDF
	public function make_pdf($order_info,$supplier_info,$html,$file_name) {
		// Include TCPDF library
		if (!class_exists('TCPDF')) {
			require_once( wc_dropshipping_get_base_path() . '/lib/tcpdf_min/tcpdf.php' );
		}
		$options = get_option( 'wc_dropship_manager' );
		// make a directory for the current order (if it doesn't already exist)
		$pdf_path = $this->make_directory($order_info['id']);
		// generate a pdf for the current order and the current supplier
		$file = $pdf_path.'/'.$file_name;
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		// set default header data
		$pdf->SetHeaderData($options['packing_slip_url_to_logo'], $options['packing_slip_url_to_logo_width'], get_option( 'woocommerce_email_from_name' ).' '.date('Y-m-d'));
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		// remove default header/footer
		//$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);  // set default monospaced font
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);  // set margins
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM); // set auto page breaks
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  // set image scale factor
		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->Output($file, 'F'); // save PDF
		return $file;
	}

	// get HTML packingslip
	public function get_packingslip_html($order_info,$supplier_info) {
		$html = '';
		$filename = 'packingslip.html';
		if (file_exists(get_stylesheet_directory().'/woocommerce-dropshipping/'.$supplier_info['slug'].'_'.$filename))
		{
			/* 	User can create a custom supplier packingslip PDF by creating a "woocommerce-dropshipping" directory
				inside their theme's directory and placing a custom SUPPLIERCODE_packingslip.html there */
			$templatepath = get_stylesheet_directory().'/woocommerce-dropshipping/'.$supplier_info['slug'].'_'.$filename;
		}
		else if (file_exists(get_stylesheet_directory().'/wc_dropship_manager/'.$supplier_info['slug'].'_'.$filename))
		{
			/* 	User can create a custom supplier packingslip PDF by creating a "dropship_manager" directory
				inside their theme's directory and placing a custom SUPPLIERCODE_packingslip.html there */
			$templatepath = get_stylesheet_directory().'/wc_dropship_manager/'.$supplier_info['slug'].'_'.$filename;
		}
		else if (file_exists(get_stylesheet_directory().'/woocommerce-dropshipping/'.$filename))
		{
			/* 	User can override the default packingslip PDF by creating a "woocommerce-dropshipping" directory
				inside their theme's directory and placing a custom packingslip.html there */
			$templatepath = get_stylesheet_directory().'/woocommerce-dropshipping/'.$filename;
		}
		else if (file_exists(get_stylesheet_directory().'/wc_dropship_manager/'.$filename))
		{
			/* 	User can override the default packingslip PDF by creating a "dropship_manager" directory
				inside their theme's directory and placing a custom packingslip.html there */
			$templatepath = get_stylesheet_directory().'/wc_dropship_manager/'.$filename;
		}
		else
		{
			$templatepath = wc_dropshipping_get_base_path() . $filename;
		}
		return $this->get_template_html($templatepath,$order_info,$supplier_info);
	}

	public function get_template_html($templatepath,$order_info,$supplier_info) {
		$html = '';
		ob_start();
		if (file_exists($templatepath)){
			include($templatepath);
		} else {
			echo '<b>Template '.$templatepath.' not found!</b>';
		}
		$html = ob_get_clean();
		return $html;
	}

	// send the pdf to the supplier
	public function send_order($order_info,$supplier_info) {
		$attachments = array();
		$attachments = apply_filters('wc_dropship_manager_send_order_attachments',$attachments,$order_info,$supplier_info);  // create a pdf packing slip file
		$options = get_option( 'wc_dropship_manager' );
		$text = '';

		$hdrs = array();
		$hdrs['From'] = get_option( 'woocommerce_email_from_address' );
		$hdrs['To'] = $supplier_info['order_email_addresses'].','.get_option( 'woocommerce_email_from_address' );
		$hdrs['CC'] = get_option( 'woocommerce_email_from_address' );
		$hdrs['Subject'] = 'New Order #'.$order_info['id'].' From '.get_option( 'woocommerce_email_from_name' );
		$hdrs['Content-Type'] = 'multipart/mixed';
		if (strlen($supplier_info['account_number']) > 0)
		{
			$text .= get_option( 'woocommerce_email_from_name' ).' account number: '.$supplier_info['account_number'].'<br/>';
		}
		$text = $this->get_packingslip_html($order_info,$supplier_info);
		$text = $options['email_order_note'] . $text;
		$html = apply_filters('wc_dropship_manager_send_order_email_html',$text);

		 // Filters for the email
		add_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		add_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		add_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );
		wp_mail( $hdrs['To'], $hdrs['Subject'], $html, $hdrs, $attachments  );

		// Unhook filters
		remove_filter( 'wp_mail_from', array( $this, 'get_from_address' ) );
		remove_filter( 'wp_mail_from_name', array( $this, 'get_from_name' ) );
		remove_filter( 'wp_mail_content_type', array( $this, 'get_content_type' ) );
	}

	public function send_order_email_html( $text ) {
		return '<b>'.$text.'</b>';
	}

	public function send_order_attach_packingslip($attachments,$order_info,$supplier_info) {
		$html = $this->get_packingslip_html($order_info,$supplier_info);
		$file_name = $order_info['id'].'_'.$supplier_info['slug'].'.pdf';
		$attachments['pdf_packingslip'] = $this->make_pdf($order_info,$supplier_info,$html,$file_name);  // create a pdf packing slip file
		return $attachments;
	}
}
