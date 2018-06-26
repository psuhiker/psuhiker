<?php
class WC_Dropshipping_Product {
	public function __construct() {
		// admin for product edit
		add_action( 'add_meta_boxes', array($this,'dropship_supplier_meta_box'));
	}

	public function dropship_supplier_meta_box() {
		 add_meta_box( 'dropship_supplier', 'Drop Ship Supplier',array($this,'dropship_supplier_metabox'),'product' ,'side','core');
	}

	public function dropship_supplier_metabox( $post ) {
		//Get taxonomy and terms
		$taxonomy = 'dropship_supplier';
		//Set up the taxonomy object and get terms
		$tax = get_taxonomy($taxonomy);
		$terms = get_terms($taxonomy,array('hide_empty' => false));
		//Name of the form
		$name = 'tax_input[' . $taxonomy . ']';
		//Get current and popular terms
		//$popular = get_terms( $taxonomy, array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 10, 'hierarchical' => false ) );
		$postterms = get_the_terms( $post->ID,$taxonomy );
		$current = ($postterms ? array_pop($postterms) : false);
		$current = ($current ? $current->term_id : 0);
		echo '<div id="taxonomy-'.$taxonomy.'" class="categorydiv">
			<!-- Display tabs-->
			<ul id="'.$taxonomy.'-tabs" class="category-tabs">
				<li class="tabs"><a href="#'.$taxonomy.'-all" tabindex="3">Select a Drop Ship Supplier</a></li>
			</ul>
			<!-- Display taxonomy terms -->
			<div id="'.$taxonomy.'-all" class="tabs-panel">
			<select id="" name="tax_input[dropship_supplier]" class="form-no-clear">
				<option value=""></option>';
				foreach($terms as $term)
				{
					$selected = '';
					if($current == $term->term_id) {$selected='selected="selected"';}
					$id = $taxonomy.'-'.$term->term_id;
					echo '<option '.$selected.' value="'.$term->slug.'" />'.$term->name.'</option>';
				}
		echo "</select>
			   </ul>
			</div>
		</div>";
	}
}