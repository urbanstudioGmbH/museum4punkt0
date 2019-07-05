<?php

class block_us_slider{
    public $showYT;
    public $showVIMEO;
    public $showGMap;

    function __construct(){
        add_action('acf/init', array($this, "block_us_slider_register"));
        add_action( 'rest_api_init', function () {
            register_rest_route( 'block_us_slider/v1', '/allow/(?P<allowtype>[a-z]+)', array(
                'methods' => 'POST',
                'callback' => array($this, 'processRequest'),
            ) );
        } );
    }
    
    public function block_us_slider_register(){
        $this->block_us_slider_fields();
        acf_register_block(array(
            'name'				=> 'block_us_slider',
            'title'				=> __('Bild / Video / Slider', "uslang"),
            'description'		=> __('erzeugt einen Slider-Block', "uslang"),
            'render_callback'	=> array($this, 'block_us_slider_render'),
            'category'		=> 'usblocks',
            'icon'			=> '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="photo-video" class="svg-inline--fa fa-photo-video fa-w-20" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path fill="currentColor" d="M608 0H160a32 32 0 0 0-32 32v96h160V64h192v320h128a32 32 0 0 0 32-32V32a32 32 0 0 0-32-32zM232 103a9 9 0 0 1-9 9h-30a9 9 0 0 1-9-9V73a9 9 0 0 1 9-9h30a9 9 0 0 1 9 9zm352 208a9 9 0 0 1-9 9h-30a9 9 0 0 1-9-9v-30a9 9 0 0 1 9-9h30a9 9 0 0 1 9 9zm0-104a9 9 0 0 1-9 9h-30a9 9 0 0 1-9-9v-30a9 9 0 0 1 9-9h30a9 9 0 0 1 9 9zm0-104a9 9 0 0 1-9 9h-30a9 9 0 0 1-9-9V73a9 9 0 0 1 9-9h30a9 9 0 0 1 9 9zm-168 57H32a32 32 0 0 0-32 32v288a32 32 0 0 0 32 32h384a32 32 0 0 0 32-32V192a32 32 0 0 0-32-32zM96 224a32 32 0 1 1-32 32 32 32 0 0 1 32-32zm288 224H64v-32l64-64 32 32 128-128 96 96z"></path></svg>',
            'keywords'		=> array("article", "featured"),
            'enqueue_assets' => function(){
                wp_enqueue_style( 'block-us-faq', get_template_directory_uri()."/inc/blocks/slider/slider.css");
                wp_enqueue_script( 'block-us-slider', get_template_directory_uri()."/inc/blocks/slider/slider.js", array('jquery'), '', true );
            }
        ));
        //add_editor_style("inc/blocks/faq/faq.css");
    }
    
    public function block_us_slider_render($block, $content = '', $is_preview = false){

        $blockid = 'block_slider-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        if (!\is_admin()) {
            //wp_enqueue_style("block_us_slider", get_template_directory_uri()."/inc/blocks/faq/faq.css");
            //wp_enqueue_script("block_us_slider", get_template_directory_uri()."/inc/blocks/faq/faq.js");
        }


        // check if the repeater field has rows of data
        if( have_rows('block_us_slider') ): ?>
            <div class="block_us_slider cb_module cb_figure alignfull">
                <div class="center">
        <?php
            // loop through the rows of data
            while ( have_rows('block_us_slider') ) : the_row(); 
                $type = get_sub_field('media');
                if ($type !== 'image') {
                    $media = 'video';
                } else {
                    $media = $type;
                }
                $mediaObj = get_sub_field($media);

                if (!empty($mediaObj)):
                ?>
                <figure class="<?=$media; ?>-item">
                    <?php if($media == 'video'): 
                        $video = $mediaObj;
                        $image = get_sub_field('image');
                        ?>

                    
                        <?php 

                        echo '<div class="poster">';
                            echo '<img class="image-responsive" src="'.$image["sizes"]["thumbnail"].'" srcset="'.$image["sizes"]["medium"].' 1x, '.$image["sizes"]["large"].' 2x" alt="'.esc_attr($caption).'">';
                            echo '<a class="play-btn"'.(($type == "youtube") ? ' data-action="'.(!$this->showYT ? "allow" : "check").'" data-type="youtube"' : '').(($type == "vimeo") ? ' data-action="'.(!$this->showVIMEO ? "allow" : "check").'" data-type="vimeo"' : '').'><i class="fas fa-play"></i></a>';
                            
                        echo '</div>';
                        
                            
                        if (($type == "youtube" && !$this->showYT) || ($type == "vimeo" && !$this->showVIMEO)) {
                            echo '<div class="privacy">';
                                $tt = $this->replTexts($type);
                                echo '<div class="text">'.$tt["text"].'</div>';
                            echo '</div>';
                        }
                        echo '<div class="video">';
                            preg_match('/src="(.+?)"/', $video, $matches);
                            $src = $matches[1];

                            // add extra params to iframe src
                            $params = array(
                                'autoplay'    => 1,
                                'hd'        => 1
                            );
                            
                            $new_src = add_query_arg($params, $src);
                            
                            $video = str_replace($src, "", $video);
                            
                            
                            // add extra attributes to iframe html
                            $attributes = 'frameborder="0" ';
                            $attributes .= ' data-src="'.$new_src.'"';
                            
                            $video = str_replace('></iframe>', ' ' . $attributes . '></iframe>', $video);
                            echo $video;

                        echo '</div>';
                    ?>

                    <?php elseif($media == 'image'): 
                        $image = $mediaObj;
                        ?>
                        <img class="image-responsive" src="<?=$image['sizes']['thumbnail']; ?>" srcset="<?=$image['sizes']['medium'];?> 1x, <?=$image['sizes']['large']; ?> 2x" alt="<?=esc_attr($caption); ?>">
                    <?php endif; ?>
                    <?php 
                        $caption = get_sub_field('caption');
                        if(!empty($caption)):
                    ?>
                    <figcaption>
                        <p><?=$caption; ?></p>
                    </figcaption>
                    <?php endif; ?>
                </figure>

                <?php endif; ?>
            <?php
            endwhile; ?>
            </div>
        </div>
        <?php

        else :

            if(\is_admin()){
                $c .= '<div class="block_us_faq '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passe diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
                echo $c;
            }

        endif;


        /*
        $c = "";

        if($faqs && count($faqs)){
            $theHTML = '<div class="block_us_slider cb_module cb_figure alignfull" id="'.$blockid.'"><div class="accordion">';
            $i = 0;
            foreach($faqs AS $faq){
                $theHTML .= '<h3 class="'.(($faqFirstOpen && !$i) ? ' ui-accordion-header-active ui-state-active' : '').'">';
                $theHTML .= $faq["question"].'</h3>';
                $theHTML .= '<div class="ui-accordion-content '.(($faqFirstOpen && !$i) ? ' ui-accordion-content-active" style="display: block;"' : '"').'>'.apply_filters('the_content', $faq["answer"]).'</div>';

                $i++;
            }
            $theHTML .= '</div></div>';
            $c .= $theHTML;
        }else{
            if(\is_admin()){
                $c .= '<div class="block_us_slider '.$alignclass.'" id="'.$blockid.'">';
                    $c .= '<h3>Hinweis!</h3>';
                    $c .= '<div class="usdc_text">Wechseln Sie in den Bearbeiten-Modus oder passe diesen Block in den Blockeinstellungen in der rechten Seitenleiste an.</div>';
                $c .= '</div>';
            }
        }
        echo $c;*/
    }


    public function processRequest( WP_REST_Request $request ) {
        return $this->processCookies($request);
    }
    public function processCookies($data = null){
        // Google Maps
        //print_r($data);
        if((isset($_COOKIE["allow_gmaps"]) && $_COOKIE["allow_gmaps"]) || (isset($_POST["allow_gmaps"]) && $_POST["allow_gmaps"])){
            if(isset($_POST["allow_gmaps"]) && $_POST["allow_gmaps"] == 1){
                setcookie ( "allow_gmaps", 1, time()+60*60*24, "/", $_SERVER["HOST_NAME"], 1 ); 
            }
            $this->showGMap = 1;
        }else{
            $this->showGMap = 0;
        }
        // Youtube Video
        if((isset($_COOKIE["allow_youtube"]) && $_COOKIE["allow_youtube"]) || (isset($data["allowtype"]) && $data["allowtype"] == "youtube")){
            if(isset($data["allowtype"]) && $data["allowtype"] == "youtube"){
                setcookie ( "allow_youtube", 1, time()+60*60*24, "/", $_SERVER["HOST_NAME"], 1 );   
            }
            $this->showYT = 1;
            return true;
        }else{
            $this->showYT = 0;
        }
        // VIMEO Video
        if((isset($_COOKIE["allow_vimeo"]) && $_COOKIE["allow_vimeo"]) || (isset($data["allowtype"]) && $data["allowtype"] == "vimeo")){
            if(isset($data["allowtype"]) && $data["allowtype"] == "vimeo"){
                setcookie ( "allow_vimeo", 1, time()+60*60*24, "/", $_SERVER["HOST_NAME"], 1 ); 
            }
            $this->showVIMEO = 1;
            return true;
        }else{
            $this->showVIMEO = 0;
        }
    }
    public function replTexts($type){
        $array = array(
            "youtube" => array(
                "headline" => __("YouTube - Video", "uslang"),
                "text" => __("Mit Klick auf den Playbutton stimmen Sie zu, dass an dieser Stelle Inhalte von YouTube und damit verbundenen Diensten geladen werden. Mehr dazu in unserer <a href=\"".get_privacy_policy_url()."\" target=\"_blank\">Datenschutzerklärung</a>.", "uslang"),
                "allow" => "Immer Erlauben",
                "deny" => "Immer verweigern"
            ),
            "vimeo" => array(
                "headline" => __("Vimeo - Video", "uslang"),
                "text" => __("Mit Klick auf den Playbutton stimmen Sie zu, dass an dieser Stelle Inhalte von Vimeo und damit verbundenen Diensten geladen werden. Mehr dazu in unserer <a href=\"".get_privacy_policy_url()."\" target=\"_blank\">Datenschutzerklärung</a>.", "uslang"),
                "allow" => "Immer Erlauben",
                "deny" => "Immer verweigern"
            ),
            "gmaps" => array(
                "headline" => "Google Maps - Karte",
                "text" => "Hier wird eine Karte von Google-Maps eingebettet. Lesen Sie in unserer <a href=\"/datenschutz\" target=\"_blank\">Datenschutzerklärung</a> zum Thema Google Maps bevor Sie erlauben Google Maps-Karten zu laden.",
                "allow" => "Immer Erlauben",
                "deny" => "Immer verweigern"
            )
        );
        return $array[$type];   
    }

    public function block_us_slider_fields(){
        if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_5d036e70854ca',
    'title' => 'block_us_slider',
    'fields' => array(
        array(
            'key' => 'field_5d036e99c4c3b',
            'label' => 'Slider',
            'name' => 'block_us_slider',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
                'width' => '',
                'class' => '',
                'id' => '',
            ),
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'table',
            'button_label' => '',
            'sub_fields' => array(
                array(
                    'key' => 'field_5d036eb7c4c3c',
                    'label' => 'Media',
                    'name' => 'media',
                    'type' => 'select',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'choices' => array(
                        'image' => 'Image',
                        'youtube' => 'Youtube',
                        'vimeo' => 'Vimeo',
                    ),
                    'default_value' => array(
                    ),
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 0,
                    'return_format' => 'value',
                    'ajax' => 0,
                    'placeholder' => '',
                ),
                array(
                    'key' => 'field_5d036edac4c3d',
                    'label' => 'Image',
                    'name' => 'image',
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
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
                array(
                    'key' => 'field_5d036ef2c4c3e',
                    'label' => 'Video',
                    'name' => 'video',
                    'type' => 'oembed',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => array(
                        array(
                            array(
                                'field' => 'field_5d036eb7c4c3c',
                                'operator' => '==',
                                'value' => 'youtube',
                            ),
                        ),
                        array(
                            array(
                                'field' => 'field_5d036eb7c4c3c',
                                'operator' => '==',
                                'value' => 'vimeo',
                            ),
                        ),
                    ),
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'width' => '',
                    'height' => '',
                ),
                array(
                    'key' => 'field_5d0371ccb1e35',
                    'label' => 'Caption',
                    'name' => 'caption',
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
            ),
        ),
    ),
    'location' => array(
            array(
                array(
                    'param' => 'block',
                    'operator' => '==',
                    'value' => 'acf/block-us-slider',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'seamless',
        'label_placement' => 'top',
        'instruction_placement' => 'field',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => '',
    ));
    
    endif;
/*if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5c1f38bc82857',
                'title' => 'Block: FAQ',
                'fields' => array(
                    array(
                        'key' => 'field_5c1f38ca17034',
                        'label' => 'erstes Frage geöffnet?',
                        'name' => 'block_us_slider_fo',
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
                        'key' => 'field_5c1f38f417035',
                        'label' => 'Fragen / Antworten',
                        'name' => 'block_us_slider_index',
                        'type' => 'repeater',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'collapsed' => '',
                        'min' => 0,
                        'max' => 0,
                        'layout' => 'block',
                        'button_label' => 'Frage hinzufügen',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_5c1f391217036',
                                'label' => 'Frage',
                                'name' => 'question',
                                'type' => 'text',
                                'instructions' => '',
                                'required' => 1,
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
                                'key' => 'field_5c1f392d17037',
                                'label' => 'Antwort',
                                'name' => 'answer',
                                'type' => 'wysiwyg',
                                'instructions' => '',
                                'required' => 1,
                                'conditional_logic' => 0,
                                'wrapper' => array(
                                    'width' => '',
                                    'class' => '',
                                    'id' => '',
                                ),
                                'default_value' => '',
                                'tabs' => 'all',
                                'toolbar' => 'basic',
                                'media_upload' => 0,
                                'delay' => 0,
                            ),
                        ),
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-faq',
                        ),
                    ),
                ),
                'menu_order' => 0,
                'position' => 'normal',
                'style' => 'seamless',
                'label_placement' => 'top',
                'instruction_placement' => 'field',
                'hide_on_screen' => '',
                'active' => 1,
                'description' => '',
            ));
            
            endif;
        */
    }
    
}
$block_us_slider = new block_us_slider();