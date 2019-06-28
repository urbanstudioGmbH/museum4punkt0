<?php

class themeHelper{

    protected $allowComments;
    protected $allowSharing;
    protected $sharingVia;
    protected $currentPost;

    function __construct($post = null){
        if($post === null){
            global $post;
            $this->currentPost = $post;
        }elseif(is_int($post)){
            $this->currentPost = get_post($post);
        }else{
            $this->currentPost = $post;
        }
        $this->allowComments = get_field("allow_comments", "options");
        $this->allowSharing = get_field("allow_sharing", "options");
        $this->sharingVia = get_field("sharing_via", "options");
        
        return true;
    }

    public static function blogFilters(int $nojs = 0){
        
        wp_enqueue_style( 'us-theme-helper/blogfilters', get_template_directory_uri().'/css/themehelper/blogfilters.css' );
        if(!$nojs) wp_enqueue_script( 'us-theme-helper/blogfilters', get_template_directory_uri()."/js/themehelper/blogfilters.js", array('jquery'), '', true );
        $post = get_option("page_for_posts");
        echo '<div class="blog-filters">';
            
            echo '<div class="filter category"><i class="fas fa-chevron-down"></i>';
                static::getTermsDropdown("category", "Alle Kategorien");
            echo '</div>';
            echo '<div class="filter post_tag"><i class="fas fa-chevron-down"></i>';
                static::getTermsDropdown("post_tag", "Alle Tags");
            echo '</div>';
            echo '<div class="filter search"><i class="fas fa-times"></i>';
            echo '<a href="'.esc_url(get_permalink( $post )).'" class="reset-filters">Alle Filter zurücksetzen</a>';
            echo '</div>';
        echo '</div>';
    }
    public static function getBlogfiltersJS(){
        $js = file_get_contents(get_template_directory()."/js/themehelper/blogfilters.js");
        return $js;
    }
    public static function getTermsDropdown(string $type, string $alloption){
        $terms = get_terms( array(
            'taxonomy' => $type,
            'hide_empty' => false,
        ) );
        if ( !empty($terms) ) :
            $obj_id = get_queried_object_id();
            $current_url = get_term_link( $obj_id );
            $post = get_option("page_for_posts");
            $output = '<select name="'.$type.'" id="'.$type.'">';
            $output .= '<option value="-">'.__($alloption,"uslang").'</option>';
            foreach( $terms as $category ) {
                if( $category->parent == 0 ) {
                    $selected = "";
                    if($current_url == get_term_link( $category, $type )) $selected = ' selected="selected"';
                    $output.= '<option value="'.esc_attr($category->slug).'"'.$selected.'>'.esc_html( $category->name ).'</option>';
                    foreach( $terms as $subcategory ) {
                        if($subcategory->parent == $category->term_id) {
                            //if($current_url == get_term_link( $subcategory, $type )) $selected = ' selected="selected"';
                            $output.= '<option value="'.esc_attr($subcategory->slug).'"'.$selected.'>-- '. esc_html( $subcategory->name ) .'</option>';
                        }
                    }
                }
            }
            $output.='</select>';
            echo $output;
        endif;
    }
    public static function processBlogFiltersRequest( WP_REST_Request $request ) {
        return static::processBlogFilters($request);
    }
    public static function processBlogFilters($data = null){
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
            echo '<div class="grid-sizer"></div>
			<div class="gutter-sizer"></div>';
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
					post_class($class); ?> id="post-<?php the_ID(); ?>">

				<?php
					if(has_post_thumbnail()){
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
    public function getSharingOptions(){
        $pt = get_post_type($this->currentPost);
        if(in_array($pt, $this->allowSharing)){
            $sharingURL = get_the_permalink($this->currentPost);
            $title = get_the_title($this->currentPost);
            $text = get_the_excerpt($this->currentPost);
            $sharingOptions = array();
            foreach($this->sharingVia AS $sharingtype){
                array_push($sharingOptions, $this->getSharingLink($sharingtype, $sharingURL, $title, $text));
            }
            wp_enqueue_style( 'us-theme-helper/sharingoptions', get_template_directory_uri().'/css/themehelper/sharingoptions.css' );
            wp_enqueue_script( 'us-theme-helper/sharingoptions', get_template_directory_uri()."/js/themehelper/sharingoptions.js", array('jquery'), '', true );
            echo $this->getSharingHTML($sharingOptions);
        }
    }

    public function getSharingLink($type = null, $url, $title, $text){
        if($type == null) return;
        switch($type){
            case "fb":
                return '<a href="https://www.facebook.com/sharer/sharer.php?u='.urlencode($url).'" class="sharer-popup" title="'.esc_attr(__("Diesen Beitrag auf Facebook teilen.", "uslang")).'"><i class="fab fa-facebook-f"></i> '.__("teilen", "uslang").'</a>';
            break;

            case "twitter":
                return '<a href="https://twitter.com/share?url='.urlencode($url).'&text='.urlencode($title).'" class="sharer-popup" title="'.esc_attr(__("Diesen Beitrag twittern.", "uslang")).'"><i class="fab fa-twitter"></i> '.__("twittern", "uslang").'</a>';
            break;

            case "wa":
                return '<a href="https://wa.me/?text='.urlencode($title."\n\n".$text."\n\n".$url).'" class="sharer-popup" title="'.esc_attr(__("Diesen Beitrag via WhatsApp teilen.", "uslang")).'"><i class="fab fa-whatsapp"></i> '.__("teilen", "uslang").'</a>';
            break;

            case "email":
                return '<a href="mailto:?subject='.__("Link-Empfehlung", "uslang").'&body='.$title."%0A%0A".$text."%0A%0A".$url.'" title="'.esc_attr(__("Diesen Beitrag via E-Mail teilen.", "uslang")).'"><i class="fas fa-envelope"></i> '.__("E-Mail", "uslang").'</a>';
            break;
        }
        return;
    }

    private function getSharingHTML($opts){
        if(!$opts || !is_array($opts) || !count($opts)) return;
        $sl = implode("\n", $opts);
        $html = <<<EOF
            <div class="us-sharer">
                $sl
            </div>
EOF;
        return $html;
    }

    public static function checkCommentsAllowed(){
        global $post;
        if(in_array(get_post_type($post), get_field("allow_comments", "option"))) return true;
        return false;
    }
}
