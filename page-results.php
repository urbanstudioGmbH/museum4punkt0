<?php
/**
 * Template Name: Results Overview
 * @package WordPress
 */
get_header();
global $defaultresultterm;
$defaultresultterm = get_field("default_result_category","options");
?>
	<main>
		<div class="center">
			<div class="intro">
				<h1 class="post-header-title"><?php the_title(); ?></h1>
				<div class="intro-content">
					<?php the_excerpt(); 
					if(defined("ICL_LANGUAGE_CODE")) { 
						$lang = ICL_LANGUAGE_CODE;
							//echo $lang;

						/*$post = get_post(); 

						if ( has_blocks( $post->post_content ) ) {
						    $blocks = parse_blocks( $post->post_content );
						    $countBlocks = count($blocks);
						    
						    if ( $countBlocks > 0 ) {*/

						if( '' !== get_post()->post_content ) { ?>
							<a href="#foot_content" class="arrow-down"><?php the_field("cc_link_usage_".$lang, "options"); ?></a>
						<?php
						   
						} 
					}
					?>
					
				</div>
			</div>


		</div>
		
		<?php 
		// get taxonomies for custom post type 'result' as objects
		$taxonomies = get_object_taxonomies( 'result', 'objects' );
		// sort taxonomies by plugin function of "Custom Taxonomy Order" WP Plugin
		$taxonomies = customtaxorder_sort_taxonomies($taxonomies);
		?>
		<div id="sortable">
			<div class="sortable-menu-placeholder">
				<div class="sortable-menu-wrapper">
					<div class="center">
						<div id="sortable-menu">
							<span class="label">Sortieren nach</span>
							<nav>
								<span class="selected-helper empty" data-placeholder="Auswählen"></span>
								<ul id="sorts" class="button-group">
									<?php 
									$countTax = 1;
									// create taxonomie sortable filter with tab id by count
									foreach($taxonomies as $taxonomy) { 
										?>
									<li><a href="#sortable-<?=$countTax; ?>" data-sort-by="<?=$taxonomy->name; ?>"><?=$taxonomy->label; ?></a></li>
									
									<?php 
									$countTax++;
									} ?>
								</ul>
							</nav>
							
						</div>
						<div id="jump-menu">
							<nav>
								<?php
									$countTaxTerms = 1;
									foreach($taxonomies as $taxonomy) { 
										
									// create taxonomie terms navigation
										

								?>

								<ul id="sortable-<?=$countTaxTerms; ?>">
									<?php 
										// show taxonomies terms that are not empty
										$terms = get_terms( array(
										    'taxonomy' => $taxonomy->name,
										    'orderby' => 'term_order',
										    'hide_empty' => false,
										) );

										
										foreach($terms as $term) {
											if($term->count > 0): 
												//print_r($term);

									?>
									<li><a href=""><?=$term->name; ?></a></li>
									
									<?php
										endif;
										}
									?>
									<li><a href=""><?=$defaultresultterm; ?></a></li>
								</ul>
								<?php 
									$countTaxTerms++;
								} ?>
								
							</nav>
						</div>
					</div>
				</div>
			</div>
			
								
			<div class="center">
				<a href="#sortable" id="scrolltop-results" style="display:none">Scroll to top</a>
				<div id="sortable-content" class="items">
					<?php 

					$args = array(
					    'post_type'=> 'result',
					    'posts_per_page' => -1,
					    'nopaging' => true,					    
					    'order'    => 'ASC'
					    );              

					$the_query = new WP_Query( $args );
					if($the_query->have_posts() ) : while ( $the_query->have_posts() ) : $the_query->the_post(); 


						$thumbnail = get_the_post_thumbnail_url(get_the_ID(),'thumbnail'); 
						$thisSlug = wp_get_post_terms(get_the_ID(), 'resulttype')[0]->slug;


						$initialOrder = 1;
						if ($thisSlug === "digitale-anwendung") {
							$initialOrder = 0;
						}
						include("template-parts/result-item.php");

					?>

					


				<?php endwhile;
					wp_reset_postdata();
				endif;

			?>
			
		</div>
		<div class="following-content">
			<div class="center" id="foot_content">
				<article>
					<?php the_content(); ?>
				</article>
			</div>
		</div>
	</main>
<?php 
get_footer();
?>