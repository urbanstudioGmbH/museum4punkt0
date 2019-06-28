<?php

class block_us_twoimages{

    function __construct(){
        add_action('acf/init', array($this, "block_us_twoimages_register"));
    }

    public function block_us_twoimages_register(){
        $this->block_us_twoimages_fields();
        acf_register_block(array(
            'name'				=> 'block_us_twoimages',
            'title'				=> __('2 Bilder', "uslang"),
            'description'		=> __('erzeugt einen Block, mit je einem Bild links und rechts.', "uslang"),
            'render_callback'	=> array($this, 'block_us_twoimages_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'format-image',
            'align'         => 'wide',
            'mode'          => 'preview',
            'keywords'		=> array("article", "related"),
            'supports'      => array("align" => array("wide")),
            'enqueue_assets' => function(){
                wp_enqueue_style('block_us_twoimages', get_template_directory_uri() . '/inc/blocks/twoimages/twoimages.css');
                wp_enqueue_script('block_us_twoimages', get_template_directory_uri() . '/inc/blocks/twoimages/twoimages.js', array('us/magnificpopup/lang'), '', true);
            }
        ));
        //add_editor_style("inc/blocks/twoimages/twoimages.css");
    }

    public function block_us_twoimages_render($block, $content = '', $is_preview = false){
        $left_image = get_field('block_us_twoimages_left');
        $left_caption = get_field('block_us_twoimages_left_caption');
        $right_image = get_field('block_us_twoimages_right');
        $right_caption = get_field('block_us_twoimages_right_caption');

        $blockid = 'block_twoimages-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        //$alignclass = $block['align'] ? 'align' . $block['align'] : 'alignwide';
        $block["align"] = "wide";
        $alignclass = 'alignwide';
        $c = "";
        //wp_enqueue_style("block_twoimages_style", get_template_directory_uri()."/inc/blocks/twoimages/twoimages.css");
        if($left_image && $right_image){
            echo '<div class="block_twoimages two-images-container '.$alignclass.'" id="'.$blockid.'">';
                echo '<div class="grid-images">';
                    echo '<figure class="grid-image-left">';
                        echo '<a href="'.$left_image["sizes"]["large"].'" title="'.esc_attr($left_caption).'">';
                            echo '<img class="image-responsive" src="'.$left_image["sizes"]["thumbnail"].'" srcset="'.$left_image["sizes"]["thumbnail"].' 1x, '.$left_image["sizes"]["medium"].' 2x" alt="'.esc_attr($left_caption).'">';
                        echo '</a>';
                        if($left_caption) echo '<figcaption>'.$left_caption.'</figcaption>';
                    echo '</figure>';
                    echo '<figure class="grid-image-right">';
                        echo '<a href="'.$right_image["sizes"]["large"].'" title="'.esc_attr($right_caption).'">';
                            echo '<img class="image-responsive" src="'.$right_image["sizes"]["thumbnail"].'" srcset="'.$right_image["sizes"]["thumbnail"].' 1x, '.$right_image["sizes"]["medium"].' 2x alt="'.esc_attr($right_caption).'">';
                        echo '</a>';
                        if($right_caption) echo '<figcaption>'.$right_caption.'</figcaption>';
                    echo '</figure>';
                echo '</div>';
            echo '<div class="clear"></div></div>';

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

    public function block_us_twoimages_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5cab89c782b02',
                'title' => 'Block: twoimages',
                'fields' => array(
                    array(
                        'key' => 'field_5cab89fd100de',
                        'label' => 'Bild Links',
                        'name' => 'block_us_twoimages_left',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => 'jpg,png,jpeg',
                    ),
                    array(
                        'key' => 'field_5cab8a25100df',
                        'label' => 'Bildbeschreibung',
                        'name' => 'block_us_twoimages_left_caption',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'wpml_cf_preferences' => 0,
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_5cab8a3d100e0',
                        'label' => 'Bild Rechts',
                        'name' => 'block_us_twoimages_right',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'preview_size' => 'medium',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => 'jpg,png,jpeg',
                    ),
                    array(
                        'key' => 'field_5cab8a5f100e1',
                        'label' => 'Bildbeschreibung',
                        'name' => 'block_us_twoimages_right_caption',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'wpml_cf_preferences' => 0,
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-twoimages',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'field',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));
            
            endif;
    }
}
$block_us_twoimages = new block_us_twoimages();
