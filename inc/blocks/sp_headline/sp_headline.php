<?php

class block_us_sp_headline{

    function __construct(){
        add_action('acf/init', array($this, "block_us_sp_headline_register"));
    }

    public function block_us_sp_headline_register(){
        $this->block_us_sp_headline_fields();
        acf_register_block(array(
            'name'				=> 'block_us_sp_headline',
            'title'				=> __('Seiten Header', "uslang"),
            'description'		=> __('Setzt Header-Bild, Überschrift und 1. Absatz (Auszug) korrekt ein.', "uslang"),
            'render_callback'	=> array($this, 'block_us_sp_headline_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'admin-customizer',
            'align'         => 'full',
            'supports'      => array('align' => array("full"), 'multiple' => false),
            'keywords'		=> array("icon", "image", "text"),
            'post_types'    => array("teilprojekt","page","post","partner","events"),
            'mode'          => 'preview'
        ));
        
        add_editor_style("inc/blocks/sp_headline/sp_headline.css");
    }

    public function block_us_sp_headline_render($block, $content = '', $is_preview = false, $postid){
        $post = get_post($postid);
        $heroimage = get_field('block_us_sp_headline_heroimage');
        $blockid = 'block_sp_headline-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = $block['align'] ? 'align' . $block['align'] : '';
        $block['align'] = "full";
		$alignclass = "alignfull";
        $p = get_field("project",$post->ID);
        $c = "";
        /*if(\is_admin()){
            $c .= '<div class="block_related '.$alignclass.'" id="'.$blockid.'">';
                $c .= '<h3>Dieser Block setzt die Hauptüberschrift korrekt ein.</h3>';
                $c .= '<div class="usdc_text">Für diesen Block gibt es keine Vorschau!</div>';
            $c .= '</div>';
            echo $c;
            return;
        }*/
        //echo "<pre>".print_r($p,1)."</pre>";
        $tepo = "";
        if(get_post_type($post) == "post"){
            //$tp = get_field("teilprojekt",$post);

        }
        if(!\is_admin()) wp_enqueue_style("block_sp_headline_style", get_template_directory_uri()."/inc/blocks/sp_headline/sp_headline.css");
        echo '<div class="block_sp_headline post-header-container '.$alignclass.'" id="'.$blockid.'">';
        if($heroimage){
            echo '<div class="hero">';
            $return .= '<picture>';
				$return .= '<source media="(min-width: 1400px)" srcset="'.$heroimage["sizes"]["heroimage_full"].'">';
				$return .= '<source media="(min-width: 660px)" srcset="'.$heroimage["sizes"]["heroimage_wide"].' 1x, '.$heroimage["sizes"]["slide_desktop_full"].' 2x">';
				$return .= '<source srcset="'.$heroimage["sizes"]["heroimage_full"].'">';
				$return .= '<img src="'.$heroimage["sizes"]["heroimage_full"].'" alt="'.get_the_title($post).'">';
            $return .= '</picture>';
            echo $return;
            echo '</div>';
        }
        $subtitle = get_field("subtitle", $post->ID);
        if (($p && $p["value"] != "none" && $p["label"])) $subtitle = $p["label"];
		echo '<div class="post-header">';
		echo '<div class="center">';
            if ($p && $p["value"] != "none" && $p["value"] && get_post_type($post) == "teilprojekt") {
                echo '<div class="project">';
                echo '<div class="project-image '.$p["value"].'">';
                echo '<img class="image-responsive" src="'.get_field("svg", $post->ID).'" alt="'.$p["value"].'">';
                echo '</div>';
                echo '</div>';
            }
            echo '<div class="subtitle-divider-container">';
                if(is_single() && (get_post_type() == "post" || get_post_type() == "news" || get_post_type() == "events")){
                    echo '<div class="post-header-meta">';
                        if(get_post_type() != "events") echo '<div class="publishdate">'.get_the_date("", $post).'</div>';
                        if (get_post_type() == "post" && is_single()){
                            $categories = get_the_category();
                            $separator = ', ';
                            $output = '';
                            if ( ! empty( $categories ) ) {
                                echo '<div class="post-categories">';
                                foreach( $categories as $category ) {
                                    $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( sprintf( __( 'Alle Beiträge der Kategorie: %s', 'uslang' ), $category->name ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
                                }
                                echo trim( $output, $separator );
                                echo '</div>';
                            }
                        }
                        if (get_post_type() == "events") {
                            $eventtype = get_field("type", $post);
                            echo '<div class="eventtype">'.$eventtype->name.'</div>';
                        }
                        //echo '<div class="sub-project"></div>';
                    echo '</div>';
                }
                echo '<h1 class="post-header-title">'.get_the_title($post).'</h1>';
                if ($p && $p["value"] != "none" && $p["value"]  && get_post_type($post) == "teilprojekt") {
                    echo '<div class="subtitle-divider '.$p["value"].'"></div>';
                }
            echo '</div>';
            $subtitle = get_field("subtitle", $post->ID);
            if (($p && $p["value"] != "none" && $p["label"]) && get_post_type($post) == "teilprojekt") $subtitle = $p["label"];
            if(!empty($subtitle)) {
                echo '<h2 class="post-header-subtitle">'.$subtitle.'</h2>';
            }
            if(get_post_type($post) != "post" && get_post_type($post) != "events" && !empty($post->post_excerpt)) echo '<p class="post-header-excerpt">'.get_the_excerpt($post).'</p>';
            if(get_post_type($post) == "events"){
                $from = get_field("from_date", $post); $to = get_field("to_date", $post);
                $from_time = get_field("from_time", $post); $to_time = get_field("to_time", $post);
                if(($from != $to && empty($to)) || ($from == $to && !empty($to))){
                    $ft = strftime("%d. %B %Y", strtotime($from));
                    if($from_time && $to_time){
                        $ft .= " ".__("von", "uslang")." ".$from_time." ".__("bis", "uslang")." ".$to_time." ".__("Uhr", "uslang");
                        //echo "hmmm 1";
                    }elseif($from_time && !$to_time){
                        $ft .= " ".__("ab", "uslang")." Uhr";
                        //echo "hmmm 2";
                    }else{
                        //echo "hmmm 3: $from_time - $to_time - ".get_field("from_time", $box);
                    }
                }elseif($from != $to && !empty($to)){
                    $my = strftime("%m%Y", strtotime($from)) == strftime("%m%Y", strtotime($to)) ? 1 : 0;
                    if($my){
                        $ft = strftime("%d.",strtotime($from))." - ".strftime("%d. %B %Y", strtotime($to));
                        if($from_time && $to_time){
                            $ft .= " ".__("von", "uslang")." ".$from_time." ".__("bis", "uslang")." ".$to_time." ".__("Uhr", "uslang");
                        }elseif($from_time && !$to_time){
                            $ft .= " ".__("ab", "uslang")." Uhr";
                        }
                    }else{
                        $ft = strftime("%d. %B %Y",strtotime($from))." - ".strftime("%d. %B %Y", strtotime($to));
                    }
                }
                echo '<div class="post-event-container">';
                    echo '<div class="event-time"><i class="far fa-calendar-day"></i> <time>'.$ft.'</time></div>';
                    echo '<div class="event-place"><i class="fas fa-map-marker-alt"></i> '.esc_html(get_field("place", $post)).'</div>';
                    $ki = get_field("info", $post); $kis = array();
                    if(is_array($ki) && count($ki)){
                        foreach($ki AS $kio){
                            array_push($kis, $kio->name);
                        }
                        echo '<div class="event-info"><i class="far fa-info-square"></i> '.implode(", ", $kis).'</div>';
                    }
                echo '</div>';
            }
        echo '</div>';
		echo '</div>';
		echo '</div>';
    }

    public function block_us_sp_headline_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5cab5caa4199b',
                'title' => 'Block: Page-Header',
                'fields' => array(
                    array(
                        'key' => 'field_5cab5cbb2dcdb',
                        'label' => 'Bild',
                        'name' => 'block_us_sp_headline_heroimage',
                        'type' => 'image',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'preview_size' => 'slide_desktop',
                        'library' => 'all',
                        'min_width' => 1400,
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => 4000,
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => 'jpg,png,jpeg',
                        'wpml_cf_preferences' => 0,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-sp-headline',
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
$block_us_sp_headline = new block_us_sp_headline();
