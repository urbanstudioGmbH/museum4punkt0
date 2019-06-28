<?php
/**
 * The main template file.
 * @package WordPress
 */
get_header();
?>

<main class="single page">
	<div class="center">
		<article>

			<?php while (have_posts()) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile; // End the loop. Whew.  ?>

		</article>
    </div>
</main>

<?php get_footer(); ?>
