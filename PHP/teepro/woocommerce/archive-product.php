<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
 * @version     3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
global $wp_query;
global $wpdb;
$paged = get_query_var('paged') != '0' ? get_query_var('paged') : 1;
get_header( 'shop' ); 
?>

	<?php  
		if(!empty($wp_query->query["orderby"])){
			$order_by = $wp_query->query["orderby"];
		}
		$style_pagination = teepro_get_options('pagination_shop_style');
		if(!empty($_REQUEST['pagination_style'])){
			$query_string = $_REQUEST['pagination_style'];
			if($query_string == "load_more" || $query_string == "infinite_scroll"){
				$style_pagination = $query_string;
			}
		}
		$prepared_query_min = "SELECT min(min_price) as min_prcie FROM {$wpdb->prefix}wc_product_meta_lookup WHERE stock_status='instock' ";
		$prepared_query_max = "SELECT max(max_price) as max_price FROM {$wpdb->prefix}wc_product_meta_lookup WHERE stock_status='instock' ";	
		
		$price_min = $wpdb->get_results( $prepared_query_min );
		$price_max = $wpdb->get_results( $prepared_query_max );
		$min_price = $price_min[0]->min_prcie;
		$max_price = $price_max[0]->max_price;
	?>

	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 */
		do_action( 'woocommerce_before_main_content' );
		
	?>

		<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );
		?>
		
		<?php if ( have_posts() ) :
			if(teepro_get_options('nbcore_shop_action')) :
			?>
				<?php
				/**
				 * woocommerce_before_shop_loop hook.
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );?>
				
				<div class = "chosen-all">
					<ul>
						<li class="clear-filter" style="display:none"></style><?php _e( 'Clear filters' ); ?></li>
					</ul>
					<ul class = "chosen-price">
						<li class = "min-price-shop" style = "display:none"><span><?php _e("Min ") ?></span><?php echo esc_attr($min_price) ?></li>
						<li class = "max-price-shop" style = "display:none"><span><?php _e("Max ") ?></span><?php echo esc_attr($max_price) ?></li>
					</ul>
					<ul class = "chosen-filter"></ul>
				</div>
			<?php endif; ?>
			
			<div class= "teepro-product-content-show loaded">
				<span class="icon-spin6"></span>
				<?php woocommerce_product_loop_start(); ?>


					<?php woocommerce_product_subcategories(); ?>

					<?php while ( have_posts() ) : the_post(); ?>

						<?php wc_get_template_part( 'content', 'product' );
							
						?>
					<?php endwhile; // end of the loop. ?>
				<?php woocommerce_product_loop_end(); ?>
				<?php if($style_pagination == "pagination-style-1" || $style_pagination == "pagination-style-2") :
				/**
				* Hook: woocommerce_after_shop_loop.
				*
				* @hooked woocommerce_pagination - 10
				*/
				do_action( 'woocommerce_after_shop_loop' ); 
				endif; 
				
				?>
			
			</div>


		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>
		
		<?php if (  $wp_query->max_num_pages > 1 && $style_pagination == "load_more" ):?>
			<div class="text-center">
				<a class=" teepro-load-more" data-total-page="<?php echo esc_attr($wp_query->max_num_pages) ?>" data-order-by="<?php echo esc_attr($order_by) ?>" data-url="<?php echo admin_url('admin-ajax.php'); ?>"><?php _e( 'LOAD MORE PRODUCTS' ); ?>
					<span class="icon-spin6"></span>
				</a>
			</div>
		<?php endif;?>

		<?php if (  $wp_query->max_num_pages > 1 && $style_pagination == "infinite_scroll" ):?>
			<div class="text-center">
				<a class=" teepro-load-more-scroll" data-total-page="<?php echo esc_attr($wp_query->max_num_pages) ?>" data-order-by="<?php echo esc_attr($order_by) ?>" data-url="<?php echo admin_url('admin-ajax.php'); ?>">
					<span class="icon-spin6"></span>
				</a>
			</div>
		<?php endif; ?>
		

	<?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
	

	
<?php
$nbcore_page_image_banner_bottom = teepro_get_options('nbcore_pages_image_banner_bottom');
$nbcore_page_text_banner_bottom = teepro_get_options('nbcore_page_text_banner_bottom');
 if($nbcore_page_image_banner_bottom){ 
	$feat_image_url = wp_get_attachment_image_src( $nbcore_page_image_banner_bottom,'full' );?>
		<div class="image_banner_pages" >
			<div class="container" style ="background-image: url(<?php echo $feat_image_url[0]; ?>);">
				<?php if($nbcore_page_text_banner_bottom) { ?>
					<div class="text_banner_bottom_section">
						<?php echo $nbcore_page_text_banner_bottom;  ?>
					</div>
				<?php }?>
			</div>
		</div
<?php } ?>

<?php get_footer( 'shop' );?>
