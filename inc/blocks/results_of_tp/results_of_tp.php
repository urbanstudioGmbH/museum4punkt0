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
            'icon'			=> '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="copyright" class="svg-inline--fa fa-copyright fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M256 8C119.033 8 8 119.033 8 256s111.033 248 248 248 248-111.033 248-248S392.967 8 256 8zm117.134 346.753c-1.592 1.867-39.776 45.731-109.851 45.731-84.692 0-144.484-63.26-144.484-145.567 0-81.303 62.004-143.401 143.762-143.401 66.957 0 101.965 37.315 103.422 38.904a12 12 0 0 1 1.238 14.623l-22.38 34.655c-4.049 6.267-12.774 7.351-18.234 2.295-.233-.214-26.529-23.88-61.88-23.88-46.116 0-73.916 33.575-73.916 76.082 0 39.602 25.514 79.692 74.277 79.692 38.697 0 65.28-28.338 65.544-28.625 5.132-5.565 14.059-5.033 18.508 1.053l24.547 33.572a12.001 12.001 0 0 1-.553 14.866z"></path></svg>',
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
                $c .= '<div class="block_us_faq '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passe diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
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