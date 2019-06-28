<?php

class block_us_iconbox{

    function __construct(){
        add_action('acf/init', array($this, "block_us_iconbox_register"));
    }

    public function block_us_iconbox_register(){
        $this->block_us_iconbox_fields();
        acf_register_block(array(
            'name'				=> 'block_us_iconbox',
            'title'				=> __('Iconbox', "uslang"),
            'description'		=> __('erzeugt einen Block, mit dem man SVG-Icon mit Titel und Text in Spalten unterbringen kann', "uslang"),
            'render_callback'	=> array($this, 'block_us_iconbox_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'admin-customizer',
            'supports'      => array("align" => false),
            'keywords'		=> array("icon", "image", "text")
        ));
    }

    public function block_us_iconbox_render($block, $content = '', $is_preview = false){
        $image = get_field('block_us_iconbox_image');
        $title = get_field('block_us_iconbox_title');
        $text = get_field('block_us_iconbox_text');
        $btntext = get_field('block_us_iconbox_btntext');
        $link = get_field('block_us_iconbox_link');

        $blockid = 'block_iconbox-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = $block['align'] ? 'align' . $block['align'] : '';

        $c = "";
        wp_enqueue_style("block_iconbox_style", get_template_directory_uri()."/css/iconbox.css");
        if($image && $title){
            
            $link_url = (!empty($link['url']) ? $link['url'] : "#");
            $link_title = (!empty($link['title']) ? $link['title'] : $title);
            $link_target = $link['target'] ? $link['target'] : '_self';
            $astart = '<a class="%s" href="'.esc_url($link_url).'" target="'.esc_attr($link_target).'" title="'.esc_attr($link_title).'">';

            echo '<div class="block_iconbox '.$alignclass.'" id="'.$blockid.'">';
                echo sprintf($astart, "svg-image imageblock");
                //echo '<img src="'.esc_url($image).'" alt="'.esc_attr($link_title).'" title="'.esc_attr($link_title).'">';
                echo ($image);
                echo '</a>';

                echo '<div class="textcontentbox">';
                echo '<h3>'.sprintf($astart, "headline").$title.'</a></h3>';
                if($text) echo '<div class="textholder">'.$text.'</div>';
                if(trim($btntext)) echo sprintf($astart, "theme-button").$btntext.'</a>';
				echo '</div>';

                echo '<div class="clear"></div>';
			echo '</div>';
        }else{
            if(\is_admin()){
                $c .= '<div class="block_iconbox '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passen Sie diesen Block in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
                echo $c;
            }
        }
    }

    public function block_us_iconbox_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5c37250e916e7',
                'title' => 'Block: Iconbox',
                'fields' => array(
                    array(
                        'key' => 'field_5c37250ebb8ca',
                        'label' => 'Bild',
                        'name' => 'block_us_iconbox_image',
                        'type' => 'font-awesome',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'icon_sets' => array(
                            0 => 'fas',
                            1 => 'far',
                            2 => 'fab',
                        ),
                        'custom_icon_set' => '',
                        'default_label' => '',
                        'default_value' => '',
                        'save_format' => 'element',
                        'allow_null' => 0,
                        'show_preview' => 1,
                        'enqueue_fa' => 0,
                        'fa_live_preview' => '',
                        'choices' => array(
                        ),
                    ),
                    array(
                        'key' => 'field_5c37250ebb9ea',
                        'label' => 'Titel',
                        'name' => 'block_us_iconbox_title',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 1,
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
                        'key' => 'field_5c37250ebba23',
                        'label' => 'Text',
                        'name' => 'block_us_iconbox_text',
                        'type' => 'wysiwyg',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'tabs' => 'all',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                        'delay' => 0,
                    ),
                    array(
                        'key' => 'field_5c37250ebba5c',
                        'label' => 'Text auf Button',
                        'name' => 'block_us_iconbox_btntext',
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
                        'key' => 'field_5c37250ebba95',
                        'label' => 'Link',
                        'name' => 'block_us_iconbox_link',
                        'type' => 'link',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-iconbox',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'field',
                'hide_on_screen' => '',
                'active' => 1,
                'description' => '',
            ));
            
            endif;
    }
}
$block_us_iconbox = new block_us_iconbox();