<?php

class block_us_partnergrid{

    function __construct(){
        add_action('acf/init', array($this, "block_us_partnergrid_register"));
    }

    public function block_us_partnergrid_register(){
        $this->block_us_partnergrid_fields();
        acf_register_block(array(
            'name'				=> 'block_us_partnergrid',
            'title'				=> __('Partner', "uslang"),
            'description'		=> __('erzeugt einen Block, mit dem man eine Liste der Partner anlegen kann.', "uslang"),
            'render_callback'	=> array($this, 'block_us_partnergrid_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'grid-view',
            'mode'          => 'preview',
            'align'         => 'full',
            'keywords'		=> array("article", "related"),
            'supports'     => array('align' => array("full"))
        ));
        add_editor_style("inc/blocks/partnergrid/partnergrid.css");
    }

    public function block_us_partnergrid_render($block, $content = '', $is_preview = false, $postid){
        $currentpost = get_post($postid);
        $hl = get_field('block_us_partnergrid_headline');
        $setbg = get_field('block_us_partnergrid_setbg');
        $btn = get_field('block_us_partnergrid_morebtn'); // show 0|1 // text "Alle Einträge anzeigen"
        $block["align"] = "full";
        $blockid = 'block_partnergrid-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = 'alignfull';
        $opts = array(
            'post_type' => "partner",
            'post_status' => 'publish',
            'orderby' => 'ID',
            'order'  => 'ASC',
            'posts_per_page' => -1,
            "suppress_filters" => false
        );

        $posts = get_posts($opts);
        $c = "";
        //if(\is_admin()) add_editor_style("inc/blocks/partnergrid/partnergrid.css");
        if(!\is_admin()) wp_enqueue_style("block_partnergrid_style", get_template_directory_uri()."/inc/blocks/partnergrid/partnergrid.css");
        if($posts){
            echo '<div class="block_partnergrid partner-grid-container teilprojekt '.($setbg ? 'has-background' : '').' '.$alignclass.'" id="'.$blockid.'">';
                echo '<div class="center blog">';
                    if($hl && !empty($hl)) echo '<div class="gridheadline"><h2>'.$hl.'</h2></div>';
                    echo '<div class="blog-list">';
                    if($posts){
                        foreach($posts as $i => $box){
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
                                    echo '<span class="excerpt">'.esc_html(get_the_excerpt($box)).'</span>';
                                echo '</div>';
                            echo '</article>';
                        }
                    }else{
                        echo "no posts";
                    }
                    echo '</div>';
                    /*if($btn["show"]){
                        $url = "/partner/";
                        echo '<div class="call-to-action-container">';
                            echo '<a class="btn btn-primary" href="'.esc_url($url).'" title="'.esc_attr($btn["text"]).'" target="_self">'.esc_html($btn["text"]).'</a>';
                        echo '</div>';
                    }*/
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

    public function block_us_partnergrid_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5cb33b54891ad',
                'title' => 'Block: Partner-Grid',
                'fields' => array(
                    array(
                        'key' => 'field_5cb33b549eb1e',
                        'label' => 'Überschrift',
                        'name' => 'block_us_partnergrid_headline',
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
                        'key' => 'field_5cb33b549ec21',
                        'label' => 'Grau hinterlegen?',
                        'name' => 'block_us_partnergrid_setbg',
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
                            'value' => 'acf/block-us-partnergrid',
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
$block_us_partnergrid = new block_us_partnergrid();
