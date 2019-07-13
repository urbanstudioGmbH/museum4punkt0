<?php
/**
 * Template Name: Results Overview
 * @package WordPress
 */
get_header();
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
					?>

					<div class="item" data-order="<?=$initialOrder; ?>" data-original-order="<?=$initialOrder; ?>"  data-project="<?=get_field("project")[0]->ID; ?>">
						<a href="<?php the_permalink( get_the_ID() ); ?>" data-item="item-<?php echo get_the_ID(); ?>">
							<article>
								<header>
									<div class="meta">
										<span class="insights">
											<?php 
												$insights = wp_get_post_terms(get_the_ID(), 'insights')[0]->name;
												if (empty($insights) ) {
													echo "Nicht eingeordnet";
												} else {
													echo $insights;
												}
											?>

										</span>

										<span class="applicationfields">
											<?php 
												$applicationfields = wp_get_post_terms(get_the_ID(), 'applicationfields')[0]->name;
												if (empty($applicationfields) ) {
													echo "Nicht eingeordnet";
												} else {
													echo $applicationfields;
												}
											?>
										</span>

										<strong class="resulttype" <?php if(wp_get_post_terms(get_the_ID(), 'resulttype')[0]->name == "Nicht eingeordnet"):?>style="display:none"<?php endif; ?>>
											
											<?php 
												$resulttype = wp_get_post_terms(get_the_ID(), 'resulttype')[0]->name;
												if (empty($resulttype) ) {
													echo "Nicht eingeordnet";
												} else {
													echo $resulttype;
												}
											?>
										</strong> <?php if(wp_get_post_terms(get_the_ID(), 'resulttype')[0]->name !== "Nicht eingeordnet" && wp_get_post_terms(get_the_ID(), 'technology')[0]->name !== "Nicht eingeordnet"):?>für<?php endif; ?> 
										<strong class="technology" <?php if(wp_get_post_terms(get_the_ID(), 'technology')[0]->name == "Nicht eingeordnet"):?>style="display:none"<?php endif; ?>>
											
											<?php 
												$technology = wp_get_post_terms(get_the_ID(), 'technology')[0]->name;
												if (empty($technology) ) {
													echo "Nicht eingeordnet";
												} else {
													echo $technology;
												}
											?>
										</strong>
									</div>
									<h1><?php the_title(); ?></h1>
									
								</header>
								<figure style="background-image:url(<?=$thumbnail; ?>)" >
									<?php echo get_the_post_thumbnail(get_the_ID()); ?>
								</figure>
								<footer class="communicationmethod" <?php if(wp_get_post_terms(get_the_ID(), 'communicationmethod')[0]->name == "Nicht eingeordnet" || empty(wp_get_post_terms(get_the_ID(), 'communicationmethod')[0]->name)):?>style="visibility: hidden"<?php endif; ?>>
									<?php 
										$communicationmethod = wp_get_post_terms(get_the_ID(), 'communicationmethod')[0]->name;
										if (empty($communicationmethod) ) {
											echo "Nicht eingeordnet";
										} else {
											echo $communicationmethod;
										}
									?>
								</footer>
							</article>
						</a>
					</div>


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