<?php
/**
 * Single Product Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product;

if ( ! teepro_get_options( 'nbcore_pd_enable_review_rating' ) ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

if ( $rating_count > 0 ) : ?>

	<div class="woocommerce-product-rating">
		<?php echo wc_get_rating_html( $average, $rating_count ); ?>
		<?php if ( comments_open() ) : ?>
		<div class="wc-link-review">
			<a href="#reviews" class="woocommerce-review-link" rel="nofollow">
				<?php printf( _n( '%s Review', '%s Reviews', $review_count, 'teepro' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>
			</a>
			<span class="separated-line"> | </span>
			<a href="#reviews" class="woocommerce-review-link" rel="nofollow">
				<?php printf( esc_html__('Add Your Review', 'teepro'));?>
			</a>
		</div>
		<?php endif ?>
	</div>

<?php else: ?>
	<div class="woocommerce-product-rating">
		<?php
		$html  = '<div class="star-rating no-rating">';
		$html .= wc_get_star_rating_html( $average, $rating_count );
		$html .= '</div>';
		echo $html;
		?>

		<?php if ( comments_open() ) : ?>
		<div class="wc-link-review">
			<a href="#reviews" class="woocommerce-review-link" rel="nofollow">
				<?php printf( _n( '%s Review', '%s Reviews', $review_count, 'teepro' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>
			</a>
			<span class="separated-line"> | </span>
			<a href="#reviews" class="woocommerce-review-link" rel="nofollow">
				<?php printf( esc_html__('Add Your Review', 'teepro'));?>
			</a>
		</div>
		<?php endif ?>

	</div>
<?php endif; ?>