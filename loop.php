<?php
/**
 * The loop that displays posts.
 *
 * The loop displays the posts and the post content.  See
 * http://codex.wordpress.org/The_Loop to understand it and
 * http://codex.wordpress.org/Template_Tags to understand
 * the tags used in it.
 *
 * This can be overridden in child themes with loop.php or
 * loop-template.php, where 'template' is the loop context
 * requested by a template. For example, loop-index.php would
 * be used if it exists and we ask for the loop with:
 * <code>get_template_part( 'loop', 'index' );</code>
 *
 * @package WordPress
 * @subpackage davaso
 * @since davaso 1.0
 */

?>

<section id="headergap"></section>

<section id="archiv_title">
	<h1><?php if( is_post_type_archive() ){ $title = post_type_archive_title( '', false ); echo $title; } else { get_the_archive_title(); } ?></h1>
</section>

<main class="archive padding">

			<?php if (!have_posts()) : ?>

				<strong>Leider führte Ihre Suche zu keinem Ergebnis.</strong>

			<?php endif;
				$i = 1;
				while (have_posts()) : the_post(); ?>
			
				<article <?

					if(!has_post_thumbnail())
					{ 
						$class = 'loop no-image';
						$showthumb = true;
					}
					else
					{ 
						$class = 'loop';
						$showthumb = false;
					} 

					post_class($class); ?> id="post-<?php the_ID(); ?>">

				<?php
					if(has_post_thumbnail())
					{
						$tnid = get_post_thumbnail_id($post->ID);
						$imagedata = wp_get_attachment_metadata( $tnid );
						$thumbdesktop = wp_get_attachment_image_src( $tnid, 'post-thumbnail' );
						$thumbmobile = wp_get_attachment_image_src( $tnid, 'post-thumbnail' );
						$caption = get_post($tnid)->post_excerpt;
				?>
					<div class="post-image">
						<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
							<? /*<img src="<?=$thumbbig[0]?>" class="attachment-post-thumbnail size-preview_blog wp-post-image" alt="<?php the_title(); ?>" width="300" height="230">*/ ?>
								<picture>
									<source media="(min-width: 40em)" srcset="<?=$thumbdesktop[0]?>">
									<source srcset="<?=$thumbmobile[0]?>">
									<img src="<?=$thumbdesktop[0]?>" alt="<?php the_title(); ?>">
								</picture>
						</a>
					</div>

				<?php } ?>

					<div class="post-content">
						<h2><a href="<?php the_permalink(); ?>" title="Permalink zu <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						<div class="post-description">
							<?php the_excerpt(); ?>
						</div>
						<?php /*<div class="post-meta">
							<span class="meta-datum"><i class="fa fa-calendar"></i> <?php the_date(); ?></span>
						</div>*/ ?>
					</div>
					<div class="clear"></div>
				</article>
				<!-- Post -->
	
				<?php if($i % 5 == 0) {echo '
	<div class="rennab_archiv">
	<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	<!-- Buddha Responsive -->
	<ins class="adsbygoogle"
		 style="display:block"
		 data-ad-client="ca-pub-7972469515780086"
		 data-ad-slot="4399027514"
		 data-ad-format="auto"></ins>
	<script>
	(adsbygoogle = window.adsbygoogle || []).push({});
	</script>
	</div>
				';} $i++; ?>
	
	
				<?php endwhile; // End the loop. Whew.  ?>

	<div class="clear"></div>
</main>

<?php
if(function_exists('wp_pagenavi') && $wp_query->max_num_pages > 1) {
	echo '<div class="pagination">';
	wp_pagenavi();
	echo '<div class="clear"></div></div>';
}
?>

