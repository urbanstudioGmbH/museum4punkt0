<?php

class block_us_home{

    function __construct(){
        add_action('acf/init', array($this, "block_us_home_register"));
    }

    public function block_us_home_register(){
        $this->block_us_home_fields();
        acf_register_block(array(
            'name'				=> 'block_us_home',
            'title'				=> __('Startseite-Intro', "uslang"),
            'description'		=> __('erzeugt einen Startseite-Intro-Block', "uslang"),
            'render_callback'	=> array($this, 'block_us_home_render'),
            'category'		=> 'usblocks',
            'icon'			=> '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="copyright" class="svg-inline--fa fa-copyright fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm117.134 346.753c-1.592 1.867-39.776 45.731-109.851 45.731-84.692 0-144.484-63.26-144.484-145.567 0-81.303 62.004-143.401 143.762-143.401 66.957 0 101.965 37.315 103.422 38.904a12 12 0 0 1 1.238 14.623l-22.38 34.655c-4.049 6.267-12.774 7.351-18.234 2.295-.233-.214-26.529-23.88-61.88-23.88-46.116 0-73.916 33.575-73.916 76.082 0 39.602 25.514 79.692 74.277 79.692 38.697 0 65.28-28.338 65.544-28.625 5.132-5.565 14.059-5.033 18.508 1.053l24.547 33.572a12.001 12.001 0 0 1-.553 14.866z"></path></svg>',
            'keywords'		=> array("article", "featured"),
            'enqueue_assets' => function(){
                //wp_enqueue_style( 'block-us-faq', get_template_directory_uri()."/inc/blocks/faq/faq.css");
                //wp_enqueue_script( 'block-us-faq', get_template_directory_uri()."/inc/blocks/faq/faq.js", array('jquery'), '', true );
            }
        ));
        //add_editor_style("inc/blocks/faq/faq.css");
    }

    public function block_us_home_render($block, $content = '', $is_preview = false){
        
        ?>
        <div class="alignfull">
            <div class="center">
              <header class="intro">
                <h2><strong><?php the_field('leitfrage'); ?></strong> &mdash; <?php the_field('leitfrage_2'); ?></h2>

                <?php the_field('introtext'); ?>
              </header>
            
        
      <?php


        // check if the repeater field has rows of data
        if( have_rows('sections') ): 
           // loop through the rows of data
            while ( have_rows('sections') ) : the_row(); 
                

               ?>
              
                    
                <section class="grid">
                    <a href="<?php the_sub_field('link'); ?>">
                      <figure>
                        <img src="<?php the_sub_field('image'); ?>">
                      </figure>
                      <div>
                        
                        <h3><?php the_sub_field('sectionstitle') ?></h3>
                        <?php the_sub_field('content'); ?>
                        <span class="arrow-right"><?php the_sub_field('link_name'); ?></span>
                      </div>
                    </a>
                  </section>
                <?php
                 
                
                endwhile; ?>
            
        <?php else :

            
            if(\is_admin()){
                $c .= '<div class="block_us_faq '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passe diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
                echo $c;
            }
       

        endif; ?>

        </div>
      </div>

      <?php
    

    }

    public function block_us_home_fields(){
        
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5d09fe45ef5dd',
                'title' => 'Startseite',
                'fields' => array(
                    array(
                        'key' => 'field_5d09fe5d0d9bc',
                        'label' => 'Leitfrage',
                        'name' => 'leitfrage',
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
                        'key' => 'field_5d09fe6f0d9bd',
                        'label' => 'Leitfrage (zweiter Teil)',
                        'name' => 'leitfrage_2',
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
                        'key' => 'field_5d09fe880d9be',
                        'label' => 'Introtext',
                        'name' => 'introtext',
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
                        'new_lines' => 'wpautop',
                    ),
                    array(
                        'key' => 'field_5d09fe970d9bf',
                        'label' => 'Sektionen',
                        'name' => 'sections',
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
                        'button_label' => '',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5d09fec20d9c0',
                                'label' => 'Bild',
                                'name' => 'image',
                                'type' => 'image',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'return_format' => 'url',
                                'preview_size' => 'thumbnail',
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
                                'key' => 'field_5d09fed90d9c1',
                                'label' => 'Sektionstitle',
                                'name' => 'sectionstitle',
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
                                'key' => 'field_5d09fee60d9c2',
                                'label' => 'Sektionsinhalt',
                                'name' => 'content',
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
                                'new_lines' => 'wpautop',
                            ),
                            array(
                                'key' => 'field_5d0a02f2ac952',
                                'label' => 'Sektionslink Name',
                                'name' => 'link_name',
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
                                'key' => 'field_5d09ff080d9c3',
                                'label' => 'Sektionslink',
                                'name' => 'link',
                                'type' => 'page_link',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'post_type' => array(
                                    0 => 'page',
                                ),
                                'taxonomy' => '',
                                'allow_null' => 0,
                                'allow_archives' => 1,
                                'multiple' => 0,
                            ),
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-home',
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
            /*
                'location' => array(
                    array(
                        array(
                            'param' => 'page_type',
                            'operator' => '==',
                            'value' => 'front_page',
                        ),
                    ),
                ),
                */
            endif;
    }
}

$block_us_home = new block_us_home();