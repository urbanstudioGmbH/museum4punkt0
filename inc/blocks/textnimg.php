<?php

class block_us_textnimg{

    function __construct(){
        add_action('acf/init', array($this, "block_us_textnimg_register"));
    }

    public function block_us_textnimg_register(){
        $this->block_us_textnimg_fields();
        acf_register_block(array(
            'name'				=> 'block_us_textnimg',
            'title'				=> __('Text & Bild', "uslang"),
            'description'		=> __('erzeugt einen Block, mit dem man Bild und Text in Spalten unterbringen kann', "uslang"),
            'render_callback'	=> array($this, 'block_us_textnimg_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'align-left',
            'align'         => 'full',
            'supports'      => array("align" => array("wide","full")),
            'keywords'		=> array("article", "image", "text")
        ));
    }

    public function block_us_textnimg_render($block, $content = '', $is_preview = false){
        $image = get_field('block_us_textnimg_image');
        $imgposition = get_field('block_us_textnimg_imgleftright');
        $title = get_field('block_us_textnimg_title');
        $text = get_field('block_us_textnimg_text');
        $btntext = get_field('block_us_textnimg_btntext');
        $link = get_field('block_us_textnimg_link');
        $bgcolor = get_field('block_us_textnimg_bgcolor');
        $fontcolor = get_field('block_us_textnimg_fontcolor');
        $verticalalign = get_field("block_us_textnimg_imgverticalalignment");

        $blockid = 'block_textnimg-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = $block['align'] ? 'align' . $block['align'] : 'alignfull';

        $c = "";
        wp_enqueue_style("block_textnimg_style", get_template_directory_uri()."/css/textnimg.css");
        if(is_array($image) && $title){
            $link_url = (!empty($link['url']) ? $link['url'] : "#");
            $link_title = (!empty($link['title']) ? $link['title'] : $title);
            $link_target = $link['target'] ? $link['target'] : '_self';
            $astart = '<a class="%s" href="'.esc_url($link_url).'" target="'.esc_attr($link_target).'" title="'.esc_attr($link_title).'">';
            $imgurl = esc_url($image["sizes"]["large"]);
            $imageCSS = <<<EOF
                #$blockid .hasImage {
                    background: url('$imgurl') no-repeat $verticalalign center; 
                    -webkit-background-size: cover;
                    -moz-background-size: cover;
                    -o-background-size: cover;
                    background-size: cover;
                    filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='$imgurl', sizingMethod='scale');
                    -ms-filter: "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='$imgurl', sizingMethod='scale')";
                }

EOF;
            echo '<style>'.$imageCSS.'</style>';
            wp_add_inline_style( '', $imageCSS );
            echo '<div class="block_textnimg '.$alignclass.' '.$fontcolor.'" id="'.$blockid.'" style="background-color:'.$bgcolor.';">';
                $ic = "";
                $ic .= sprintf($astart, "image");
                //$ic .= '<img src="'.esc_url($image["sizes"]["large"]).'" alt="'.esc_attr($link_title).'" title="'.esc_attr($link_title).'">';
                $ic .= '</a>';

                $tc = '<div class="textcontentbox">';
                $tc .= '<h2>'.sprintf($astart, "headline").$title.'</a></h2>';
                $tc .= '<div class="textholder">'.$text.'</div>';
                if(trim($btntext)) $tc .= sprintf($astart, "theme-button").$btntext.'</a>';
				$tc .= '</div>';

                echo '<div class="left'.($imgposition == "left" ? " hasImage" : " hasText").'">';
                    if($imgposition == "left"){
                        echo $ic;
                    }else{
                        echo sprintf($astart, "hidden-image").'<img src="'.esc_url($image["sizes"]["large"]).'" alt="'.esc_attr($link_title).'" title="'.esc_attr($link_title).'"></a>';
                        echo $tc;
                    }
                echo '</div>';
                echo '<div class="right'.($imgposition == "right" ? " hasImage" : " hasText").'">';
                    if($imgposition == "right"){
                        echo $ic;
                    }else{
                        echo sprintf($astart, "hidden-image").'<img src="'.esc_url($image["sizes"]["large"]).'" alt="'.esc_attr($link_title).'" title="'.esc_attr($link_title).'"></a>';
                        echo $tc;
                    }
                echo '</div>';
            //echo '<div class="clear"></div>';
			echo '</div>';
        }else{
            if(\is_admin()){
                $c .= '<div class="block_textnimg '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passe diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
                echo $c;
            }
        }
    }

    public function block_us_textnimg_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5c320ce729cca',
                'title' => 'Block: Bild + Text',
                'fields' => array(
                    array(
                        'key' => 'field_5c320cfb8f691',
                        'label' => 'Bild - Spalte',
                        'name' => '',
                        'type' => 'column',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'column-type' => '1_2',
                    ),
                    array(
                        'key' => 'field_5c320d098f692',
                        'label' => 'Bild',
                        'name' => 'block_us_textnimg_image',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'preview_size' => 'slide_desktop',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => '',
                    ),
                    array(
                        'key' => 'field_5c32119e1dbe9',
                        'label' => 'Ausrichtung des Bildes',
                        'name' => 'block_us_textnimg_imgleftright',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'left' => 'links',
                            'right' => 'rechts',
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => 'links',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_5c3f445911fc9',
                        'label' => 'Bild Ausschnitt',
                        'name' => 'block_us_textnimg_imgverticalalignment',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 1,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'top' => 'Oben',
                            'center' => 'Mitte',
                            'bottom' => 'Unten',
                        ),
                        'default_value' => array(
                            0 => 'center',
                        ),
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                        'return_format' => 'value',
                        'ajax' => 0,
                        'placeholder' => '',
                    ),
                    array(
                        'key' => 'field_5c320d6a8f693',
                        'label' => 'Text-Spalte',
                        'name' => '',
                        'type' => 'column',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'column-type' => '1_2',
                    ),
                    array(
                        'key' => 'field_5c32199e369a1',
                        'label' => 'Hintergrundfarbe',
                        'name' => 'block_us_textnimg_bgcolor',
                        'type' => 'color_picker',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                    ),
                    array(
                        'key' => 'field_5c3381ef06c7c',
                        'label' => 'Schriftfarbe',
                        'name' => 'block_us_textnimg_fontcolor',
                        'type' => 'select',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'dark' => 'dunkel',
                            'light' => 'hell',
                        ),
                        'default_value' => array(
                        ),
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 0,
                        'return_format' => 'value',
                        'ajax' => 0,
                        'placeholder' => '',
                    ),
                    array(
                        'key' => 'field_5c320d7a8f694',
                        'label' => 'Titel',
                        'name' => 'block_us_textnimg_title',
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
                        'key' => 'field_5c320d908f695',
                        'label' => 'Text',
                        'name' => 'block_us_textnimg_text',
                        'type' => 'wysiwyg',
                        'instructions' => '',
                        'required' => 1,
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
                        'key' => 'field_5c320dc18f696',
                        'label' => 'Text auf Button',
                        'name' => 'block_us_textnimg_btntext',
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
                        'key' => 'field_5c320e128f698',
                        'label' => 'Link',
                        'name' => 'block_us_textnimg_link',
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
                            'value' => 'acf/block-us-textnimg',
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
$block_us_textnimg = new block_us_textnimg();