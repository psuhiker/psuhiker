<?php
if ( ! function_exists( 'wc_dropshipping_get_dropship_supplier' ) ) {
	function wc_dropshipping_get_dropship_supplier ( $id = '' ) {
		$term = get_term( intval( $id ),'dropship_supplier' );
		$supplier = get_woocommerce_term_meta( intval( $id ), 'meta', true );

		if ( isset( $term->term_id ) ) {
			$supplier['id'] = $term->term_id;
			$supplier['slug'] = $term->slug;
			$supplier['name'] = $term->name;
			$supplier['description'] = $term->description;
		}
		return $supplier;
	}
}

if ( ! function_exists( 'wc_dropshipping_get_dropship_supplier_by_product_id' ) ) {
	function wc_dropshipping_get_dropship_supplier_by_product_id ( $product_id ) {
		$supplier = array();
		$terms = get_the_terms( intval( $product_id ), 'dropship_supplier' );
		if ( 0 < count( $terms ) ) {
			$supplier = wc_dropshipping_get_dropship_supplier( intval( $terms[0]->term_id ) ); // load the term. there can only be one supplier notified per product
		}
		return $supplier;
	}
}

if (! function_exists( 'wc_dropshipping_get_base_path' ) ) {
	function wc_dropshipping_get_base_path () {
		return plugin_dir_path( __FILE__ );
	}
}