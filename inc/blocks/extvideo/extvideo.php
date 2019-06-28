<?php
/**
 * "external Video" Block for Gutenberg
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
class block_us_extvideo{

    public $showYT;
    public $showVIMEO;
    public $showGMap;
    /**
     * constructor adds action on "acf/init" to register block
     */
    function __construct(){
        add_action('acf/init', array($this, "block_us_extvideo_register"));
        add_action( 'rest_api_init', function () {
            register_rest_route( 'block_us_extvideo/v1', '/allow/(?P<allowtype>[a-z]+)', array(
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
    public function block_us_extvideo_register(){
        $this->block_us_extvideo_fields();
        acf_register_block(array(
            'name'				=> 'block_us_extvideo',
            'title'				=> __('YT plus Vimeo', "uslang"),
            'description'		=> __('erzeugt einen Block, mit YouTube oder Vimeo Video und Datenschutzabfrage.', "uslang"),
            'render_callback'	=> array($this, 'block_us_extvideo_render'),
            'category'		=> 'usblocks',
            'icon'			=> 'format-image',
            'mode'          => 'preview',
            'keywords'		=> array("article", "related"),
            'supports'      => array("align" => array("center","wide","full")),
            'enqueue_assets' => function(){
                wp_enqueue_style( 'block-us-extvideo', get_template_directory_uri()."/inc/blocks/extvideo/extvideo.css");
                wp_enqueue_script( 'block-us-extvideo', get_template_directory_uri()."/inc/blocks/extvideo/extvideo.js", array('jquery'), '', true );
            }
        ));
        //add_editor_style("inc/blocks/extvideo/extvideo.css");
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
    public function block_us_extvideo_render($block, $content = '', $is_preview = false, $post_id = null){
        $this->processCookies();
        $type = get_field('block_us_extvideo_type');
        $image = get_field('block_us_extvideo_image');
        $video = get_field('block_us_extvideo_video');
        $caption = get_field('block_us_extvideo_caption');

        $blockid = 'block_extvideo-' . $block['id'];
        // create align class ("alignwide") from block setting ("wide")
        $alignclass = $block['align'] ? 'align' . $block['align'] : '';
        //$alignclass = 'alignfull';
        $c = "";
        //if(!\is_admin()) wp_enqueue_style("block_extvideo_style", get_template_directory_uri()."/inc/blocks/extvideo/extvideo.css");
        $tc = '<div class="grid-column '.($medialr == "left" ? "right" : "left").'">';
            $tc .= '<div class="grid-text">';
                $tc .= '<h3>'.$hl.'</h3>';
                $tc .= '<div class="text">'.$text.'</div>';
            $tc .= '</div>';
        $tc .= '</div>';
        if($type && $video){
            if(!$image){
                // use default image
                $image = array(); $image["sizes"] = array();
                $image["sizes"]["medium"] = get_template_directory_uri()."/inc/blocks/extvideo/medium.jpg";
                $image["sizes"]["large"] = get_template_directory_uri()."/inc/blocks/extvideo/large.jpg";
            }
            echo '<div class="block_extvideo extvideo-container '.$alignclass.'" id="'.$blockid.'">';
                echo '<figure class="extvideo">';
                    echo '<div class="poster">';
                        echo '<img class="image-responsive" src="'.$image["sizes"]["medium"].'" srcset="'.$image["sizes"]["medium"].' 1x, '.$image["sizes"]["large"].' 2x" alt="'.esc_attr($caption).'">';
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
        $link = "<a href=\"".get_privacy_policy_url()."\" target=\"_blank\">".__("Datenschutzerklärung","uslang")."</a>";
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
    public function block_us_extvideo_fields(){
        if( function_exists('acf_add_local_field_group') ):

            acf_add_local_field_group(array(
                'key' => 'group_5cb4c702a5836',
                'title' => 'Block: YT plus Vimeo',
                'fields' => array(
                    array(
                        'key' => 'field_5cb4c702bb018',
                        'label' => 'Art',
                        'name' => 'block_us_extvideo_type',
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
                            'vimeo' => 'Vimeo',
                            'youtube' => 'YouTube',
                        ),
                        'allow_null' => 0,
                        'default_value' => 'youtube',
                        'layout' => 'horizontal',
                        'return_format' => 'value',
                    ),
                    array(
                        'key' => 'field_5cb4c702bb068',
                        'label' => 'Vorschaubild',
                        'name' => 'block_us_extvideo_image',
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
                        'mime_types' => 'jpg,jpeg,png,svg',
                    ),
                    array(
                        'key' => 'field_5cb4c702bb0a5',
                        'label' => 'Vimeo oder YouTube Video',
                        'name' => 'block_us_extvideo_video',
                        'type' => 'oembed',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'width' => '',
                        'height' => '',
                    ),
                    array(
                        'key' => 'field_5cb4c702bb0f5',
                        'label' => 'Untertitel',
                        'name' => 'block_us_extvideo_caption',
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
                'location' => array(
                    array(
                        array(
                            'param' => 'block',
                            'operator' => '==',
                            'value' => 'acf/block-us-extvideo',
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
$block_us_extvideo = new block_us_extvideo();
