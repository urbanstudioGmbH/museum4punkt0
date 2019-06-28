<?php

class block_us_yearblock{

    function __construct(){
        add_action('acf/init', array($this, "block_us_yearblock_register"));
    }

    public function block_us_yearblock_register(){
        $this->block_us_yearblock_fields();
        acf_register_block(array(
            'name'				=> 'block_us_yearblock',
            'title'				=> __('Yearblock', "uslang"),
            'description'		=> __('erzeugt einen Block mit Jahreszahl und Text ', "uslang"),
            'render_callback'	=> array($this, 'block_us_yearblock_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'admin-customizer',
            'align'         => '',
            'supports'      => array("align" => array("wide","center")),
            'keywords'		=> array("icon", "image", "text")
        ));
    }

    public function block_us_yearblock_render($block, $content = '', $is_preview = false){
        $year = get_field('block_us_yearblock_year');
        $text = get_field('block_us_yearblock_text');

        $blockid = 'block_yearblock-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = $block['align'] ? 'align' . $block['align'] : '';

        $c = "";
        wp_enqueue_style("block_yearblock_style", get_template_directory_uri()."/css/yearblock.css");
        if($year && $text){
            echo '<div class="yearblock block_yearblock '.$alignclass.'" id="'.$blockid.'">';
                echo '<div class="yearblock_year">'.$year.'</div>';
                echo '<div class="yearblock_content">';
                    echo $text;
                echo '</div>';
			echo '</div>';
        }else{
            if(\is_admin()){
                $c .= '<div class="block_yearblock '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passen Sie diesen Block in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
                echo $c;
            }
        }
    }

    public function block_us_yearblock_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5c618fee87990',
                'title' => 'Block: Yearblock',
                'fields' => array(
                    array(
                        'key' => 'field_5c619001cdbcc',
                        'label' => 'Jahreszahl',
                        'name' => 'block_us_yearblock_year',
                        'type' => 'number',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'min' => 1800,
                        'max' => 2100,
                        'step' => 1,
                    ),
                    array(
                        'key' => 'field_5c61904bcdbcd',
                        'label' => 'Text',
                        'name' => 'block_us_yearblock_text',
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
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-yearblock',
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
$block_us_yearblock = new block_us_yearblock();