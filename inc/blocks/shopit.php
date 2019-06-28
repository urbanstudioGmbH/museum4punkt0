<?php

class block_us_shopit{

    function __construct(){
        add_action('acf/init', array($this, "block_us_shopit_register"));
    }

    public function block_us_shopit_register(){
        $this->block_us_shopit_fields();
        acf_register_block(array(
            'name'				=> 'block_us_shopit',
            'title'				=> __('Shop it!', "uslang"),
            'description'		=> __('erzeugt einen Affiliate-Block', "uslang"),
            'render_callback'	=> array($this, 'block_us_shopit_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'cart',
            'keywords'		=> array("article", "featured")
        ));
    }

    public function block_us_shopit_render($block, $content = '', $is_preview = false){
        $theImage = get_field('block_us_shopit_image');
        $theTitle = get_field('block_us_shopit_title');
        $theText = get_field('block_us_shopit_text');
        $theURL = get_field('block_us_shopit_url');
        $theButton = get_field('block_us_shopit_button');

        $blockid = 'block_us_shopit-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $align_class = $block['align'] ? 'align' . $block['align'] : '';

        $c = "";
        if($theImage && $theURL && $theTitle){
            $theHTML = '';
            $theHTML .= '<a href="'.$theURL.'" target="_blank">';
                $theHTML .= '<div class="shopit_image">';
                    $theHTML .= '<picture>';
                        $theHTML .= '<source media="(min-width: 1401px)" srcset="'.$theImage["sizes"]["slide_desktop_wide"].'">';
                        $theHTML .= '<source media="(min-width: 660px)" srcset="'.$theImage["sizes"]["slide_desktop"].' 1x, '.$theImage["sizes"]["slide_desktop_wide"].' 2x">';
                        $theHTML .= '<source srcset="'.$theImage["sizes"]["slide_desktop"].'">';
                        $theHTML .= '<img src="'.$theImage["sizes"]["slide_desktop"].'" alt="'.$theTitle.'">';
                    $theHTML .= '</picture>';
                $theHTML .= '</div>';
                $theHTML .= '<div class="shopit_title">'.$theTitle.'</div>';
                $theHTML .= '<div class="shopit_text">'.$theText.'</div>';
                $theHTML .= '<div class="shopit_button">'.$theButton.'</div>';
            $theHTML .= '</a>';
            $c .= '<div class="block_us_shopit '.$alignclass.'" id="'.$blockid.'">'.$theHTML.'</div>';
        }else{
            if(\is_admin()){
                $c .= '<div class="block_us_shopit '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passe diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
            }
        }
        echo $c;
    }

    public function block_us_shopit_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5bf6c87a32c9b',
                'title' => 'Block: Shop it!',
                'fields' => array(
                    array(
                        'key' => 'field_5bf6c88d772d2',
                        'label' => 'Bild',
                        'name' => 'block_us_shopit_image',
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
                        'preview_size' => 'thumbnail',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => 'jpg,jpeg,png',
                    ),
                    array(
                        'key' => 'field_5bf6c8e8772d3',
                        'label' => 'Titel',
                        'name' => 'block_us_shopit_title',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_5bf6c8f6772d4',
                        'label' => 'Text',
                        'name' => 'block_us_shopit_text',
                        'type' => 'textarea',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'maxlength' => '',
                        'rows' => '',
                        'new_lines' => '',
                    ),
                    array(
                        'key' => 'field_5bf6c90d772d5',
                        'label' => 'URL',
                        'name' => 'block_us_shopit_url',
                        'type' => 'url',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                    ),
                    array(
                        'key' => 'field_5bf6c930772d6',
                        'label' => 'Button',
                        'name' => 'block_us_shopit_button',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => 'zum Shop',
                        'placeholder' => 'zum Shop',
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
                            'value' => 'acf/block-us-shopit',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => 1,
                'description' => '',
            ));
            
            endif;
    }
}
$block_us_shopit = new block_us_shopit();