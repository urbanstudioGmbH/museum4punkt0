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
		<article class="blogpost project">
	        	
			<?php while (have_posts()) : the_post(); ?>
	       
				<?php the_content(); ?>
				
				<?php the_tags( '<div class="meta-tags"><i class="fas fa-tag"></i> ', ' &nbsp; ', '</div>' ); ?>

				

			

		
        <?php endwhile; // End the loop. Whew.  ?>

	


</main>


	<?php if(themeHelper::checkCommentsAllowed()){
        comments_template();
    } ?>

	
	<div class="clear"></div>
</main>


<?php get_footer(); ?>