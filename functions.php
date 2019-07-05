<?php
/**
 * museum4punkt0 functions and definitions
 *
 * @package museum4punkt0
 */

if ( ! function_exists( 'museum4punkt0_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */


function museum4punkt0_setup() {
	global $wpdb;


	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on urbanstudio, use a find and replace
	 * to change 'urbanstudio' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'museum4punkt0', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'mainmenu' => __( 'Haupt-Navigation', 'museum4punkt0' ),
		'footnav' => __( 'Fuß-Navigation', 'museum4punkt0' )
	) );


	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array('quote','gallery','video'));

	add_theme_support( 'align-wide' );

	//add_theme_support('editor-styles');
	//add_editor_style( 'style-editor.css' );
	/**
	 * Disable admin bar in frontend
	 */
	add_filter('show_admin_bar', '__return_false');
	// Set up the WordPress core custom background feature.
	/*add_theme_support( 'custom-background', apply_filters( 'urbanstudio_custom_background_args', array(
		'default-color' => 'e9e9e9',
		'default-image' => '',
	) ) );*/
	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
	/**
	 * Add support for core custom logo.
	 *
	 * @link https://codex.wordpress.org/Theme_Logo
	 */
	add_theme_support( 'custom-logo', array(
		'height'      => 80,
		'width'       => "auto",
		'flex-width'  => true,
		'flex-height' => true,
	) );
	// Adding support for core block visual styles.
	add_theme_support( 'wp-block-styles' );

	add_theme_support( 'editor-styles' );
	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );
	// Add support for custom color scheme.
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => __( 'Strong Blue', 'museum4punkt0' ),
			'slug'  => 'strong-blue',
			'color' => '#0073aa',
		),
		array(
			'name'  => __( 'Lighter Blue', 'museum4punkt0' ),
			'slug'  => 'lighter-blue',
			'color' => '#229fd8',
		),
		array(
			'name'  => __( 'Very Light Gray', 'museum4punkt0' ),
			'slug'  => 'very-light-gray',
			'color' => '#eee',
		),
		array(
			'name'  => __( 'Very Dark Gray', 'museum4punkt0' ),
			'slug'  => 'very-dark-gray',
			'color' => '#444',
		),
	) );
	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );
	// Allow excerpts on pages
	add_post_type_support( 'page', 'excerpt' );
}
endif; // urbanstudio_setup
add_action( 'after_setup_theme', 'museum4punkt0_setup' );

if(defined("ICL_LANGUAGE_CODE")){
	if(ICL_LANGUAGE_CODE == "en"){
		date_default_timezone_set("Europe/Berlin");
		setlocale(LC_ALL,"en_GB.utf8","en_GB","en_GB","en","gb");
	}else{
		date_default_timezone_set("Europe/Berlin");
		setlocale(LC_ALL,"de_DE.utf8","de_DE@euro","de_DE","de","ge");
	}
}else{
	date_default_timezone_set("Europe/Berlin");
	setlocale(LC_ALL,"de_DE.utf8","de_DE@euro","de_DE","de","ge");
}
if (defined("ICL_LANGUAGE_CODE")) {
	$CC_FILE_de = WP_CONTENT_DIR. '/uploads/usdsgvo_cache/js/usdsgvo_cc_custom-de.js';
	$CC_URL_de = WP_CONTENT_URL."/uploads/usdsgvo_cache/js/usdsgvo_cc_custom-de.js";
	$CC_FILE_en = WP_CONTENT_DIR. '/uploads/usdsgvo_cache/js/usdsgvo_cc_custom-en.js';
	$CC_URL_en = WP_CONTENT_URL."/uploads/usdsgvo_cache/js/usdsgvo_cc_custom-en.js";
}else{
    $CC_FILE_de = WP_CONTENT_DIR. '/uploads/usdsgvo_cache/js/usdsgvo_cc_custom-de.js';
    $CC_URL_de = WP_CONTENT_URL."/uploads/usdsgvo_cache/js/usdsgvo_cc_custom-de.js";
}
if(!is_dir(WP_CONTENT_DIR. '/uploads/usdsgvo_cache')){ mkdir(WP_CONTENT_DIR. '/uploads/usdsgvo_cache'); }
if(!is_dir(WP_CONTENT_DIR. '/uploads/usdsgvo_cache/js')){ mkdir(WP_CONTENT_DIR. '/uploads/usdsgvo_cache/js'); }
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function museum4punkt0_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'museum4punkt0_content_width', 760 );
}
add_action( 'after_setup_theme', 'museum4punkt0_content_width', 0 );

/*
*	Render Shortcodes in Widgets
*/
add_filter('widget_text', 'do_shortcode');


/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function museum4punkt0_widgets_init() {
	if(function_exists("icl_get_languages")) $languages = icl_get_languages('skip_missing=0&orderby=code&order=DESC');
    $headerlangs = array();
    if(!empty($languages)){
        foreach($languages as $l){
			array_push($headerlangs, $l);
			register_sidebar(array(
				'id' => 'sidebar_'.$l['language_code'],
				'name' => 'Sidebar '.strtoupper($l['language_code']),
				'before_widget' => '<div id="%1$s" class="widget  %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<div class="headline no-margin"><h4>',
				'after_title' => '</h4></div>',
			));
        }
    }

	/*register_sidebar(array(
        'id' => 'footer-text',
        'name' => 'About Text in Footer',
        'before_widget' => '<div id="%1$s" class="widget  %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<div class="headline no-margin"><h4>',
        'after_title' => '</h4></div>',
    ));*/


}
add_action( 'widgets_init', 'museum4punkt0_widgets_init' );

/**
 * Register Theme Gutenberg Blocks
 */
$blockstyles = array();
$us_blockspath = dirname(__FILE__)."/inc/blocks/";
$usb = scandir($us_blockspath); $us_blocks = array();
foreach($usb AS $i => $us_blockfile)
{
	if(is_dir($us_blockspath.$us_blockfile) && !in_array($us_blockfile, array(".","..")))
	{
		require_once($us_blockspath.$us_blockfile."/".$us_blockfile.".php");
		array_push($blockstyles, "inc/blocks/".$us_blockfile."/".$us_blockfile.".css");
	}
}

/**
 * Register Theme Gutenberg Blocks Category within Gutenberg editor
 */
function museum4punkt0_block_categories( $categories, $post ) {
	if ( $post->post_type !== 'post' ) {
		//return $categories;
	}
	return array_merge(
		$categories,
		array(
			array(
				'slug' => 'usblocks',
				'title' => __( 'Museum 4.0 Blöcke', 'museum4punkt0' ),
			),
		)
	);
}
add_filter( 'block_categories', 'museum4punkt0_block_categories', 10, 2 );

require(get_template_directory()."/inc/cpt_tax.php");

function museum4punkt0_themeoptions_acf_save_post( $post_id ) {
	
    // get new value
    $cc = get_field('cc', "options");
    if($cc == 1){
		if(function_exists("icl_get_languages")) $languages = icl_get_languages('skip_missing=0&orderby=code&order=DESC');
        if (!empty($languages)) {
            foreach ($languages as $l) {
                US\Privacy::writeCCScript($l["language_code"]);
            }
        }
	}else{
		return wp_delete_file($CC_FILE);		
	}
    
    // do something
    
}

add_action('acf/save_post', 'museum4punkt0_themeoptions_acf_save_post', 20);
/**
 * Enqueue styles
 */
function museum4punkt0_styles() {

	//wp_enqueue_style( 'museum4punkt0/font-lato', "//cdnjs.urbanstudio.de/fonts/css?family=Lato:300,400,700" );
	wp_enqueue_style( 'museum4punkt0/fonts-m40', get_template_directory_uri().'/css/fonts.css' );
	wp_enqueue_style( 'museum4punkt0/fontawesome', get_template_directory_uri().'/css/fonts/font-awesome-pro/css/all.min.css' );

	wp_enqueue_style( 'museum4punkt0/base', get_template_directory_uri().'/style.css', array("museum4punkt0/fonts-m40","museum4punkt0/fontawesome") );
	wp_enqueue_style( 'museum4punkt0/form', get_template_directory_uri().'/usform.css', array("museum4punkt0/base") );

	wp_enqueue_style( 'us/magnific-popup', get_template_directory_uri().'/css/mfp.css' );
}
add_action( 'wp_enqueue_scripts', 'museum4punkt0_styles' );
/**
 * Enqueue scripts
 */
function museum4punkt0_scripts() {

	wp_enqueue_script('jquery');
	wp_enqueue_script( 'us/magnificpopup', get_template_directory_uri() . '/js/mfp.min.js', array( 'jquery' ), '', true ); // magnific popup
	if(defined("ICL_LANGUAGE_CODE")){
		wp_enqueue_script( 'us/magnificpopup/lang', get_template_directory_uri() . '/js/mfp.'.ICL_LANGUAGE_CODE.'.js', array( 'jquery', 'us/magnificpopup' ), '', true ); // magnific popup
	}
    wp_enqueue_script( 'museum4punkt0/custom', get_template_directory_uri() . '/js/custom.js', array( 'jquery' ), '', true );
}
add_action( 'wp_enqueue_scripts', 'museum4punkt0_scripts' );

/**
 * Enqueue block editor style
 */
function museum4punk0_block_editor_styles() {
	global $blockstyles;
	wp_enqueue_style( 'us-editor-styles', get_theme_file_uri( '/custom-editor-style.css' ), false, '1.0', 'all' );
    foreach ($blockstyles as $as) {
        wp_enqueue_style('us-editor-styles-'.$as, get_theme_file_uri('/'.$as), false, '1.0', 'all');
    }
}
add_action( 'enqueue_block_editor_assets', 'museum4punk0_block_editor_styles' );
/**
 * Archive title without category prefixed
 *
 * @param [type] $title
 * @return void
 */
function remove_category_prefix_from_archive_title( $title ) {
	if ( is_category() ) {
            $title = single_cat_title( '', false );

        } elseif ( is_tag() ) {
            $title = single_tag_title( '', false );

        } elseif ( is_author() ) {
            $title = '<span class="vcard">' . get_the_author() . '</span>' ;
        }elseif (is_archive()){
			$title = post_type_archive_title( '', false );
		}

    return $title;
}
add_filter( 'get_the_archive_title', 'remove_category_prefix_from_archive_title' );

/**
 * Load themeHelper class file.
 */
require get_template_directory() . '/inc/classes/themeHelper.php';

/**
 * Load Shortcodes file.
 */
require get_template_directory() . '/inc/shortcodes.php';

/**
 * Load Widgets file.
 */
require get_template_directory() . '/inc/widgets.php';

/**
 * Load GDPR-Compliance files.
 */
require get_template_directory() . '/inc/gdpr_compliance/comments.php';
require get_template_directory() . '/inc/gdpr_compliance/Privacy.php';


/**
 * Load media fields file.
 */
require get_template_directory() . '/inc/media_custom_fields.php';



set_post_thumbnail_size(850, 400, false); //size of thumbs
add_image_size('small-thumb', 49, 49, true);
add_image_size('big-thumb', 320, 320, true);
//add_image_size('slider', 372, 255, true);

// US Bilder
add_image_size("teasergrid", 1200, 900, true);
add_image_size("heroimage_full", 1920, 640, true);
add_image_size("heroimage_wide", 1400, 467, true);
add_image_size('aboutbox', 250, 250, true);

add_image_size("blogpreview", 1200, 1200, false);

// Gallery
add_image_size("gallery_preview_1x", 520, 344, true);
add_image_size("gallery_preview_2x", 1040, 688, true);
//add_image_size('slide_desktop', 1400, 440, true);
//add_image_size('background', 1400, 520, true);
//add_image_size("boxes", 600, 325, true);
//add_image_size("contact", 280, 280, false);

//add_image_size('slide_desktop', 1400, 440, true);
//add_image_size('slide_desktop_wide', 2000, 629, true);
//add_image_size('slide_mobile', 800, 600, true);
//add_image_size('slides__mobil_2x', 1280, 800, true);
//add_image_size('gallery-big', 1200, 1200, false);
//add_image_size('preview', 680, 452, true);
//add_image_size('preview_masonry', 680, 0, true);
//add_image_size('preview_blog', 800, 531, true);


remove_action('wp_head', 'wp_generator');



function fix_img_caption_shortcode_inline_style($output,$attr,$content) {
	$atts = shortcode_atts( array(
		'id'	  => '',
		'align'	  => 'alignnone',
		'width'	  => '',
		'caption' => '',
		'class'   => '',
	), $attr, 'caption' );

	$atts['width'] = (int) $atts['width'];
	if ( $atts['width'] < 1 || empty( $atts['caption'] ) )
		return $content;

	if ( ! empty( $atts['id'] ) )
		$atts['id'] = 'id="' . esc_attr( $atts['id'] ) . '" ';

	$class = trim( 'wp-caption ' . $atts['align'] . ' ' . $atts['class'] );

	if ( current_theme_supports( 'html5', 'caption' ) ) {
		return '<figure ' . $atts['id'] . ' class="' . esc_attr( $class ) . '">'
		. do_shortcode( $content ) . '<figcaption class="wp-caption-text">' . $atts['caption'] . '</figcaption></figure>';
	}

	$caption_width = 10 + $atts['width'];

	$caption_width = apply_filters( 'img_caption_shortcode_width', $caption_width, $atts, $content );

	$style = '';

	return '<div ' . $atts['id'] . $style . 'class="' . esc_attr( $class ) . '">'
		. do_shortcode( $content ) . '<p class="wp-caption-text">' . $atts['caption'] . '</p></div>';
}

add_filter('img_caption_shortcode','fix_img_caption_shortcode_inline_style',10,3);

function shortcode_empty_paragraph_fix( $content ) {

    // define your shortcodes to filter, '' filters all shortcodes
    $shortcodes = array( '' );

    foreach ( $shortcodes as $shortcode ) {

        $array = array (
            '<p>[' . $shortcode => '[' .$shortcode,
            '<p>[/' . $shortcode => '[/' .$shortcode,
            $shortcode . ']</p>' => $shortcode . ']',
            $shortcode . ']<br />' => $shortcode . ']'
        );

        $content = strtr( $content, $array );
    }

    return $content;
}

add_filter( 'the_content', 'shortcode_empty_paragraph_fix' );

if( function_exists('acf_add_options_page') ) {

	acf_add_options_page(array(
		'page_title' 	=> 'Theme Einstellungen',
		'menu_title'	=> 'Theme Optionen',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
/*
	acf_add_options_sub_page(array(
		'page_title' 	=> 'Startseiten - Einstellungen',
		'menu_title'	=> 'Startseite',
		'parent_slug'	=> 'theme-general-settings',
	));

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Datenschutz - Einstellungen',
		'menu_title'	=> 'Datenschutz',
		'parent_slug'	=> 'theme-general-settings',
	));
*/
}




function urbanstudio_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>" class="comment-container">
		<div class="comment-author">
        	<?php printf(__('<div class="user">%s</div>'), get_comment_author_link()) ?>
 		</div>
		<?php if ($comment->comment_approved == '0') : ?>
			<div class="notapprovedyet"><?php echo __("Ihr Beitrag wurde noch nicht freigeschaltet.", "uslang"); ?></div>
		<?php endif; ?>
		<div class="comment-content"><?php comment_text() ?></div>
		<div class="date"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?></a></div>
		<div class="reply">
        <?php edit_comment_link(__('Edit'),'',' &nbsp;&middot;&nbsp; ') ?><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
		</div>
		<div class="clear"></div>
	</div>
<?php
}

add_filter( 'get_comment_author_link', 'open_comment_author_link_in_new_window' );
function open_comment_author_link_in_new_window( $author_link ) {
    return str_replace( "<a", "<a target='_blank'", $author_link );
}


function nav_breadcrumb() {

 $delimiter = ' &nbsp; <i class="fa fa-angle-right" aria-hidden="true"></i> &nbsp; ';
 $home = '<i class="fa fa-home" aria-hidden="true"></i>';
 $before = '<span class="current-page">';
 $after = '</span>';

 if ( !is_home() && !is_front_page() || is_paged() ) {

 echo '<nav class="breadcrumb">';

 global $post;
 $homeLink = get_bloginfo('url');
 echo '<a href="' . $homeLink . '" class="home">' . $home . '</a> ' . $delimiter . ' ';

 if ( is_category()) {
 global $wp_query;
 $cat_obj = $wp_query->get_queried_object();
 $thisCat = $cat_obj->term_id;
 $thisCat = get_category($thisCat);
 $parentCat = get_category($thisCat->parent);
 if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, ' ' . $delimiter . ' '));
 echo $before . single_cat_title('', false) . $after;

 } elseif ( is_day() ) {
 echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
 echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
 echo $before . get_the_time('d') . $after;

 } elseif ( is_month() ) {
 echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
 echo $before . get_the_time('F') . $after;

 } elseif ( is_year() ) {
 echo $before . get_the_time('Y') . $after;

 } elseif ( is_single() && !is_attachment() ) {
 if ( get_post_type() != 'post' ) {
 $post_type = get_post_type_object(get_post_type());
 //echo '<pre>'.print_r($post_type,1).'</pre>';
 // $slug = $post_type->rewrite;
 $slug = $post_type->rewrite != $post_type->has_archive ? $post_type->has_archive : $post_type->rewrite["slug"];
// echo '<a href="' . $homeLink . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
 echo '<a href="' . $homeLink . '/' . $slug . '/">' . $post_type->label . '</a> ' . $delimiter . ' ';
 echo $before . get_the_title() . $after;
 } else {
 $cat = get_the_category(); $cat = $cat[0];
 echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
 echo $before . get_the_title() . $after;
 }

 } elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
 $post_type = get_post_type_object(get_post_type());
 echo $before . $post_type->labels->singular_name . $after;


 } elseif ( is_attachment() ) {
 $parent = get_post($post->post_parent);
 $cat = get_the_category($parent->ID); $cat = $cat[0];
 echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
 echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
 echo $before . get_the_title() . $after;

 } elseif ( is_page() && !$post->post_parent ) {
 echo $before . get_the_title() . $after;

 } elseif ( is_page() && $post->post_parent ) {
 $parent_id = $post->post_parent;
 $breadcrumbs = array();
 while ($parent_id) {
 $page = get_page($parent_id);
 $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
 $parent_id = $page->post_parent;
 }
 $breadcrumbs = array_reverse($breadcrumbs);
 foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
 echo $before . get_the_title() . $after;

 } elseif ( is_search() ) {
 echo $before . 'Ergebnisse für Ihre Suche nach "' . get_search_query() . '"' . $after;

 } elseif ( is_tag() ) {
 echo $before . 'Beiträge mit dem Schlagwort "' . single_tag_title('', false) . '"' . $after;

 } elseif ( is_tag() ) {
 echo $before . 'Beiträge mit dem Schlagwort "' . single_tag_title('', false) . '"' . $after;

 } elseif ( is_404() ) {
 echo $before . 'Fehler 404' . $after;
 }

 if ( get_query_var('paged') ) {
 if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
 echo ': ' . __('Seite') . ' ' . get_query_var('paged');
 if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
 }

 echo '</nav>';

 }
}

// Standard send mail
function sendMail($recipient, $subject, $text, $html, $var_array = array()){
	if(isset($var_array['sender'])) $sendermail = $var_array['sender'];
	if(isset($var_array['sendername'])) $sendername = $var_array['sendername'];
	if(isset($var_array['bcc'])) $bccmail = $var_array['bcc'];
	if(isset($var_array['replyto'])) $replytomail = $var_array['replyto'];
    require_once(dirname(__FILE__) . '/inc/classes/Rmail.php');
        /* Klasse initialisieren */
        $mail = new Rmail();
        // Absender
		$mail->setFrom(''.$sendername.' <'.$sendermail.'>');
		if(isset($bccmail) && $bccmail) $mail->setBcc($bccmail);
        $mail->setReturnPath(''.$sendermail.'');
        $mail->setHeader('Reply-To', ''.$replytomail.'');
        // Betreff
        $mail->setSubject($subject);
        if(isset($var_array["notpl"]) && $var_array["notpl"]){
       		//
        }else{
        	$html = str_replace("{TEXT}", $html, file_get_contents(get_template_directory_uri() . "/email.html"));
        }
        $mail->setHtml(utf8_encode($html));
        if($text) $mail->setText($text);
        $receiver = explode(";", $recipient);
        if($mail->send($receiver)){
        //if($mail->send(array(''.$recipient.''))){
            return true;
        }else{
        	return false;
        }
}

function header_lang_selector($separator = "/"){
    if(function_exists("icl_get_languages")) $languages = icl_get_languages('skip_missing=0&orderby=code&order=DESC&link_empty_to={%lang}');
    $headerlangs = array();
    if(!empty($languages)){
        foreach($languages as $l){
            $hl = "";
            if(!$l['active']) $hl .= '<a href="'.$l['url'].'" title="'.sprintf(__("Wechsle die Sprache zu %s", "museum4punkt0"), $l["native_name"]).'">';
            if($l["active"]) $hl .= '<strong>';
            $hl .= strtoupper($l['language_code']);
            if($l["active"]) $hl .= '</strong>';
            if(!$l['active']) $hl .= '</a>';
            array_push($headerlangs, $hl);
        }
    }
    return implode(" $separator ", $headerlangs);
}

function getmeacoffee(){
	$paypal_email = get_field('paypal_email', "option");
	$min = get_field('min', "option");
	$max = get_field('max', "option");
	$smalltext = get_field('smalltext', "option");
	$bigtext = get_field('bigtext', "option");
	$button = get_field('button', "option");
	if(!$min) $min = 1;
	if(!$max) $max = 1;
	if(!$button) $button = get_template_directory_uri()."/images/paypalbtn.png";

	$c = "";
	if($paypal_email){
		// rangeslider
		wp_enqueue_script("ion-range-slider", get_template_directory_uri()."/js/ion.rangeSlider-2.2.0/js/ion-rangeSlider/ion.rangeSlider.min.js", array("jquery"));
		wp_enqueue_style("ion-range-slider-css", get_template_directory_uri()."/js/ion.rangeSlider-2.2.0/css/ion.rangeSlider.css");
		wp_enqueue_style("ion-range-slider-skin-css", get_template_directory_uri()."/js/ion.rangeSlider-2.2.0/css/ion.rangeSlider.skinHTML5.css");
		wp_enqueue_style("ion-range-slider-normalize-css", get_template_directory_uri()."/js/ion.rangeSlider-2.2.0/css/normalize.css");
		$inlinescript = <<<EOF
			jQuery("input#amount").ionRangeSlider({
				min: $min,
				max: $max,
				postfix: "&euro;",
				hide_min_max: true,
				hide_from_to: true,
				onChange: function (data) {
					console.log(data.from);
					jQuery("div.amount span").text(data.from);
				}
			});

EOF;
		wp_add_inline_script("ion-range-slider", $inlinescript);
?>
		<div class="usgetmeacoffee">
			<h3><?php echo $smalltext; ?></h3>
			<h2><?php echo $bigtext; ?></h2>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">

				<!-- Identify your business so that you can collect the payments. -->
				<input type="hidden" name="business" value="<?php echo $paypal_email; ?>">

				<!-- Specify a Donate button. -->
				<input type="hidden" name="cmd" value="_donations">

				<!-- Specify details about the contribution -->
				<input type="hidden" name="item_name" value="<?php echo get_bloginfo("name"); ?>">
				<input type="hidden" name="item_number" value="Get me a coffee">
				<input type="hidden" name="amount" id="amount" value="<?php echo $min; ?>">
				<input type="hidden" name="currency_code" value="EUR">
				<div class="amount"><span>1</span> &euro;</div>
				<!-- Display the payment button. -->
				<input type="image" name="submit" src="<?php echo $button; ?>" alt="Donate">
				<img alt="" width="1" height="1" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" >
				</form>
		</div>
<?php
	}
}

function usHeaderImage( $atts, $content = null )
{
    extract( shortcode_atts(
                array(
					'active' => false,
					'title' => '',
                    'pic' => array()
                ),
                $atts
            )
	);
	//echo $active;
	$return = "";
	//$return = "<pre>".print_r($pic,1)."</pre>";
    if($active && count($pic) >= 1){
        $return .= '<section id="headergap"></section>';
        $return .= '<div id="showcase">';
            $return .= '<div class="bottomline"></div>';
			$return .= '<picture>';
				$return .= '<source media="(min-width: 1401px)" srcset="'.$pic["sizes"]["slide_desktop_wide"].'">';
				$return .= '<source media="(min-width: 660px)" srcset="'.$pic["sizes"]["slide_desktop"].' 1x, '.$pic["sizes"]["slide_desktop_wide"].' 2x">';
				$return .= '<source srcset="'.$pic["sizes"]["slide_desktop"].'">';
				$return .= '<img src="'.$pic["sizes"]["slide_desktop"].'" alt="'.$title.'">';
			$return .= '</picture>';
        $return .= '</div>';
    }
 return $return;
}

function kb_remove_page_for_posts_class_outside_blog( $classes, $item ) {
	if ( !is_singular( 'post' ) && !is_category() && !is_tag() && !is_date()) {
	  $blog_page_id = intval( get_option( 'page_for_posts' ) );
	  if ( $blog_page_id != 0 ) {
		if ( $item->object_id == $blog_page_id ) {
		  unset ( $classes[array_search( 'current_page_parent',$classes )] );
		}
	  }
	}
	if(is_singular("events")){
		$events_main_page = get_field("page_for_events","options");
		if($events_main_page){
			if ( $item->object_id == $events_main_page ) array_push($classes, "current-menu-item");
		}
	}elseif(is_singular("teilprojekt")){
		$tp_main_page = get_field("page_for_teilprojekt","options");
		//echo "Page for TP: $tp_main_page, $item->object_id";
		if($tp_main_page){
			if ( $item->object_id == $tp_main_page ) array_push($classes, "current-menu-item");
		}
	}elseif(is_singular("partner")){
		$partner_main_page = get_field("page_for_partner","options");
		if($partner_main_page){
			if ( $item->object_id == $partner_main_page ) array_push($classes, "current-menu-item");
		}
	}elseif(is_singular("news")){
		$news_main_page = get_field("page_for_news","options");
		if($news_main_page){
			if ( $item->object_id == $news_main_page ) array_push($classes, "current-menu-item");
		}
	}
  return $classes;
  }
  add_filter( 'nav_menu_css_class', 'kb_remove_page_for_posts_class_outside_blog', 10, 2 );

  /* sync ACF options */
add_action('acf/save_post',  __NAMESPACE__ . '\\sync_custom_field', 11);
function sync_custom_field ( $current_post_id ) {
    $post_ids = [];
     
    $langs = icl_get_languages('skip_missing=0&orderby=KEY&order=DIR&link_empty_to=str');
    $wpml_options = get_option( 'icl_sitepress_settings' );
    $default_lang = $wpml_options['default_language'];
     
    $option_pages = array();
    foreach ($langs as $language) {
         if($language['language_code'] === $default_lang){
             $post_ids[$default_lang] = 'options';
             $option_pages[] =  'options';
         } else {
            $post_ids[$language['language_code']] = 'options_'.$language['language_code'];
            $option_pages[] =  'options_'.$language['language_code'];;
         }
    }
     
    // Sync option page fields
    if (in_array($current_post_id,$option_pages)) { 
  
        // Get options page field groups set to sync
        $acf_field_groups = acf_get_field_groups(); 
         
        foreach ($acf_field_groups as $group) {
             
            $field_string .= $group['title'].', ';
            // Test if group should be synced
            //$acf_group_slug = \Weisang\Tools\slugify($group['title']);
            if ( !strpos($group['title'], 'translated') ) {
  
                // Get fields and sync them
                $acf_group_fields = acf_get_fields($group['ID']);
  
                foreach ($acf_group_fields as $field) {
                    if ($field['type'] == 'file') {
                        $value = get_field( $field['name'], $current_post_id, false);
  
                        foreach ($post_ids as $lang_id) {
                            if ( $current_post_id != $lang_id ) { update_field( $field['name'], $value, $lang_id); }     
                        }
                    } else {
                        $value = get_field( $field['name'], $current_post_id);  
  
                        foreach ($post_ids as $lang_id) {
                            if ( $current_post_id != $lang_id ) { update_field( $field['name'], $value, $lang_id); }     
                        }                     
                    }
                }
            }
                 
        }
    }  
}

// Blogfilters API Route

add_action( 'rest_api_init', function () {
	register_rest_route( 'blogfilters/v1', '/getposts/(?P<category>[\w-]+)/(?P<tag>[\w-]+)', array(
		'methods' => 'GET',
		'callback' => 'processBlogFiltersRequest'
	) );
} );

function processBlogFiltersRequest( WP_REST_Request $request ) {
	return processBlogFilters($request);
}

function processBlogFilters($data = null){
	$opts = array(
		'post_type' => "post",
		'post_status' => 'publish',
		'orderby' => 'date',
		'order'  => 'DESC',
		'numberposts' => -1,
	);
	if($data["category"] != "-" && $data["tag"] == "-"){
		$opts["category_name"] = $data["category"];
	}elseif($data["category"] == "-" && $data["tag"] != "-"){
		$opts["tag"] = $data["tag"];
	}elseif($data["category"] != "-" && $data["tag"] != "-"){
		$opts["category_name"] = $data["category"];
		$opts["tag"] = $data["tag"];
	}
	$posts = get_posts($opts);
	
	if ($posts) {
		ob_start();
		//echo '<div class="grid-sizer"></div><div class="gutter-sizer"></div>';
		foreach ($posts as $i => $post) {
			?>
			<article <?
				$tp = get_field("teilprojekt",$post); $pp = "";
				if($tp){
					$p = get_field("project", $tp);
					$pp = $p["value"];
				}
				if(!has_post_thumbnail()) { $class = 'loop no-image'; } else { $class = 'loop'; }
				$class .= " article ".$pp;
				post_class($class); ?> id="post-<?php echo $post->ID; ?>">

			<?php
				$tnid = get_post_thumbnail_id($post->ID);
				if($tnid){
					echo '<div class="image">';
						$tnid = get_post_thumbnail_id($post->ID);
						$srcset = wp_get_attachment_image_srcset($tnid, 'teasergrid');
						$src = wp_get_attachment_image_url($tnid, 'teasergrid');
						echo '<a href="'.get_the_permalink($post).'" title="'.esc_attr(get_the_title($post)).'">';
							echo '<img class="image-responsive blog-imageItem" src="'.$src.'" srcset="'.$srcset.'" alt="'.esc_attr(get_the_title($post)).'">';
						echo '</a>';
					echo '</div>';

				}
				echo '<div class="content">';
					echo '<time class="date" datetime="'.get_the_date("Y-m-d H:i:s",$post).'">'.get_the_date("",$post).'</time>';
					echo '<h3 class="article-title"><a href="'.get_the_permalink($post).'" title="'.esc_attr(get_the_title($post)).'">'.esc_html(get_the_title($post)).'</a></h3>';
					echo '<span class="excerpt">'.esc_html(get_the_excerpt($post)).'</span>';
				echo '</div>';
			echo '</article>';
		}
		$html = ob_get_clean();
		$response = new WP_REST_Response($html);
		$response->set_status(200);
		return $response;
	}else{
		//echo '<strong>'.__("Leider führte Ihre Suche zu keinem Ergebnis.", "uslang").'</strong>';
		return new WP_Error( 'empty_data', __("Leider führte Ihre Suche zu keinem Ergebnis."), array('status' => 404) );
	}
}

function kb_svg ( $svg_mime ){
	$svg_mime['svg'] = 'image/svg+xml';
	return $svg_mime;
}

add_filter( 'upload_mimes', 'kb_svg' );

// cpt results
function cptui_register_my_cpts_result() {

	/**
	 * Post Type: Ergebnisse.
	 */

	$labels = array(
		"name" => __( "Ergebnisse", "custom-post-type-ui" ),
		"singular_name" => __( "Ergebnis", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "Ergebnisse", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "result", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 16,
		"menu_icon" => "dashicons-format-aside",
		"supports" => array( "title", "editor", "thumbnail", "excerpt" ),
		"taxonomies" => array( "communicationmethod", "technology", "resulttype", "insights", "applicationfields" ),
	);

	register_post_type( "result", $args );
}

add_action( 'init', 'cptui_register_my_cpts_result' );

// cpt approaches
function cptui_register_my_cpts_approach() {

	/**
	 * Post Type: Umsetzungsansätze.
	 */

	$labels = array(
		"name" => __( "Umsetzungsansätze", "custom-post-type-ui" ),
		"singular_name" => __( "Umsetzungsansatz", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "Umsetzungsansätze", "custom-post-type-ui" ),
		"labels" => $labels,
		"description" => "",
		"public" => true,
		"publicly_queryable" => true,
		"show_ui" => true,
		"delete_with_user" => false,
		"show_in_rest" => true,
		"rest_base" => "",
		"rest_controller_class" => "WP_REST_Posts_Controller",
		"has_archive" => false,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"exclude_from_search" => false,
		"capability_type" => "post",
		"map_meta_cap" => true,
		"hierarchical" => false,
		"rewrite" => array( "slug" => "approach", "with_front" => true ),
		"query_var" => true,
		"menu_position" => 15,
		"supports" => array( "title", "editor", "thumbnail" ),
	);

	register_post_type( "approach", $args );
}

add_action( 'init', 'cptui_register_my_cpts_approach' );

// Result taxonomies
function cptui_register_my_taxes_communicationmethod() {

	/**
	 * Taxonomy: Wie wird vermittelt?.
	 */

	$labels = array(
		"name" => __( "Wie wird vermittelt?", "custom-post-type-ui" ),
		"singular_name" => __( "Vermittlungsmethode", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "Wie wird vermittelt?", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'communicationmethod', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "communicationmethod",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		);
	register_taxonomy( "communicationmethod", array( "result" ), $args );
}
add_action( 'init', 'cptui_register_my_taxes_communicationmethod' );


function cptui_register_my_taxes_technology() {

	/**
	 * Taxonomy: Technologie.
	 */

	$labels = array(
		"name" => __( "Technologie", "custom-post-type-ui" ),
		"singular_name" => __( "Technologie", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "Technologie", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'technology', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "technology",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		);
	register_taxonomy( "technology", array( "result" ), $args );
}
add_action( 'init', 'cptui_register_my_taxes_technology' );


function cptui_register_my_taxes_resulttype() {

	/**
	 * Taxonomy: Ergebnistypen.
	 */

	$labels = array(
		"name" => __( "Ergebnistypen", "custom-post-type-ui" ),
		"singular_name" => __( "Ergebnistyp", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "Ergebnistypen", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'resulttype', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "resulttype",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		);
	register_taxonomy( "resulttype", array( "result" ), $args );
}
add_action( 'init', 'cptui_register_my_taxes_resulttype' );

function cptui_register_my_taxes_insights() {

	/**
	 * Taxonomy: Erkenntnisse zu.
	 */

	$labels = array(
		"name" => __( "Erkenntnisse zu", "custom-post-type-ui" ),
		"singular_name" => __( "Erkenntnis", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "Erkenntnisse zu", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'insights', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "insights",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		);
	register_taxonomy( "insights", array( "result" ), $args );
}
add_action( 'init', 'cptui_register_my_taxes_insights' );

function cptui_register_my_taxes_applicationfields() {

	/**
	 * Taxonomy: Anwendungsbereiche.
	 */

	$labels = array(
		"name" => __( "Anwendungsbereiche", "custom-post-type-ui" ),
		"singular_name" => __( "Anwendungsbereich", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "Anwendungsbereiche", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'applicationfields', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "applicationfields",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		);
	register_taxonomy( "applicationfields", array( "result" ), $args );
}
add_action( 'init', 'cptui_register_my_taxes_applicationfields' );



/* ACF PHP include
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
	'key' => 'group_5d075d0591233',
	'title' => 'Ergebnis Meta',
	'fields' => array(
		array(
			'key' => 'field_5d076b81b9a15',
			'label' => 'Teilprojekt',
			'name' => 'project',
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
				0 => 'teilprojekt',
			),
			'taxonomy' => '',
			'filters' => '',
			'elements' => '',
			'min' => '',
			'max' => 1,
			'return_format' => 'object',
		),
		array(
			'key' => 'field_5d075d123206d',
			'label' => 'Umsetzungsansatz',
			'name' => 'approach',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'approach',
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1,
		),
		array(
			'key' => 'field_5d0cd37f819d0',
			'label' => 'Infobox',
			'name' => 'infobox',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_5d11eef22f034',
					'label' => 'Übergeordnetes Ergebnis',
					'name' => 'top_result',
					'type' => 'post_object',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'post_type' => array(
						0 => 'result',
					),
					'taxonomy' => '',
					'allow_null' => 0,
					'multiple' => 0,
					'return_format' => 'object',
					'ui' => 1,
				),
				array(
					'key' => 'field_5d0cd3a2819d1',
					'label' => 'Freitext Titel',
					'name' => 'freitext_titel',
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
					'key' => 'field_5d0cd3b9819d2',
					'label' => 'Freitext Inhalt',
					'name' => 'freitext_inhalt',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => array(
						array(
							array(
								'field' => 'field_5d0cd3a2819d1',
								'operator' => '!=empty',
							),
						),
					),
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'tabs' => 'all',
					'toolbar' => 'basic',
					'media_upload' => 0,
					'delay' => 1,
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'result',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5d09fe45ef5dd',
	'title' => 'Startseite',
	'fields' => array(
		array(
			'key' => 'field_5d09fe5d0d9bc',
			'label' => 'Leitfrage',
			'name' => 'leitfrage',
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
			'key' => 'field_5d09fe6f0d9bd',
			'label' => 'Leitfrage (zweiter Teil)',
			'name' => 'leitfrage_2',
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
			'key' => 'field_5d09fe880d9be',
			'label' => 'Introtext',
			'name' => 'introtext',
			'type' => 'textarea',
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
			'maxlength' => '',
			'rows' => '',
			'new_lines' => 'wpautop',
		),
		array(
			'key' => 'field_5d09fe970d9bf',
			'label' => 'Sektionen',
			'name' => 'sections',
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
					'key' => 'field_5d09fec20d9c0',
					'label' => 'Bild',
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
					'return_format' => 'url',
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
					'key' => 'field_5d09fed90d9c1',
					'label' => 'Sektionstitle',
					'name' => 'sectionstitle',
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
					'key' => 'field_5d09fee60d9c2',
					'label' => 'Sektionsinhalt',
					'name' => 'content',
					'type' => 'textarea',
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
					'maxlength' => '',
					'rows' => '',
					'new_lines' => 'wpautop',
				),
				array(
					'key' => 'field_5d0a02f2ac952',
					'label' => 'Sektionslink Name',
					'name' => 'link_name',
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
					'key' => 'field_5d09ff080d9c3',
					'label' => 'Sektionslink',
					'name' => 'link',
					'type' => 'page_link',
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
					'allow_null' => 0,
					'allow_archives' => 1,
					'multiple' => 0,
				),
			),
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'page_type',
				'operator' => '==',
				'value' => 'front_page',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5d075c7bbf596',
	'title' => 'Teilprojekt',
	'fields' => array(
		array(
			'key' => 'field_5d075c8162f9d',
			'label' => 'Umsetzungsansätze',
			'name' => 'approaches',
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
				0 => 'approach',
			),
			'taxonomy' => '',
			'filters' => array(
				0 => 'search',
				1 => 'post_type',
				2 => 'taxonomy',
			),
			'elements' => '',
			'min' => '',
			'max' => '',
			'return_format' => 'object',
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'teilprojekt',
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

acf_add_local_field_group(array(
	'key' => 'group_5bec39ca8c3e8',
	'title' => 'Teilprojekt zuweisen',
	'fields' => array(
		array(
			'key' => 'field_5cab8c486f4e3',
			'label' => 'Teilprojekt',
			'name' => 'teilprojekt',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'wpml_cf_preferences' => 0,
			'post_type' => array(
				0 => 'teilprojekt',
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'object',
			'ui' => 1,
		),
		array(
			'key' => 'field_5cc2bba3f1d53',
			'label' => 'weitere Teilprojekte',
			'name' => 'addtp',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cab8c486f4e3',
						'operator' => '!=empty',
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
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'multiple' => 1,
			'return_format' => 'object',
			'ui' => 1,
		),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'post',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'partner',
			),
		),
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'news',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'side',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'field',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
));

acf_add_local_field_group(array(
	'key' => 'group_5bee6439b4b4d',
	'title' => 'Theme Optionen',
	'fields' => array(
		array(
			'key' => 'field_5bfffde584f51',
			'label' => 'Allgemeines',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'wpml_cf_preferences' => 0,
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5caed6b5c3d41',
			'label' => 'Kommentare erlauben für...',
			'name' => 'allow_comments',
			'type' => 'checkbox',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '33',
				'class' => '',
				'id' => '',
			),
			'wpml_cf_preferences' => 0,
			'choices' => array(
				'post' => 'Blogbeiträge',
				'events' => 'Veranstaltungen',
				'news' => 'Pressenews',
				'teilprojekt' => 'Teilprojekte',
				'partner' => 'Partner',
			),
			'allow_custom' => 0,
			'default_value' => array(
				0 => 'post',
				1 => 'news',
			),
			'layout' => 'vertical',
			'toggle' => 0,
			'return_format' => 'value',
			'save_custom' => 0,
		),
		array(
			'key' => 'field_5caedf33c3d45',
			'label' => 'Teilen erlauben für...',
			'name' => 'allow_sharing',
			'type' => 'checkbox',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '33',
				'class' => '',
				'id' => '',
			),
			'wpml_cf_preferences' => 0,
			'choices' => array(
				'page' => 'Seiten',
				'post' => 'Blogbeiträge',
				'events' => 'Veranstaltungen',
				'news' => 'Pressenews',
				'teilprojekt' => 'Teilprojekte',
				'partner' => 'Partner',
			),
			'allow_custom' => 0,
			'default_value' => array(
				0 => 'post',
				1 => 'news',
				2 => 'events',
			),
			'layout' => 'vertical',
			'toggle' => 0,
			'return_format' => 'value',
			'save_custom' => 0,
		),
		array(
			'key' => 'field_5caedf82c3d46',
			'label' => 'Teilen via...',
			'name' => 'sharing_via',
			'type' => 'checkbox',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '33',
				'class' => '',
				'id' => '',
			),
			'wpml_cf_preferences' => 0,
			'choices' => array(
				'fb' => 'Facebook',
				'twitter' => 'Twitter',
				'wa' => 'WhatsApp',
				'email' => 'E-Mail',
			),
			'allow_custom' => 0,
			'default_value' => array(
				0 => 'fb',
				1 => 'twitter',
			),
			'layout' => 'vertical',
			'toggle' => 0,
			'return_format' => 'value',
			'save_custom' => 0,
		),
		array(
			'key' => 'field_5c07e2509437e',
			'label' => 'Copyright',
			'name' => 'copyrighttext',
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
			'maxlength' => 60,
		),
		array(
			'key' => 'field_5bee646a138e7',
			'label' => 'Socialmedia - Links',
			'name' => 'socialmedialinks',
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
					'key' => 'field_5bee6be24bdb1',
					'label' => 'Netzwerk',
					'name' => 'network',
					'type' => 'select',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '30',
						'class' => '',
						'id' => '',
					),
					'wpml_cf_preferences' => 0,
					'choices' => array(
						'none' => 'Bitte auswählen',
						'facebook' => 'Facebook',
						'pinterest' => 'Pinterest',
						'instagram' => 'Instagram',
						'twitter' => 'Twitter',
						'youtube' => 'YouTube',
						'vimeo' => 'Vimeo',
						'linkedin' => 'LinkedIN',
						'xing' => 'Xing',
					),
					'default_value' => array(
					),
					'allow_null' => 0,
					'multiple' => 0,
					'ui' => 0,
					'return_format' => 'array',
					'ajax' => 0,
					'placeholder' => '',
				),
				array(
					'key' => 'field_5bee6c204bdb2',
					'label' => 'Socialmedia Profil',
					'name' => 'url',
					'type' => 'url',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '70',
						'class' => '',
						'id' => '',
					),
					'default_value' => '',
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_5c07f5f80fc5e',
			'label' => 'reCaptcha',
			'name' => 'recaptcha',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_5bfffe0f84f52',
					'label' => 'Websiteschlüssel',
					'name' => 'theme_recaptcha_sitekey',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
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
					'key' => 'field_5bfffe6984f53',
					'label' => 'Geheimer Schlüssel',
					'name' => 'theme_recaptcha_secret',
					'type' => 'text',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '50',
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
			),
		),
		array(
			'key' => 'field_5caed949c3d44',
			'label' => 'Datenschutz',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'wpml_cf_preferences' => 0,
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5caed696c3d40',
			'label' => 'Deutsch',
			'name' => 'ds_de',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'layout' => 'block',
			'wpml_cf_preferences' => 0,
			'sub_fields' => array(
				array(
					'key' => 'field_5caed79ac3d42',
					'label' => 'Einwilligung in die Datenverarbeitung (Kommentare)',
					'name' => 'comments_agreement',
					'type' => 'wysiwyg',
					'instructions' => '',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => 'Ich stimme zu, dass meine Angaben aus dem Formular gemäß Art. 6 Abs. 1 lit. a) DSGVO erhoben, gesepeichert und verarbeitet werden. Meine Name und mein Kommentar sowie eine ggf. angegebene Adresse meiner Webseite werden auf dieser Seite veröffentlicht. Meine E-Mail-Adresse wird nicht veröffentlicht.

Hinweis: Ich kann meine Einwilligung jederzeit für die Zukunft per E-Mail an ihre@email-adresse.com widerrufen.',
					'tabs' => 'visual',
					'toolbar' => 'basic',
					'media_upload' => 0,
					'delay' => 1,
					'wpml_cf_preferences' => 0,
				),
				array(
					'key' => 'field_5caed8acc3d43',
					'label' => 'Datenschutz Infotext',
					'name' => 'datenschutz_infotext',
					'type' => 'wysiwyg',
					'instructions' => 'Das Wort Datenschutzerklärung verlinken Sie bitte mit Ihrer Seite "Datenschutz".',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'default_value' => 'Weitere Informationen zum Datenschutz und dem Umgang mit personenbezogenen Daten entnehmen Sie bitte unserer Datenschutzerklärung.',
					'tabs' => 'visual',
					'toolbar' => 'basic',
					'media_upload' => 0,
					'delay' => 1,
					'wpml_cf_preferences' => 0,
				),
			),
		),
		array(
			'key' => 'field_5caee1e23b33d',
			'label' => 'Englisch',
			'name' => 'ds_en',
			'type' => 'group',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'wpml_cf_preferences' => 0,
			'layout' => 'block',
			'sub_fields' => array(
				array(
					'key' => 'field_5caee1e23b33e',
					'label' => 'Einwilligung in die Datenverarbeitung (Kommentare)',
					'name' => 'comments_agreement',
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
					'default_value' => 'I agree, that my personal data in this form will be collected, stored and processed in accordance with Art. 6 para. 1 lit. a) GDPR. My name, my comment and my website address (if any) will be published on this site. My Email address will not be published!

Note: I can revoke my consent at any time for the future via Email to info@your-domain.com.',
					'tabs' => 'visual',
					'toolbar' => 'basic',
					'media_upload' => 0,
					'delay' => 1,
				),
				array(
					'key' => 'field_5caee1e23b33f',
					'label' => 'Datenschutz Infotext',
					'name' => 'datenschutz_infotext',
					'type' => 'wysiwyg',
					'instructions' => 'Das Wort "privacy policy" verlinken Sie bitte mit Ihrer Seite "Datenschutz".',
					'required' => 0,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '',
						'class' => '',
						'id' => '',
					),
					'wpml_cf_preferences' => 0,
					'default_value' => 'Further information on the handling of your personal data can be found in our privacy policy.',
					'tabs' => 'visual',
					'toolbar' => 'basic',
					'media_upload' => 0,
					'delay' => 1,
				),
			),
		),
		array(
			'key' => 'field_5caeeceb0fd62',
			'label' => 'Sponsor & Institutionen',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
			'wpml_cf_preferences' => 0,
		),
		array(
			'key' => 'field_5caeed040fd63',
			'label' => 'Sponsor',
			'name' => 'sponsor',
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
			'min' => 1,
			'max' => 1,
			'layout' => 'block',
			'button_label' => 'Sponsor hinzufügen',
			'wpml_cf_preferences' => 0,
			'sub_fields' => array(
				array(
					'key' => 'field_5caeed530fd64',
					'label' => 'Logo',
					'name' => 'logo',
					'type' => 'image',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '20',
						'class' => '',
						'id' => '',
					),
					'wpml_cf_preferences' => 0,
					'return_format' => 'array',
					'preview_size' => 'aboutbox',
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
					'key' => 'field_5caeed770fd65',
					'label' => 'URL',
					'name' => 'url',
					'type' => 'url',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '70',
						'class' => '',
						'id' => '',
					),
					'wpml_cf_preferences' => 0,
					'default_value' => '',
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_5caeedd10fd66',
			'label' => 'beteiligte Institutionen',
			'name' => 'institutions',
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
			'min' => 1,
			'max' => 0,
			'layout' => 'block',
			'button_label' => 'Institution hinzufügen',
			'wpml_cf_preferences' => 0,
			'sub_fields' => array(
				array(
					'key' => 'field_5caeedd10fd67',
					'label' => 'Logo',
					'name' => 'logo',
					'type' => 'image',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '20',
						'class' => '',
						'id' => '',
					),
					'wpml_cf_preferences' => 0,
					'return_format' => 'array',
					'preview_size' => 'aboutbox',
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
					'key' => 'field_5caeedd10fd68',
					'label' => 'URL',
					'name' => 'url',
					'type' => 'url',
					'instructions' => '',
					'required' => 1,
					'conditional_logic' => 0,
					'wrapper' => array(
						'width' => '70',
						'class' => '',
						'id' => '',
					),
					'wpml_cf_preferences' => 0,
					'default_value' => '',
					'placeholder' => '',
				),
			),
		),
		array(
			'key' => 'field_5cb6df0ae0687',
			'label' => 'Einstellungen',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5cb6df1be0688',
			'label' => 'Hinweis',
			'name' => '',
			'type' => 'message',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'message' => 'Hier werden den Custom-Post-Types Seiten zu geordnet um in der Navigation eine korrekte Zuordnung zu erreichen!',
			'new_lines' => 'wpautop',
			'esc_html' => 0,
		),
		array(
			'key' => 'field_5cb6df70e0689',
			'label' => 'Teilprojekte',
			'name' => 'page_for_teilprojekt',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'page',
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1,
		),
		array(
			'key' => 'field_5cb6dfabe068a',
			'label' => 'Partner',
			'name' => 'page_for_partner',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'page',
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1,
		),
		array(
			'key' => 'field_5cb6dfcee068b',
			'label' => 'Presse',
			'name' => 'page_for_news',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'page',
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1,
		),
		array(
			'key' => 'field_5cb6dfeae068c',
			'label' => 'Events',
			'name' => 'page_for_events',
			'type' => 'post_object',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'post_type' => array(
				0 => 'page',
			),
			'taxonomy' => '',
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1,
		),
		array(
			'key' => 'field_5d0cd981fd1f6',
			'label' => 'Ergebnisse',
			'name' => 'page_for_results',
			'type' => 'post_object',
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
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'object',
			'ui' => 1,
		),
		array(
			'key' => 'field_5cc712e8935ab',
			'label' => 'Cookie-Notice',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5cc71301935ac',
			'label' => 'Cookie-Banner',
			'name' => 'cc',
			'type' => 'true_false',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'message' => 'Wollen Cookie-Banner anzeigen?',
			'default_value' => 0,
			'ui' => 1,
			'ui_on_text' => '',
			'ui_off_text' => '',
		),
		array(
			'key' => 'field_5cc7147c935b1',
			'label' => 'Position',
			'name' => 'cc_position',
			'type' => 'select',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cc71301935ac',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '50',
				'class' => '',
				'id' => '',
			),
			'choices' => array(
				'bottom' => 'Unten angeheftet',
				'top' => 'Oben angeheftet',
				'bottom-left' => 'Unten links',
				'bottom-right' => 'Unten rechts',
			),
			'default_value' => array(
				0 => 'bottom-left',
			),
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 0,
			'return_format' => 'value',
			'ajax' => 0,
			'placeholder' => '',
		),
		array(
			'key' => 'field_5cc7133f935ad',
			'label' => 'Hintergrundfarbe',
			'name' => 'cc_popup_background',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cc71301935ac',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '25',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#f5f5f5',
		),
		array(
			'key' => 'field_5cc71370935ae',
			'label' => 'Textfarbe',
			'name' => 'cc_popup_text',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cc71301935ac',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '25',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#000000',
		),
		array(
			'key' => 'field_5cc713aa935af',
			'label' => 'Buttonfarbe',
			'name' => 'cc_button_background',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cc71301935ac',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '25',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#000000',
		),
		array(
			'key' => 'field_5cc7141f935b0',
			'label' => 'Buttontextfarbe',
			'name' => 'cc_button_text',
			'type' => 'color_picker',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cc71301935ac',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '25',
				'class' => '',
				'id' => '',
			),
			'default_value' => '#FFFFFF',
		),
		array(
			'key' => 'field_5d0cc7b57eeeb',
			'label' => 'Übersetzungen',
			'name' => '',
			'type' => 'tab',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'placement' => 'top',
			'endpoint' => 0,
		),
		array(
			'key' => 'field_5cc716f2935b2',
			'label' => 'Deutsch',
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
		),
		array(
			'key' => 'field_5cc71722935b3',
			'label' => 'Hinweistext',
			'name' => 'cc_message_de',
			'type' => 'textarea',
			'instructions' => 'Standard: Um unsere Webseite für Sie optimal zu gestalten und fortlaufend verbessern zu können, verwenden wir Cookies. Durch die weitere Nutzung der Webseite stimmen Sie der Verwendung von Cookies zu. Weitere Informationen zu Cookies erhalten Sie in unserer',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cc71301935ac',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Um unsere Webseite für Sie optimal zu gestalten und fortlaufend verbessern zu können, verwenden wir Cookies. Durch die weitere Nutzung der Webseite stimmen Sie der Verwendung von Cookies zu. Weitere Informationen zu Cookies erhalten Sie in unserer',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => 5,
			'new_lines' => '',
		),
		array(
			'key' => 'field_5cc7176f935b4',
			'label' => 'Linktext',
			'name' => 'cc_link_de',
			'type' => 'text',
			'instructions' => 'Beschriftung des Links zur Datenschutzerklärung',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cc71301935ac',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Datenschutzerklärung',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5cc717b6935b5',
			'label' => 'Buttontext',
			'name' => 'cc_dismiss_de',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cc71301935ac',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Verstanden',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5d0cc7d27eeec',
			'label' => 'Linktext Nachnutzung',
			'name' => 'cc_link_usage_de',
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
			'key' => 'field_5d0cc8527eeef',
			'label' => 'Toggle Ergebnis Infobox',
			'name' => 'cc_toggle_result_infobox_de',
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
			'key' => 'field_5d0ccd29eb1ee',
			'label' => 'Ergebnis des Teilprojekts',
			'name' => 'cc_resultof_de',
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
			'key' => 'field_5d0cd8b212a82',
			'label' => 'Zum Teilprojekt',
			'name' => 'cc_gotoproject_de',
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
			'key' => 'field_5d0cd8d312a84',
			'label' => 'Alle Ergebnisse',
			'name' => 'cc_allresults_de',
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
			'key' => 'field_5d0cdd8a69324',
			'label' => 'Titel Umsetzungsansätze',
			'name' => 'cc_approaches_title_de',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Projektergebnisse <span>nach Umsetzungansätzen</span>',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5d11f0930f301',
			'label' => 'Bezug zur Anwendung',
			'name' => 'cc_top_result_de',
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
			'key' => 'field_5cc71803935b6',
			'label' => 'Englisch',
			'name' => '_Kopie',
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
		),
		array(
			'key' => 'field_5cc71811935b7',
			'label' => 'Hinweistext',
			'name' => 'cc_message_en',
			'type' => 'textarea',
			'instructions' => 'Standard: In order to optimize our website for you and to be able to continuously improve it, we use cookies. By continuing to use the website, you agree to the use of cookies. For more information about cookies, please visit our',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cc71301935ac',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'In order to optimize our website for you and to be able to continuously improve it, we use cookies. By continuing to use the website, you agree to the use of cookies. For more information about cookies, please visit our',
			'placeholder' => '',
			'maxlength' => '',
			'rows' => 5,
			'new_lines' => '',
		),
		array(
			'key' => 'field_5cc71879935b8',
			'label' => 'Linktext',
			'name' => 'cc_link_en',
			'type' => 'text',
			'instructions' => 'Beschriftung des Links zur Datenschutzerklärung',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cc71301935ac',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Privacy policy',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5cc71882935b9',
			'label' => 'Buttontext',
			'name' => 'cc_dismiss_en',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => array(
				array(
					array(
						'field' => 'field_5cc71301935ac',
						'operator' => '==',
						'value' => '1',
					),
				),
			),
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Got it!',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5d0cc8127eeed',
			'label' => 'Linktext Nachnutzung',
			'name' => 'cc_link_usage_en',
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
			'key' => 'field_5d0cc83f7eeee',
			'label' => 'Toggle Ergebnis Infobox',
			'name' => 'cc_toggle_result_infobox_en',
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
			'key' => 'field_5d0ccd04eb1ed',
			'label' => 'Ergebnis des Teilprojekts',
			'name' => 'cc_resultof_en',
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
			'key' => 'field_5d0cd89d12a81',
			'label' => 'Zum Teilprojekt',
			'name' => 'cc_gotoproject_en',
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
			'key' => 'field_5d0cd8c212a83',
			'label' => 'Alle Ergebnisse',
			'name' => 'cc_allresults_en',
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
			'key' => 'field_5d0cdd6b69323',
			'label' => 'Titel Umsetzungsansätze',
			'name' => 'cc_approaches_title_en',
			'type' => 'text',
			'instructions' => '',
			'required' => 0,
			'conditional_logic' => 0,
			'wrapper' => array(
				'width' => '',
				'class' => '',
				'id' => '',
			),
			'default_value' => 'Projektergebnisse <span>nach Umsetzungansätzen</span>',
			'placeholder' => '',
			'prepend' => '',
			'append' => '',
			'maxlength' => '',
		),
		array(
			'key' => 'field_5d11f07a0f300',
			'label' => 'Bezug zur Anwendung',
			'name' => 'cc_top_result_en',
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
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'theme-general-settings',
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
*/