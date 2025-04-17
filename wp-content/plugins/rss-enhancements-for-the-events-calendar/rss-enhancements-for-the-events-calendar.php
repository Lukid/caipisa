<?php
/*
Plugin Name: RSS Enhancements for The Events Calendar
Plugin URI:  http://room34.com
Description: Customize The Events Calendar's RSS feed with date range, featured image and venue details.
Version:     1.2.0
Author:      Room 34 Creative Services, LLC
Author URI:  http://room34.com
Text Domain: r34ecre
License:     GPL2
*/

/*  Copyright 2016 Room 34 Creative Services, LLC (email: info@room34.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Don't load directly
if (!defined('ABSPATH')) { exit; }


// Install/upgrade
register_activation_hook(__FILE__, 'r34ecre_default_options');


// Add admin page
function r34ecre_add_admin() {
	if (!is_plugin_active('the-events-calendar/the-events-calendar.php')) {
		add_action('admin_notices', 'r34ecre_missing_plugin');
	}
	else {
		add_submenu_page('edit.php?post_type=tribe_events', 'RSS Options', 'RSS Options', 'manage_options', 'ec-rss-options', 'r34ecre_admin');
	}
}
add_action('admin_menu', 'r34ecre_add_admin');


// Admin page
function r34ecre_admin() {
	// Process input
	if (isset($_POST['r34ecre-nonce'])) {
		if (wp_verify_nonce($_POST['r34ecre-nonce'],'r34ecre-update')) {
			update_option('r34ecre_days', (!empty($_POST['r34ecre_days']) ? intval($_POST['r34ecre_days']) : 7));
			update_option('r34ecre_max_events', (!empty($_POST['r34ecre_max_events']) ? intval($_POST['r34ecre_max_events']) : 100));
			update_option('r34ecre_images_all', !empty($_POST['r34ecre_images_all']));
			update_option('r34ecre_image_size', filter_input(INPUT_POST, 'r34ecre_image_size', FILTER_SANITIZE_STRING));
			update_option('r34ecre_venue_link', !empty($_POST['r34ecre_venue_link']));
			echo '<div class="notice notice-success"><p>Configuration changes were saved.</p></div>';
		}
		elseif (wp_verify_nonce($_POST['r34ecre-nonce'],'r34ecre-defaults')) {
			r34ecre_default_options();
			echo '<div class="notice notice-success"><p>Default configuration was restored.</p></div>';
		}
	}
	// Display page
	include_once(dirname(__FILE__) . '/admin.php');
}


// Set default options
function r34ecre_default_options() {
	// Only set defaults if the options are not already present; 'r34ecre_days' must have a value > 0 if set
	if (!get_option('r34ecre_days')) {
		update_option('r34ecre_days', 7);
		update_option('r34ecre_max_events', 100);
		update_option('r34ecre_images_all', false);
		update_option('r34ecre_image_size', 'thumbnail');
		update_option('r34ecre_venue_link', false);
	}
}


// Admin notice for missing plugin
function r34ecre_missing_plugin() {
	?>
	<div class="notice notice-error"><p><b>RSS Enhancements for The Events Calendar</b> requires <b>The Events Calendar</b> plugin, but it is missing. Please <a href="plugins.php?s=The%20Events%20Calendar">activate</a> or <a href="plugin-install.php?s=The+Events+Calendar&tab=search&type=term">install</a> The Events Calendar, or <a href="plugins.php?s=RSS%20Enhancements%20for%20The%20Events%20Calendar">deactivate</a> RSS Enhancements for The Events Calendar.</p></div> 
	<?php
}


// Modify individual RSS items
function r34ecre_rss_modify_item() {
	global $post;
	
	do_action('r34ecre_rss_modify_item_before');

	// Add featured image
	$images_all = get_option('r34ecre_images_all') ? get_option('r34ecre_images_all') : false;
	if ($images_all || $post->post_type == 'tribe_events') {

		if (has_post_thumbnail($post->ID)) {
			
			// Get image
			$image_size = get_option('r34ecre_image_size') ? get_option('r34ecre_image_size') : 'thumbnail';
			$thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), get_option('r34ecre_image_size'));
			$image = $thumbnail[0];

			// Get image file details
			$uploads = wp_upload_dir();
			$ext = pathinfo($image, PATHINFO_EXTENSION);
			$mime = ($ext == 'jpg') ? 'image/jpeg' : 'image/' . $ext;
			$path = $uploads['basedir'] . substr($image, (strpos($image, '/uploads') + strlen('/uploads')));
			$size = filesize($path);

			// Add image as enclosure
			echo '<enclosure url="' . esc_url($image) . '" length="' . intval($size) . '" type="' . esc_attr($mime) . '" />' . "\n";

		}
	}
	
	// Add event location (fudged into the <source> tag since there's no better place for it in RSS)
	if ($post->post_type == 'tribe_events') {
		if ($location = strip_tags(tribe_get_venue($post->ID))) {

			// Use the venue link
			if (get_option('r34ecre_venue_link')) {
				echo '<source url="' . tribe_get_venue_link($post->ID, false) . '">' . $location . '</source>';
			}

			// Use the event link
			else {
				echo '<source url="' . get_permalink($post->ID) . '">' . $location . '</source>';
			}

		}
	}

	do_action('r34ecre_rss_modify_item_after');

}
add_action('rss2_item','r34ecre_rss_modify_item');


// Modify feed query
function r34ecre_rss_pre_get_posts($query) {

	if ($query->is_feed() && $query->tribe_is_event_query) {

		$max_events = get_option('r34ecre_max_events') ? intval(get_option('r34ecre_max_events')) : 100;
		$days = get_option('r34ecre_days') ? intval(get_option('r34ecre_days')) : 7;
		$end_date = date('Y-m-d H:i', mktime(23, 59, 59, date('n'), date('j') + $days, date('Y')));

		// Change number of posts retrieved on events feed
		$query->set('posts_per_rss', $max_events);

		// Add restriction to only show events within defined number of days
		$query->set('end_date', $end_date);
		
		// Modify 'tec_event_end_date' meta query (introduced in TEC 6.0.2)
		if (isset($query->query['meta_query']['tec_event_end_date'])) {
			$meta_query = array(
				'relation' => 'AND',
				$query->query['meta_query']['tec_event_end_date'],
				array(
					'key' => '_EventEndDate',
					'value' => $end_date,
					'compare' => '<=',
					'type' => 'DATETIME',
				)
			);
			$query->query_vars['meta_query']['tec_event_end_date'] = $meta_query;
			$query->query['meta_query'] = $query->query_vars['meta_query'];
		}

	}
	return $query;
}
add_filter('tribe_events_parse_query', 'r34ecre_rss_pre_get_posts', 1001);
