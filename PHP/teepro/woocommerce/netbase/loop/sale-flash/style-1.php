<?php
global $post, $product;
echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale sale-style-1">' . esc_html__( 'Sale', 'teepro' ) . '</span>', $post, $product );