<?php
/**
 * Template Name: Page Index
 * @package WordPress
 */
get_header();
?>


<?php
$picActive = get_field("show_header_image") ? 1 : 0;
$pic = get_field("header_image");
echo usHeaderImage(array("active" => $picActive, "title" => get_the_title($post->ID), "pic" => (is_array($pic) ? $pic : array())));
?>
<?php /*<section id="breadcrumbs">
		<?php if (function_exists('nav_breadcrumb')) nav_breadcrumb(); ?>
</section>*/ ?>


<main class="single page">
	<div class="center">
		<article class="page">

			<hgroup>
				<h1 class="main-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
			</hgroup>

			<?php while (have_posts()) : the_post(); ?>

				<?php /*
				<?php
					if(has_post_thumbnail())
					{
						$tnid = get_post_thumbnail_id($post->ID);
						$caption = get_post($tnid)->post_excerpt;
				?>
				<div class="post-image">
					<?php the_post_thumbnail( 'post-thumbnail', array( 'alt' => get_the_title().' - Behind the Buddha' ) ); ?>
					<div class="post-caption"><?php echo $caption; ?></div>
				</div>

				<?php } ?>
				
				*/
				?>

				<?php the_content(); ?>
		</article>
		
    </div>
        <?php endwhile; // End the loop. Whew.  ?>
	
	<div class="clear"></div>
</main>
<section class="archive">
	<div class="center">
		<div id="portfolio">
			<div class="grid-sizer"></div>
			<div class="gutter-sizer"></div>
				<?php
					$index = get_field("index");
					//echo '<pre>'.print_r($index, 1).'</pre>';
					if($index && is_array($index) && count($index)){
						$posts = get_posts(
							array(
								'post_type' => 'page',
								'include' => ''.implode(",",$index).'',
								'post_status'      => 'publish',
								'suppress_filters' => true,
								'orderby' => 'post__in'
							)
						);
						if($posts){
							foreach($posts as $i => $box){ ?>
								<article <?php

								if(!has_post_thumbnail($box->ID))
								{ 
									$class = 'loop no-image';
									$showthumb = true;
								}
								else
								{ 
									$class = 'loop';
									$showthumb = false;
								} 

								post_class($class); ?> id="post-<?php echo $box->ID; ?>">

							<?php
								if(has_post_thumbnail($box->ID)){
									$tnid = get_post_thumbnail_id($box->ID);
									$imagedata = wp_get_attachment_metadata( $tnid );
									$thumbdesktop = wp_get_attachment_image_src( $tnid, 'post-thumbnail' );
									$thumbmobile = wp_get_attachment_image_src( $tnid, 'post-thumbnail' );
									$caption = get_post($tnid)->post_excerpt;
							?>
								<div class="post-image">
									<a href="<?php echo get_permalink($box->ID); ?>" title="<?php echo addslashes(get_the_title($box->ID)); ?>">
										<?php /*<img src="<?=$thumbbig[0]?>" class="attachment-post-thumbnail size-preview_blog wp-post-image" alt="<?php the_title(); ?>" width="300" height="230">*/ ?>
											<picture>
												<source media="(min-width: 40em)" srcset="<?=$thumbdesktop[0]?>">
												<source srcset="<?=$thumbmobile[0]?>">
												<img src="<?=$thumbdesktop[0]?>" alt="<?php echo addslashes(get_the_title($box->ID)); ?>">
											</picture>
									</a>
								</div>

							<?php } ?>

								<div class="post-content">
									<h2><a href="<?php echo get_permalink($box->ID); ?>" title="Permalink zu <?php echo addslashes(get_the_title($box->ID)); ?>" rel="bookmark"><?php echo get_the_title($box->ID); ?></a></h2>
									<div class="post-description">
										<?php echo $box->post_excerpt; ?>
									</div>
								</div>
								<div class="clear"></div>
							</article>
							<!-- Post --><?php
							}
						}
					}
				?>
		</div>
	</div>
</section>
<?php
wp_enqueue_script("us-imagesloaded", get_template_directory_uri()."/js/imagesloaded.pkgd.min.js", array( 'jquery' ));
wp_enqueue_script("us-masonry", get_template_directory_uri()."/js/masonry.pkgd.min.js", array( 'jquery','us-imagesloaded' ));
?>
<!--<script src="<?php echo get_template_directory_uri(); ?>/js/masonry.pkgd.min.js"></script>-->
<?php
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

get_footer(); ?>