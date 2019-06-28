<?php
/**
 * Template Name: Sitemap Page
 * @package WordPress
 */
get_header();
?>

<main class="single page">
	<div class="center">
		<article>

			<?php while (have_posts()) : the_post(); ?>
				<?php the_content(); ?>

				<h2 id="pages"><?php echo __("Seiten","uslang"); ?></h2>
				<ul>
				<?php // Add pages you'd like to exclude in the exclude here
				$frontpage_id = get_option( 'page_on_front' );
				wp_list_pages( array( 'exclude' => $frontpage_id,
						'title_li' => '',
					)
				);
				?>
				</ul>
<?php if(defined("ICL_LANGUAGE_CODE") && ICL_LANGUAGE_CODE == "de"){ ?>
				<h2 id="posts">Blog</h2>
				<ul>
				<?php
				// Add categories you'd like to exclude in the exclude here
				$cats = get_categories('exclude=');
				foreach ($cats as $cat) {
					echo "
							<li>
							<h3>".$cat->cat_name."</h3>
							";
					echo "
							<ul>";
								query_posts('posts_per_page=-1&cat='.$cat->cat_ID);
								while(have_posts()) {
									the_post();
									$category = get_the_category();
									// Only display a post link once, even if it's in multiple categories
									if ($category[0]->cat_ID == $cat->cat_ID) {
										echo '
											<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>

										';
									}			
								}
							echo "</ul>
					";
					echo "</li>";
				}
				?>
				</ul>
<?php } ?>
			<?php
				foreach( get_post_types( array('public' => true) ) as $post_type ) {
                    if (defined("ICL_LANGUAGE_CODE") && ICL_LANGUAGE_CODE == "de") {
                        if (in_array($post_type, array('post','page','attachment',"kontakt"))) {
                            continue;
                        }
                    }else{
											if (in_array($post_type, array('post','page','attachment',"kontakt","news","events"))) {
												continue;
										}
										}
					$pt = get_post_type_object( $post_type );

					echo '<h2>'.__($pt->labels->name,"uslang").'</h2>';
					echo '<ul>';

					query_posts('post_type='.$post_type.'&posts_per_page=-1');
					while( have_posts() ) {
						the_post();
						echo '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
					}

					echo '</ul>';
				}
				wp_reset_query();
			?>
			<?php endwhile; // End the loop. Whew.  ?>

		</article>
    </div>
</main>

<?php get_footer(); ?>
