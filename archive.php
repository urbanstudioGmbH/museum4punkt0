<?php
/**
 * The template for displaying archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package urbanstudio
 */
get_header();

?>

<main class="archive">
	<div class="center">
		
		<hgroup id="archiv_title">
			<h1><?php the_archive_title(); ?></h1>
		</hgroup>
		
		<div class="masonry">
			<div class="grid-sizer"></div>
			<div class="gutter-sizer"></div>
			<?php if (!have_posts()) : ?>

				<strong>Leider führte Ihre Suche zu keinem Ergebnis.</strong>

			<?php endif;
				while (have_posts()) : the_post(); ?>
			
				<article <?php
					if(!has_post_thumbnail()) { $class = 'loop no-image'; } else { $class = 'loop'; }
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
							<picture>
								<source media="(min-width: 40em)" srcset="<?=$thumbdesktop[0]?>">
								<source srcset="<?=$thumbmobile[0]?>">
								<img src="<?=$thumbdesktop[0]?>" alt="<?php the_title(); ?>">
							</picture>
						</a>
					</div>

				<?php } ?>

					<div class="post-content">
						<hgroup>
							<h4><?php the_category(', '); ?></h4>
							<h2><a href="<?php the_permalink(); ?>" title="Permalink zu <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
						</hgroup>
						<div class="post-description">
							<?php the_excerpt(); ?>
							<?php if(get_post_format( $post->ID ) == "quote"){ ?><div class="quote-author"><?php the_field("zitat-author"); ?></div><?php } ?>
						</div>
					</div>
					<div class="clear"></div>
				</article>
				<!-- Post -->

			<?php endwhile; // End the loop. Whew.  ?>
		</div>
		
		<div class="clear"></div>

	</div>
	
	<div class="clear"></div>
</main>


<?php
the_posts_pagination( array(
	'mid_size'  => 2,
	'prev_text' => __( 'Back', 'textdomain' ),
	'prev_next'          => false,
	'type'               => 'plain',
	'next_text' => __( 'Onward', 'textdomain' ),
) );

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
?>

<?php get_footer(); ?>