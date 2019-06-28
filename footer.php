</div>
<!-- #wrapper // end // -->

<!-- #footer // -->
<footer id="footer">

	<section id="footer-dark">
		<div class="center">

			<div class="footer-company">
				<img class="" src="/wp-content/themes/museum4punkt0/images/Logo-Kombi_footer.svg" alt="Museum4punkt0">
				<h2 class="paragraph"><?php echo __("Digitale Strategien für das Museum der Zukunft", "uslang"); ?></h2>
			</div>

			<nav role="menu" class="footer-navigation">
				<?php
					$footernav = wp_nav_menu(
					array(
						'theme_location' => 'footnav',
						'echo' => 0,
						'menu_id' => 'footer-nav',
						'container' => false)
					);
					$footernav = str_replace("\n", "", $footernav);
					$footernav = str_replace("\r", "", $footernav);
					echo $footernav;
				?>
			</nav>

			<div class="footer-social">
				<a href="https://twitter.com/museum4punkt0" class="twitter" target="_blank">Twitter</a>
				<a href="https://vimeo.com/channels/museum4punkt0" class="vimeo" target="_blank">Vimeo</a>
			</div>

		</div>
		<div class="topline"></div>
		<div class="bottomline"></div>
	</section>

	<section id="footer-logos">
		<div class="center">
			<div class="container-institutions">
				<h3 class="container-title"><?php echo __("Gefördert durch"); ?>:</h3>
				<?php
				$sponsors = get_field("sponsor", "option");
				foreach($sponsors AS $sponsor){
					echo '<a class="institution-link" href="'.$sponsor["url"].'" target="_blank" title="'.$sponsor["logo"]["alt"].'">';
						echo '<img class="institution-logo" src="'.$sponsor["logo"]["url"].'" alt="'.$sponsor["logo"]["alt"].'">';
					echo '</a>';
				}
				?>
			</div>
			<div class="container-sponsors">
				<h3 class="container-title"><?php echo __("Beteiligte Institutionen"); ?>:</h3>
				<div class="sponsors">
				<?php
				$institutions = get_field("institutions", "option");
                foreach ($institutions as $institution) {
                    echo '<a class="sponsor-link" href="'.$institution["url"].'" target="_blank" title="'.$institution["logo"]["alt"].'">';
                    	echo '<img class="sponsor-logo" src="'.$institution["logo"]["url"].'" alt="'.$institution["logo"]["alt"].'">';
                    echo '</a>';
				}
				?>
				</div>
			</div>
		</div>
	</section>

	<section id="footer-copy">&copy; <?php echo date('Y'); ?> <?php the_field("copyrighttext", "option"); ?></section>

</footer>
<!-- #footer // end // -->

<?php wp_footer(); ?>
</body>
</html>
