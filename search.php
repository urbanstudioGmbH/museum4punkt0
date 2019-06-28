<?php
/**
 * The main template file.
 * @package WordPress
 */
get_header();
?>


<main>

	<div class="center">
		<article>

			<?php
				$post = get_option("page_for_posts");
				$block_us_sp_headline = new block_us_sp_headline();
				ob_start();
				$block_us_sp_headline->block_us_sp_headline_render(array("id" => uniqid(), "align" => ""),'',false,$post);
				$hl = ob_get_clean();
				$dom = new \DOMDocument();
				$dom->preserveWhiteSpace = false;
	        	$dom->formatOutput = true;
				$dom->loadHTML(mb_convert_encoding($hl, 'HTML-ENTITIES', 'UTF-8'));
				$dom->getElementsByTagName("h1")->item(0)->nodeValue = 'Suche nach: "'.get_search_query().'"';
				$element = $dom->getElementsByTagName("p")->item(0);
				$element->parentNode->removeChild($element);
				echo $dom->saveHTML();
				libxml_clear_errors();
			?>

	<?php /*<section id="archiv_title">
		<h1>Sucher&shy;gebnisse für "<?php echo get_search_query(); ?>"</h1>
	</section>*/?>

		<div id="inlinesearch">
			<div class="search">
				<form method="get" id="searchform2" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<input name="s" id="s" value="<?php echo get_search_query(); ?>" placeholder=""  type="text" class="text" onclick="this.select();" />
					<div class="searchbtn" onClick="document.getElementById('searchform2').submit();"><i class="far fa-search" aria-hidden="true"></i></div>
				</form>
			</div>
		</div>

		</article>

		<div class="clear"></div>
	</div>
	<div class="clear"></div>

	<section class="search-archive">
		<div class="center">

			<?php if (!have_posts()) : ?>
				
				<strong>Leider führte Ihre Suche nach "<?php echo get_search_query(); ?>" auf unserer Seite zu keinem Ergebnis.</strong>

			<?php endif;
				while (have_posts()) : the_post();
				$pp = "";
				$p = get_field("project", $post);
				if($p) $pp = $p["value"];
				$tp = get_field("teilprojekt",$post);
				if($tp){
					$p = get_field("project", $tp);
					$pp = $p["value"];
				}
				if(has_post_thumbnail()){
					$class = "has-image";
				}else{
					$class = "no-image";
				}
			?>

				<article class="<?php echo $class." ".$pp; ?>">
					<?php
					if(has_post_thumbnail()){
						echo '<div class="image">';
							$tnid = get_post_thumbnail_id($post->ID);
							$srcset = wp_get_attachment_image_srcset($tnid, 'gallery_preview_2x');
							$src = wp_get_attachment_image_url($tnid, 'gallery_preview_2x');
							echo '<a href="'.get_the_permalink($post).'" title="'.esc_attr(get_the_title($post)).'">';
								echo '<img class="image-responsive blog-imageItem" src="'.$src.'" srcset="'.$srcset.'" alt="'.esc_attr(get_the_title($post)).'">';
							echo '</a>';
						echo '</div>';

					} ?>
					<div class="content">
						<?php
						$pt = array(
							"de" => array(
								"post" => "Blog",
								"page" => "Seite",
								"news" => "Presse-News",
								"partner" => "Partner",
								"teilprojekt" => "Teilprojekt",
								"events" => "Events"
							),
							"en" => array(
								"post" => "Blog",
								"page" => "Page",
								"news" => "Press news",
								"partner" => "Partner",
								"teilprojekt" => "Sub project",
								"events" => "Events"
							)
						);
						if(defined("ICL_LANGUAGE_CODE")){
							echo '<h4>'.$pt[ICL_LANGUAGE_CODE][get_post_type()].'</h4>';
						}else{
							echo '<h4>'.$pt["de"][get_post_type()].'</h4>';
						}
						?>
						<h2><a href="<?php the_permalink(); ?>" title="Permalink zu <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<?php if(get_post_type() != "events"){ ?>
						<div class="post-description">
							<?php the_excerpt(); ?>
						</div>
						<?php } ?>
						<div class="post-meta">
						<?php
							if(in_array(get_post_type(), array("post","news"))){
								echo '<time class="date" datetime="'.get_the_date("Y-m-d H:i:s",$post).'">'.get_the_date("",$post).'</time>';
							}elseif(get_post_type() == "events"){
								$eventtype = get_field("type",$post);
								$et = $eventtype->name;
								echo '<div class="event-type">'.$et.'</div>';
								$from = get_field("from_date", $post); $to = get_field("to_date", $post);
								$from_time = get_field("from_time", $post); $to_time = get_field("to_time", $post);
								if(($from != $to && empty($to)) || ($from == $to && !empty($to))){
									$ft = strftime("%d. %B %Y", strtotime($from));
									if($from_time && $to_time){
										$ft .= " ".__("von", "uslang")." ".$from_time." ".__("bis", "uslang")." ".$to_time." ".__("Uhr", "uslang");
										//echo "hmmm 1";
									}elseif($from_time && !$to_time){
										$ft .= " ".__("ab", "uslang")." Uhr";
										//echo "hmmm 2";
									}else{
										//echo "hmmm 3: $from_time - $to_time - ".get_field("from_time", $box);
									}
								}elseif($from != $to && !empty($to)){
									$my = strftime("%m%Y", strtotime($from)) == strftime("%m%Y", strtotime($to)) ? 1 : 0;
									if($my){
										$ft = strftime("%d.",strtotime($from))." - ".strftime("%d. %B %Y", strtotime($to));
										if($from_time && $to_time){
											$ft .= " ".__("von", "uslang")." ".$from_time." ".__("bis", "uslang")." ".$to_time." ".__("Uhr", "uslang");
										}elseif($from_time && !$to_time){
											$ft .= " ".__("ab", "uslang")." Uhr";
										}
									}else{
										$my = strftime("%Y", strtotime($from)) == strftime("%Y", strtotime($to)) ? 1 : 0;
										if($my){
											$ft = strftime("%d. %B", strtotime($from))." - ".strftime("%d. %B %Y", strtotime($to));
										}else{
											$ft = strftime("%d. %B %Y", strtotime($from))." - ".strftime("%d. %B %Y", strtotime($to));
										}
									}
								}
								echo '<time class="event-time">'.$ft.'</time>';
								$ki = get_field("info", $post);
								echo '<div class="event kurzinfo">'.$ki->name.'</div>';
								echo '<div class="event place"><strong>'.esc_html(get_field("place", $post)).'</strong></div>';
							}
						?>
						</div>
					</div>
					<div class="clear"></div>
				</article>
				<!-- Post -->

			<?php endwhile; // End the loop. Whew.  ?>

		</div>

		<?php
			the_posts_pagination( array(
				'mid_size'  => 2,
				'prev_text' => __( '<', 'uslang' ),
				'prev_next'          => false,
				'type'               => 'plain',
				'next_text' => __( '>', 'uslang' ),
			) );
		?>
	</section>

</main>

<?php get_footer(); ?>
