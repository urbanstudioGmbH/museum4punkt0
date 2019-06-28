<?php

class block_us_gallery{

    function __construct(){
        add_action('acf/init', array($this, "block_us_gallery_register"));
    }

    public function block_us_gallery_register(){
        $this->block_us_gallery_fields();
        acf_register_block(array(
            'name'				=> 'block_us_gallery',
            'title'				=> __('Galerie', "uslang"),
            'description'		=> __('erzeugt einen Block, mit einer Galerie mit Caption', "uslang"),
            'render_callback'	=> array($this, 'block_us_gallery_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'format-image',
            'align'         => 'full',
            'mode'          => 'preview',
            'keywords'		=> array("article", "related"),
            'supports'      => array("align" => array("full"))
        ));
        add_editor_style("inc/blocks/gallery/gallery.css");
    }

    public function block_us_gallery_render($block, $content = '', $is_preview = false){
        $images = get_field('block_us_gallery_images');
        $sc = get_field('block_us_gallery_showcaption');

        $blockid = 'block_gallery-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        //$alignclass = $block['align'] ? 'align' . $block['align'] : 'alignwide';
        $alignclass = 'alignfull';
        $c = "";
        if(!\is_admin()) wp_enqueue_style("block_gallery_style", get_template_directory_uri()."/inc/blocks/gallery/gallery.css");
        if($images && count($images)){
            $inlinescript = <<<EOF
            jQuery('#$blockid').magnificPopup({
                delegate: 'a',
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'my-mfp-zoom-in',
                gallery:{
                    enabled:true
                }
            });
EOF;
            wp_add_inline_script("us/magnificpopup", $inlinescript);
            echo '<div class="block_gallery gallery-grid-container '.$alignclass.'" id="'.$blockid.'">';
                echo '<div class="center">';
                    echo '<div class="grid-gallery">';
                        $i = 1;
                        foreach ($images as $image) {
                            echo '<figure class="grid-gallery-item'.($i==4?' last':'').($i==1?' first':'').'">';
                                echo '<a href="'.$image["sizes"]["large"].'" title="'.($image["caption"] ? esc_attr($image["caption"]) : esc_attr($image["alt"])).'">';
                                    echo '<img class="image-responsive" src="'.$image["sizes"]["gallery_preview_1x"].'" srcset="'.$image["sizes"]["gallery_preview_1x"].' 1x, '.$image["sizes"]["gallery_preview_2x"].' 2x" alt="'.$image["alt"].'">';
                                echo '</a>';
                                if ($image["caption"] || $image["description"]) {
                                    echo '<figcaption>'.($image["caption"] ? $image["caption"] : "").'</figcaption>';
                                }
                            echo '</figure>';
                            $i = $i<4 ? $i+1 : 1;
                        }
                    echo '</div>';
                echo '</div>';
            echo '</div>';

        }else{
            if(\is_admin()){
                $c .= '<div class="block_related '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passe diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
                echo $c;
            }
        }
    }

    public function block_us_gallery_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5caf5b04f3cc0',
                'title' => 'Block: Gallery',
                'fields' => array(
                    array(
                        'key' => 'field_5caf5b19d4139',
                        'label' => 'Bildbeschreibung zeigen?',
                        'name' => 'block_us_gallery_showcaption',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => '',
                        'default_value' => 1,
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                        'wpml_cf_preferences' => 0,
                    ),
                    array(
                        'key' => 'field_5caf5b51d413a',
                        'label' => 'Bilder',
                        'name' => 'block_us_gallery_images',
                        'type' => 'gallery',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'min' => '',
                        'max' => '',
                        'insert' => 'append',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => 'jpg,jpeg,png',
                        'wpml_cf_preferences' => 0,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-gallery',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));
            
            endif;
    }
}
$block_us_gallery = new block_us_gallery();
