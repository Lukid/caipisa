<?php
/*
Plugin Name: CAI Custom Feed
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function custom_posts_feed_template() {
    load_template( plugin_dir_path( __FILE__ ) . 'custom_posts_feed_template.php' );
}

function custom_events_feed_template() {
    load_template( plugin_dir_path( __FILE__ ) . 'custom_events_feed_template.php' );
}

add_action( 'do_feed_custom_feed', 'custom_feed_template', 10, 1 );

function custom_feed_init() {
    add_feed( 'custom_posts_feed', 'custom_posts_feed_template' );
    add_feed( 'custom_events_feed', 'custom_events_feed_template' );
}

add_action( 'init', 'custom_feed_init' );
