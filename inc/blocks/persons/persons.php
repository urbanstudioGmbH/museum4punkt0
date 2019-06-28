<?php

class block_us_persons{

    function __construct(){
        add_action('acf/init', array($this, "block_us_persons_register"));
    }

    public function block_us_persons_register(){
        $this->block_us_persons_fields();
        acf_register_block(array(
            'name'				=> 'block_us_persons',
            'title'				=> __('Personen', "uslang"),
            'description'		=> __('erzeugt einen Block, mit dem man eine Liste von Personen aus Kontakten erstellen kann.', "uslang"),
            'render_callback'	=> array($this, 'block_us_persons_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'id',
            'keywords'		=> array("article", "related"),
            'supported'     => array('align' => false)
        ));
        add_editor_style("inc/blocks/persons/persons.css");
    }

    public function block_us_persons_render($block, $content = '', $is_preview = false){
        $theIndex = get_field('block_us_persons_index');
        $theTitle = get_field('block_us_persons_title');
        //echo $theIndex;
        //echo print_r($theIndex,1);
        $showPosition = 1;
        $showTelefon = 1;
        $showEmail = 1;
        $showUrl = 1;
        $blockid = 'block_persons-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = $block['align'] ? 'align' . $block['align'] : '';

        $c = "";
        wp_enqueue_style("block_persons_style", get_template_directory_uri()."/inc/blocks/persons/persons.css");
        //echo $theIndex;
        if($theIndex && is_array($theIndex) && count($theIndex)){
            echo '<div class="block_persons list-contacts '.$alignclass.'" id="'.$blockid.'">';
                if($theTitle && !empty($theTitle)) echo '<h2 class="list-contacts-title">'.$theTitle.'</h2>';
                echo '<div class="list-contacts-container">';
                //echo implode(",",$theIndex);
                $posts = get_posts(
                    array(
                        'post_type' => 'kontakt',
                        'include' => $theIndex,
                        'post_status'      => 'publish',
                        'suppress_filters' => true,
                        'orderby' => 'post__in',
                        'numberposts' => -1,
                    )
                );
                //echo print_r($posts,1);
                //echo ICL_LANGUAGE_CODE;
                if($posts){
                    foreach($posts as $i => $box){
                        $extrafields = get_field(strtolower(ICL_LANGUAGE_CODE), $box->ID);
                        echo '<div class="list-contacts-item">';
                            echo '<div class="list-contacts-picture">';
                                if (has_post_thumbnail($box->ID)) {
                                    $tnid = get_post_thumbnail_id($box->ID);
                                    $imagearr = wp_get_attachment_image_src($tnid, 'aboutbox');
                                    $image = $imagearr[0];
                                }else{
                                    $image = get_template_directory_uri()."/inc/blocks/persons/persons_default.jpg";
                                }
                                echo '<img class="image-responsive list-contacts-image-item" src="'.$image.'" alt="'.esc_attr(get_the_title($box)).'">';
                            echo '</div>';
                            echo '<div class="list-contacts-person-details">';
                                echo '<h3 class="list-contacts-name">'.esc_html(get_the_title($box)).'</h3>';
                                $position = $extrafields["postition"];
                                //echo "<pre>".print_r($extrafields,1)."</pre>";
                                //echo $extrafields["postition"];
                                if (!empty($position)) {
                                    echo '<p class="list-contacts-position">'.esc_html($position).'</p>';
                                }
                                $telefon = $extrafields["telefon"];
                                if (!empty($telefon)) {
                                    echo '<a class="list-contacts-fon" href="tel:'.esc_attr($telefon).'">'.esc_html($telefon).'</a>';
                                }
                                $email = $extrafields["email"];
                                if (!empty($email)) {
                                    echo '<a class="list-contacts-email" href="mailto:'.esc_attr($email).'">'.esc_html($email).'</a>';
                                }
                                $link = $extrafields["url"];
                                if ($link) {
                                    $link_target = $link['target'] ? $link['target'] : '_blank';
                                    echo '<a class="list-contacts-url" href="'.esc_attr($link["url"]).'" target="'.$link_target.'">'.esc_html($link["title"]).'</a>';
                                }
                            echo '</div>';
                        echo '</div>';

                    }
                }else{
                    echo "no posts";
                }
                echo '</div>';
            echo '</div>';
            wp_reset_query();
        }else{
            if(\is_admin()){
                $c .= '<div class="block_related '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passe diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
                echo $c;
            }
        }
    }

    public function block_us_persons_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5ca861f5677a2',
                'title' => 'Block: Persons',
                'fields' => array(
                    array(
                        'key' => 'field_5cab5950a9a2e',
                        'label' => 'Überschrift',
                        'name' => 'block_us_persons_title',
                        'type' => 'text',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'wpml_cf_preferences' => 0,
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'maxlength' => '',
                    ),
                    array(
                        'key' => 'field_5ca8620bbf153',
                        'label' => 'Personen zum Anzeigen auswählen',
                        'name' => 'block_us_persons_index',
                        'type' => 'post_object',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'post_type' => array(
                            0 => 'kontakt',
                        ),
                        'taxonomy' => '',
                        'allow_null' => 0,
                        'multiple' => 1,
                        'return_format' => 'id',
                        'wpml_cf_preferences' => 0,
                        'ui' => 1,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-persons',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'label',
                'hide_on_screen' => '',
                'active' => true,
                'description' => '',
            ));

            endif;
    }
}
$block_us_persons = new block_us_persons();
