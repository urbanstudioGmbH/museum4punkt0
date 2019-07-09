<?php
/**
 * 
 * @package WordPress
 */
get_header();

	$project = get_field("project");
	$approachID = get_field("approach");
	$thisID = get_the_ID();
?>	
<main>
	<div class="center">
		<article class="result-detail">
			<div class="alignfull">
				<div class="center">
					<header>
						<div class="meta">
							<strong class="resulttype" <?php if(wp_get_post_terms(get_the_ID(), 'resulttype')[0]->name == "Nicht eingeordnet"):?>style="display:none"<?php endif; ?>>
								<?php 
									echo wp_get_post_terms(get_the_ID(), 'resulttype')[0]->name;
								?>
							</strong> <?php if(wp_get_post_terms(get_the_ID(), 'resulttype')[0]->name !== "Nicht eingeordnet" && wp_get_post_terms(get_the_ID(), 'technology')[0]->name !== "Nicht eingeordnet"):?>für<?php endif; ?> 
							<strong class="technology" <?php if(wp_get_post_terms(get_the_ID(), 'technology')[0]->name == "Nicht eingeordnet"):?>style="display:none"<?php endif; ?>>
								<?php 
									echo wp_get_post_terms(get_the_ID(), 'technology')[0]->name;
								?>
							</strong>
						</div>
						<h1 class="post-header-title"><?php the_title(); ?></h1>
					</header>
					<div class="detail-intro">
						<div class="intro-content">
							<?php the_excerpt(); 

							if(defined("ICL_LANGUAGE_CODE")) { 
								$lang = ICL_LANGUAGE_CODE;
								//echo $lang;

							$post = get_post(); 

							if ( has_blocks( $post->post_content ) ) {
							    $blocks = parse_blocks( $post->post_content );
							    $hasusage = false;
							    foreach( $blocks as $block) {
							    	if ( $block['blockName'] === 'acf/block-us-usage' && $hasusage === false) { 
							    		$hasusage = true; 

							    		$linktext = "cc_link_usage_".$lang;
								?>
							<a href="#usage" class="arrow-down"><?php the_field($linktext, "options"); ?></a>	
								    <?
									
								    }
							    }
							  } 
							} ?>
						</div>
						<div class="infobox">
							<a href="javascript:;" class="arrow-plus"><?php the_field("cc_toggle_result_infobox_".$lang, "options"); ?></a>

							<?php $infobox = get_field('infobox');	 ?>
							<dl>
								<?php if(!empty($project[0]->ID)): ?>
								<dt><?php the_field("cc_resultof_".$lang, "options"); ?></dt>
								<dd><a href="<?php the_permalink($project[0]->ID); ?>">"<?php echo $project[0]->post_title; ?>"</a></dd>
								<?php endif; ?>
								<?php if(!empty($infobox["top_result"])): ?>
								<dt><?php the_field("cc_top_result_".$lang, "options"); ?></dt>
								<dd><a href="<?php the_permalink($infobox["top_result"]->ID); ?>"><?=$infobox["top_result"]->post_title; ?></a></dd>
								<?php endif; ?>
								<?php if ( !empty(wp_get_post_terms(get_the_ID(), 'communicationmethod')[0]->name ) && wp_get_post_terms(get_the_ID(), 'communicationmethod')[0]->name !== "Nicht eingeordnet" ): ?>
								<dt><?php $taxonomy = get_taxonomy( 'communicationmethod' ); echo $taxonomy->label; // or singular_name?></dt>
								<dd>
									<?php 
										echo wp_get_post_terms(get_the_ID(), 'communicationmethod')[0]->name;
									?>
								</dd>
								<?php endif; ?>

								<?php if( !empty($infobox['freitext_titel']) && !empty($infobox['freitext_inhalt']) ): ?>
								<dt><?=$infobox['freitext_titel']; ?></dt>
								<dd>
									<?=$infobox['freitext_inhalt']; ?>
								</dd>
								<?php endif; ?>
							</dl>
						</div>
						<?php 
							$post_image = get_the_post_thumbnail_url(get_the_ID(),'large'); 

							if (!empty($post_image)):
						?>
						<!-- predefined content -->
						<div class="cb_module cb_figure">
							<figure>
								<div class="image" style="background-image: url(<?php echo $post_image; ?>)">
									<?php echo get_the_post_thumbnail(get_the_ID(), 'large'); ?>
								</div>
								<?php
								$figcaption = get_the_post_thumbnail_caption(get_the_ID());
								if ( !empty($figcaption) ) { 	?>	
								<figcaption>
									<p><?=$figcaption; ?></p>
								</figcaption>
								<?php } ?>
							</figure>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		
			<main>

				<?php the_content(); ?>
				
			</main>
			<footer>
				
				<div class="cb_module cb_sharing">
					<?php //echo do_shortcode('[shariff]'); ?>
					<?php

					$sharer = new themeHelper($post);

					$sharer->getSharingOptions();

					?>

				</div>
			</footer>
		</article>

		<div class="project_reference alignfull">
			<div class="center">
				<h2><?php the_field('cc_resultof_'.$lang,'options')?> <a href="<?php the_permalink($project[0]->ID); ?>">"<?php echo $project[0]->post_title; ?>"</a></h2>
				<a href="<?php the_permalink($project[0]->ID); ?>" class="btn btn-arrow-right light"><?php the_field('cc_gotoproject_'.$lang,'options')?></a>


				<?php 
				
				$args = array(
			        'post_type' => 'result',
			        'meta_query'     => array(
						array(
							'key'     => 'approach',
							'value'   => $approachID,
							'compare' => '='
						),
					)

			    );

			    $post_query = new WP_Query($args);

				if($post_query->have_posts() ) { ?>

				<div class="cb_module cb_items">
					<div class="items slider">

						<?php
						while($post_query->have_posts() ) {
						    $post_query->the_post();
						    setup_postdata($post); 
						    $thumbnail = get_the_post_thumbnail_url(get_the_ID(),'thumbnail'); 
						    
							?>
						<div class="item <?php if(get_the_ID() == $thisID) echo 'current'; ?>">
							<a href="<?php the_permalink( get_the_ID() ); ?>" data-item="item-<?php echo get_the_ID(); ?>">
								<article>
									<header>
										<div class="meta">
											<span class="insights">
												<?php 
													echo wp_get_post_terms(get_the_ID(), 'insights')[0]->name;
												?>

											</span>

											<span class="applicationfields">
												<?php 
													echo wp_get_post_terms(get_the_ID(), 'applicationfields')[0]->name;
												?>
											</span>

											<strong class="resulttype" <?php if(wp_get_post_terms(get_the_ID(), 'resulttype')[0]->name == "Nicht eingeordnet"):?>style="display:none"<?php endif; ?>>
												<?php 
													echo wp_get_post_terms(get_the_ID(), 'resulttype')[0]->name;
												?>
											</strong> <?php if(wp_get_post_terms(get_the_ID(), 'resulttype')[0]->name !== "Nicht eingeordnet" && wp_get_post_terms(get_the_ID(), 'technology')[0]->name !== "Nicht eingeordnet"):?>für<?php endif; ?> 
											<strong class="technology" <?php if(wp_get_post_terms(get_the_ID(), 'technology')[0]->name == "Nicht eingeordnet"):?>style="display:none"<?php endif; ?>>
												<?php 
													echo wp_get_post_terms(get_the_ID(), 'technology')[0]->name;
												?>
											</strong>
										</div>
										<h1><?php the_title(); ?></h1>
										
									</header>
									<figure style="background-image:url(<?=$thumbnail; ?>)">
										<?php echo get_the_post_thumbnail(get_the_ID()); ?>
									</figure>
									<footer class="communicationmethod" <?php if(wp_get_post_terms(get_the_ID(), 'communicationmethod')[0]->name == "Nicht eingeordnet"):?>style="visibility: hidden"<?php endif; ?>>
										<?php 
											echo wp_get_post_terms(get_the_ID(), 'communicationmethod')[0]->name;
										?>
									</footer>
								</article>
							</a>
						</div>
						    <?php
						} wp_reset_postdata();
						?>
						
		            </div>
		        </div>
				<?php } ?>
			</div>
		</div>
	

		<div class="center-button">
			<a href="<?php $resultspage = get_field('page_for_results','options'); the_permalink($resultspage->ID); ?>" class="btn outline"><?php the_field('cc_allresults_'.$lang,'options')?></a>
			
		</div>

	</div>

</main>
<?php 
get_footer();
?>