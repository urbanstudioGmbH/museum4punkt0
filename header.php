<?php if ( !session_id() ) session_start(); ?>
<!DOCTYPE html>
<html lang="de-DE">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5">
	<meta name="apple-mobile-web-app-title" content="museum4punkt0">
    <meta name="application-name" content="museum4punkt0">
    <meta name="theme-color" content="#ffffff">

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	/*<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png" >
	<link rel="icon" type="image/png" sizes="32x32" href="https://www.museum4punkt0.de/app/themes/museum40/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="https://www.museum4punkt0.de/app/themes/museum40/favicon-16x16.png">
	<link rel="mask-icon" href="https://www.museum4punkt0.de/app/themes/museum40/safari-pinned-tab.svg" color="#000000">
	<link rel="apple-touch-icon" href="https://www.museum4punkt0.de/app/themes/museum40/apple-touch-icon-180x180.png">
	<link rel="manifest" href="https://www.museum4punkt0.de/app/themes/museum40/site.webmanifest">
*/ ?>
	<?php wp_head(); ?>
	<!-- Overwrite CSS-->
	<link type="text/css" media="all" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/m4p0.css">

</head>

<?php $body_class = get_field("body_class"); ?>
<body role="document" class="<?php if(is_front_page()){ echo 'home'; } ?> <?=$body_class?>">
<div id="wrapper">

<!-- #header // -->
<header id="header" class="<?php if(is_front_page()){ echo 'home'; } ?>">
	<div class="center">
		<div id="branding">
			<a href="<?php echo get_home_url(); ?>" id="logo" title="<?php echo get_bloginfo("name"); ?> - <?php echo get_bloginfo("description"); ?>">
				<span class="claim"><?php echo get_bloginfo("name"); ?> - <?php echo get_bloginfo("description"); ?></span>
				<?php
					$custom_logo_id = get_theme_mod( 'custom_logo' );
					$logo = wp_get_attachment_image_src( $custom_logo_id , 'full' );
                    if (has_custom_logo()) {
                        $logourl = esc_url($logo[0]);
                    }else{
						$logourl = "/wp-content/themes/museum4punkt0/images/logo-museum4punkt0.svg";
					}
					echo '<img src="'.$logourl.'" alt="'.get_bloginfo("name").'">';
				?>
			</a>
		</div>
		<nav id="navigation">
		<?php
			$menu = wp_nav_menu(
			array(
				'theme_location' => 'mainmenu',
				'echo' => 0,
				'menu_class' => 'mainmenu',
				'container' => false)
			);
			$menu = str_replace("\n", "", $menu);
			$menu = str_replace("\r", "", $menu);
			echo $menu;
		?>
		</nav>

		<div id="navbtn" class="closed">
			<span class="line1"></span>
			<span class="line2"></span>
			<span class="line3"></span>
		</div>
	</div>
</header>
<!-- #header // end // -->

<section id="globalsearch">
	<?php include('searchform.php'); ?>
</section>
