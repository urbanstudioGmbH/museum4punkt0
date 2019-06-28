<?php

class block_us_gridteaser{

    function __construct(){
        add_action('acf/init', array($this, "block_us_gridteaser_register"));
    }

    public function block_us_gridteaser_register(){
        $this->block_us_gridteaser_fields();
        acf_register_block(array(
            'name'				=> 'block_us_gridteaser',
            'title'				=> __('Grid: Teaser', "uslang"),
            'description'		=> __('erzeugt einen Block, mit dem man eine Liste relativer Posts erstellen kann.', "uslang"),
            'render_callback'	=> array($this, 'block_us_gridteaser_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'grid-view',
            'align'         => 'full',
            'mode'          => 'edit',
            'keywords'		=> array("article", "related"),
            'supports'      => array("align" => array("full"))
        ));
    }

    public function block_us_gridteaser_render($block, $content = '', $is_preview = false){
        $teasers_hl = get_field('block_us_gridteaser_hl');
        $teasers = get_field('block_us_gridteaser_index');

        $blockid = 'block_gridteaser-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        //$alignclass = $block['align'] ? 'align' . $block['align'] : 'alignwide';
        $alignclass = 'alignfull';
        $c = "";
        if(\is_admin()) add_editor_style("/inc/blocks/gridteaser/gridteaser.css");
        else wp_enqueue_style("block_gridteaser_style", get_template_directory_uri()."/inc/blocks/gridteaser/gridteaser.css");
        if($teasers && is_array($teasers) && count($teasers)){
            echo '<div class="block_gridteaser teaser-grid-container '.$alignclass.'" id="'.$blockid.'">';
                echo '<div class="center blog">';
                    if($teasers_hl && !empty($teasers_hl)) echo '<div class="gridheadline"><h2>'.$teasers_hl.'</h2></div>';
                    echo '<div class="blog-list">';
                    foreach($teasers AS $box){ $box = (object)$box;
                        $p = get_field("project", $box->post);
                        $pp = $p["value"];
                        $pic = 0;
                        if ($box->type == "int") {
                            $tnid = get_post_thumbnail_id($box->post->ID);
                            if($tnid){
                                $srcset = wp_get_attachment_image_srcset($tnid, 'teasergrid'); $pic = 1;
                                $src = wp_get_attachment_image_url($tnid, 'teasergrid');
                            }
                            $link = get_the_permalink($box->post);
                            $title = esc_attr(get_the_title($box->post));
                            $hl = get_the_title($box->post);

                        } else {
                            if($box->pic){
                                $srcset = wp_get_attachment_image_srcset($box->pic, 'teasergrid'); $pic = 1;
                                $src = wp_get_attachment_image_url($box->pic, 'teasergrid');
                            }
                            $link = $box->linkurl;
                            $title = esc_attr($box->linktitle);
                            $hl = $box->linktitle;
                        }
                        echo '<article class="article '.$pp.($pic ? ' hasimage' : '').'" id="post-'.($box->type == "int" ? $box->post->ID : uniqid()).'">';
                            if ($pic) {
                                echo '<div class="image">';
                                    echo '<a href="'.$link.'" title="'.$title.'">';
                                        echo '<img class="image-responsive gridteaser-imageitem" src="'.$src.'" srcset="'.$srcset.'" alt="'.$title.'">';
                                    echo '</a>';
                                echo '</div>';
                            }
                            echo '<div class="content">';
                                echo '<h3 class="article-title"><a href="'.$link.'" title="'.$title.'">'.$hl.'</a></h3>';
                                if ($box->type == "int") echo '<h4 class="project">'.$p["label"].'</h4>';
                                echo '<span class="excerpt">'.esc_html(get_the_excerpt($box->post)).'</span>';
                            echo '</div>';
                            echo '<div class="clear"></div>';
                        echo '</article>';
                    }
                    echo '</div>';
                echo '</div>';
            echo '</div>';
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

    public function block_us_gridteaser_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5ca789999f8e9',
                'title' => 'Block: Grid Teaser',
                'fields' => array(
                    array(
                        'key' => 'field_5cab584c69c5b',
                        'label' => 'Überschrift',
                        'name' => 'block_us_gridteaser_hl',
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
                        'key' => 'field_5ca789a169440',
                        'label' => 'Teaser-Links',
                        'name' => 'block_us_gridteaser_index',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'wpml_cf_preferences' => 0,
                        'collapsed' => '',
                        'min' => 0,
                        'max' => 0,
                        'layout' => 'block',
                        'button_label' => 'Link hinzufügen',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5ca78ec59d446',
                                'label' => 'Link Typ',
                                'name' => 'type',
                                'type' => 'radio',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'choices' => array(
                                    'int' => 'interner Link',
                                    'ext' => 'externer Link',
                                ),
                                'allow_null' => 0,
                                'other_choice' => 0,
                                'default_value' => 'int',
                                'layout' => 'horizontal',
                                'return_format' => 'value',
                                'wpml_cf_preferences' => 0,
                                'save_other_choice' => 0,
                            ),
                            array(
                                'key' => 'field_5ca790df9d44a',
                                'label' => 'Link-Ziel',
                                'name' => 'target',
                                'type' => 'select',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '50',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'choices' => array(
                                    '_self' => 'gleiches Fenster',
                                    '_blank' => 'neuer Tab',
                                ),
                                'default_value' => array(
                                    0 => '_self',
                                ),
                                'allow_null' => 0,
                                'multiple' => 0,
                                'ui' => 0,
                                'return_format' => 'value',
                                'wpml_cf_preferences' => 0,
                                'ajax' => 0,
                                'placeholder' => '',
                            ),
                            array(
                                'key' => 'field_5ca78fb69d447',
                                'label' => 'Seite / Beitrag verlinken',
                                'name' => 'post',
                                'type' => 'post_object',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_5ca78ec59d446',
                                            'operator' => '==',
                                            'value' => 'int',
                                        ),
                                    ),
                                ),
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'post_type' => array(
                                    0 => 'teilprojekt',
                                    1 => 'page',
                                    2 => 'post',
                                ),
                                'taxonomy' => '',
                                'allow_null' => 0,
                                'multiple' => 0,
                                'return_format' => 'object',
                                'wpml_cf_preferences' => 0,
                                'ui' => 1,
                            ),
                            array(
                                'key' => 'field_5ca7905c9d448',
                                'label' => 'Link',
                                'name' => 'linkurl',
                                'type' => 'url',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_5ca78ec59d446',
                                            'operator' => '==',
                                            'value' => 'ext',
                                        ),
                                    ),
                                ),
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'placeholder' => '',
                                'wpml_cf_preferences' => 0,
                            ),
                            array(
                                'key' => 'field_5ca7909d9d449',
                                'label' => 'Link Titel',
                                'name' => 'linktitle',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_5ca78ec59d446',
                                            'operator' => '==',
                                            'value' => 'ext',
                                        ),
                                    ),
                                ),
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
                                'key' => 'field_5ca7915c9d44b',
                                'label' => 'Vorschau-Bild',
                                'name' => 'pic',
                                'type' => 'image',
                                'instructions' => '',
                                'required' => 0,
                                'conditional_logic' => array(
                                    array(
                                        array(
                                            'field' => 'field_5ca78ec59d446',
                                            'operator' => '==',
                                            'value' => 'ext',
                                        ),
                                    ),
                                ),
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'wpml_cf_preferences' => 0,
                                'return_format' => 'id',
                                'preview_size' => 'thumbnail',
                                'library' => 'all',
                                'min_width' => '',
                                'min_height' => '',
                                'min_size' => '',
                                'max_width' => '',
                                'max_height' => '',
                                'max_size' => '',
                                'mime_types' => 'jpg,jpeg,png',
                            ),
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-gridteaser',
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
$block_us_gridteaser = new block_us_gridteaser();
