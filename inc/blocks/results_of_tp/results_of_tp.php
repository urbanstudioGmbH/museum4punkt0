<?php

class block_us_results{

    function __construct(){
        add_action('acf/init', array($this, "block_us_results_register"));
    }

    public function block_us_results_register(){
        $this->block_us_results_fields();
        acf_register_block(array(
            'name'				=> 'block_us_results',
            'title'				=> __('Umsetzungsansätze', "uslang"),
            'description'		=> __('erzeugt einen Ergebnisse-Block', "uslang"),
            'render_callback'	=> array($this, 'block_us_results_render'),
            'category'		=> 'usblocks',
            'icon'			=> '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="sitemap" class="svg-inline--fa fa-sitemap fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M128 352H32c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32zm-24-80h192v48h48v-48h192v48h48v-57.59c0-21.17-17.23-38.41-38.41-38.41H344v-64h40c17.67 0 32-14.33 32-32V32c0-17.67-14.33-32-32-32H256c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h40v64H94.41C73.23 224 56 241.23 56 262.41V320h48v-48zm264 80h-96c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32zm240 0h-96c-17.67 0-32 14.33-32 32v96c0 17.67 14.33 32 32 32h96c17.67 0 32-14.33 32-32v-96c0-17.67-14.33-32-32-32z"></path></svg>',
            'keywords'		=> array("article", "featured"),
            'enqueue_assets' => function(){
                //wp_enqueue_style( 'block-us-faq', get_template_directory_uri()."/inc/blocks/faq/faq.css");
                //wp_enqueue_script( 'block-us-faq', get_template_directory_uri()."/inc/blocks/faq/faq.js", array('jquery'), '', true );
            }
        ));
        //add_editor_style("inc/blocks/faq/faq.css");
    }

    public function block_us_results_render($block, $content = '', $is_preview = false, $post_id){
           /* $lang = "de";
            if(defined("ICL_LANGUAGE_CODE")) { 
                $lang = ICL_LANGUAGE_CODE;
            }*/
            
            // get approaches from current post
            $approaches = get_field('approaches', $post_id);
            //echo $post_id;

            /*if ($lang === "de") {
                $fieldID = "5d0cdd8a69324";
            } else {
                $fieldID = "5d0cdd6b69323";
            }
            $field_key = "field_".$fieldID;
            $field = get_field_object($field_key);*/
            
            global $approachtitle;
            global $defaultresultterm;
            
            if( $approaches ): ?>
                <div class="cb_module cb_text">
                    <h2 class="approach-title"><?php echo $approachtitle;//$field["value"]; ?></h2>
                </div>
                <?php foreach( $approaches as $approach): // variable must be called $post (IMPORTANT) ?>
                    <?php //setup_postdata($post); 
                    

                    
                    $approachID = $approach->ID;
                    //echo $approachID;
                    ?>
                    
                    <div class="cb_module cb_text">
                        
                        <h3><?=$approach->post_title; ?></h3>
                        <p><?=$approach->post_content; ?></p>
                        <!--<a href="<?php the_permalink($approachID); ?>">Informationen zum Experiment</a>-->
                    </div>
                    <?php 

                    $args = array(
                        'post_type' => 'ergebnis',
                        'numberposts' => -1,
                        'post_status' => 'publish',
                        'meta_query'     => array(
                            array(
                                'key'     => 'approach',
                                'value'   => $approachID,
                                'compare' => '='
                            ),
                        )

                    );

                    $post_query = new WP_Query($args);

                    

                    if($post_query->have_posts() ) { ?>
                    <div class="cb_module cb_items alignfull">
                        <div class="center">
                            <div class="items slider">
                                <?php
                                    while($post_query->have_posts() ) {
                                        $post_query->the_post();
                                        setup_postdata($post); 
                                        $thumbnail = get_the_post_thumbnail_url(get_the_ID(),'thumbnail'); 
                                        
                                        include(get_template_directory() . '/template-parts/result-item.php');
                                        ?>
                                    
                                    <?php
                                } //wp_reset_postdata();
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php } 
                    
                endforeach; 
                
                
          wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly 
               
        else :

            
            if(\is_admin()){
                $c .= '<div class="block_us_faq '.$alignclass.'" id="'.$blockid.'" style="border:2px solid black; padding:0 20px 20px 20px;">';
                    $c .= '<h3>Umsetzungsansätze</h3>';
                    $c .= '<div class="usdc_text">Wählen Sie die Umsetzungsansätze für dieses Teilprojekt bitte am Ende der Seite aus. Die Umsetzungsansätze und Ergebnisse werden dann automatisch an dieser Stelle ausgegeben.</div>';
                $c .= '</div>';
                echo $c;
            }
       

        endif;
    

    }

    public function block_us_results_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5d0cddcd7e839',
                'title' => 'block_us_results',
                'fields' => array(
                    array(
                        'key' => 'field_5d0cddecabc67',
                        'label' => 'Mitteilung',
                        'name' => '',
                        'type' => 'message',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'message' => 'Hier werden die Umsetzungsansätze automatisch eingefügt. Die Ansätze können am Ende der Seite ausgewählt werden und unter "Umsetzungsansätze" im Hauptmenü bearbeitet werden.',
                        'new_lines' => 'wpautop',
                        'esc_html' => 0,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-results',
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
$block_us_results = new block_us_results();