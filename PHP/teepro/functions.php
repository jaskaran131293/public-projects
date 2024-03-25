<?php

/**
 * Netbaseteam core
 */
require get_template_directory() . '/netbase-core/core.php';

if ( ! function_exists( 'pt_woocommerce_template_loop_variation' ) ) {
    function pt_woocommerce_template_loop_variation($args = array()) {
      global $product;
  
      if ( $product ) {
          $defaults = array(
            'quantity' => 1,
            'class'    => implode( ' ', array_filter( array(
              'button',
              'product_type_' . $product->get_type(),
              $product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
              $product->supports( 'ajax_add_to_cart' ) ? 'ajax_add_to_cart' : ''
            ) ) )
          );
  
          $args = apply_filters( 'woocommerce_loop_add_to_cart_args', wp_parse_args( $args, $defaults ), $product );
  
          if ($product->get_type() == "variable" ) {
            //woocommerce_variable_add_to_cart();
                      wp_enqueue_script( 'wc-add-to-cart-variation' );
  
                      // Get Available variations?
                      $get_variations = count( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
  
                      // Load the template.
                      wc_get_template( 'woocommerce/netbase/loop/loop_variable.php', array(
                          'available_variations' => $get_variations ? $product->get_available_variations() : false,
                          'attributes'           => $product->get_variation_attributes(),
                          'selected_attributes'  => $product->get_default_attributes(),
                      ) );
          }
          /*else {
            wc_get_template( 'loop/add-to-cart.php', $args );
          }*/
  
      }
    }
  }

  add_filter('filter_metabox','custom_field_img_banner');
  function custom_field_img_banner($array){
    $array[] = array(
        'name' => __('Show Banner Bottom', 'teepro'),
        'desc' => __('Check this show banner', 'teepro'),
        'id' => 'teepro_show_banner',
        'type' => 'checkbox',
        'default' => '',
        'tab' => 'layout'
    );
    return $array;
  }



  if ( ! function_exists('write_log')) {
    function write_log ( $log )  {
       if ( is_array( $log ) || is_object( $log ) ) {
          error_log( print_r( $log, true ) );
       } else {
          error_log( $log );
       }
    }
 }
 add_action('woocommerce_before_shop_loop_item_title','nb_hover_img');
 function nb_hover_img(){
  global $product;
  if(!$product->is_type('variable')){return;}

  $product_id = $product->get_id();
  $product = new WC_Product_Variable( $product_id );
  $variations = $product->get_available_variations();
  ?>
  <div class="hover-image" style="display: none;">
    <?php
  foreach($variations as $variation):
    ?>
  <img data-color="<?php echo esc_attr($variation['attributes']['attribute_pa_color']) ?>" src="<?php echo esc_attr($variation['image']['thumb_src']) ?>" srcset="<?php echo esc_attr($variation['image']['thumb_src']) ?>" alt="">
  <?php
  endforeach; ?>
  </div>
  <?php

  }

  add_action('woocommerce_before_shop_loop_item_title','nb_product_thumbs');
  function nb_product_thumbs(){
    global $product;
    $nbcore_enable_hover_change_image 	= teepro_get_options('nbcore_enable_hover_change_image');
    if(!$nbcore_enable_hover_change_image){return;}

    $attachment_ids = $product->get_gallery_image_ids();
      foreach( array_slice( $attachment_ids, 0,1 ) as $attachment_id ) {
      $thumbnail_url = wp_get_attachment_image_src( $attachment_id, 'thumbnail' )[0];
      $thumbnail_srcset = wp_get_attachment_image_srcset( $attachment_id, 'thumbnail' );
      echo '<img class="product-thumbs" src="' . $thumbnail_url . '" srcset="' . $thumbnail_srcset . '">';
    }
  }


// v-360

  
  if( ! function_exists( 'teepro_product_360_view_meta' ) ) {
    function teepro_product_360_view_meta() {
      add_meta_box( 'woocommerce-product-360-images', __( 'Product 360 View Gallery (optional)', 'woocommerce' ), 'teepro_360_metabox_output', 'product', 'side', 'low' );
    }
    add_action( 'add_meta_boxes', 'teepro_product_360_view_meta', 50 );
  }
  if( ! function_exists( 'teepro_360_metabox_output' ) ) {
    function teepro_360_metabox_output( $post ) {
      ?>
      <div id="product_360_images_container">
        <ul class="product_360_images">
          <?php
            $product_360_image_gallery = array();
  
            if ( metadata_exists( 'post', $post->ID, '_product_360_image_gallery' ) ) {
              $product_360_image_gallery = get_post_meta( $post->ID, '_product_360_image_gallery', true );
            } else {
              // Backwards compat
              $attachment_ids = get_posts( 'post_parent=' . $post->ID . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids&meta_key=_woocommerce_360_image&meta_value=1' );
              $attachment_ids = array_diff( $attachment_ids, array( get_post_thumbnail_id() ) );
              $product_360_image_gallery = implode( ',', $attachment_ids );
            }
  
            $attachments         = array_filter( explode( ',', $product_360_image_gallery ) );
            $update_meta         = false;
            $updated_gallery_ids = array();
  
            if ( ! empty( $attachments ) ) {
              foreach ( $attachments as $attachment_id ) {
                $attachment = wp_get_attachment_image( $attachment_id, 'thumbnail' );
  
                // if attachment is empty skip
                if ( empty( $attachment ) ) {
                  $update_meta = true;
                  continue;
                }
  
                echo '<li class="image" data-attachment_id="' . esc_attr( $attachment_id ) . '">
                  ' . $attachment . '
                  <ul class="actions">
                    <li><a href="#" class="delete tips" data-tip="' . esc_html__( 'Delete image', 'teepro' ) . '"><i class="fa fa-times"></i></a></li>
                  </ul>
                </li>';
  
                // rebuild ids to be saved
                $updated_gallery_ids[] = $attachment_id;
              }
  
              // need to update product meta to set new gallery ids
              if ( $update_meta ) {
                update_post_meta( $post->ID, '_product_360_image_gallery', implode( ',', $updated_gallery_ids ) );
              }
            }
          ?>
        </ul>
  
        <input type="hidden" id="product_360_image_gallery" name="product_360_image_gallery" value="<?php echo esc_attr( $product_360_image_gallery ); ?>" />
  
      </div>
      <p class="add_product_360_images hide-if-no-js">
        <a href="#" data-choose="<?php esc_attr_e( 'Add Images to Product 360 view Gallery', 'teepro' ); ?>" data-update="<?php esc_attr_e( 'Add to gallery', 'teepro' ); ?>" data-delete="<?php esc_attr_e( 'Delete image', 'teepro' ); ?>" data-text="<?php esc_attr_e( 'Delete', 'teepro' ); ?>"><?php esc_html_e( 'Add product 360 view gallery images', 'teepro' ); ?></a>
      </p>
      <?php
  
    }
  }

/**
 * ------------------------------------------------------------------------------------------------
 * Save metaboxes
 * ------------------------------------------------------------------------------------------------
 */
if( ! function_exists( 'teepro_proccess_360_view_metabox' ) ) {
	add_action( 'woocommerce_process_product_meta', 'teepro_proccess_360_view_metabox', 50, 2 );
	function teepro_proccess_360_view_metabox( $post_id, $post ) {
		$attachment_ids = isset( $_POST['product_360_image_gallery'] ) ? array_filter( explode( ',', wc_clean( $_POST['product_360_image_gallery'] ) ) ) : array();

		update_post_meta( $post_id, '_product_360_image_gallery', implode( ',', $attachment_ids ) );
	}
}


/**
 * ------------------------------------------------------------------------------------------------
 * Returns the 360 view gallery attachment ids.
 * ------------------------------------------------------------------------------------------------
 */

if( ! function_exists( 'teepro_get_360_gallery_attachment_ids' ) ) {
	function teepro_get_360_gallery_attachment_ids() {
		global $post;

		if( ! $post ) return;

    $product_360_image_gallery = get_post_meta( $post->ID, '_product_360_image_gallery', true);
    
    return apply_filters( 'woocommerce_product_360_gallery_attachment_ids', array_filter( array_filter( (array) explode( ',', $product_360_image_gallery ) ), 'wp_attachment_is_image' ) );
	}
}

// $images_360_gallery = teepro_get_360_gallery_attachment_ids();

  add_action( 'teepro_on_product_image', 'teepro_product_360_view', 40 );





if( ! function_exists( 'teepro_product_360_view' ) ) {
	function teepro_product_360_view() {
    $images = teepro_get_360_gallery_attachment_ids();
		if( empty( $images ) ) return;

		$id = rand(100,999);

		$title = '';

    $frames_count = count( $images );

    $images_js_string = '';

    

		?>
			<div class="product-360-button wd-gallery-btn">
				<a href="#product-360-view"><span><?php esc_html_e('360 product view', 'teepro'); ?></span></a>
			</div>
			<div id="product-360-view" class="product-360-view-wrapper mfp-hide">
        <div class="WC-threed-view threed-id-<?php echo esc_attr( $id ); ?>">
          <div class="ui">
              <div class="prev"></div>
              <div class="next"></div>
          </div>

          <div class="threesixty-wrapper" >
            <div class="threesixty" data-count="<?php echo $frames_count ?>" >
              <?php if ( $frames_count > 0 ): $images_js_string = []; ?>
                <?php foreach ($images as $key => $img_id): ?>
                  <?php 
                    $img = wp_get_attachment_image_src( $img_id, 'full' );
                    $width = $img[1];
                    $height = $img[2];
                    $images_js_string[] =  $img[0];
                    
                    $nb_class = ($key === 0) ? 'current-image' : 'previous-image';
                    echo '<img class="threesixty-frame '.$nb_class.'" src=' . $img[0] . ' data-index='.$key.' width='.$width.' heigh='.$height.'>';
                    
                  ?>
                <?php endforeach ?>
              <?php endif ?> 
            </div>
          </div>
          <div class="spinner">
              <span>0%</span>
          </div>
        </div>
        <p><a class="popup-modal-dismiss" href="#"></a></p>
			</div>
    <?php
    $images_js_string = '['.implode(',',$images_js_string).']';
		wp_enqueue_script( 'WC-threesixty' );
	}
}



  function add_script_to_paroduct_360_images($hook)
{

    global $pagenow;
    $screen = get_current_screen();
    if($screen->post_type != 'product') {return;}
    wp_enqueue_script('product-360',get_template_directory_uri().'/assets/netbase/js/admin/product-360.js',array('jquery'),'1.0.0',true);

    wp_register_style( 'product-360_css', get_template_directory_uri() . '/assets/netbase/css/admin/metaboxes/product360.css', true, '1.0.0' );
    wp_enqueue_style( 'product-360_css' );
}
 
add_action( 'admin_enqueue_scripts', 'add_script_to_paroduct_360_images' );


// Add variation-images-gallery


add_action('woocommerce_product_after_variable_attributes','gallery_admin_html', 10, 3);
add_action('woocommerce_save_product_variation', 'save_variation_gallery', 10, 2);

function gallery_admin_html($loop, $variation_data, $variation) {
  $variation_id = absint($variation->ID);
  $gallery_images = get_post_meta($variation_id, 'rtwpvg_images', true);
  ?>
  <div class="form-row form-row-full rtwpvg-gallery-wrapper">
      <h4><?php esc_html_e('Variation Image Gallery', 'teepro') ?></h4>
      <div class="rtwpvg-image-container">
          <ul class="rtwpvg-images">
              <?php
              if (is_array($gallery_images) && !empty($gallery_images)) {
                  foreach ($gallery_images as $image_id):
                      $image = wp_get_attachment_image_src($image_id);
                      ?>
                      <li class="image">
                          <input type="hidden" name="rtwpvg[<?php echo esc_attr($variation_id) ?>][]"
                                 value="<?php echo $image_id ?>">
                          <img src="<?php echo esc_url($image[0]) ?>"/>
                          <a href="#" class="delete rtwpvg-remove-image"><span
                                      class="dashicons dashicons-dismiss"></span></a>
                      </li>
                  <?php endforeach;
              } ?>
          </ul>
      </div>
      <p class="rtwpvg-add-image-wrapper  hide-if-no-js">
          <a href="#" data-product_variation_loop="<?php echo absint($loop) ?>"
             data-product_variation_id="<?php echo esc_attr($variation_id) ?>"
             class="button rtwpvg-add-image"><?php esc_html_e('Add Gallery Images', 'teepro') ?></a>
      </p>
  </div>
  <?php
}
function save_variation_gallery($variation_id, $loop) {
  if (isset($_POST['rtwpvg'])) {
      if (isset($_POST['rtwpvg'][$variation_id])) {
          $rtwpvg_ids = (array)array_map('absint', $_POST['rtwpvg'][$variation_id]);
          update_post_meta($variation_id, 'rtwpvg_images', $rtwpvg_ids);
      } else {
          delete_post_meta($variation_id, 'rtwpvg_images');
      }
  } else {
      delete_post_meta($variation_id, 'rtwpvg_images');
  }
}

function add_script_to_variations_gallery($hook)
{

    wp_enqueue_script('variation-gallery',get_template_directory_uri().'/assets/netbase/js/admin/variation-gallery.js',array('jquery'),'1.0.0',true);
    wp_localize_script('variation-gallery', 'rtwpvg_admin', array(
      'choose_image' => esc_html__('Choose Image', 'teepro'),
      'add_image'    => esc_html__('Add Images', 'teepro')
  ));

    wp_register_style( 'variation-gallery_css', get_template_directory_uri() . '/assets/netbase/css/admin/metaboxes/variation-gallery.css', true, '1.0.0' );
    wp_enqueue_style( 'variation-gallery_css' );
}
 
add_action( 'admin_enqueue_scripts', 'add_script_to_variations_gallery' );

// Ajax gallery image

add_action( 'wp_ajax_color_ajax', 'color_ajax' );
add_action( 'wp_ajax_nopriv_color_ajax', 'color_ajax' );



function color_ajax(){
  $product_id = $_POST['product_id'];
  $product = wc_get_product($product_id);
  $variations = $product->get_available_variations();
  $data = array();
  $varriation_color=$_POST['varriation_color'];
  $attachment_ids = $product->get_gallery_image_ids();


  foreach($variations as $key => $variation) {
      $data[$key]['pa_colora'] = $variation['attributes']['attribute_pa_color'];
      $data[$key]['variation_id'] = $variation['variation_id'];
      $data[$key]['image_id'] = $variation['image_id'];
      $data[$key]['src'] = $variation['src'];
      $data[$key]['gallery_thumbnail_src'] = $variation['gallery_thumbnail_src'];
 
      if ($varriation_color == $data[$key]['pa_colora']){
        $varriation_ids = $data[$key]['variation_id'];
        $gallery_images = get_post_meta($varriation_ids, 'rtwpvg_images', true);

        ?>
        <?php $html  = '<figure class="woocommerce-product-gallery__wrapper has-gallery '.$varriation_color.'">' ?>
        <?php $html  .= '<div class="featured-gallery swiper-container '.$varriation_color.'">' ?>
        <?php $html .= '<div class="swiper-wrapper">' ?>
                        <?php
                        $full_size_image  = wp_get_attachment_image_src( $data[$key]['image_id'], 'full' );
                        $thumbnail       = wp_get_attachment_image_src( $data[$key]['image_id'], 'shop_thumbnail' );

                        $attributes = array(
                            'data-src'                => $full_size_image[0],
                            'data-large_image'        => $full_size_image[0],
                            'data-large_image_width'  => $full_size_image[1],
                            'data-large_image_height' => $full_size_image[2],
                        );
                        if ( $full_size_image) {
                            $html .= '<div data-thumb="' . get_the_post_thumbnail_url( $varriation_ids, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image swiper-slide">';
                            $html .= get_the_post_thumbnail( $varriation_ids, 'shop_single', $attributes );
                            $html .= '</div>';
                        } else {
                            $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                            $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'teepro' ) );
                            $html .= '</div>';
                        }
                        if ( $gallery_images ) {
                          foreach ( $gallery_images as $gallery_image ) {

                            $full_size_image  = wp_get_attachment_image_src( $gallery_image, 'full' );
                            $thumbnail        = wp_get_attachment_image_src( $gallery_image, 'shop_thumbnail' );

                            $attributes = array(
                                'data-src'                => $full_size_image[0],
                                'data-large_image'        => $full_size_image[0],
                                'data-large_image_width'  => $full_size_image[1],
                                'data-large_image_height' => $full_size_image[2],
                            );

                            $html .= '<div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image swiper-slide" data-index="">';
                            $html .= wp_get_attachment_image( $gallery_image, 'shop_single', false, $attributes );
                            $html .= '</div>';
                          }  
                        }else{
                          foreach ( $attachment_ids as $attachment_id ) {
                          $full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
                          $thumbnail        = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );

                            $attributes = array(
                                'data-src'                => $full_size_image[0],
                                'data-large_image'        => $full_size_image[0],
                                'data-large_image_width'  => $full_size_image[1],
                                'data-large_image_height' => $full_size_image[2],
                            );

                            $html .= '<div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image swiper-slide" data-index="">';
                            $html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
                            $html .= '</div>';
                          }
                        }
                        ?>
                        <?php $html .= '</div>'?>
                        <?php if ( count($gallery_images) > 1 or count($attachment_ids) > 1 )  : ?>
                    
                          <?php $html .= '<div class="swiper-button-next swiper-button-black"></div>';?>
                          <?php $html .= '<div class="swiper-button-prev swiper-button-black"></div>';?>
                          
                        <?php endif;?>
                <?php $html .= '</div>'?>
          
            <?php if($gallery_images or $attachment_ids ):?> 
              <?php $html .= '<div class="thumb-gallery swiper-container '.$varriation_color.'">' ?>
              <?php $html .= '<div class="swiper-wrapper">' ?>
              <?php
                        $full_size_image  = wp_get_attachment_image_src( $data[$key]['image_id'], 'full' );
                        $thumbnail       = wp_get_attachment_image_src( $data[$key]['image_id'], 'shop_thumbnail' );

                        $attributes = array(
                            'data-src'                => $full_size_image[0],
                            'data-large_image'        => $full_size_image[0],
                            'data-large_image_width'  => $full_size_image[1],
                            'data-large_image_height' => $full_size_image[2],
                        );
                        if ( $full_size_image) {
                            $html .= '<div data-thumb="' . get_the_post_thumbnail_url( $varriation_ids, 'shop_thumbnail' ) . '" class="woocommerce-product-gallery__image swiper-slide">';
                            $html .= get_the_post_thumbnail( $varriation_ids, 'shop_single', $attributes );
                            $html .= '</div>';
                        } else {
                            $html  = '<div class="woocommerce-product-gallery__image--placeholder">';
                            $html .= sprintf( '<img src="%s" alt="%s" class="wp-post-image" />', esc_url( wc_placeholder_img_src() ), esc_html__( 'Awaiting product image', 'teepro' ) );
                            $html .= '</div>';
                        }
                        if ( $gallery_images ) {
                          foreach ( $gallery_images as $gallery_image ) {

                            $full_size_image  = wp_get_attachment_image_src( $gallery_image, 'full' );
                            $thumbnail        = wp_get_attachment_image_src( $gallery_image, 'shop_thumbnail' );

                            $attributes = array(
                                'data-src'                => $full_size_image[0],
                                'data-large_image'        => $full_size_image[0],
                                'data-large_image_width'  => $full_size_image[1],
                                'data-large_image_height' => $full_size_image[2],
                            );

                            $html .= '<div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image swiper-slide" data-index="">';
                            $html .= wp_get_attachment_image( $gallery_image, 'shop_single', false, $attributes );
                            $html .= '</div>';
                          }  
                        }else{
                          foreach ( $attachment_ids as $attachment_id ) {
                          $full_size_image  = wp_get_attachment_image_src( $attachment_id, 'full' );
                          $thumbnail        = wp_get_attachment_image_src( $attachment_id, 'shop_thumbnail' );

                            $attributes = array(
                                'data-src'                => $full_size_image[0],
                                'data-large_image'        => $full_size_image[0],
                                'data-large_image_width'  => $full_size_image[1],
                                'data-large_image_height' => $full_size_image[2],
                            );

                            $html .= '<div data-thumb="' . esc_url( $thumbnail[0] ) . '" class="woocommerce-product-gallery__image swiper-slide" data-index="">';
                            $html .= wp_get_attachment_image( $attachment_id, 'shop_single', false, $attributes );
                            $html .= '</div>';
                          }
                        }
                        ?>
                  <?php $html .= '</div></div></figure>'?>
              <?php endif;?>
            <?php
      }    
  }

  echo $html;

  die;
}

add_action('admin_footer','admin_template_gallery_variation_js');

function admin_template_gallery_variation_js(){
  ?>
  <script type="text/html" id="tmpl-rtwpvg-image">
    <li class="image">
        <input type="hidden" name="rtwpvg[{{data.product_variation_id}}][]"
               value="{{data.id}}">
        <img src="{{data.url}}">
        <a href="#" class="delete rtwpvg-remove-image"><span
                    class="dashicons dashicons-dismiss"></span></a>
    </li>
  </script>
  <?php
}

// Ajax in shop page 

global $wpdb;
global $prefix;
$prefix = $wpdb->prefix;

add_action( 'wp_ajax_nopriv_teepro_load_more', 'teepro_load_more' );
add_action( 'wp_ajax_teepro_load_more', 'teepro_load_more' );

$order_sort_by = " DESC";
$categories_id = "";

$product_private = "";
if( current_user_can('editor') || current_user_can('administrator') ){
  $product_private = "OR {$prefix}posts.post_status = 'private'";
}else{
  $product_private = "";
}

$join_sql_for_ajax_shop = "LEFT JOIN {$prefix}term_relationships ON ({$prefix}posts.ID = {$prefix}term_relationships.object_id) LEFT JOIN {$prefix}wc_product_meta_lookup wc_product_meta_lookup ON {$prefix}posts.ID = wc_product_meta_lookup.product_id";

$where_sql_for_ajax_shop = "AND ( 
  {$prefix}posts.ID NOT IN (
        SELECT object_id
        FROM {$prefix}term_relationships
        WHERE term_taxonomy_id IN (7)
      )
) AND {$prefix}posts.post_type = 'product' AND ({$prefix}posts.post_status = 'publish' OR {$prefix}posts.post_status = 'wc-nbdq-new' OR {$prefix}posts.post_status = 'wc-nbdq-pending' OR {$prefix}posts.post_status = 'wc-nbdq-expired' OR {$prefix}posts.post_status = 'wc-nbdq-accepted' OR {$prefix}posts.post_status = 'wc-nbdq-rejected'".$product_private.")";

function teepro_load_more() {
  
  global $product;
  global $wp_query;
  global $order_sort_by;
  global $categories_id;

  $args = json_decode( stripslashes( $_POST['query'] ), true );
  $order_by = $_POST['order_by'];
  $categories_id = $_POST['categories_id'];
	$args['paged'] = $_POST['page'] + 1; // load the next page
  $args['post_status'] = 'publish';

  $categories_id = implode(',', $categories_id);

  // change request query before add new WP_Query 
    add_filter( 'posts_where', 'ss_where_table', 20, 2 );
    function ss_where_table( $where, $wp_query ) {
      global $wpdb;
      global $categories_id;
      global $where_sql_for_ajax_shop;
      $where = $where_sql_for_ajax_shop."AND 
      {$prefix}term_relationships.term_taxonomy_id IN (".$categories_id.") ";

      if($categories_id == ""){
        $where = $where_sql_for_ajax_shop;
      }
      return $where;
    }

    // add new WP_Query
    
  $query = new WP_Query($args);

  if( $query->have_posts() ) {   

    while( $query->have_posts() ): $query->the_post();

      wc_get_template_part( 'content', 'product' );

    endwhile;

  }
  wp_reset_postdata();
  wp_reset_query();

  die();
}


// Add Teepro Ajax Filter

  // Add Widget Ajax Filter Product by Price

class Teepro_ajax_filter_by_price extends WP_Widget {

  function __construct() {
    parent::__construct (
      'filter-by-price', // id của widget
      'Ajax Filter Product by Price', 
 
      array(
        'description' => 'Ajax Filter Product by Price'
      )
    );
  }

  function form( $instance ) {
    $default = array(
      'title' => "Filter by price",
    );
    $instance = wp_parse_args( (array) $instance, $default);

    $title = esc_attr( $instance['title'] );
    echo "
    <p>
      <label for='filter-by-price'>Title:</label>
      <input class='widefat' type='text' value='". $title ."' name=".$this->get_field_name('title')." >
    </p>";
    
  }

  function update( $new_instance, $old_instance ) {
    parent::update( $new_instance, $old_instance );
 
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    return $instance;
  }

  function widget( $args, $instance ) {
    extract( $args );
      $title = apply_filters( 'widget_title', $instance['title'] );

      echo $before_widget;

      echo $before_title.$title.$after_title;

      $price_slider_html = '
        
      <div id="price_slider_wrapper">
        <div id="slider-range"></div>
        <p>
          <label for="amount">Price range:</label>
          $<input type="text" id="amount_min" readonly></input>
          — $<input type="text" id="amount_max" readonly></input>
        </p>
        <button class="ajax-filter button" data-url='. admin_url('admin-ajax.php') .' >Filter</button>
      </div>
      ';
      echo $price_slider_html;

      echo $after_widget;
  }
}

// Add Widget Ajax Filter Product by Attribute

class Teepro_ajax_filter_by_attr extends WP_Widget {


  function __construct() {
    parent::__construct (
      'filter-by-attr', // id của widget
      'Ajax Filter Product by Attributes ', // tên của widget
 
      array(
        'description' => 'Ajax Filter Product by Attributes' // mô tả
      )
    );
  }

  /**
   * Tạo form option cho widget
   */
  function form( $instance ) {
    
    $default = array(
      'title' => "Filter by ",     
    );
    $instance = wp_parse_args( (array) $instance, $default);
    $title = $instance['title']; 
    $attr_type = $instance['attr_type']; 
    $query_type = $instance['query_type']; 
    ?>

    <label for="filter-by-attr">Title:</label>
    <input class='widefat' type='text' value="<?php echo $title; ?>" name="<?php echo $this->get_field_name('title'); ?>">
    <p>
      <label for='filter-by-attr'>Attribute:</label>
        <select id="<?php echo $this->get_field_id( 'attr_type' ); ?>" name="<?php echo $this->get_field_name( 'attr_type' ); ?>" class="widefat">
          <?php 
          $attrs_raw = wc_get_attribute_taxonomies();
          foreach($attrs_raw as $k => $v): ?>
            <option value="<?php echo $v->attribute_name; ?>" <?php echo ($attr_type == $v->attribute_name)?'selected="selected"':'';?>><?php echo $v->attribute_label; ?></option>
          <?php endforeach; ?>
        </select>
    </p>
    <p>
      <label for='ajax-query-type'>Query type:</label>
        <select id="<?php echo $this->get_field_id( 'query_type' ); ?>" name="<?php echo $this->get_field_name( 'query_type' ); ?>" class="widefat">
          <option value='and'<?php echo ($query_type=='and')?'selected':''; ?>>AND</option> 
          <option value='or'<?php echo ($query_type=='or')?'selected':''; ?>>OR</option>  
        </select>
    </p>

    <?php
    
    
  }

  /**
   * save widget form
   */

  function update( $new_instance, $old_instance ) {
 
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['attr_type'] = strip_tags($new_instance['attr_type']);
    $instance['query_type'] = strip_tags($new_instance['query_type']);
    return $instance;
  }

  /**
   * Show widget
   */

  function widget( $args, $instance ) {
      global $wpdb;
      global $prefix;
      extract( $args );
      $title = apply_filters( 'widget_title', $instance['title'] );
      $attr_type = empty($instance['attr_type']) ? '' : $instance['attr_type'];
      $query_type = empty($instance['query_type']) ? '' : $instance['query_type'];
      echo $before_widget;

      echo $before_title.$title.$after_title;

      $attr_type_selected = "pa_".$attr_type;

      $total_attribute_terms = get_terms($attr_type_selected);
      $prepared_query = "SELECT attribute_type FROM {$prefix}woocommerce_attribute_taxonomies WHERE attribute_name = '".$attr_type."'";
      $attribute = $wpdb->get_results( $prepared_query );?>
      <ul class= "product-filter <?php echo "attribute-".$attribute[0]->attribute_type."" ;?>">
      <?php foreach ($total_attribute_terms as $k => $v):?>
        <li class="product-attr-list" data-url="<?php echo admin_url('admin-ajax.php'); ?>" >
          <?php if(!empty(get_term_meta($v->term_id)["color"][0])):
            $color_attr = get_term_meta($v->term_id)["color"][0];
            echo "<a class='circle' aria-hidden='true' style="." background-color:" . $color_attr . "></a>"; 
          endif;?>
          <a class="product-attr <?php echo $v->taxonomy; ?>" data-value ="<?php echo "filter_".$attr_type."=".$v->term_taxonomy_id; ?>" data-slug = "<?php echo $v->slug; ?>"><?php echo $v->name; ?></a>
          <i class="remove-filter" style="opacity: 0" aria-hidden="true"></i>
        </li>
      <?php endforeach; ?>
        <p class = "term-id-selected" style= "display: none;" ><?php echo "filter_".$attr_type."=".$v->term_id; ?></p>
        <p class = "term-name" style= "display: none;" ></p>
        <p class = "query-type-selected" style= "display: none;" ><?php echo $query_type; ?></p>
      </ul> 
      
      <?php

      echo $after_widget;
  }
}

// Add Widget Ajax Filter Product by Brand

class Teepro_ajax_filter_by_brand extends WP_Widget {

  function __construct() {
    parent::__construct (
      'filter-by-brand', // id của widget
      'Ajax Filter Product by Brands', 
 
      array(
        'description' => 'Ajax Filter Product by Brands'
      )
    );
  }

  function form( $instance ) {
    $default = array(
      'title' => "Filter by Brands",
    );
    $instance = wp_parse_args( (array) $instance, $default);

    $title = esc_attr( $instance['title'] );
    $query_type = $instance['query_type']; ?>
    <p>
      <label for='filter-by-brands'>Title:</label>
      <input class='widefat' type='text' value='<?php echo $title; ?>' name=" <?php echo $this->get_field_name('title'); ?>" >
    </p>
    <p>
      <label for='ajax-query-type'>Query type:</label>
      <select id="<?php echo $this->get_field_id( 'query_type' ); ?>" name="<?php echo $this->get_field_name( 'query_type' ); ?>" class="widefat">
        <option value='and'<?php echo ($query_type=='and')?'selected':''; ?>>AND</option> 
        <option value='or'<?php echo ($query_type=='or')?'selected':''; ?>>OR</option>  
      </select>
    </p>
    <?php
    
  }

  function update( $new_instance, $old_instance ) {
    parent::update( $new_instance, $old_instance );
 
    $instance = $old_instance;
    $instance['title'] = strip_tags($new_instance['title']);
    $instance['query_type'] = strip_tags($new_instance['query_type']);
    return $instance;
  }

  function widget( $args, $instance ) {
    extract( $args );
      $title = apply_filters( 'widget_title', $instance['title'] );
      $query_type = empty($instance['query_type']) ? '' : $instance['query_type'];
      echo $before_widget;

      echo $before_title.$title.$after_title;

      $total_attribute_terms = get_terms("product_brand");?>
      
      <ul class= "product-filter">
        <?php foreach ($total_attribute_terms as $k => $v): 
          $brands_thumbnail = get_term_meta( $v->term_id, 'brands_thumbnail', true );
					$brands_thumbnail = wp_get_attachment_image_src($brands_thumbnail);
        ?>
          <li class="product-attr-list product-brand-list " style="border-color: transparent !important" data-url="<?php echo admin_url('admin-ajax.php'); ?>" >
            <span class="circle <?php echo $v->taxonomy; ?>" style="background-image:url(<?php echo $brands_thumbnail[0]; ?>)"></span>
            <a class="product-attr " data-value ="<?php echo "filter_brand=".$v->term_taxonomy_id;?>" data-slug = "<?php echo $v->slug ;?>"><?php echo $v->name; ?></a>
            <i class="remove-filter" style="opacity: 0" aria-hidden="true"></i>
          </li>
        <?php endforeach; ?>
          <p class="term-id-selected" style= "display: none;" ><?php echo $v->term_id; ?></p>
          <p class="term-name" style= "display: none;" ></p>
          <p class="query-type-selected" style= "display: none;" ><?php echo $query_type; ?></p>
      </ul>

      <?php

      echo $after_widget;
  }
}

  add_action( 'wp_ajax_nopriv_teepro_ajax_filter_product', 'teepro_ajax_filter_product' );
  add_action( 'wp_ajax_teepro_ajax_filter_product', 'teepro_ajax_filter_product' );

  $ajax_min_price = "";
  $ajax_max_price = "";



function teepro_ajax_filter_product(){
  global $product;
  global $wpdb;
  global $prefix;
  global $wp_query;
  global $categories_id;
  global $ajax_min_price;
  global $ajax_max_price;
  global $term_id;
  global $teepro_order_by;
  global $product_private;

  $args = json_decode( stripslashes( $_POST['query'] ), true );
  $ajax_min_price = $_POST['ajax_min_price'].".00";
  $ajax_max_price = $_POST['ajax_max_price'].".00";
  $categories_id = $_POST['categories_id'];
  $term_id = $_POST['term_id'];
  $teepro_order_by = $_POST['teepro_order_by'];
  $product_brand_selected = $_POST['product_brand_selected'];
  $page_selected = $_POST['page_selected'];

  $term_id = str_replace(";","",$term_id);

  if($product_brand_selected != 0){
    $categories_id = [$product_brand_selected];
  }

  $datas = explode('filter_',$term_id);
  foreach($datas as $key=>$value){  // remove empty value
    if(is_null($value) || $value == ''){
      unset($datas[$key]);
    }
  }

  $arrs = [];  
  foreach ($datas as $data ) {  // separate arrays by value
    $attr = explode('=',$data);
    $arrs[] = $attr;
  }

  $term_id = array();
  foreach($arrs as $data){   // create new array term_id[]
    $term_id[$data[0]][] = $data[1];
  }

  $categories_id = implode(',', $categories_id);


  add_filter( 'posts_join', 'filter_posts_distinct_request', 12, 2 ); 
  add_filter( 'posts_where', 'ss_where_table', 20, 2 );
  add_filter( 'posts_orderby', 'orderby_other_table', 10, 2 );

  
  function filter_posts_distinct_request($join, $wp_query){
    global $wpdb;
    global $join_sql_for_ajax_shop;
    $join = $join_sql_for_ajax_shop;
    return $join ;
  }

  function ss_where_table( $where, $wp_query ) {
    global $wpdb;
    global $prefix;
    global $categories_id;
    global $where_sql_for_ajax_shop;
    global $ajax_min_price;
    global $ajax_max_price;
    global $term_id;
    global $product_private;

    $query_terms = "";
    foreach($term_id as $k => $v){
      $query_terms .= "( SELECT COUNT(1) FROM {$prefix}term_relationships WHERE term_taxonomy_id IN (";
      foreach($v as $v1 => $v2){
        if(count($v) > 1){
          $query_terms .= implode(',',$v);
          break;
        }else{
          $query_terms .= $v2;
        }
      }
      $query_terms .= ") AND object_id = {$prefix}posts.ID ) = ".count($v)." AND ";
    }

    $check_value_term_id = "";
    foreach($term_id as $k => $v){
      $check_value_term_id = $v[0];
      break;
    }
    if (is_null($check_value_term_id)) {
      $where = $where_sql_for_ajax_shop;
      if($categories_id != ""){
        $where .= "AND {$prefix}term_relationships.term_taxonomy_id IN (".$categories_id.") ";
      }
    }else{
      $where = " AND ( ".$query_terms."{$prefix}posts.ID NOT IN (
              SELECT object_id
              FROM {$prefix}term_relationships
              WHERE term_taxonomy_id IN (7)
            )
      ) AND {$prefix}posts.post_type = 'product' AND ({$prefix}posts.post_status = 'publish' OR {$prefix}posts.post_status = 'wc-nbdq-new' OR {$prefix}posts.post_status = 'wc-nbdq-pending' OR {$prefix}posts.post_status = 'wc-nbdq-expired' OR {$prefix}posts.post_status = 'wc-nbdq-accepted' OR {$prefix}posts.post_status = 'wc-nbdq-rejected'".$product_private." )";

      if($categories_id != ""){
        $where .= "AND {$prefix}term_relationships.term_taxonomy_id IN (".$categories_id.") ";
      }
    }

    //filter by price
    $where.= " AND wc_product_meta_lookup.min_price >=". $ajax_min_price . " AND wc_product_meta_lookup.max_price <=". $ajax_max_price;
    
    return $where;
  }

  function orderby_other_table($teepro_order_by, $wp_query ) {

  $ajax_sort_by ="";
  global $teepro_order_by;
  global $order_sort_by;
  global $prefix;

  if($teepro_order_by == "popularity"){
    $ajax_sort_by = "total_sales";
  }elseif($teepro_order_by == "rating"){
    $ajax_sort_by = "rating_count";
  }elseif($teepro_order_by == "date"){
    $ajax_sort_by = "post_date";
  }elseif($teepro_order_by == "price"){
    $order_sort_by = " ASC";   
    $ajax_sort_by = "min_price";
  }elseif($teepro_order_by == "price-desc"){
    $ajax_sort_by = "max_price";
  }elseif($teepro_order_by == "menu_order"){
    $ajax_sort_by = "menu_order";
    $order_sort_by = " ASC"; 
  }

  if($ajax_sort_by == "post_date"){
    $teepro_order_by = "{$prefix}posts.".$ajax_sort_by . $order_sort_by .", {$prefix}posts.ID".$order_sort_by;
  }elseif ($ajax_sort_by == "max_price" || $ajax_sort_by == "min_price" || $ajax_sort_by == "rating_count" || $ajax_sort_by == "total_sales") {
    $teepro_order_by = "wc_product_meta_lookup.".$ajax_sort_by . $order_sort_by.", wc_product_meta_lookup.product_id".$order_sort_by;
  }elseif($ajax_sort_by == "menu_order"){
    $teepro_order_by = "{$prefix}posts.".$ajax_sort_by . $order_sort_by .", {$prefix}posts.post_title".$order_sort_by;
  }
  return $teepro_order_by;
  }

  $args['paged'] = $page_selected;
  $query = new WP_Query($args);

  //filter by price
  $request = $query->request;
  $new_request = str_replace("LIMIT 0, 12", "LIMIT 0, 100", $request);
  $query_price = $new_request;
  $all_price = $wpdb->get_results( $query_price );
  $min_arr = [];
  $max_arr = [];
  foreach($all_price as $v){
    $min_price_filter = "SELECT min_price FROM {$prefix}wc_product_meta_lookup WHERE product_id IN (".$v->ID.")";
    $max_price_filter = "SELECT max_price FROM {$prefix}wc_product_meta_lookup WHERE product_id IN (".$v->ID.")";
    $min_price_ = $wpdb->get_results( $min_price_filter );
    $max_price_ = $wpdb->get_results( $max_price_filter );
    array_push($min_arr,$min_price_[0]->min_price);
    array_push($max_arr,$max_price_[0]->max_price);
  }
  if(empty($min_arr)){
    $min = $max = 0;
  }else{
    $min = 9999999999999;
    $max = 0;
    foreach($min_arr as $v){
      if($min > $v){
        $min = $v;
      }
    }

    foreach($max_arr as $v){
      if($max < $v){
        $max = $v;
      }
    }
  }
  
  $min = (int)($min);
  $max = (int)($max);
  echo "<input type ='hidden' class='min_value_filter' value=".$min."></input>";
  echo "<input type ='hidden' class='max_value_filter' value=".$max."></input>";
  //end filter by price
  echo "<input type ='hidden' class='max_num_pages' value=".$query->max_num_pages."></input>";

  if( $query->have_posts() ) {   

    while( $query->have_posts() ): $query->the_post();

      wc_get_template_part( 'content', 'product' );

    endwhile;

  }else{ ?>
    <div class="no_product">
      <span class="icon-attention-circled"></span>
      <p class="text_no_product"><?php _e( 'No products found' );  ?></p>
    </div>
  <?php }
  wp_reset_postdata();
  wp_reset_query();

  die();
}
