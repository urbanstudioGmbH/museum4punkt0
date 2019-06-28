<?php

class block_us_newsgrid{

    function __construct(){
        add_action('acf/init', array($this, "block_us_newsgrid_register"));
    }

    public function block_us_newsgrid_register(){
        $this->block_us_newsgrid_fields();
        acf_register_block(array(
            'name'				=> 'block_us_newsgrid',
            'title'				=> __('Grid: Presse', "uslang"),
            'description'		=> __('erzeugt einen Block, mit dem man eine Liste Presse-Beiträgen anlegen kann.', "uslang"),
            'render_callback'	=> array($this, 'block_us_newsgrid_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'grid-view',
            'mode'          => 'preview',
            'align'         => 'full',
            'keywords'		=> array("article", "related"),
            'supports'     => array('align' => array("full")),

        ));
        add_editor_style("inc/blocks/newsgrid/newsgrid.css");
    }

    public function block_us_newsgrid_render($block, $content = '', $is_preview = false, $postid){
        $currentpost = get_post($postid);
        $hl = get_field('block_us_newsgrid_headline');
        $type = get_field('block_us_newsgrid_type');
        $count = get_field('block_us_newsgrid_count');
        $setbg = get_field('block_us_newsgrid_setbg');
        $btn = get_field('block_us_newsgrid_morebtn'); // show 0|1 // text "Alle Einträge anzeigen"
        $blockid = 'block_newsgrid-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = 'alignfull';
        $opts = array(
            'post_type' => "news",
            'post_status' => 'publish',
            'orderby' => 'date',
            'order'  => 'DESC',
            'numberposts' => $count,
        );
        $posts = get_posts($opts);
        $masonry = 0; if($count == -1) $masonry = 1;
        $c = "";
        //if(\is_admin()) add_editor_style("inc/blocks/newsgrid/newsgrid.css");
        if(!\is_admin()) wp_enqueue_style("block_newsgrid_style", get_template_directory_uri()."/inc/blocks/newsgrid/newsgrid.css");
        if($posts){
            echo '<div class="block_newsgrid news-grid-container '.$type.' '.($setbg ? 'has-background' : '').' '.$alignclass.'" id="'.$blockid.'">';
                echo '<div class="center blog">';
                    if($hl && !empty($hl)) echo '<div class="gridheadline"><h2>'.$hl.'</h2></div>';
                    echo '<div class="blog-list'.($masonry ? " masonry" : "").'">';
                    if($masonry){
                        echo '<div class="grid-sizer"></div>';
			            echo '<div class="gutter-sizer"></div>';
                    }
                    if($posts){
                        foreach($posts as $i => $box){
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
                                    echo '<time class="date" datetime="'.get_the_date("Y-m-d H:i:s",$box).'">'.get_the_date("",$box).'</time>';
                                    echo '<h3 class="article-title"><a href="'.get_the_permalink($box).'" title="'.esc_attr(get_the_title($box)).'">'.esc_html(get_the_title($box)).'</a></h3>';
                                    echo '<span class="excerpt">'.esc_html(get_the_excerpt($box)).'</span>';
                                echo '</div>';
                            echo '</article>';
                        }
                    }else{
                        echo "no posts";
                    }
                    echo '</div>';
                    if(isset($btn["show"]) && $btn["show"]){
                        $url = "/presse/pressemitteilungen/";
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
                $c .= '<div class="block_related '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passen Sie diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
                echo $c;
            }
        }
    }

    public function block_us_newsgrid_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5cb37f0a97379',
                'title' => 'Block: Presse',
                'fields' => array(
                    array(
                        'key' => 'field_5cb37f0aa6b7c',
                        'label' => 'Überschrift',
                        'name' => 'block_us_newsgrid_headline',
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
                        'key' => 'field_5cb38180cee0c',
                        'label' => 'Anzahl Beiträge',
                        'name' => 'block_us_newsgrid_count',
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
                        'key' => 'field_5cb37f0aa6bce',
                        'label' => 'Grau hinterlegen?',
                        'name' => 'block_us_newsgrid_setbg',
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
                    array(
                        'key' => 'field_5cb37f0aa6c1e',
                        'label' => '"Mehr zeigen"-Button',
                        'name' => 'block_us_newsgrid_morebtn',
                        'type' => 'group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_5cb37f0aa6b7c',
                                    'operator' => '!=empty',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'layout' => 'block',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5cb37f0aacb60',
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
                                'key' => 'field_5cb37f0aacbba',
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
                            'value' => 'acf/block-us-newsgrid',
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
$block_us_newsgrid = new block_us_newsgrid();
