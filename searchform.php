<?php
/**
 * The template for displaying search forms 
 *
 */
?>
<div class="search">
	<form method="get" id="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
		<label for="s">Suche:</label><input name="s" id="s" value="<?php echo get_search_query(); ?>" placeholder="Suchbegriff eingeben..." autocomplete="off"  type="text" class="text"/>
		<?php /*<div class="searchbtn" onClick="document.getElementById('searchform').submit();"><i class="fa fa-search" aria-hidden="true"></i></div>*/ ?>
		<div class="searchtipp">...und mit Enter starten.</div>
	</form>
</div>