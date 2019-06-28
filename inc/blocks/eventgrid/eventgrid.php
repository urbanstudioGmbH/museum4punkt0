<?php

class block_us_eventgrid{

    function __construct(){
        add_action('acf/init', array($this, "block_us_eventgrid_register"));
    }

    public function block_us_eventgrid_register(){
        $this->block_us_eventgrid_fields();
        acf_register_block(array(
            'name'				=> 'block_us_eventgrid',
            'title'				=> __('Grid: Events', "uslang"),
            'description'		=> __('erzeugt einen Block, mit dem man eine Liste mit Event-Beiträgen anlegen kann.', "uslang"),
            'render_callback'	=> array($this, 'block_us_eventgrid_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'grid-view',
            'mode'          => 'preview',
            'align'         => 'full',
            'keywords'		=> array("article", "related"),
            'supports'     => array('align' => array("full"))
        ));
        add_editor_style("inc/blocks/eventgrid/eventgrid.css");
    }

    public function block_us_eventgrid_render($block, $content = '', $is_preview = false){
        $hl = get_field('block_us_eventgrid_headline');
        $type = get_field('block_us_eventgrid_type');
        $count = get_field('block_us_eventgrid_count');
        $currentpast = get_field('block_us_eventgrid_currentpast');
        $masonry = get_field('block_us_eventgrid_masonry');
        $setbg = get_field('block_us_eventgrid_setbg');
        $btn = get_field('block_us_eventgrid_morebtn'); // show 0|1 // text "Alle Einträge anzeigen"
        $blockid = 'block_eventgrid-' . $block['id'];
        //echo $type;
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = 'alignfull';
        if($type == "past"){
            $posts = get_posts(
                array(
                    'post_type' => "events",
                    'post_status'      => 'publish',
                    'suppress_filters' => true,
                    'meta_query' => array(
                        'relation' => 'OR',
                        array(
                            'relation' => 'AND',
                            array(
                                'key' => 'from_date',
                                'value' => date("Y-m-d"),
                                'compare' => '<',
                            ),
                            array(
                                'key' => 'to_date',
                                'value' => '',
                                'compare' => '==',
                            )
                        ),
                        array(
                            'relation' => 'AND',
                            array(
                                'key' => 'from_date',
                                'value' => date("Y-m-d"),
                                'compare' => '<',
                                'type' => "DATE"
                            ),
                            array(
                                'key' => 'to_date',
                                'value' => '',
                                'compare' => '!=',
                                'type' => "DATE"
                            ),
                            array(
                                'key' => 'to_date',
                                'value' => date("Y-m-d"),
                                'compare' => '<',
                                'type' => "DATE"
                            )
                        ),
                    ),
                    'orderby' => 'date',
                    'order'  => 'DESC',
                    'numberposts' => $count,
                )
            );
        }elseif($type == "current"){
            $posts = get_posts(
                array(
                    'post_type' => "events",
                    'post_status'      => 'publish',
                    'suppress_filters' => true,
                    'meta_query' => array(
                        'relation' => 'OR',
                        array(
                            'key' => 'from_date',
                            'value' => date("Y-m-d"),
                            'type' => "DATE",
                            'compare' => '>=',
                        ),
                        array(
                            'relation' => 'AND',
                            array(
                                'key' => 'to_date',
                                'value' => '',
                                'compare' => '!=',
                                'type' => "DATE"
                            ),
                            array(
                                'key' => 'to_date',
                                'value' => date("Y-m-d"),
                                'compare' => '>=',
                                'type' => "DATE"
                            )
                        ),
                    ),
                    'orderby' => 'date',
                    'order'  => 'ASC',
                    'numberposts' => ($count ? $count : 3),
                )
            );
            $cp = count($posts);
            if ($cp < $count && $currentpast) {
                $cc = $count-$cp;
                $posts2 = get_posts(
                    array(
                        'post_type' => "events",
                        'post_status'      => 'publish',
                        'suppress_filters' => true,
                        'meta_query' => array(
                            'relation' => 'OR',
                            array(
                                'relation' => 'AND',
                                array(
                                    'key' => 'from_date',
                                    'value' => date("Y-m-d"),
                                    'compare' => '<',
                                ),
                                array(
                                    'key' => 'to_date',
                                    'value' => '',
                                    'compare' => '==',
                                )
                            ),
                            array(
                                'relation' => 'AND',
                                array(
                                    'key' => 'from_date',
                                    'value' => date("Y-m-d"),
                                    'compare' => '<',
                                    'type' => "DATE"
                                ),
                                array(
                                    'key' => 'to_date',
                                    'value' => '',
                                    'compare' => '!=',
                                    'type' => "DATE"
                                ),
                                array(
                                    'key' => 'to_date',
                                    'value' => date("Y-m-d"),
                                    'compare' => '<',
                                    'type' => "DATE"
                                )
                            ),
                        ),
                        'orderby' => 'date',
                        'order'  => 'DESC',
                        'numberposts' => $cc,
                    )
                );
                $posts = array_merge($posts, $posts2);
            }
        }else {
            // Events
            $posts = get_posts(
                array(
                    'post_type' => "events",
                    'post_status'      => 'publish',
                    'suppress_filters' => true,
                    'meta_query' => array(
                        'relation' => 'OR',
                        array(
                            'key' => 'from_date',
                            'value' => date("Y-m-d"),
                            'compare' => '>=',
                            'type' => "DATE"
                        ),
                        array(
                            'relation' => 'AND',
                            array(
                                'key' => 'to_date',
                                'value' => '',
                                'compare' => '!=',
                                'type' => "DATE"
                            ),
                            array(
                                'key' => 'to_date',
                                'value' => date("Y-m-d"),
                                'compare' => '>=',
                                'type' => "DATE"
                            )
                        ),
                    ),
                    'orderby' => 'date',
                    'order'  => 'ASC',
                    'numberposts' => ($count ? $count : 3),
                )
            );
            $cp = count($posts);
            if($cp < $count){
                $cc = $count-$cp;
                $posts2 = $posts = get_posts(
                    array(
                        'post_type' => "events",
                        'post_status'      => 'publish',
                        'suppress_filters' => true,
                        'meta_query' => array(
                            'key' => 'to_date',
                            'value' => date("Y-m-d"),
                            'compare' => '<',
                            'type' => "DATE"
                        ),
                        'orderby' => 'date',
                        'order'  => 'DESC',
                        'numberposts' => $cc,
                    )
                );
                $posts = array_merge($posts,$posts2);
            }
        }
        $c = "";
        //if(\is_admin()) add_editor_style("inc/blocks/eventgrid/eventgrid.css");
        wp_enqueue_style("block_eventgrid_style", get_template_directory_uri()."/inc/blocks/eventgrid/eventgrid.css");
        if($posts){

            echo '<div class="block_eventgrid event-grid-container '.$type.' '.($setbg ? 'has-background' : '').' '.$alignclass.'" id="'.$blockid.'">';
                echo '<div class="center blog">';
                    if($hl && !empty($hl)) echo '<div class="gridheadline"><h2>'.$hl.'</h2></div>';
                    echo '<div class="blog-list'.($masonry ? " masonry" : "").'">';
                    if($masonry){
                        echo '<div class="grid-sizer"></div>';
			            echo '<div class="gutter-sizer"></div>';
                    }
                    if($posts){
                        foreach($posts as $i => $box){
                            $tp = get_field("teilprojekt",$box); $pp = "";
                            if($tp){
                                $p = get_field("project", $tp);
                                $pp = $p["value"];
                            }
                            echo '<article class="article loop '.$pp.'">';
                                echo '<div class="image">';
                                    $tnid = get_post_thumbnail_id($box->ID);
                                    if ($masonry) {
                                        $srcset = wp_get_attachment_image_srcset($tnid, array(1024,640));
                                        $src = wp_get_attachment_image_url($tnid, 'thumbnail');
                                    }else{
                                        $srcset = wp_get_attachment_image_srcset($tnid, 'gallery_preview_2x');
                                        $src = wp_get_attachment_image_url($tnid, 'gallery_preview_1x');
                                    }
                                    echo '<a href="'.get_the_permalink($box).'" title="'.esc_attr(get_the_title($box)).'">';
                                        echo '<img class="image-responsive blog-imageItem" src="'.$src.'" srcset="'.$srcset.'" alt="'.esc_attr(get_the_title($box)).'">';
                                    echo '</a>';
                                echo '</div>';
                                echo '<div class="content">';
                                    $eventtype = get_field("type",$box);
                                    $et = $eventtype->name;
                                    echo '<h4 class="event-type">'.$et.'</h4>';
                                     echo '<h3 class="article-title"><a href="'.get_the_permalink($box).'" title="'.esc_attr(get_the_title($box)).'">'.esc_html(get_the_title($box)).'</a></h3>';
                                    $from = get_field("from_date", $box); $to = get_field("to_date", $box);
                                    $from_time = get_field("from_time", $box); $to_time = get_field("to_time", $box);
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
                                    echo '<time class="event-time">'.$ft.'</time>';
                                    $ki = get_field("info", $box);
                                    echo '<div class="event kurzinfo">'.$ki->name.'</div>';
                                    echo '<div class="event place"><strong>'.esc_html(get_field("place", $box)).'</strong></div>';
                                echo '</div>';
                            echo '</article>';
                        }
                    }else{
                        echo "no posts";
                    }
                    echo '</div>';
                    if(isset($btn["show"]) && $btn["show"] && $count > -1){
                        $url = get_home_url()."/mitmachen/events/";
                        echo '<div class="call-to-action-container">';
                            echo '<a class="btn btn-primary" href="'.esc_url($url).'" title="'.esc_attr($btn["text"]).'" target="_self">'.esc_html($btn["text"]).'</a>';
                        echo '</div>';
                    }
                echo '</div>';
            echo '</div>';
            if($masonry){
                wp_enqueue_script("us-imagesloaded", get_template_directory_uri()."/js/imagesloaded.pkgd.min.js", array( 'jquery' ));
                wp_enqueue_script("us-masonry", get_template_directory_uri()."/js/masonry.pkgd.min.js", array( 'jquery','us-imagesloaded' ));

                $inlinescript = <<<EOF
                    jQuery(document).ready(function(){
                        imagesLoaded( '.masonry', function() {
                            var msnry = jQuery('.masonry').masonry({
                                // options
                                columnWidth: '.loop',
                                itemSelector: '.loop',
                                percentPosition: true,
                                gutter: '.gutter-sizer'
                            });
                            msnry.masonry('layout');
                        });
                    });
EOF;
                wp_add_inline_script("us-masonry", $inlinescript);
            }
            wp_reset_query();
        }else{
            if(\is_admin()){
                $c .= '<div class="block_eventgrid '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passen Sie diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
                echo $c;
            }else{
                
            }
        }
    }

    public function block_us_eventgrid_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5cae28abbdce5',
                'title' => 'Block: Eventgrid',
                'fields' => array(
                    array(
                        'key' => 'field_5cae28abd24d3',
                        'label' => 'Überschrift',
                        'name' => 'block_us_eventgrid_headline',
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
                        'key' => 'field_5cae28abd2527',
                        'label' => 'Typ',
                        'name' => 'block_us_eventgrid_type',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            'past' => 'Vergangene',
                            'current' => 'Aktuelle',
                            'all' => 'Alle',
                        ),
                        'allow_null' => 0,
                        'default_value' => 'post',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                    ),
                    array(
                        'key' => 'field_5cae28abd2578',
                        'label' => 'Anzahl Einträge',
                        'name' => 'block_us_eventgrid_count',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'choices' => array(
                            3 => '3',
                            6 => '6',
                            9 => '9',
                            -1 => 'Alle',
                        ),
                        'allow_null' => 0,
                        'default_value' => 3,
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                    ),
                    array(
                        'key' => 'field_5cbe9a921ef4e',
                        'label' => 'Mit vergangenen auffüllen?',
                        'name' => 'block_us_eventgrid_currentpast',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_5cae28abd2527',
                                    'operator' => '==',
                                    'value' => 'current',
                                ),
                                array(
                                    'field' => 'field_5cae28abd2578',
                                    'operator' => '==',
                                    'value' => '3',
                                ),
                            ),
                        ),
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
                        'key' => 'field_5cbe9b361ef51',
                        'label' => 'als Masonry anzeigen?',
                        'name' => 'block_us_eventgrid_masonry',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_5cae28abd2578',
                                    'operator' => '!=',
                                    'value' => '3',
                                ),
                            ),
                        ),
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
                        'key' => 'field_5cae28abd25c7',
                        'label' => 'Grau hinterlegen?',
                        'name' => 'block_us_eventgrid_setbg',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'wpml_cf_preferences' => 0,
                        'message' => '',
                        'default_value' => 0,
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ),
                    array(
                        'key' => 'field_5cae28abd2616',
                        'label' => '"Mehr zeigen"-Button',
                        'name' => 'block_us_eventgrid_morebtn',
                        'type' => 'group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_5cae28abd2578',
                                    'operator' => '!=',
                                    'value' => '-1',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'wpml_cf_preferences' => 0,
                        'layout' => 'block',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5cae28abdca71',
                                'label' => 'Button anzeigen?',
                                'name' => 'show',
                                'type' => 'true_false',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'wpml_cf_preferences' => 0,
                                'message' => '',
                                'default_value' => 0,
                                'ui' => 1,
                                'ui_on_text' => '',
                                'ui_off_text' => '',
                            ),
                            array(
                                'key' => 'field_5cae28abdcacc',
                                'label' => 'Beschriftung',
                                'name' => 'text',
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
                                'default_value' => 'Alle Einträge anzeigen',
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
                            'value' => 'acf/block-us-eventgrid',
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
$block_us_eventgrid = new block_us_eventgrid();
