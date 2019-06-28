<?php

class block_us_tpgrid{

    function __construct(){
        add_action('acf/init', array($this, "block_us_tpgrid_register"));
    }

    public function block_us_tpgrid_register(){
        $this->block_us_tpgrid_fields();
        acf_register_block(array(
            'name'				=> 'block_us_tpgrid',
            'title'				=> __('Grid: Teilprojekte', "uslang"),
            'description'		=> __('erzeugt einen Block, mit dem man eine Liste der Teilprojekte anlegen kann.', "uslang"),
            'render_callback'	=> array($this, 'block_us_tpgrid_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'grid-view',
            'mode'          => 'preview',
            'align'         => 'full',
            'keywords'		=> array("article", "related"),
            'supports'     => array('align' => array("full"))
        ));
        add_editor_style("inc/blocks/tpgrid/tpgrid.css");
    }

    public function block_us_tpgrid_render($block, $content = '', $is_preview = false, $post_id = null){
        $currentpost = get_post($postid);
        $hl = get_field('block_us_tpgrid_headline');
        $setbg = get_field('block_us_tpgrid_setbg');
        $block["align"] = "full";
        $blockid = 'block_tpgrid-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = 'alignfull';
        $order = "DESC";
        if(defined("ICL_LANGUAGE_CODE") && ICL_LANGUAGE_CODE == "en") $order = "ASC";
        $opts = array(
            'post_type' => "teilprojekt",
            'post_status' => 'publish',
            'orderby' => 'ID',
            'order'  => $order,
            'posts_per_page' => -1,
            "suppress_filters" => false
        );

        $posts = get_posts($opts);
        $c = "";
        //if(\is_admin()) add_editor_style("inc/blocks/tpgrid/tpgrid.css");
        if(!\is_admin()) wp_enqueue_style("block_tpgrid_style", get_template_directory_uri()."/inc/blocks/tpgrid/tpgrid.css");
        if($posts){
            echo '<div class="block_tpgrid tp-grid-container teilprojekt '.($setbg ? 'has-background' : '').' '.$alignclass.'" id="'.$blockid.'">';
                echo '<div class="center blog">';
                    if($hl && !empty($hl)) echo '<div class="gridheadline"><h2>'.$hl.'</h2></div>';
                    echo '<div class="blog-list">';
                    if($posts){
                        foreach($posts as $i => $box){
                            $p = get_field("project", $box );
                            $pp = $p["value"];
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
                                    echo '<h3 class="article-title"><a href="'.get_the_permalink($box).'" title="'.esc_attr(get_the_title($box)).'">'.esc_html(get_the_title($box)).'</a></h3>';
                                    echo '<h4 class="project">'.$p["label"].'</h4>';
                                    echo '<span class="excerpt">'.esc_html(get_the_excerpt($box)).'</span>';
                                echo '</div>';
                            echo '</article>';
                        }
                    }else{
                        echo "no posts";
                    }
                    echo '</div>';
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

    public function block_us_tpgrid_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5cb455d5b8457',
                'title' => 'Block: Teilprojekte-Grid',
                'fields' => array(
                    array(
                        'key' => 'field_5cb455d5cbfa6',
                        'label' => 'Überschrift',
                        'name' => 'block_us_tpgrid_headline',
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
                        'key' => 'field_5cb455d5cbffe',
                        'label' => 'Grau hinterlegen?',
                        'name' => 'block_us_tpgrid_setbg',
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
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-tpgrid',
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
$block_us_tpgrid = new block_us_tpgrid();
