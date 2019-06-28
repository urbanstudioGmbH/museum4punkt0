<?php
/**
 * Template for displaying Post-Archive
 * @package WordPress
 * @subpackage urbanstudio
 */

get_header();

?>

<main class="archive">

	<div class="center">
		<?php
			$post = get_option("page_for_posts");
			$block_us_sp_headline = new block_us_sp_headline();
			$block_us_sp_headline->block_us_sp_headline_render(array("id" => uniqid(), "align" => ""),'',false,$post);
			$info_text = get_field("sinfo_text", $post);
			$featured = get_field("featured", $post);
			if(!empty($info_text)){
				echo $info_text;
			}
			if($featured){
				echo '<article class="article">';
					
					echo '<a href="'.get_the_permalink($featured).'" title="'.get_the_title($featured).'">';
						$tp = get_field("teilprojekt", $featured); $p = "";
                        if ($tp) {
							$fp = get_field("project", $tp);
							$p = $fp["value"];
                        }
						echo '<div class="article-image '.$p.'">';
							$featureimageid = get_post_thumbnail_id($featured->ID);
							echo '<img class="article-imageElement" srcset="'.wp_get_attachment_image_srcset($featureimageid).'" alt="">';
						echo '</div>';
					echo '</a>';
					echo '<div class="article-content">';
						echo '<time class="article-date" datetime="'.get_the_date('Y-m-d H:i:s', $featured).'">'.get_the_date('', $featured).'</time>';
						echo '<a href="'.get_the_permalink($featured).'" title="'.get_the_title($featured).'">';
							echo '<h4 class="article-title">'.get_the_title($featured).'</h4>';
						echo '</a>';
						echo '<span class="article-description">'.get_the_excerpt($featured).'</span>';
					echo '</div>';
				echo '</article>';
			}
		?>
		<div class="masonry blog-grid-container">
			<div class="grid-sizer"></div>
			<div class="gutter-sizer"></div>
			<?php if (!have_posts()) : ?>

				<strong>Leider führte Ihre Suche zu keinem Ergebnis.</strong>

			<?php endif;
				$i = 1;
				while (have_posts()) : the_post(); 
					if(get_the_ID() === $featured->ID) continue;	
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
						if(get_post_type($post) == "events"){
							$eventtype = get_field("type",$box);
							$et = $eventtype->name;
							echo '<h4 class="eventtype">'.$et.'</h4>';
						}else{
							echo '<time class="date" datetime="'.get_the_date("Y-m-d H:i:s",$post).'">'.get_the_date("",$post).'</time>';
						}
						echo '<h3 class="article-title"><a href="'.get_the_permalink($post).'" title="'.esc_attr(get_the_title($post)).'">'.esc_html(get_the_title($post)).'</a></h3>';
						if (get_post_type($post) == "events") {
							$from = get_field("from", $post); $to = get_field("to", $post);
							$from_time = get_field("from_time", $post); $to_time = get_field("to_time", $post);
							if(($from != $to && empty($to)) || ($from == $to && !empty($to))){
								$ft = strftime("%d. %B %Y", strtotime($from));
								if($from_time && $to_time){
									$ft .= " ".__("von", "uslang")." ".$from_time." ".__("bis", "uslang")." ".$to_time." ".__("Uhr", "uslang");
								}elseif($from_time && !$to_time){
									$ft .= " ".__("ab", "uslang")." Uhr";
								}
							}elseif($from != $to && !empty($to)){
								$my = strftime("%m%Y", strtotime($from)) == strftime("%m%Y", strtotime($to)) ? 1 : 0;
								if($my){
									$ft = strftime("%d.",strtotime($from))." - ".strftime("%d. %B %Y", strtotime($to));
								}else{
									$ft = strftime("%d. %B %Y",strtotime($from))." - ".strftime("%d. %B %Y", strtotime($to));
								}
							}
							echo '<span class="event date"><span>'.__("Datum").': </span><time>'.$ft.'</time></span>';
							echo '<span class="event place"><span>'.__("Ort").': </span>'.esc_html(get_field("place", $post)).'</span>';
						}else{
							echo '<span class="excerpt">'.esc_html(get_the_excerpt($post)).'</span>';
						}
					echo '</div>';
				echo '</article>';
				endwhile; // End the loop. Whew.  ?>
				<div class="clear"></div>
		</div>
	</div>
	<div class="clear"></div>
</main>


<?php
if(function_exists('wp_pagenavi') && $wp_query->max_num_pages > 1) {
	echo '<div class="pagination">';
	wp_pagenavi();
	echo '<div class="clear"></div></div>';
}

wp_enqueue_script("us-imagesloaded", get_template_directory_uri()."/js/imagesloaded.pkgd.min.js", array( 'jquery' ));
wp_enqueue_script("us-masonry", get_template_directory_uri()."/js/masonry.pkgd.min.js", array( 'jquery','us-imagesloaded' ));

$inlinescript = <<<EOF
jQuery(document).ready(function()
{
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

?>
<?php get_footer(); ?>