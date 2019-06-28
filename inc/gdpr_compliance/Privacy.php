<?php

namespace US;

class Privacy{

	function __construct(){
		add_filter( 'pre_comment_user_ip', array($this, 'ipShortener') );
		$this->disableDNSPrefetch();
		add_action( 'init', array($this, 'disableEmojis' ));
		add_action( 'init', array($this, 'disableAvatars'));
		add_action('wp_head', array($this, 'usDNSPrefetch'), 3);
		add_filter( 'script_loader_src', array($this, 'activateCDNUsage') );
		add_filter( 'style_loader_src', array($this, 'activateCDNUsage') );
		add_action( 'init', array($this, 'disableSome'), 9999999 );
		//add_action('wp_head', array($this, 'writeGAScript'), 99);
        add_action('wp_head', array($this, 'ownComment'), 0);
        if(get_field("cc", "option")) add_action( 'wp_enqueue_scripts', array($this, 'enqueue_cc_scripts'));
	}
	
	public function ownComment(){
		echo '<!-- Site has been optimized with "DSGVO Helper v2" by urbanstudio.de -->';	
	}
    
    public function enqueue_cc_scripts(){
		global $CC_URL_de, $CC_URL_en;
        wp_enqueue_style( 'usdsgvo_cc_style', get_template_directory_uri()."/js/cookieconsent2/cookieconsent.min.css" );
        wp_enqueue_script( 'usdsgvo_cc_script', get_template_directory_uri()."/js/cookieconsent2/cookieconsent.min.js" );
        if (!defined("ICL_LANGUAGE_CODE")) {
            wp_enqueue_script('usdsgvo_cc_custom', $CC_URL_de, array( 'usdsgvo_cc_script' ));
        }else{
            wp_enqueue_script('usdsgvo_cc_custom-'.ICL_LANGUAGE_CODE, ${"CC_URL_".ICL_LANGUAGE_CODE}, array( 'usdsgvo_cc_script' ));
        }
    }
	public static function writeCCScript($lang = "de"){
		global $CC_FILE_de, $CC_FILE_en;
		$basejson = '{
					  "palette": {
					    "popup": {
					      "background": "#dbd9d9",
					      "text": "#000000"
					    },
					    "button": {
					      "background": "#393b78",
					      "text": "#ffffff"
					    }
					  },
					  "position": "bottom-left",
					  "content": {
					    "message": "Um unsere Webseite für Sie optimal zu gestalten und fortlaufend verbessern zu können, verwenden wir Cookies. Durch die weitere Nutzung der Webseite stimmen Sie der Verwendung von Cookies zu. Weitere Informationen zu Cookies erhalten Sie in unserer",
					    "dismiss": "Verstanden",
					    "link": "Datenschutzerklärung",
					    "href": "/datenschutzerklaerung/"
					  }
					}';
		$bj = json_decode($basejson);
		//$bj->position = $this->cc_position;
        //if(empty($this->cc_position)) unset($bj->position);
        if(get_field("cc_position","option") == "bottom"){
            unset($bj->position);
        }else{
            $bj->position = get_field("cc_position","option");
        }
		if(get_field("cc_popup_background","option")) $bj->palette->popup->background = get_field("cc_popup_background","option");
		if(get_field("cc_popup_text","option")) $bj->palette->popup->text = get_field("cc_popup_text","option");
		if(get_field("cc_button_background","option")) $bj->palette->button->background = get_field("cc_button_background","option");
		if(get_field("cc_button_text","option")) $bj->palette->button->text = get_field("cc_button_text","option");
		if(get_field("cc_message_$lang","option")) $bj->content->message = get_field("cc_message_$lang","option");
		if(get_field("cc_dismiss_$lang","option")) $bj->content->dismiss = get_field("cc_dismiss_$lang","option");
		global $wp_version;
		if ( version_compare( $wp_version, '4.9.6', '>=' ) && !empty(get_privacy_policy_url())) {
			// WordPress version is greater than 4.9.6
            if (ICL_LANGUAGE_CODE == "de") {
                $bj->content->href = get_privacy_policy_url();
            }else{
				$bj->content->href = "/en/privacy-policy/";
			}
		}else{
			if(get_field("cc_href","option")) $bj->content->href = get_field("cc_href","option");
		}
		if(get_field("cc_link_$lang","option")) $bj->content->link = get_field("cc_link_$lang","option");
		$basescript = '
			window.addEventListener("load", function(){
				window.cookieconsent.initialise('.json_encode($bj).')
			});
			';
        //if(!is_dir(USDSGVO_DIR)) wp_mkdir_p(USDSGVO_DIR);
        if (defined("ICL_LANGUAGE_CODE")) {
            if (!file_put_contents(${"CC_FILE_".$lang}, $basescript)) {
                return new WP_Error('broke', __("Could not write new Cookie Consent File", "usdsgvo"));
            }
        }else{
            if (!file_put_contents($CC_FILE_de, $basescript)) {
                return new WP_Error('broke', __("Could not write new Cookie Consent File", "usdsgvo"));
            }
        }
        
		return true;	
	}

	// Helper functions
	public function disableSome(){
		remove_action('wp_head', 'wlwmanifest_link');
	    remove_action('wp_head', 'rsd_link');
	    remove_action('wp_head', 'wp_shortlink_wp_head');
		remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    	remove_action('wp_head', 'wp_generator');
    	add_filter('the_generator', '__return_false');
    	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );	
	}
	
	private function oldCommentsClearIP(){
		global $wpdb;
		$query = $wpdb->prepare("UPDATE $wpdb->comments SET `comment_author_IP` = '' WHERE `comment_author_IP` != ''", '');
		$res = $wpdb->query( $query );
		if($res) update_option("usdsgvo_oldcomments", 0);
	}
	
	public function activateCDNUsage( $url ){
		if($this->usecdn){
			$search_array = array("fonts.googleapis.com" => "cdnjs.urbanstudio.de/fonts", "ajax.googleapis.com" => "cdnjs.urbanstudio.de", "cdnjs.cloudflare.com" => "cdnjs.urbanstudio.de", "maxcdn.bootstrapcdn.com/font-awesome" => "cdnjs.urbanstudio.de/ajax/libs/font-awesome"); // maybe ext
			$pu = parse_url($url, PHP_URL_HOST);
			if($pu == "code.jquery.com"){
				$url = codeJqueryReplace($url);
			}else{
				foreach($search_array AS $needle => $replace){
					$url = str_replace($needle, $replace, $url);
				}
			}
			$url = str_replace("maxcdn.bootstrapcdn.com/font-awesome", "cdnjs.urbanstudio.de/ajax/libs/font-awesome", $url);
			$url = str_replace( site_url(), '', $url );
		    // why pass by reference on count? last arg
		    return str_replace( array( 'http:', 'https:' ), '', $url);
		}else{
			return $url;	
		}
	}
	// add cdnjs.urbanstudio.de to dns-prefetch
	public function usDNSPrefetch() {
        echo '
            <meta http-equiv="x-dns-prefetch-control" content="on">
            <link rel="dns-prefetch" href="//cdnjs.urbanstudio.de" />
            <link rel="preconnect" href="//cdnjs.urbanstudio.de">
        ';
	}
	
	// Disable Avatars
	public function disableAvatars(){
		update_option("show_avatars", "");
	}
	
	// Disable Emojis
	public function disableEmojis() {
        remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
        remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
        remove_action( 'wp_print_styles', 'print_emoji_styles' );
        remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
        remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
        remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
        remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
        add_filter( 'tiny_mce_plugins', array($this, 'disable_emojis_tinymce' ));
        add_filter( 'wp_resource_hints', array($this, 'disable_emojis_remove_dns_prefetch'), 10, 2 );
	}

	// Disable Emojis - Helper for TinyMCE
	public function disable_emojis_tinymce( $plugins ) {
		if ( is_array( $plugins ) ) {
			return array_diff( $plugins, array( 'wpemoji' ) );
		} else {
			return array();
		}
	}

	// Disable Emojis - Helper for DNS-Prefetch
	public function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
		if ( 'dns-prefetch' == $relation_type ) {
			/** This filter is documented in wp-includes/formatting.php */
			$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
			
			$urls = array_diff( $urls, array( $emoji_svg_url ) );
		}
		return $urls;
	}

	public function disableDNSPrefetch(){
		remove_action('wp_head', 'wp_resource_hints', 2);	
	}
	public function ipShortener($comment_author_ip){
		$tmp = explode(".", $comment_author_ip);
		if(!$this->ipshortener){
			return $comment_author_ip;
		}elseif($this->ipshortener == 1){
			foreach($tmp AS $i => $ippart){
				if($i < 3) $usdsgvo_caip[] = $ippart;
				if($i == 3) $usdsgvo_caip[] = 0;
			}
			return implode(".", $usdsgvo_caip);
		}else{
			return '';
		}
		return;
	}
	
	private function codeJqueryReplace($body){
	    $pregs = array(
	        "/\/\/code\.jquery\.com\/jquery(-[a-z]*)?-([0-9,\.]*)(\.[a-z,\.]*)/",
	        "/\/\/code\.jquery\.com\/ui\/([0-9,\.]*)\/(.*)/",
	        "/\/\/code\.jquery\.com\/mobile\/([0-9,\.]*)\/(.*)(-[0-9,\.]*)(\..*)/",
	        "/\/\/code\.jquery\.com\/qunit\/qunit-([0-9,\.]*)(\.js)/",
	        "/\/\/code\.jquery\.com\/color\/(.*)-([0-9,\.]*)(\..*)/",
	        "/\/\/code\.jquery\.com\/pep\/([0-9,\.]*)\/(.*)/"
	        
	
	    );
	
	    $replaces = array(
	        '//cdnjs.urbanstudio.de/ajax/libs/jquery\1/\2/jquery\1\3',
	        '//cdnjs.urbanstudio.de/ajax/libs/jqueryui/\1/\2',
	        '//cdnjs.urbanstudio.de/ajax/libs/jquery-mobile/\1/\2\4',
	        '//cdnjs.urbanstudio.de/ajax/libs/qunit/\1/qunit\2',
	        '//cdnjs.urbanstudio.de/ajax/libs/jquery-color/\2/\1\3',
	        '//cdnjs.urbanstudio.de/ajax/libs/jquery.pep/\1/\2'
	        
	    );
	
	    return preg_replace($pregs,$replaces,$body);
	}	
}
$usPrivacy = new Privacy;