<?php

class block_us_textwithborder{

    function __construct(){
        add_action('acf/init', array($this, "block_us_textwithborder"));
    }

    public function block_us_textwithborder(){
        $this->block_us_textwithborder_fields();
        acf_register_block(array(
            'name'				=> 'block_us_textwithborder',
            'title'				=> __('Text mit Rahmen', "uslang"),
            'description'		=> __('Hiermit wird ein Textblock erstellt, der auch einen Rahmen haben kann.', "uslang"),
            'render_callback'	=> array($this, 'block_us_textwithborder_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'editor-textcolor',
            'keywords'		=> array("article", "featured")
        ));
    }

    public function block_us_textwithborder_render($block, $content = '', $is_preview = false){
        $theHTML = get_field('block_us_textwithborder_html'); // html
        $borderColor = get_field('block_us_textwithborder_bordercolor'); // Hex
        $borderThickness = get_field('block_us_textwithborder_borderthickness'); // fine | bold
        $borderThickness = !$borderThickness ? "fine" : $borderThickness;

        $blockid = 'block_us_textwithborder-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $align_class = $block['align'] ? 'align' . $block['align'] : '';

        $c = "";
        if($theHTML){
            $c .= '<div id="'.$blockid.'" class="block_us_textwithborder_html '.$borderThickness.' '.$align_class.'"'.($borderColor ? ' style="border-color:#000000;"' :'').'>'.$theHTML.'</div>';
        }else{
            if(\is_admin()){
                $c .= '<div id="'.$blockid.'" class="block_us_textwithborder_html '.$borderThickness.' '.$align_class.'">';
                    $c .= '<h3>'.__("Hinweis", "uslang").'</h3>';
                    $c .= '<div class="usdc_text">'.__("Wechseln Sie in den Bearbeiten-Modus oder passe diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.", "uslang").'</div>';
                $c .= '</div>';
            }
        }
        echo $c;
    }

    public function block_us_textwithborder_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5bf522f79d5c6',
                'title' => 'Block: Text mit Rahmen',
                'fields' => array(
                    array(
                        'key' => 'field_5bf5233f90b80',
                        'label' => __("Rahmenfarbe", "uslang"),
                        'name' => 'block_us_textwithborder_bordercolor',
                        'type' => 'color_picker',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ),
                        'default_value' => '',
                    ),
                    array(
                        'key' => 'field_5bf5238554aae',
                        'label' => __("Rahmenstärke", "uslang"),
                        'name' => 'block_us_textwithborder_borderthickness',
                        'type' => 'radio',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'fine' => 'Fine',
                            'bold' => 'Bold',
                        ),
                        'allow_null' => 0,
                        'other_choice' => 0,
                        'default_value' => 'fine',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                        'save_other_choice' => 0,
                    ),
                    array(
                        'key' => 'field_5bf523bd54aaf',
                        'label' => __("Inhalt", "uslang"),
                        'name' => 'block_us_textwithborder_html',
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
                        'toolbar' => 'Basic',
                        'media_upload' => 1,
                        'delay' => 0,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-textwithborder',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'seamless',
                'label_placement' => 'top',
                'instruction_placement' => 'field',
                'hide_on_screen' => '',
                'active' => 1,
                'description' => '',
            ));
            
            endif;
    }
}
$block_us_textwithborder = new block_us_textwithborder();