<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package buddha
 */

get_header(); ?>

<main class="single page">
	<div class="center">
		<article>

			<?php
				$post = get_option("page_for_posts");
				$block_us_sp_headline = new block_us_sp_headline();
				ob_start();
				$block_us_sp_headline->block_us_sp_headline_render(array("id" => uniqid(), "align" => ""),'',false,$post);
				$hl = ob_get_clean();
				$dom = new \DOMDocument();
				$dom->preserveWhiteSpace = false;
	        	$dom->formatOutput = true;
				$dom->loadHTML(mb_convert_encoding($hl, 'HTML-ENTITIES', 'UTF-8'));
				$dom->getElementsByTagName("h1")->item(0)->nodeValue = 'Error #404';
				$element = $dom->getElementsByTagName("p")->item(0);
				$element->parentNode->removeChild($element);
				echo $dom->saveHTML();
				libxml_clear_errors();
			?>

			<?php /*<figure class="wp-block-image alignwide">
				<img src="/wp-content/themes/museum4punkt0/images/error404testbild.svg" alt="Error #404" class="error-image">
				<figcaption>© Stiftung Preußischer Kulturbesitz</figcaption>
			</figure>*/ ?>

			<p><strong><?php echo __("Der gewünschte Inhalt existiert nicht (mehr).", "uslang"); ?></strong><br>
			<?php
				$link = '<a href="'.get_home_url().'">'.__("Startseite", "uslang").'</a>';
				echo sprintf(__("Kehren Sie zu %s zurück oder suchen Sie einfach nach Themen:", "uslang"), $link); ?>
			</p>

			<div id="inlinesearch">
				<div class="search">
					<form method="get" id="searchform2" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<input name="s" id="s" value="" placeholder="<?php echo __("Suchbegriff eingeben und mit Enter starten...", "uslang"); ?>"  type="text" class="text" />
						<div class="searchbtn" onClick="document.getElementById('searchform2').submit();"><i class="far fa-search" aria-hidden="true"></i></div>
					</form>
				</div>
			</div>


		</article>

	</div>

	<section class="search-archive">
		<div class="center">
			<?php
				$tags = get_tags();
				$html = '<div class="meta-tags no-margin"><i class="fas fa-tag"></i> ';
				foreach ( $tags as $tag ) {
				    $tag_link = get_tag_link( $tag->term_id );

				    $html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>";
				    $html .= "{$tag->name}</a> &nbsp; ";
				}
				$html .= '</div>';
				echo $html;
			?>

		</div>
	</section>
</main>

<?php get_footer(); ?>
