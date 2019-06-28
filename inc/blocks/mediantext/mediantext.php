<?php
/**
 * "Media 'n Text" Block for Gutenberg
 *
 * @version 1.0.0
 * @package usblocks
 * @author Marian Feiler <mf@urbanstudio.de>
 * @copyright 2019 urbanstudio GmbH
 * @license Commercial
 * @link https://www.urbanstudio.de
 */

/**
 * Block class for "Media 'n Text" Block for Gutenberg
 */
class block_us_mediantext{
    public $showYT;
    public $showVIMEO;
    public $showGMap;
    /**
     * constructor adds action on "acf/init" to register block
     */
    function __construct(){
        add_action('acf/init', array($this, "block_us_mediantext_register"));
        add_action( 'rest_api_init', function () {
            register_rest_route( 'block_us_mediantext/v1', '/allow/(?P<allowtype>[a-z]+)', array(
                'methods' => 'POST',
                'callback' => array($this, 'processRequest'),
            ) );
        } );
    }
    /**
     * Register block in Wordpress Gutenberg editor
     *
     * @return void
     */
    public function block_us_mediantext_register(){
        $this->block_us_mediantext_fields();
        acf_register_block(array(
            'name'				=> 'block_us_mediantext',
            'title'				=> __('Media plus Text', "uslang"),
            'description'		=> __('erzeugt einen Block, mit Media sowie Text jeweils links oder rechts.', "uslang"),
            'render_callback'	=> array($this, 'block_us_mediantext_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'format-image',
            'align'         => 'full',
            'mode'          => 'preview',
            'keywords'		=> array("article", "related"),
            'supports'      => array("align" => array("full")),
            'enqueue_assets' => function(){
                wp_enqueue_style( 'block-us-mediantext', get_template_directory_uri()."/inc/blocks/mediantext/mediantext.css");
                wp_enqueue_script( 'block-us-mediantext', get_template_directory_uri()."/inc/blocks/mediantext/mediantext.js", array('jquery'), '', true );
            }
        ));
    }
    /**
     * Render block HTML to display in frontend or preview in Gutenberg
     *
     * @param array $block
     * @param string $content
     * @param boolean $is_preview
     * @param int $post_id
     * @return void
     */
    public function block_us_mediantext_render($block, $content = '', $is_preview = false, $post_id = null){
        $this->processCookies();
        $type = get_field('block_us_mediantext_type');
        $image = get_field('block_us_mediantext_image');
        $video = get_field('block_us_mediantext_video');
        $caption = get_field('block_us_mediantext_media_caption');
        $medialr = get_field('block_us_mediantext_media_lr');
        $hl = get_field('block_us_mediantext_text_hl');
        $text = get_field('block_us_mediantext_text');

        $blockid = 'block_mediantext-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        //$alignclass = $block['align'] ? 'align' . $block['align'] : 'alignwide';
        $alignclass = 'alignfull';
        $c = "";
        $tc = '<div class="grid-column '.($medialr == "left" ? "right" : "left").'">';
            $tc .= '<div class="grid-text">';
                $tc .= '<h3>'.$hl.'</h3>';
                $tc .= '<div class="text">'.$text.'</div>';
            $tc .= '</div>';
        $tc .= '</div>';
        if($hl && ($image || $video)){
            echo '<div class="block_mediantext media-text-container '.$alignclass.'" id="'.$blockid.'">';
			echo '<div class="center">';
                if($medialr == "right") echo $tc;
				echo '<div class="grid-column '.$medialr.'">';
                if ($type == "image") {
                    //echo '<pre>'.print_r($image,1).'</pre>';
                    echo '<figure class="grid-media">';
                        echo '<img class="image-responsive" src="'.$image["sizes"]["thumbnail"].'" srcset="'.$image["sizes"]["medium"].' 1x, '.$image["sizes"]["large"].' 2x" alt="'.esc_attr($caption).'">';
                        if ($caption) {
                            echo '<figcaption>'.$caption.'</figcaption>';
                        }
                    echo '</figure>';
                }else{
                    echo '<figure class="grid-media">';
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
                        if($caption) echo '<figcaption>'.$caption.'</figcaption>';
                    echo '</figure>';
                }
                echo '</div>';
                if($medialr == "left") echo $tc;
            echo '</div></div>';

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
        $link = "<a href=\"".get_privacy_policy_url()."\" target=\"_blank\">".__("Datenschutzerklärung", "uslang")."</a>";
		$array = array(
			"youtube" => array(
				"headline" => __("YouTube - Video", "uslang"),
				"text" => sprintf(__("Mit Klick auf den Playbutton stimmen Sie zu, dass an dieser Stelle Inhalte von YouTube und damit verbundenen Diensten geladen werden. Mehr dazu in unserer %s.", "uslang"),$link),
				"allow" => "Immer Erlauben",
				"deny" => "Immer verweigern"
			),
			"vimeo" => array(
				"headline" => __("Vimeo - Video", "uslang"),
				"text" => sprintf(__("Mit Klick auf den Playbutton stimmen Sie zu, dass an dieser Stelle Inhalte von Vimeo und damit verbundenen Diensten geladen werden. Mehr dazu in unserer %s.", "uslang"),$link),
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
    /**
     * Register additional fields via ACF
     *
     * @return void
     */
    public function block_us_mediantext_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5caf6b47a9732',
                'title' => 'Block: Media und Text',
                'fields' => array(
                    array(
                        'key' => 'field_5caf6b5d1001c',
                        'label' => 'Media',
                        'name' => 'media',
                        'type' => 'column',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'wpml_cf_preferences' => 0,
                        'column-type' => '1_2',
                    ),
                    array(
                        'key' => 'field_5cb2ff4bdff23',
                        'label' => 'Art',
                        'name' => 'block_us_mediantext_type',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'wpml_cf_preferences' => 0,
                        'choices' => array(
                            'image' => 'Bild',
                            'vimeo' => 'Vimeo',
                            'youtube' => 'YouTube',
                        ),
                        'allow_null' => 0,
                        'default_value' => 'image',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                    ),
                    array(
                        'key' => 'field_5caf6b751001d',
                        'label' => 'Bildwählen',
                        'name' => 'block_us_mediantext_image',
                        'type' => 'image',
                        'instructions' => 'Wenn Video gewählt ist, dient dieses Bild als Vorschau-Bild.',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'preview_size' => 'big-thumb',
                        'library' => 'all',
                        'min_width' => '',
                        'min_height' => '',
                        'min_size' => '',
                        'max_width' => '',
                        'max_height' => '',
                        'max_size' => '',
                        'mime_types' => 'jpg,jpeg,png,svg',
                    ),
                    array(
                        'key' => 'field_5cb2ffd3dff24',
                        'label' => 'Vimeo oder YouTube Video',
                        'name' => 'block_us_mediantext_video',
                        'type' => 'oembed',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => array(
                            array(
                                array(
                                    'field' => 'field_5cb2ff4bdff23',
                                    'operator' => '!=',
                                    'value' => 'image',
                                ),
                            ),
                        ),
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'wpml_cf_preferences' => 0,
                        'width' => '',
                        'height' => '',
                    ),
                    array(
                        'key' => 'field_5caf6bb41001e',
                        'label' => 'Untertitel',
                        'name' => 'block_us_mediantext_media_caption',
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
                        'key' => 'field_5caf6be41001f',
                        'label' => 'Media zeigen...',
                        'name' => 'block_us_mediantext_media_lr',
                        'type' => 'button_group',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'wpml_cf_preferences' => 0,
                        'choices' => array(
                            'left' => 'Links',
                            'right' => 'Rechts',
                        ),
                        'allow_null' => 0,
                        'default_value' => 'left',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                    ),
                    array(
                        'key' => 'field_5caf6c2610020',
                        'label' => 'Text',
                        'name' => '',
                        'type' => 'column',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'column-type' => '1_2',
                        'wpml_cf_preferences' => 0,
                    ),
                    array(
                        'key' => 'field_5caf6c3b10021',
                        'label' => 'Überschrift',
                        'name' => 'block_us_mediantext_text_hl',
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
                        'key' => 'field_5caf6c4f10022',
                        'label' => 'Text',
                        'name' => 'block_us_mediantext_text',
                        'type' => 'wysiwyg',
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
                        'tabs' => 'visual',
                        'toolbar' => 'basic',
                        'media_upload' => 0,
                        'delay' => 0,
                    ),
                ),
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-mediantext',
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
$block_us_mediantext = new block_us_mediantext();
