<?php

class block_us_dropcap{

    function __construct(){
        add_action('acf/init', array($this, "block_us_dropcap_register"));
    }

    public function block_us_dropcap_register(){
        $this->block_us_dropcap_fields();
        acf_register_block(array(
            'name'				=> 'block_us_dropcap',
            'title'				=> __('Dropcap', "uslang"),
            'description'		=> __('Erster Buchstabe im erstern Absatz groß', "uslang"),
            'render_callback'	=> array($this, 'block_us_dropcap_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'editor-textcolor',
            'keywords'		=> array("article", "featured")
        ));
    }

    public function block_us_dropcap_render($block, $content = '', $is_preview = false){
        $theHTML = get_field('block_us_dropcap_html');
        $blockid = 'block_us_dropcap-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $align_class = $block['align'] ? 'align' . $block['align'] : '';
        $c = "";
        if($theHTML){
            $tmp = explode("<p>", $theHTML);
            if($tmp >= 2){
                $firstLetter = substr($tmp[1], 0, 1);
                $theReplace = $tmp[0].'<p><span class="initial">'.$firstLetter.'</span>';
                $num = strlen($tmp[0]."<p>$firstLetter");
                $theHTML = $theReplace.substr($theHTML, $num);
                //$theHTML = str_replace($tmp[0]."<p>$firstLetter", $theReplace, $theHTML);
            }
            $c .= '<div id="'.$blockid.'" class="block_us_dropcap_html '.$align_class.'">'.$theHTML.'</div>';
        }else{
            if(\is_admin()){
                $c .= '<div id="'.$blockid.'" class="block_us_dropcap_html '.$align_class.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passe diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
            }
        }
        echo $c;
    }

    public function block_us_dropcap_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5beefe920ef13',
                'title' => 'Block: Dropcap',
                'fields' => array(
                    array(
                        'key' => 'field_5beefe92e7a36',
                        'label' => __("Inhalt", "uslang"),
                        'name' => 'block_us_dropcap_html',
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
                            'value' => 'acf/block-us-dropcap',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'seamless',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => 1,
                'description' => '',
            ));
            
        endif;
    }
}
$block_us_dropcap = new block_us_dropcap();