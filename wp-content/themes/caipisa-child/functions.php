<?php
/**
 * Child theme functions
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Text Domain: oceanwp
 * @link http://codex.wordpress.org/Plugin_API
 *
 */

/**
 * Load the parent style.css file
 *
 * @link http://codex.wordpress.org/Child_Themes
 */
function oceanwp_child_enqueue_parent_style() {
	// Dynamically get version number of the parent stylesheet (lets browsers re-cache your stylesheet when you update your theme)
	$theme   = wp_get_theme( 'OceanWP' );
	$version = $theme->get( 'Version' );
	// Load the stylesheet
	wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( 'oceanwp-style' ), $version );
	
}
add_action( 'wp_enqueue_scripts', 'oceanwp_child_enqueue_parent_style' );

// code from old.caipisa.it for custom post type corso
if ( ! function_exists('corso_post_type') ) {

// Register Custom Post Type
function corso_post_type() {

	 $labels = array(
	 	'name'                  => _x( 'Corsi', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Corso', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Corsi', 'text_domain' ),
		'name_admin_bar'        => __( 'Corsi', 'text_domain' ),
		'archives'              => __( 'Archivio corsi', 'text_domain' ),
		'attributes'            => __( 'Caratteristiche del corso:', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Item:', 'text_domain' ),
		'all_items'             => __( 'Tutti i corsi', 'text_domain' ),
		'add_new_item'          => __( 'Aggiungi nuovo corso', 'text_domain' ),
		'add_new'               => __( 'Aggiungi nuovo', 'text_domain' ),
		'new_item'              => __( 'Nuovo corso', 'text_domain' ),
		'edit_item'             => __( 'Modifica corso', 'text_domain' ),
		'update_item'           => __( 'Aggiorna corso', 'text_domain' ),
		'view_item'             => __( 'Visualizza corso', 'text_domain' ),
		'view_items'            => __( 'Visualizza corsi', 'text_domain' ),
		'search_items'          => __( 'Cerca corso', 'text_domain' ),
		'not_found'             => __( 'Nessun risultato', 'text_domain' ),
		'not_found_in_trash'    => __( 'Nessun risultato nel cestino', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Inserisci nel corso', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Lista dei corsi', 'text_domain' ),
		'items_list_navigation' => __( 'Navigazione dei corsi', 'text_domain' ),
		'filter_items_list'     => __( 'Filtra la lista dei corsi', 'text_domain' ),
		);
		$args = array(
		'label'                 => __( 'corso', 'text_domain' ),
		'description'           => __( '', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'revisions', 'page-attributes', 'post-formats', ),
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-welcome-learn-more',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => 'corsi',
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
		'show_in_rest'          => true,
		);
		register_post_type( 'corso', $args );
}
add_action( 'init', 'corso_post_type', 0 );

}
add_filter( 'tec_views_v2_use_subscribe_links', '__return_false' );