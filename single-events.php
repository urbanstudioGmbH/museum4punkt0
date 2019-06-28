<?php
/**
 * The template for displaying all single posts.
 * @package urbanstudio
 */
get_header();
?>
<?php /*

<section id="breadcrumbs">
		<?php if (function_exists('nav_breadcrumb')) nav_breadcrumb(); ?>
</section>
*/ ?>

<main class="single">
	<div class="center">
	<article class="blogpost">
		<?php while (have_posts()) : the_post(); ?>
		   
			<?php the_content(); ?>
			
			<?php
				$sharer = new themeHelper($post);
				$sharer->getSharingOptions();
			?>
	<?php
		$tp = get_field("teilprojekt");
		if($tp){
			$tnid = get_post_thumbnail_id($tp->ID); $class = " no-image";
			if ($tnid) {
				$src = wp_get_attachment_image_url($tnid, 'teasergrid');
				$class = " has-image";
			}
			$p = get_field("project", $tp);
            $pp = $p["value"];
			echo '<section class="blog-teilprojekt-container alignfull">';
				echo '<div class="center">';
					echo '<div class="meta-teilprojekt'.$class.' '.$pp.'">';
						if($tnid){
							echo '<div class="image"><a href="'.get_permalink($tp).'" title="'.__("Teilprojekt","uslang").': '.esc_attr(get_the_title($tp)).'"><img src="'.esc_url($src).'" alt="'.__("Teilprojekt","uslang").': '.esc_attr(get_the_title($tp)).'"></a></div>';
						}
						echo '<div class="tp-content">';
							echo '<h5>'.__("Teilprojekt").'</h5>';
							echo '<h4><a href="'.get_permalink($tp).'" title="'.__("Teilprojekt","uslang").': '.esc_attr(get_the_title($tp)).'">'.get_the_title($tp).'</a></h4>';
							echo '<div class="tp-excerpt">'.get_the_excerpt($tp).'</div>';
						echo '</div>';
					echo '</div>';
					$addtp = get_field("addtp");
					if($addtp){
						foreach($addtp AS $tp){
							$tnid = get_post_thumbnail_id($tp->ID); $class = " no-image";
							if ($tnid) {
								$src = wp_get_attachment_image_url($tnid, 'teasergrid');
								$class = " has-image";
							}
							$p = get_field("project", $tp);
							$pp = $p["value"];
							echo '<div class="meta-teilprojekt addtp'.$class.' '.$pp.'">';
								if($tnid){
									echo '<div class="image"><a href="'.get_permalink($tp).'" title="'.__("Teilprojekt","uslang").': '.esc_attr(get_the_title($tp)).'"><img src="'.esc_url($src).'" alt="'.__("Teilprojekt","uslang").': '.esc_attr(get_the_title($tp)).'"></a></div>';
								}
								echo '<div class="tp-content">';
									echo '<h5>'.__("Teilprojekt").'</h5>';
									echo '<h4><a href="'.get_permalink($tp).'" title="'.__("Teilprojekt","uslang").': '.esc_attr(get_the_title($tp)).'">'.get_the_title($tp).'</a></h4>';
									echo '<div class="tp-excerpt">'.get_the_excerpt($tp).'</div>';
								echo '</div>';
							echo '</div>';
						}
					}
				echo '</div>';
			echo '</section>';
		}
	?>
    </article>
		
        <?php endwhile; // End the loop. Whew.  ?>

	</div><!-- end # center -->


	<?php if(themeHelper::checkCommentsAllowed()){
        comments_template();
    } ?>
	<?php $pfp = get_option("page_for_posts"); ?>
	<section class="blog-navigation-container">
		<div class="center">
    		<div class="previous">
 				<?php
				/*$prev_post = get_adjacent_post( false, '', true );
                if (is_a($prev_post, 'WP_Post')) {
				?>
					<i class="far fa-chevron-left"></i>
                	<p class="previous-label"><?php echo __("Vorheriger Beitrag"); ?></p>
	            	<a class="previous-link" href="<?php echo get_permalink($prev_post); ?>" title="<?php echo esc_attr(get_the_title($prev_post));?>"><?php echo esc_attr(get_the_title($prev_post));?></a>
				<?php
                }*/
				?>
			</div>
			<div class="overview">
                  <a class="btn btn-primary" href="<?php echo get_home_url()."/mitmachen/events/"; ?>"><?php echo __("Zur Übersicht"); ?></a>
            </div>
			<div class="next">
				<?php
				/*$next_post = get_adjacent_post( false, '', false );
                if (is_a($next_post, 'WP_Post')) {
				?>
					<i class="far fa-chevron-right"></i>
                	<p class="next-label"><?php echo __("Nächster Beitrag"); ?></p>
	            	<a class="next-link" href="<?php echo get_permalink($next_post); ?>" title="<?php echo esc_attr(get_the_title($next_post));?>"><?php echo esc_attr(get_the_title($next_post));?></a>
				<?php
                }*/
				?>
			</div>
		</div>
	</section>
	<div class="clear"></div>
</main>


<?php get_footer(); ?>