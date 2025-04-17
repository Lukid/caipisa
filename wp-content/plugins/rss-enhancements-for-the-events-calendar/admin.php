<form method="post" action="">
	<div class="wrap">
		<h2>The Events Calendar RSS Options</h2>

		<?php wp_nonce_field('r34ecre-update','r34ecre-nonce'); ?>
		
		<table class="form-table"><tbody>
			<tr>
				<th>Days Out</th>
				<td>
					<input type="number" name="r34ecre_days" id="r34ecre_days" value="<?php echo get_option('r34ecre_days') ? get_option('r34ecre_days') : 7; ?>" min="1" max="366" step="1" />
					<p><small>Number of days' worth of upcoming events to include in feed. Default is <strong>7</strong>.</small></p>
				</td>
			</tr>
			<tr>
				<th>Max Events</th>
				<td>
					<input type="number" name="r34ecre_max_events" id="r34ecre_max_events" value="<?php echo get_option('r34ecre_max_events') ? get_option('r34ecre_max_events') : 100; ?>" min="1" max="999" step="1" />
					<p><small>Maximum number of events to include in feed. Should be more than the maximum number of events you are likely to have in the span of <strong>Days Out</strong> above. Default is <strong>100</strong>.</small></p>
				</td>
			</tr>
			<tr>
				<th>Featured Images</th>
				<td>
					<input type="checkbox" name="r34ecre_images_all" id="r34ecre_images_all" value="1"<?php if (get_option('r34ecre_images_all')) { echo ' checked="checked"'; } ?> /><label for="r34ecre_images_all">Add featured images to RSS feeds for ALL post types</label>
					<p><small>By default, this plugin only adds featured images to the Events RSS feed. By checking this box, featured images will be added to the feeds for all post types on your site. (Your theme must support <a href="https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/" target="_blank">featured images</a>.)</small></p>
				</td>
			</tr>
			<tr>
				<th>Image Size</th>
				<td>
					<select name="r34ecre_image_size">
						<?php
						$current_image_size = get_option('r34ecre_image_size') ? get_option('r34ecre_image_size') : 'thumbnail';
						$image_sizes = get_intermediate_image_sizes();
						foreach ((array)$image_sizes as $image_size) {
							echo '<option value="' . esc_attr($image_size) . '"';
							if ($image_size == $current_image_size) { echo ' selected="selected"'; }
							echo '>' . $image_size . '</option>';
						}
						?>
					</select>
					<p><small>Image size to be included in feeds. Default is <strong>thumbnail</strong>.</small></p>
				</td>
			</tr>
			<tr>
				<th>Venue Links</th>
				<td>
					<input type="checkbox" name="r34ecre_venue_link" id="r34ecre_venue_link" value="1"<?php if (get_option('r34ecre_venue_link')) { echo ' checked="checked"'; } ?> /><label for="r34ecre_venue_link">Use venue archive link with venue (location) names</label>
					<p><small>This plugin adds event venue details to the RSS feed using the <code>&lt;source&gt;</code> tag. By default it inserts the event link in the <code>url</code> attribute. Checking this box will insert the venue's archive page link instead. Only check this box if you are using venue archive pages.</small></p>
				</td>
			</tr>
		</tbody></table>

		<input type="submit" value="Save Changes" class="button button-primary" />
	</div>
</form>

<form method="post" action="">
	<div class="wrap">
		<?php wp_nonce_field('r34ecre-defaults','r34ecre-nonce'); ?>
		<input type="submit" value="Restore Defaults" class="button" />

		<p><small>This page is part of <a href="plugins.php?s=RSS%20Enhancements%20for%20The%20Events%20Calendar">RSS Enhancements for The Events Calendar</a> plugin.</small></p>
	</div>
</form>

