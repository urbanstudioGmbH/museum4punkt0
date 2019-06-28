<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package davaso
 */

get_header(); 

if(is_front_page()) {

	

}
?>

<section id="headergap"></section>

<section id="breadcrumbs">
		<?php if (function_exists('nav_breadcrumb')) nav_breadcrumb(); ?>
</section>


<!-- #main -->
<div class="main">
<div class="center">


<?php

get_template_part('loop');
get_sidebar();

?>

</div>
</div>
<!-- #main / End -->

<?php get_footer(); ?>