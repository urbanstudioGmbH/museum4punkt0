<?php

class block_us_related{

    function __construct(){
        add_action('acf/init', array($this, "block_us_related_register"));
    }

    public function block_us_related_register(){
        $this->block_us_related_fields();
        acf_register_block(array(
            'name'				=> 'block_us_related',
            'title'				=> __('ausgewählte Beiträge', "uslang"),
            'description'		=> __('erzeugt einen Block, mit dem man eine Liste relativer Posts erstellen kann.', "uslang"),
            'render_callback'	=> array($this, 'block_us_related_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'grid-view',
            'align'         => 'wide',
            'keywords'		=> array("article", "related")
        ));
    }

    public function block_us_related_render($block, $content = '', $is_preview = false){
        $theIndex = get_field('block_us_related_index');
        $showExcerpt = get_field('block_us_related_excerpt');
        $showAsMasonry = get_field('block_us_related_masonry');
        //$theURL = get_field('block_us_shopit_url');
        //$theButton = get_field('block_us_shopit_button');

        $blockid = 'block_related-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = $block['align'] ? 'align' . $block['align'] : 'alignwide';

        $c = "";
        if(\is_admin()){
            wp_enqueue_style("block_related_style", get_template_directory_uri()."/css/portfolio.css");
        }
        if($theIndex && is_array($theIndex) && count($theIndex)){
            echo '<div class="block_related '.$alignclass.'" id="'.$blockid.'">';
            
            if(!$showAsMasonry){
                echo '<div id="portfolio">';
            }else{
                echo '<div class="masonry '.$blockid.'">';
			        echo '<div class="grid-sizer"></div>';
                    echo '<div class="gutter-sizer"></div>';
                    wp_enqueue_script("us-imagesloaded", get_template_directory_uri()."/js/imagesloaded.pkgd.min.js", array( 'jquery' ));
                    wp_enqueue_script("us-masonry", get_template_directory_uri()."/js/masonry.pkgd.min.js", array( 'jquery','us-imagesloaded' ));
                    $inlinescript = <<<EOF
jQuery(document).ready(function()
{
    imagesLoaded( '.masonry.$blockid', function() {
        var msnry = jQuery('.masonry.$blockid').masonry({
            // options
            columnWidth: '.portfolio-item',
            itemSelector: '.portfolio-item',
            percentPosition: true,
            gutter: '.gutter-sizer'
		});
		msnry.masonry('layout');
    });
});
EOF;
                    wp_add_inline_script("us-masonry", $inlinescript);
            }
            $posts = get_posts(
                array(
                    'post_type' => 'page',
                    'include' => ''.implode(",",$theIndex).'',
                    'post_status'      => 'publish',
                    'suppress_filters' => true,
                    'orderby' => 'post__in'
                )
            );
            if($posts){
                foreach($posts as $i => $box){ ?>
                    <div <?php

                    if(!has_post_thumbnail($box->ID))
                    { 
                        $class = 'portfolio-item no-image';
                        $showthumb = true;
                    }
                    else
                    { 
                        $class = 'portfolio-item';
                        $showthumb = false;
                    } 

                    post_class($class); ?> id="post-<?php echo $box->ID; ?>">

                <?php
                    if(has_post_thumbnail($box->ID)){
                        $tnid = get_post_thumbnail_id($box->ID);
                        $imagedata = wp_get_attachment_metadata( $tnid );
                        $thumbdesktop = wp_get_attachment_image_src( $tnid, 'post-thumbnail' );
                        $thumbmobile = wp_get_attachment_image_src( $tnid, 'post-thumbnail' );
                        $caption = get_post($tnid)->post_excerpt;
                ?>
                    <div class="portfolio-image">
                        <a href="<?php echo get_permalink($box->ID); ?>" title="<?php echo addslashes(get_the_title($box->ID)); ?>">
                            <?php /*<img src="<?=$thumbbig[0]?>" class="attachment-post-thumbnail size-preview_blog wp-post-image" alt="<?php the_title(); ?>" width="300" height="230">*/ ?>
                                <picture>
                                    <source media="(min-width: 40em)" srcset="<?=$thumbdesktop[0]?>">
                                    <source srcset="<?=$thumbmobile[0]?>">
                                    <img src="<?=$thumbdesktop[0]?>" alt="<?php echo addslashes(get_the_title($box->ID)); ?>">
                                </picture>
							<h3><?php echo get_the_title($box->ID); ?></h3>
                        </a>
                    </div>

                <?php } ?>

                    <div class="portfolio-content">
                        
                        <?php if($showExcerpt){ ?>
                        <div class="post-description">
                            <?php echo $box->post_excerpt; ?>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="clear"></div>
                        </div>
                <!-- Post --><?php
                }
            }
                echo '</div>';
            echo '<div class="clear"></div></div>';
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

    public function block_us_related_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5c17b5f6e7aa2',
                'title' => 'Block: Related',
                'fields' => array(
                    array(
                        'key' => 'field_5c17b5f6e9452',
                        'label' => 'Index',
                        'name' => 'block_us_related_index',
                        'type' => 'relationship',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'post_type' => array(
                            0 => 'page',
                        ),
                        'taxonomy' => '',
                        'filters' => array(
                            0 => 'search',
                        ),
                        'elements' => array(
                            0 => 'featured_image',
                        ),
                        'min' => '',
                        'max' => '',
                        'return_format' => 'id',
                    ),
                    array(
                        'key' => 'field_5c17b63afb5f2',
                        'label' => 'Textvorschau anzeigen?',
                        'name' => 'block_us_related_excerpt',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50',
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
                        'key' => 'field_5c17b66cfb5f3',
                        'label' => 'als Masonry anzeigen?',
                        'name' => 'block_us_related_masonry',
                        'type' => 'true_false',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '50',
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
                            'value' => 'acf/block-us-related',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'default',
                'label_placement' => 'top',
                'instruction_placement' => 'field',
                'hide_on_screen' => '',
                'active' => 1,
                'description' => '',
            ));
            
            endif;
    }
}
$block_us_related = new block_us_related();