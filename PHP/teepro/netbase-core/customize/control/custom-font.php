<?php
class Teepro_Customize_Control_Custom_Font extends WP_Customize_Control
{

    /**
     * Declare the control type.
     *
     * @access public
     * @var string
     */
    public $type = 'test';

    public $condition;

    public function enqueue()
    {
        static $enqueued;

        //TODO min css and js
        if( !isset($enqueued) ) {
            wp_enqueue_script(
                'nb-custom-test',
                get_template_directory_uri() . '/assets/netbase/js/admin/customfont.min.js',
                array('jquery'),
                TEEPRO_VER,
                true
            );

            $enqueued = true;
        }

    }

    /**
     * Render the control. 
     */
    public function render_content()
    {
        $output_values = !is_array( $this->value() ) ? explode( ',', $this->value() ) : $this->value(); 

        $custom_fonts_array = Teepro_Helper::get_custom_fonts();

        ?>

        <div class="customize-control-content customize-control-custom-font" id="nb-<?php echo esc_attr($this->type)?>-<?php echo esc_attr($this->id)?>">
            <?php if( !empty($this->label) ): ?>
            <span class="customize-control-title">
                <?php echo esc_html($this->label); ?>
            </span>
            <?php endif;
            if( !empty($this->description) ): ?>
            <span class="description customize-control-description">
                <?php echo esc_html($this->description); ?>
            </span>
            <?php endif; ?>
            <div class = "clone-customfont">
                <?php
                    $new_custom_fonts_array = array();
                    foreach($custom_fonts_array as $index =>  $custom_font_block) {
                        foreach($custom_font_block as $i => $custom_font_item) {
                            $index_count = 0;
                            if(substr(strstr($custom_font_block[$i], '.'), 1) === "woff"){
                                $index_count = 1;
                            }
                            else if(substr(strstr($custom_font_block[$i], '.'), 1) === "woff2"){
                                $index_count = 2;
                            }
                            else if(substr(strstr($custom_font_block[$i], '.'), 1) === "ttf"){
                                $index_count = 3;
                            }
                            else if(substr(strstr($custom_font_block[$i], '.'), 1) === "eot"){
                                $index_count = 4;
                            }
                            else {
                                $index_count = 0;
                            }
                            $new_custom_fonts_array[$index][$index_count] = $custom_font_item;
                        }
                    }
                ?>
                <?php foreach($new_custom_fonts_array as $index =>  $custom_font_block):
                    ?>
                    <div class="upload-font-name" data-index=<?php echo (esc_attr($index))?>>
                        <h2 class="customize-control-title"><?php esc_html_e('Font name', 'teepro'); ?></h2>
                        <input class="button display-custom-font" type="text" name="font_name" value="<?php if(isset($custom_font_block[0])) echo esc_attr(str_replace("fontName:", "", $custom_font_block[0]));?>" />                
                    </div>
                    <div class= "clone-customfont-block" data-index=<?php echo (esc_attr($index))?>>
                        <div class="upload-font-block">
                            <h2 class="customize-control-title"><?php esc_html_e('Upload font(.woff)', 'teepro'); ?></h2>
                            <input type="text" class="display-custom-font" name="" value="<?php if(isset($custom_font_block[1])) echo esc_attr($custom_font_block[1]);?>" />
                            <button type="button" class="button upload-font upload-custom-font"><?php esc_html_e('Upload font', 'teepro'); ?></button>
                        </div>
                        <div class="upload-font-block">
                            <h2 class="customize-control-title"><?php esc_html_e('Upload font(.woff2)', 'teepro'); ?></h2>
                            <input type="text" class="display-custom-font" name="" value="<?php if(isset($custom_font_block[2]))  echo esc_attr($custom_font_block[2]);?>" />
                            <button type="button" class="button upload-font upload-custom-font"><?php esc_html_e('Upload font', 'teepro'); ?></button>
                        </div>
                        <div class="upload-font-block">
                            <h2 class="customize-control-title"><?php esc_html_e('Upload font(.ttf)', 'teepro'); ?></h2>
                            <input type="text" class="display-custom-font" name="" value="<?php if( isset($custom_font_block[3]))  echo esc_attr($custom_font_block[3]);?>" />
                            <button type="button" class="button upload-font upload-custom-font"><?php esc_html_e('Upload Font', 'teepro'); ?></button>
                        </div>
                        <div class="upload-font-block">
                            <h2 class="customize-control-title"><?php esc_html_e('Upload font(.eot)', 'teepro'); ?></h2>
                            <input type="text" class="display-custom-font" name="" value="<?php if(isset($custom_font_block[4])) echo esc_attr($custom_font_block[4]);?>" />
                            <button type="button" class="button upload-font upload-custom-font"><?php esc_html_e('Upload font', 'teepro'); ?></button>
                        </div>
                    </div>
                    <button type="button" class="button remove-font" data-index=<?php echo (esc_attr($index))?> ><?php _e( 'Remove Font' ); ?></button>
                <?php endforeach;?>
            </div>
            <button type="button" class="button add-new-font"><?php _e( 'Add new font' ); ?></button>
        </div>
        <input type="hidden" <?php $this->link(); ?> />
        <?php
    }
}
?>