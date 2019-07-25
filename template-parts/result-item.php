<?php 
global $defaultresultterm;
?>
<div class="item <?php if(isset($thisID) && get_the_ID() == $thisID) echo 'current'; ?>" data-order="<?=$initialOrder; ?>" data-original-order="<?=$initialOrder; ?>"  data-project="<?=get_field("project")[0]->ID; ?>">
	<a href="<?php the_permalink( get_the_ID() ); ?>" data-item="item-<?php echo get_the_ID(); ?>">
		<article>
			<header>
				<div class="meta">
					<span class="insights">
						<?php 
							$insights = wp_get_post_terms(get_the_ID(), 'insights')[0]->name;
							if (empty($insights) ) {
								echo $defaultresultterm;
							} else {
								echo $insights;
							}
						?>

					</span>

					<span class="applicationfields">
						<?php 
							$applicationfields = wp_get_post_terms(get_the_ID(), 'applicationfields')[0]->name;
							if (empty($applicationfields) ) {
								echo $defaultresultterm;
							} else {
								echo $applicationfields;
							}
						?>
					</span>

					<strong class="resulttype" <?php if(
						empty(wp_get_post_terms(get_the_ID(), 'resulttype')[0]->name)):?>style="display:none"<?php endif; ?>>
						
						<?php 
							$resulttype = wp_get_post_terms(get_the_ID(), 'resulttype')[0]->name;
							if (empty($resulttype) ) {
								echo $defaultresultterm;
							} else {
								echo $resulttype;
							}
						?>
					</strong> <?php 
					if(
						!empty(wp_get_post_terms(get_the_ID(), 'resulttype')[0]->name) && 
						!empty(wp_get_post_terms(get_the_ID(), 'technology')[0]->name)
					):?>&mdash;<?php endif; ?> 
					
					<strong class="technology" <?php if(empty(wp_get_post_terms(get_the_ID(), 'technology')[0]->name)):?>style="display:none"<?php endif; ?>>
						
						<?php 
							$technology = wp_get_post_terms(get_the_ID(), 'technology')[0]->name;
							if (empty($technology) ) {
								echo $defaultresultterm;
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
			<footer class="communicationmethod" <?php if( empty(wp_get_post_terms(get_the_ID(), 'communicationmethod')[0]->name)):?>style="visibility: hidden"<?php endif; ?>>
				<?php 
					$communicationmethod = wp_get_post_terms(get_the_ID(), 'communicationmethod')[0]->name;
					if (empty($communicationmethod) ) {
						echo $defaultresultterm;
					} else {
						echo $communicationmethod;
					}
				?>
			</footer>
		</article>
	</a>
</div>