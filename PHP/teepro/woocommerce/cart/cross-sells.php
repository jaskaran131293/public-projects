<?php
/**
 * Cross-sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cross-sells.php.
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
 * @version     4.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$cross_sell_per_row = teepro_get_options('nbcore_cross_sells_per_row');
//$cross_sell_limit = teepro_get_options('nbcore_cross_sells_limit');

$test=array('products','no_carosel');
if(count($cross_sells) > $cross_sell_per_row){
    array_push($test,'swiper-container');
}

if ( $cross_sells ) : ?>

	<div class="cross-sells row-<?php echo esc_attr($cross_sell_per_row); ?>-products">

		<?php
			$heading = apply_filters('woocommerce_product_cross_sells_products_heading',__( 'You may be interested in&hellip;', 'teepro' ) );
			if($heading) :
		?>
			<h2><?php echo esc_html($heading); ?></h2>
		<?php endif; ?>

		<div class="<?php echo implode(" ",$test);?>">
            <div class="swiper-wrapper">
			<?php foreach ( $cross_sells as $cross_sell ) : ?>

				<?php
				 	$post_object = get_post( $cross_sell->get_id() );

					setup_postdata( $GLOBALS['post'] =& $post_object );

				?>

				<div <?php post_class('swiper-slide'); ?>>
					<?php wc_get_template('netbase/content-product/' . 'grid-type.php'); ?>
				</div>

			<?php endforeach; ?>
            </div>
		</div>

        <div class="swiper-pagination"></div>
	</div>

<?php endif;

wp_reset_postdata();
