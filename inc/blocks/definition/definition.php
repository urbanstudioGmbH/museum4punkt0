<?php

class block_us_definition{

    function __construct(){
        add_action('acf/init', array($this, "block_us_definition_register"));
    }

    public function block_us_definition_register(){
        $this->block_us_definition_fields();
        acf_register_block(array(
            'name'				=> 'block_us_definition',
            'title'				=> __('Definitionsliste', "uslang"),
            'description'		=> __('erzeugt einen Definitions-Block', "uslang"),
            'render_callback'	=> array($this, 'block_us_definition_render'),
            'category'		=> 'usblocks',
            'icon'			=> '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="list" class="svg-inline--fa fa-list fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M80 368H16a16 16 0 0 0-16 16v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16v-64a16 16 0 0 0-16-16zm0-320H16A16 16 0 0 0 0 64v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16V64a16 16 0 0 0-16-16zm0 160H16a16 16 0 0 0-16 16v64a16 16 0 0 0 16 16h64a16 16 0 0 0 16-16v-64a16 16 0 0 0-16-16zm416 176H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16zm0-320H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16V80a16 16 0 0 0-16-16zm0 160H176a16 16 0 0 0-16 16v32a16 16 0 0 0 16 16h320a16 16 0 0 0 16-16v-32a16 16 0 0 0-16-16z"></path></svg>',
            'keywords'		=> array("article", "featured"),
            'enqueue_assets' => function(){
                //wp_enqueue_style( 'block-us-faq', get_template_directory_uri()."/inc/blocks/faq/faq.css");
                //wp_enqueue_script( 'block-us-faq', get_template_directory_uri()."/inc/blocks/faq/faq.js", array('jquery'), '', true );
            }
        ));
        //add_editor_style("inc/blocks/faq/faq.css");
    }

    public function block_us_definition_render($block, $content = '', $is_preview = false){
        $content_before = get_field('content_before');
        $blockid = 'block_us_definition-' . $block['id'];
        // check if the repeater field has rows of data
        if( have_rows('block_us_definition_index') ): ?>
        <div class="block_us_definition cb_module cb_dlist" id="<?=$blockid; ?>">
            <?php if (!empty($content_before)): the_field('content_before');  endif; ?>
            <dl>
        <?php    // loop through the rows of data
            while ( have_rows('block_us_definition_index') ) : the_row(); 

                $dt = get_sub_field('definition_title');
                $dd = get_sub_field('definition');
                if ( !empty( $dt ) && !empty( $dd ) ):
                ?>

                <dt><span><?=$dt; ?></span></dt>
                <dd><?=$dd; ?></dd>

        <?php    
                endif;
                endwhile; ?>
            </dl>
        </div>
        <?php else :

            if(\is_admin()){
                $c .= '<div class="block_us_faq '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passe diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
                echo $c;
            }

        endif;
    

    }

    public function block_us_definition_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5d03b13484efb',
                'title' => 'block_us_definition',
                'fields' => array(
                    array(
                        'key' => 'field_5d03b4016f479',
                        'label' => 'Title & Text',
                        'name' => 'content_before',
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
                        'toolbar' => 'full',
                        'media_upload' => 1,
                        'delay' => 0,
                    ),
                    array(
                        'key' => 'field_5d03b14212409',
                        'label' => 'Definitionstabelle',
                        'name' => 'block_us_definition_index',
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
                        'layout' => 'table',
                        'button_label' => '',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5d03b15b1240a',
                                'label' => 'Definition Title',
                                'name' => 'definition_title',
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
                                'key' => 'field_5d03b16c1240b',
                                'label' => 'Definition',
                                'name' => 'definition',
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
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-definition',
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
$block_us_definition = new block_us_definition();