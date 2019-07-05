<?php

class block_us_faq{

    function __construct(){
        add_action('acf/init', array($this, "block_us_faq_register"));
    }

    public function block_us_faq_register(){
        $this->block_us_faq_fields();
        acf_register_block(array(
            'name'				=> 'block_us_faq',
            'title'				=> __('Accordion', "uslang"),
            'description'		=> __('erzeugt einen Accordion-Block', "uslang"),
            'render_callback'	=> array($this, 'block_us_faq_render'),
            'category'		=> 'usblocks',
            'icon'			=> '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars" class="svg-inline--fa fa-bars fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M16 132h416c8.837 0 16-7.163 16-16V76c0-8.837-7.163-16-16-16H16C7.163 60 0 67.163 0 76v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16zm0 160h416c8.837 0 16-7.163 16-16v-40c0-8.837-7.163-16-16-16H16c-8.837 0-16 7.163-16 16v40c0 8.837 7.163 16 16 16z"></path></svg>',
            'keywords'		=> array("article", "featured"),
            'enqueue_assets' => function(){
                //wp_enqueue_style( 'block-us-faq', get_template_directory_uri()."/inc/blocks/faq/faq.css");
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
            $theHTML = '<div class="block_us_faq margin-bottom-30 cb_accordion '.$alignclass.'" id="'.$blockid.'"><div class="accordion">';
            $i = 0;
            foreach($faqs AS $faq){
                $theHTML .= '<h3 class="'.(($faqFirstOpen && !$i) ? ' ui-accordion-header-active ui-state-active' : '').'">';
                $theHTML .= $faq["question"].'</h3>';
                $theHTML .= '<div class="ui-accordion-content '.(($faqFirstOpen && !$i) ? ' ui-accordion-content-active" style="display: block;"' : '"').'>'.apply_filters('the_content', $faq["answer"]).'</div>';

                $i++;
            }
            $theHTML .= '</div></div>';
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
                        'label' => 'erste Überschrift/Frage geöffnet?',
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
                        'label' => 'Inhalt',
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
                        'button_label' => 'Überschrift/Frage hinzufügen',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5c1f391217036',
                                'label' => 'Überschrift/Frage',
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
                                'label' => 'Text/Antwort',
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