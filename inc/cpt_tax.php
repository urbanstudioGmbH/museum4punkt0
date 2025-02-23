<?php

function cptui_register_my_cpts() {

/**
 * Post Type: Teilprojekte.
 */

$labels = array(
    "name" => __( "Teilprojekte", "custom-post-type-ui" ),
    "singular_name" => __( "Teilprojekt", "custom-post-type-ui" ),
);

$args = array(
    "label" => __( "Teilprojekte", "custom-post-type-ui" ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "delete_with_user" => false,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => false,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "teilprojekt", "with_front" => true ),
    "query_var" => true,
    "menu_icon" => "dashicons-portfolio",
    "supports" => array( "title", "editor", "thumbnail", "excerpt" ),
    "template" => array(
		array( 'acf/block-us-sp-headline' ),		
	)
);

register_post_type( "teilprojekt", $args );

/**
 * Post Type: Kontakte.
 */

$labels = array(
    "name" => __( "Kontakte", "custom-post-type-ui" ),
    "singular_name" => __( "Kontakt", "custom-post-type-ui" ),
);

$args = array(
    "label" => __( "Kontakte", "custom-post-type-ui" ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => false,
    "show_ui" => true,
    "delete_with_user" => false,
    "show_in_rest" => false,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => false,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "exclude_from_search" => true,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "kontakt", "with_front" => false ),
    "query_var" => true,
    "menu_icon" => "dashicons-id",
    "supports" => array( "title", "thumbnail" ),
);

register_post_type( "kontakt", $args );

/**
 * Post Type: Presse News.
 */

$labels = array(
    "name" => __( "Presse News", "custom-post-type-ui" ),
    "singular_name" => __( "Presse News", "custom-post-type-ui" ),
);

$args = array(
    "label" => __( "Presse News", "custom-post-type-ui" ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "delete_with_user" => false,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => false,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "news", "with_front" => true ),
    "query_var" => true,
    "supports" => array( "title", "editor", "thumbnail", "excerpt", "comments" ),
    "template" => array(
		array( 'acf/block-us-sp-headline' ),		
	)
);

register_post_type( "news", $args );

/**
 * Post Type: Events.
 */

$labels = array(
    "name" => __( "Events", "custom-post-type-ui" ),
    "singular_name" => __( "Event", "custom-post-type-ui" ),
);

$args = array(
    "label" => __( "Events", "custom-post-type-ui" ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "delete_with_user" => false,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => false,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "events", "with_front" => true ),
    "query_var" => true,
    "supports" => array( "title", "editor", "thumbnail", "excerpt", "comments" ),
    "taxonomies" => array( "eventart", "kurzinfo" ),
    "template" => array(
		array( 'acf/block-us-sp-headline' ),		
	)
);

register_post_type( "events", $args );

/**
 * Post Type: Partner.
 */

$labels = array(
    "name" => __( "Partner", "custom-post-type-ui" ),
    "singular_name" => __( "Partner", "custom-post-type-ui" ),
);

$args = array(
    "label" => __( "Partner", "custom-post-type-ui" ),
    "labels" => $labels,
    "description" => "",
    "public" => true,
    "publicly_queryable" => true,
    "show_ui" => true,
    "delete_with_user" => false,
    "show_in_rest" => true,
    "rest_base" => "",
    "rest_controller_class" => "WP_REST_Posts_Controller",
    "has_archive" => false,
    "show_in_menu" => true,
    "show_in_nav_menus" => true,
    "exclude_from_search" => false,
    "capability_type" => "post",
    "map_meta_cap" => true,
    "hierarchical" => false,
    "rewrite" => array( "slug" => "partner", "with_front" => true ),
    "query_var" => true,
    "supports" => array( "title", "editor", "thumbnail", "excerpt" ),
    "template" => array(
		array( 'acf/block-us-sp-headline' ),		
	)
);

register_post_type( "partner", $args );
}

add_action( 'acf/init', 'cptui_register_my_cpts' );

function cptui_register_my_taxes() {

	/**
	 * Taxonomy: Eventarten.
	 */

	$labels = array(
		"name" => __( "Eventarten", "custom-post-type-ui" ),
		"singular_name" => __( "Eventart", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "Eventarten", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'eventart', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "eventart",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		);
	register_taxonomy( "eventart", array( "events" ), $args );

	/**
	 * Taxonomy: Kurzinfos.
	 */

	$labels = array(
		"name" => __( "Kurzinfos", "custom-post-type-ui" ),
		"singular_name" => __( "Kurzinfo", "custom-post-type-ui" ),
	);

	$args = array(
		"label" => __( "Kurzinfos", "custom-post-type-ui" ),
		"labels" => $labels,
		"public" => true,
		"publicly_queryable" => true,
		"hierarchical" => false,
		"show_ui" => true,
		"show_in_menu" => true,
		"show_in_nav_menus" => true,
		"query_var" => true,
		"rewrite" => array( 'slug' => 'kurzinfo', 'with_front' => true, ),
		"show_admin_column" => false,
		"show_in_rest" => true,
		"rest_base" => "kurzinfo",
		"rest_controller_class" => "WP_REST_Terms_Controller",
		"show_in_quick_edit" => false,
		);
	register_taxonomy( "kurzinfo", array( "events" ), $args );
}
add_action( 'acf/init', 'cptui_register_my_taxes' );

