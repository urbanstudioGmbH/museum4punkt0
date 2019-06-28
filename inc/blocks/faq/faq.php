<?php

class block_us_faq{

    function __construct(){
        add_action('acf/init', array($this, "block_us_faq_register"));
    }

    public function block_us_faq_register(){
        $this->block_us_faq_fields();
        acf_register_block(array(
            'name'				=> 'block_us_faq',
            'title'				=> __('FAQ', "uslang"),
            'description'		=> __('erzeugt einen FAQ-Block', "uslang"),
            'render_callback'	=> array($this, 'block_us_faq_render'),
            'category'		=> 'usblocks',
            'icon'			=> '<svg aria-hidden="true" data-prefix="fas" data-icon="question" class="svg-inline--fa fa-question fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M202.021 0C122.202 0 70.503 32.703 29.914 91.026c-7.363 10.58-5.093 25.086 5.178 32.874l43.138 32.709c10.373 7.865 25.132 6.026 33.253-4.148 25.049-31.381 43.63-49.449 82.757-49.449 30.764 0 68.816 19.799 68.816 49.631 0 22.552-18.617 34.134-48.993 51.164-35.423 19.86-82.299 44.576-82.299 106.405V320c0 13.255 10.745 24 24 24h72.471c13.255 0 24-10.745 24-24v-5.773c0-42.86 125.268-44.645 125.268-160.627C377.504 66.256 286.902 0 202.021 0zM192 373.459c-38.196 0-69.271 31.075-69.271 69.271 0 38.195 31.075 69.27 69.271 69.27s69.271-31.075 69.271-69.271-31.075-69.27-69.271-69.27z"></path></svg>',
            'keywords'		=> array("article", "featured"),
            'enqueue_assets' => function(){
                wp_enqueue_style( 'block-us-faq', get_template_directory_uri()."/inc/blocks/faq/faq.css");
                wp_enqueue_script( 'block-us-faq', get_template_directory_uri()."/inc/blocks/faq/faq.js", array('jquery'), '', true );
            }
        ));
        //add_editor_style("inc/blocks/faq/faq.css");
    }

    public function block_us_faq_render($block, $content = '', $is_preview = false){
        $faqs = get_field('block_us_faq_index');
        $faqFirstOpen = get_field("block_us_faq_fo");
        $blockid = 'block_faq-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = $block['align'] ? 'align' . $block['align'] : '';
        if (!\is_admin()) {
            //wp_enqueue_style("block_us_faq", get_template_directory_uri()."/inc/blocks/faq/faq.css");
            //wp_enqueue_script("block_us_faq", get_template_directory_uri()."/inc/blocks/faq/faq.js");
        }
        $c = "";

        if($faqs && count($faqs)){
            $theHTML = '<div class="block_us_faq margin-bottom-30 '.$alignclass.'" id="'.$blockid.'">';
            $i = 0;
            foreach($faqs AS $faq){
                $theHTML .= '<div class="faq-item'.(($faqFirstOpen && !$i) ? ' active' : '').'">';
                    $theHTML .= '<div class="faq-question">'.$faq["question"].'<div class="arrow"><i class="fa fa-chevron-left" aria-hidden="true"></i></div></div>';
                    $theHTML .= '<div class="faq-answer"'.(($faqFirstOpen && !$i) ? ' style="display: block;"' : '').'>'.apply_filters('the_content', $faq["answer"]).'</div>';
                $theHTML .= '</div>';
                $i++;
            }
            $theHTML .= '</div>';
            $c .= $theHTML;
        }else{
            if(\is_admin()){
                $c .= '<div class="block_us_faq '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passe diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
            }
        }
        echo $c;
    }

    public function block_us_faq_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5c1f38bc82857',
                'title' => 'Block: FAQ',
                'fields' => array(
                    array(
                        'key' => 'field_5c1f38ca17034',
                        'label' => 'erstes Frage geöffnet?',
                        'name' => 'block_us_faq_fo',
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
                        'default_value' => 0,
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ),
                    array(
                        'key' => 'field_5c1f38f417035',
                        'label' => 'Fragen / Antworten',
                        'name' => 'block_us_faq_index',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'collapsed' => '',
                        'min' => 0,
                        'max' => 0,
                        'layout' => 'block',
                        'button_label' => 'Frage hinzufügen',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5c1f391217036',
                                'label' => 'Frage',
                                'name' => 'question',
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
                                'key' => 'field_5c1f392d17037',
                                'label' => 'Antwort',
                                'name' => 'answer',
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
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-faq',
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
$block_us_faq = new block_us_faq();