<?php
/**
 * Template Name: Homepage
 * @package WordPress
 */
get_header();
?>

<?php
//if (is_front_page()) {
    ?>
<div class="flyntComponent" is="flynt-hero-section">
  <section class="scroll-content" style="height: 400vh;">
    <div id="hero-content" class="hero-content hero-content--blurred">
      <canvas id="animation" class="animation" width="3714" height="1512" style="touch-action: auto; transform: translateZ(0px); visibility: visible; cursor: inherit;"></canvas>

      <div class="animated-background">
        <h1 class="animated-heading animated-heading--title" data-filter-value="Museum4punkt0" id="museum"><span>museum4punkt0</span> </h1>
        <h2 class="animated-heading animated-heading--slogan" data-filter-value="Museum4punkt0"><span>Digitale Strategien für das Museum der Zukunft</span></h2>
      </div>

            <div class="scrollDown">
        <div class="scrollDown-wrapper">
          <span class="scrollDown-link">Scrollen</span>
        </div>
        <span class="scrollDown-link scrollDown-link-arrow"></span>
      </div>
    
    <div class="skipIntro">
      <a class="skipIntro-label" data-scroll="" href="#museum">Skip Intro <span class="skipIntro-icon"></span></a>
    </div>

    </div>
  <div id="text-trigger-1" class="scrollmagic-trigger" style="top: 250vh;"></div></section>
</div>
<?php
		wp_enqueue_script("homeani/tweenLite", get_template_directory_uri()."/js/vendor/tweenLite.js");
    wp_enqueue_script("homeani/pixiPlugin", get_template_directory_uri()."/js/vendor/pixiPlugin.js");
    wp_enqueue_script("homeani/pixi", get_template_directory_uri()."/js/vendor/pixi.js");
    wp_enqueue_script("homeani/scrollmagic", get_template_directory_uri()."/js/vendor/scrollmagic.js");
    wp_enqueue_script("homeani/Tweenlight", get_template_directory_uri()."/js/vendor/animation-gsap.js");
		wp_enqueue_script("homeani/stickyfilljs", get_template_directory_uri()."/js/vendor/stickyfilljs.js");
		wp_enqueue_script("homeani/shuffleLetters", get_template_directory_uri()."/js/vendor/jquery.shuffleLetters.js");
		wp_enqueue_script("homeani", get_template_directory_uri()."/js/homeani.js");
		wp_enqueue_style("homeani", get_template_directory_uri()."/css/homeani.css");
// } // is_front_page()
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