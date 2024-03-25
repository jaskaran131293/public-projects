<?php
global $post, $product;
$columns           = apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
$full_size_image   = wp_get_attachment_image_src( $post_thumbnail_id, 'full' );
$thumbnail_post    = get_post( $post_thumbnail_id );
$image_title       = $thumbnail_post->post_content;
$placeholder       = has_post_thumbnail() ? 'with-images' : 'without-images';
$wrapper_classes   = apply_filters( 'woocommerce_single_product_image_gallery_classes', array(
'woocommerce-product-gallery',
'woocommerce-product-gallery--' . $placeholder,
'woocommerce-product-gallery--columns-' . absint( $columns ),
'images',
) );
$thumb_pos = teepro_get_options('nbcore_pd_thumb_pos');
$attachment_ids = $product->get_gallery_image_ids();

$ids = array();
$nb_class = '';
if ( $product->is_type( 'variable' ) ) {
    $variations = $product->get_available_variations();
    foreach($variations as $key=> $variation) {
        $ids[] = $variation['variation_id'];
    }
    
    foreach($ids as $id){
        if(!empty(get_post_meta($id, 'rtwpvg_images',true))){
            $nb_class = 'has-gallery';
        break;
        }
    }
}

?>




<div class="<?php echo esc_attr( implode( ' ', array_map( 'sanitize_html_class', $wrapper_classes ) ) ); ?>" data-columns="<?php echo esc_attr( $columns ); ?>" style="opacity: 0; transition: opacity .25s ease-in-out;">
    <figure class="woocommerce-product-gallery__wrapper <?php echo esc_attr($nb_class) ?>">
        <div class="featured-gallery swiper-container">
            <div class="swiper-wrapper">
                <?php
                $attributes = array(
                    'title'                   => $image_title,
                    'data-src'                => $full_size_image[0],
                    'data-large_image'        => $full_size_image[0],
                    'data-large_image_width'  => $full_size_image[1],
                    'data-large_image_height' => $full_size_image[2],
                );

                if ( has_post_thumbnail() ) {
                    $html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image swiper-slide">';
                    $html .= get_the_post_thumbnail( $post->ID, 'shop_single', $attributes );
                    $html .= '</div>';
                } else {
                    $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                    $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'teepro' ) );
                    $html .= '</div>';
                }

                echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );

                do_action( 'woocommerce_product_thumbnails' );

                if ( $attachment_ids && has_post_thumbnail() ) {
                    foreach ( $attachment_ids as $attachment_id ) {
                        $full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
                        $thumbnail        = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );
                        $thumbnail_post   = get_post( $attachment_id );
                        $image_title      = $thumbnail_post->post_content;

                        $attributes = array(
                            'title'                   => $image_title,
                            'data-src'                => $full_size_image[0],
                            'data-large_image'        => $full_size_image[0],
                            'data-large_image_width'  => $full_size_image[1],
                            'data-large_image_height' => $full_size_image[2],
                        );

                        $html  = '<div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image swiper-slide" data-index="">';
                        $html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
                        $html .= '</div>';

                        echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
                    }
                }
                ?>
            </div>
            <?php if ( count($attachment_ids) > 1 ) : ?>
                <div class="swiper-button-next swiper-button-black"></div>
                <div class="swiper-button-prev swiper-button-black"></div>
            <?php endif;?>
            </div>  
            <?php if($attachment_ids):?>
            <div class="thumb-gallery swiper-container"'>
                <div class="swiper-wrapper">
                    <?php
                    $attributes = array(
                        'title'                   => $image_title,
                        'data-src'                => $full_size_image[0],
                        'data-large_image'        => $full_size_image[0],
                        'data-large_image_width'  => $full_size_image[1],
                        'data-large_image_height' => $full_size_image[2],
                    );

                    if ( has_post_thumbnail() ) {
                        $html  = '<div data-thumb="' . get_the_post_thumbnail_url( $post->ID, 'medium' ) . '" class="woocommerce-product-gallery__image swiper-slide">';
                        $html .= get_the_post_thumbnail( $post->ID, 'medium', $attributes );
                        $html .= '</div>';
                    } else {
                        $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                        $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'teepro' ) );
                        $html .= '</div>';
                    }

                    echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, get_post_thumbnail_id( $post->ID ) );

                    do_action( 'woocommerce_product_thumbnails' );

                    $attachment_ids = $product->get_gallery_image_ids();

                    if ( $attachment_ids && has_post_thumbnail() ) {
                        foreach ( $attachment_ids as $attachment_id ) {
                            $full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
                            $thumbnail        = wp_get_attachment_image_src( $attachment_id, 'medium' );
                            $thumbnail_post   = get_post( $attachment_id );
                            $image_title      = isset($thumbnail_post->post_content) ? $thumbnail_post->post_content : '';

                            $attributes = array(
                                'title'                   => $image_title,
                                'data-src'                => $full_size_image[0],
                                'data-large_image'        => $full_size_image[0],
                                'data-large_image_width'  => $full_size_image[1],
                                'data-large_image_height' => $full_size_image[2],
                            );

                            $html  = '<div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image swiper-slide">';
                            $html .= wp_get_attachment_image( $attachment_id, 'medium', false, $attributes );
                            $html .= '</div>';

                            echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', $html, $attachment_id );
                        }
                    }
                    ?>
                </div>
            </div>
        <?php endif;?>
    </figure>
    <?php do_action( 'teepro_on_product_image' ); ?>
</div>