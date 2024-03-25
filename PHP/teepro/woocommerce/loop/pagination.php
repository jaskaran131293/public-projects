<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}

?>
<nav class="woocommerce-pagination <?php echo teepro_get_options('pagination_shop_style'); ?>"> 
	<?php
		if( is_product_category() || is_shop() || is_product_tag() ){ ?>
			<?php
			$array_number_page = array();
			for( $i=0; $i<=$total; $i++){
				array_push($array_number_page,$i);
			}
			foreach($array_number_page as $key=>$value){  // remove empty value
				if(is_null($value) || $value == ''){
				unset($array_number_page[$key]);
				}
			} ?>
			<?php if(!empty($array_number_page[6]) && $array_number_page[6] != null){ ?>
				<a class="pagination-icon pagination-first" data-element="1" style="display: none"><i class= 'icon-angle-double-left'></i></a>
				<a class="pagination-icon pagination-pre" data-element="0" style="display: none"><i class= 'icon-angle-left'></i></a>
			<?php }else if(!empty($array_number_page[2]) && $array_number_page[2] != null){ ?>
				<a class="pagination-icon pagination-pre" data-element="0" style="display: none"><i class= 'icon-angle-left'></i></a>
			<?php }; ?>
			<ul class="list-pagination" data-total-page = "<?php echo $total; ?>">
				<?php foreach($array_number_page as $v): ?>
					<li data-url="<?php echo admin_url('admin-ajax.php'); ?>" class="pagination-number <?php if($v == 1){ echo "page-selected";} ?>" <?php if($v > 5){echo "style='display:none'";} ?>><?php echo $v; ?></li>
				<?php endforeach; ?>
			</ul>
			<?php if(!empty($array_number_page[6]) && $array_number_page[6] != null){ ?>
				<a class="pagination-icon pagination-next" data-element="2" ><i class= 'icon-angle-right'></i></a>
				<a class="pagination-icon pagination-last" data-element="<?php echo count($array_number_page); ?>" style="display: none"><i class= 'icon-angle-double-right'></i></a>
			<?php }else if(!empty($array_number_page[2]) && $array_number_page[2] != null){ ?>
				<a class="pagination-icon pagination-next" data-element="2" ><i class= 'icon-angle-right'></i></a>
				<!-- <a class="pagination-icon pagination-last" data-element="<?php// echo count($array_number_page); ?>" style="display: none"><i class= 'icon-angle-double-right'></i></a> -->

			<?php }; ?>
		<?php }else{
				echo paginate_links( apply_filters( 'woocommerce_pagination_args', array( // WPCS: XSS ok.
					'base'         => $base,
					'format'       => $format,
					'add_args'     => false,
					'current'      => max( 1, $current ),
					'total'        => $total,
					'prev_text'    => '&larr;',
					'next_text'    => '&rarr;',
					'type'         => 'list',
					'end_size'     => 3,
					'mid_size'     => 3,
				) ) );
		}?>
		
</nav>
