<?php
/**
 * Pro Designs and Plugins Feed
 *
 * @package Post grid and filter ultimate
 * @since 1.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
} ?>

<div class="wrap pgafu-wrap">
<h2><?php esc_html_e( 'How It Works - Display and shortcode', 'post-grid-and-filter-ultimate' ); ?></h2>
	<style type="text/css">
		.wpos-box{box-shadow: 0 5px 30px 0 rgba(214,215,216,.57);background: #fff; padding-bottom:10px; position:relative;}
		.wpos-box ul{padding: 15px;}
		.wpos-box h5{background:#555; color:#fff; padding:15px; text-align:center;}
		.wpos-box h4{ padding:0 15px; margin:5px 0; font-size:18px;}
		.wpos-box .button{margin:0px 15px 15px 15px; text-align:center; padding:7px 15px; font-size:15px;display:inline-block;}
		.wpos-box .wpos-list{list-style:square; margin:10px 0 0 20px;}
		.wpos-clearfix:before, .wpos-clearfix:after{content: "";display: table;}
		.wpos-clearfix::after{clear: both;}
		.wpos-clearfix{clear: both;}
		.wpos-col{width: 47%; float: left; margin-right:10px; margin-bottom:10px;}
		.wpos-pro-box .hndle{background-color:#0073AA; color:#fff;}
		.wpos-pro-box.postbox{background:#dbf0fa none repeat scroll 0 0; border:1px solid #0073aa; color:#191e23;}
		.postbox-container .wpos-list li:before{font-family: dashicons; content: "\f139"; font-size:20px; color: #0073aa; vertical-align: middle;}
		.pgafu-wrap .wpos-button-full{display:block; text-align:center; box-shadow:none; border-radius:0;}
		.pgafu-shortcode-preview{background-color: #e7e7e7; font-weight: bold; padding: 2px 5px; display: inline-block; margin:0 0 2px 0;}
		.upgrade-to-pro{font-size:18px; text-align:center; margin-bottom:15px;}
		.wpos-copy-clipboard{-webkit-touch-callout: all; -webkit-user-select: all; -khtml-user-select: all; -moz-user-select: all; -ms-user-select: all; user-select: all;}
		.wpos-new-feature{ font-size: 10px; color: #fff; font-weight: bold; background-color: #03aa29; padding:1px 4px; font-style: normal; }
		.button-orange{background: #ff5d52 !important;border-color: #ff5d52 !important; font-weight: 600;}
		.button-blue{background: #0055fb !important;border-color: #0055fb !important; font-weight: 600;}
	</style>

	<div class="post-box-container">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-2">

				<!--How it workd HTML -->
				<div id="post-body-content">
					<div class="meta-box-sortables">
						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle">
									<span><?php esc_html_e( 'How It Works - Display and shortcode', 'post-grid-and-filter-ultimate' ); ?></span>
								</h2>
							</div>

							<div class="inside">
								<table class="form-table">
									<tbody>
										<tr>
											<th>
												<label><?php esc_html_e('Geeting Started with Post Slider', 'post-grid-and-filter-ultimate'); ?>:</label>
											</th>
											<td>
												<ul>
													<li><?php esc_html_e('Step-1. This plugin create a tab under "Post grid and filter ultimate – How It Works".', 'post-grid-and-filter-ultimate'); ?></li>
													<li><?php esc_html_e('Step-2. This plugin display WordPres default standard POST with a simple shortcode.', 'post-grid-and-filter-ultimate'); ?></li>
												</ul>
											</td>
										</tr>

										<tr>
											<th>
												<label><?php esc_html_e('How Shortcode Works', 'post-grid-and-filter-ultimate'); ?>:</label>
											</th>
											<td>
												<ul>
													<li><?php esc_html_e('Step-1. Create a page like Latest Post OR add the shortcode in a page.', 'post-grid-and-filter-ultimate'); ?></li>
													<li><?php esc_html_e('Step-2. Put below shortcode as per your need.', 'post-grid-and-filter-ultimate'); ?></li>
												</ul>
											</td>
										</tr>

										<tr>
											<th>
												<label><?php esc_html_e('All Shortcodes', 'post-grid-and-filter-ultimate'); ?>:</label>
											</th>
											<td>
												<span class="wpos-copy-clipboard pgafu-shortcode-preview">[pgaf_post_grid]</span> – <?php esc_html_e('Post Grid Shortcode.', 'post-grid-and-filter-ultimate'); ?><br>
												<span class="wpos-copy-clipboard pgafu-shortcode-preview">[pgaf_post_filter]</span> – <?php esc_html_e('Post Filter Shortcode, which provide you to use 4 designs.', 'post-grid-and-filter-ultimate'); ?>
											</td>
										</tr>

										<tr>
											<th>
												<label><?php esc_html_e('Documentation', 'post-grid-and-filter-ultimate'); ?>:</label>
											</th>
											<td>
												<a class="button button-primary" href="https://docs.essentialplugin.com/post-grid-and-filter-ultimate/" target="_blank"><?php esc_html_e('Check Documentation', 'post-grid-and-filter-ultimate'); ?></a>
											</td>
										</tr>
									</tbody>
								</table>
							</div><!-- .inside -->
						</div><!-- #general -->

						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle">
									<span><?php esc_html_e( 'Gutenberg Support', 'post-grid-and-filter-ultimate' ); ?></span>
								</h2>
							</div>

							<div class="inside">
								<table class="form-table">
									<tbody>
										<tr>
											<th>
												<label><?php esc_html_e('How it Work', 'post-grid-and-filter-ultimate'); ?>:</label>
											</th>
											<td>
												<ul>
													<li><?php esc_html_e('Step-1. Go to the Gutenberg editor of your page.', 'post-grid-and-filter-ultimate'); ?></li>
													<li><?php esc_html_e('Step-2. Search "Post Grid/Post Filter" keyword in the gutenberg block list.', 'post-grid-and-filter-ultimate'); ?></li>
													<li><?php esc_html_e('Step-3. Add any block of Post Grid/Post Filter and you will find its relative options on the right end side.', 'post-grid-and-filter-ultimate'); ?></li>
												</ul>
											</td>
										</tr>
									</tbody>
								</table>
							</div><!-- .inside -->
						</div><!-- .postbox -->

						<div class="postbox">
							<div class="postbox-header">
								<h2 class="hndle">
									<span><?php esc_html_e( 'Help to improve this plugin!', 'post-grid-and-filter-ultimate' ); ?></span>
								</h2>
							</div>
							<div class="inside">
								<p><?php esc_html_e('Enjoyed this plugin? You can help by rate this plugin ', 'post-grid-and-filter-ultimate'); ?><a href="https://wordpress.org/support/plugin/post-grid-and-filter-ultimate/reviews/?filter=5#new-post" target="_blank"><?php esc_html_e('5 stars!', 'post-grid-and-filter-ultimate'); ?></a></p>
							</div><!-- .inside -->
						</div><!-- #general -->
					</div><!-- .meta-box-sortables -->
				</div><!-- #post-body-content -->

				<!--Upgrad to Pro HTML -->
				<div id="postbox-container-1" class="postbox-container">
					<div class="meta-box-sortables">
						<div class="postbox wpos-pro-box">
							<h3 class="hndle">
								<span><?php esc_html_e( 'Upgrate to Pro', 'post-grid-and-filter-ultimate' ); ?></span>
							</h3>
							<div class="inside">
								<ul class="wpos-list">
									<li><?php esc_html_e( '10 Designs for Post Grid, 10 Designs for Post Grid Filter.', 'post-grid-and-filter-ultimate' ); ?></li>
									<li><?php esc_html_e( '2 - (Post Grid Shortcode, Post Filter Shortcode)', 'post-grid-and-filter-ultimate' ); ?></li>
									<li><?php esc_html_e( '35+ Shortcode Parameters', 'post-grid-and-filter-ultimate' ); ?></li>
									<li><?php esc_html_e( 'WP Templating Features', 'post-grid-and-filter-ultimate' ); ?></li>
									<li><?php esc_html_e( 'Shortcode Generator', 'post-grid-and-filter-ultimate' ); ?></li>
									<li><?php esc_html_e( 'Drag & Drop Post Order Change.', 'post-grid-and-filter-ultimate' ); ?></li>
									<li><?php esc_html_e( 'Gutenberg Block Supports', 'post-grid-and-filter-ultimate' ); ?></li>
									<li><?php esc_html_e( 'WPBakery Page Builder Supports', 'post-grid-and-filter-ultimate' ); ?></li>
									<li><?php esc_html_e( 'Elementor, Beaver and SiteOrigin Page Builder Supports', 'post-grid-and-filter-ultimate' ); ?> <span class="wpos-new-feature">New</span></li>
									<li><?php esc_html_e( 'Divi Page Builder Native Supports', 'post-grid-and-filter-ultimate' ); ?> <span class="wpos-new-feature">New</span></li>
									<li><?php esc_html_e( 'Fusion Page Builder Native Supports', 'post-grid-and-filter-ultimate' ); ?> <span class="wpos-new-feature">New</span></li>
									<li><?php esc_html_e( 'Custom Read More link for Post.', 'post-grid-and-filter-ultimate' ); ?></li>
									<li><?php esc_html_e( 'Display Desired Post.', 'post-grid-and-filter-ultimate' ); ?></li>
									<li><?php esc_html_e( 'Exclude Some Posts.', 'post-grid-and-filter-ultimate' ); ?></li>
									<li><?php esc_html_e( 'Exclude Some Categories.', 'post-grid-and-filter-ultimate' ); ?></li>
									<li><?php esc_html_e( 'Post Order / Order By Parameters', 'post-grid-and-filter-ultimate' ); ?></li>
									<li><?php esc_html_e( 'Fully responsive', 'post-grid-and-filter-ultimate' ); ?></li>
									<li><?php esc_html_e( '100% Multi language', 'post-grid-and-filter-ultimate' ); ?></li>
								</ul>
								<div class="upgrade-to-pro"><?php sprintf( 'Gain access to <strong>Post grid and filter ultimate</strong> included in <br /><strong>Essential Plugin Bundle', 'post-grid-and-filter-ultimate' ); ?></div>
								<a class="button button-primary wpos-button-full button-orange" href="<?php echo esc_url(PGAFU_PLUGIN_LINK_UNLOCK); ?>" target="_blank"><?php esc_html_e( 'Grab Now', 'post-grid-and-filter-ultimate' ); ?></a>
							</div><!-- .inside -->
						</div><!-- #general -->
					</div><!-- .meta-box-sortables -->
				</div><!-- #post-container-1 -->
			</div><!-- #post-body -->
		</div><!-- #poststuff -->
	</div>
</div>