<?php

class block_us_bloggrid{

    function __construct(){
        add_action('acf/init', array($this, "block_us_bloggrid_register"));
    }

    public function block_us_bloggrid_register(){
        $this->block_us_bloggrid_fields();
        acf_register_block(array(
            'name'				=> 'block_us_bloggrid',
            'title'				=> __('Grid: Blog', "uslang"),
            'description'		=> __('erzeugt einen Block, mit dem man eine Liste Blog- Presse- oder Event-Beiträgen anlegen kann.', "uslang"),
            'render_callback'	=> array($this, 'block_us_bloggrid_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'grid-view',
            'mode'          => 'preview',
            'align'         => 'full',
            'keywords'		=> array("article", "related"),
            'supports'     => array('align' => array("full"))
        ));
        add_editor_style("inc/blocks/bloggrid/bloggrid.css");
    }

    public function block_us_bloggrid_render($block, $content = '', $is_preview = false, $postid){
        $currentpost = get_post($postid);
        $hl = get_field('block_us_bloggrid_headline');
        $type = get_field('block_us_bloggrid_type');
        $count = get_field('block_us_bloggrid_count');
        $setbg = get_field('block_us_bloggrid_setbg');
        $btn = get_field('block_us_bloggrid_morebtn'); // show 0|1 // text "Alle Einträge anzeigen"
        $blockid = 'block_bloggrid-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = 'alignfull';
        $opts = array(
            'post_type' => $type,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order'  => 'DESC',
            'posts_per_page' => -1,
        );
        if(get_post_type($currentpost) == "teilprojekt"){
            $opts["meta_query"] = array("key" => "teilprojekt", "value" => '"'.$currentpost->ID.'"', "compare" => "LIKE");
        }elseif(get_post_type($currentpost) == "partner"){
            $tp = get_field("teilprojekt", $currentpost);
            $opts["meta_query"] = array("key" => "teilprojekt", "value" => array($tp->ID), "compare" => "IN");
            //print_r($opts);
        }
        $posts = get_posts($opts);
        
        $c = "";
        //if(\is_admin()) add_editor_style("inc/blocks/bloggrid/bloggrid.css");
        if(!\is_admin())wp_enqueue_style("block_bloggrid_style", get_template_directory_uri()."/inc/blocks/bloggrid/bloggrid.css");
        if($posts){
            
            echo '<div class="block_bloggrid blog-grid-container '.$type.' '.($setbg ? 'has-background' : '').' '.$alignclass.'" id="'.$blockid.'">';
                echo '<div class="center blog">';
                    if($hl && !empty($hl)) echo '<div class="gridheadline"><h2>'.$hl.'</h2></div>';
                    echo '<div class="blog-list">';
                    if($posts){
                        $i = 1;
                        foreach($posts as $box){
                            if($i > 3) continue;
                            $tp = get_field("teilprojekt",$box); $pp = "";
                            if($tp){
                                $p = get_field("project", $tp);
                                $pp = $p["value"];
                            }
                            if(get_post_type($box) == "teilprojekt"){
                                $p = get_field("project", $tp);
                                $pp = $p["value"];
                            }
                            if(get_post_type($currentpost) == "teilprojekt" || get_post_type($currentpost) == "partner"){
                                if(get_post_type($currentpost) == "teilprojekt"){
                                    $tp = get_field("teilprojekt",$box); // tp in blogpost
                                    if($tp->ID != $currentpost->ID) continue;
                                }elseif(get_post_type($currentpost) == "partner"){
                                    $tp = get_field("teilprojekt",$box); // tp in blogpost
                                    $ptp = get_field("teilprojekt",$currentpost); // tp in current partner page
                                    if($ptp->ID != $tp->ID) continue;
                                }
                            }
                            echo '<article class="article loop '.$pp.'">';
                                echo '<div class="image">';
                                    $tnid = get_post_thumbnail_id($box->ID);
                                    $srcset = wp_get_attachment_image_srcset($tnid, 'teasergrid');
                                    $src = wp_get_attachment_image_url($tnid, 'teasergrid');
                                    echo '<a href="'.get_the_permalink($box).'" title="'.esc_attr(get_the_title($box)).'">';
                                        echo '<img class="image-responsive blog-imageItem" src="'.$src.'" srcset="'.$srcset.'" alt="'.esc_attr(get_the_title($box)).'">';
                                    echo '</a>';
                                echo '</div>';
                                echo '<div class="content">';
                                    echo '<time class="date" datetime="'.get_the_date("Y-m-d H:i:s",$box).'">'.get_the_date("",$box).'</time>';
                                    echo '<h3 class="article-title"><a href="'.get_the_permalink($box).'" title="'.esc_attr(get_the_title($box)).'">'.esc_html(get_the_title($box)).'</a></h3>';
                                    echo '<span class="excerpt">'.esc_html(get_the_excerpt($box)).'</span>';
                                echo '</div>';
                            echo '</article>';
                            $i++;
                        }
                    }else{
                        echo "no posts";
                    }
                    echo '</div>';
                    if(isset($btn["show"]) && $btn["show"]){
                        $posts_post = get_option("page_for_posts");
                        $url = get_the_permalink($posts_post);
                        echo '<div class="call-to-action-container">';
                            echo '<a class="btn btn-primary" href="'.esc_url($url).'" title="'.esc_attr($btn["text"]).'" target="_self">'.esc_html($btn["text"]).'</a>';
                        echo '</div>';
                    }
                echo '</div>';
            echo '</div>';
            wp_reset_query();
        }else{
            if(\is_admin()){
                $c .= '<div class="block_related '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passen Sie diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
                echo $c;
            }
        }
    }

    public function block_us_bloggrid_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5cacc6acc02f0',
                'title' => 'Block: Bloggrid',
                'fields' => array(
                    array(
                        'key' => 'field_5cacc77d0f9bc',
                        'label' => 'Überschrift',
                        'name' => 'block_us_bloggrid_headline',
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
                        'key' => 'field_5cb4137631302',
                        'label' => 'Anzahl der Beiträge',
                        'name' => 'block_us_bloggrid_count',
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
                            3 => '3 Beiträge',
                            -1 => 'Alle Beiträge',
                        ),
                        'allow_null' => 0,
                        'default_value' => 3,
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                    ),
                    array(
                        'key' => 'field_5cacc7cf0f9be',
                        'label' => 'Grau hinterlegen?',
                        'name' => 'block_us_bloggrid_setbg',
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
                        'default_value' => 1,
                        'ui' => 1,
                        'ui_on_text' => '',
                        'ui_off_text' => '',
                    ),
                    array(
                        'key' => 'field_5cacd17d0f9bf',
                        'label' => '"Mehr zeigen"-Button',
                        'name' => 'block_us_bloggrid_morebtn',
                        'type' => 'group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_5cacc7930f9bd',
                                    'operator' => '>',
                                    'value' => '0',
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
                                'key' => 'field_5cacd1d70f9c0',
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
                                'key' => 'field_5cacd1fc0f9c1',
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
                            'value' => 'acf/block-us-bloggrid',
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
$block_us_bloggrid = new block_us_bloggrid();
