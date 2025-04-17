<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Post grid and filter ultimate
 * @since 1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


class PGAFU_Admin {

	function __construct() {
		// Action to register admin menu
		add_action( 'admin_menu', array( $this, 'pgafu_register_menu' ), 12 );

		// Admin Init Processes
		add_action( 'admin_init', array( $this, 'pgafu_admin_init_process' ) );

		// Filter to add row action in category table
		add_filter( PGAFU_CAT.'_row_actions', array( $this, 'pgafu_add_tax_row_data' ), 10, 2 );

		// Filter to add plugin links
		add_filter( 'plugin_row_meta', array( $this, 'pgafu_plugin_row_meta' ), 10, 2 );

		// Action to add little JS code in admin footer
		add_action( 'admin_footer', array( $this, 'pgafu_upgrade_page_link_blank' ));
	}

	/**
	 * Function to register admin menus
	 * 
	 * @package Post grid and filter ultimate
	 * @since 1.0.4
	 */
	function pgafu_register_menu() {

		// How It Work Page
		add_menu_page( __( 'Post Grid And Filter', 'post-grid-and-filter-ultimate' ), __( 'Post Grid And Filter', 'post-grid-and-filter-ultimate' ), 'manage_options', 'pgafu-about',  array( $this, 'pgafu_designs_page' ), 'dashicons-sticky', 6 );

		// Register plugin premium page
		//add_submenu_page( 'pgafu-about', __('Upgrade to PRO - Post grid and filter', 'post-grid-and-filter-ultimate'), '<span style="color:#ff2700">'.__('Upgrade to PRO', 'post-grid-and-filter-ultimate').'</span>', 'manage_options', 'pgafu-premium', array($this, 'pgafu_premium_page') );
		add_submenu_page( 'pgafu-about', __( 'Upgrade To PRO - Post Grid and Filter', 'post-grid-and-filter-ultimate' ), '<span class="wpos-upgrade-pro" style="color:#ff2700">' . __( 'Upgrade To Premium ', 'post-grid-and-filter-ultimate' ) . '</span>', 'manage_options', 'pgafu-upgrade-pro', array( $this, 'pgafu_redirect_page' ) );
		add_submenu_page( 'pgafu-about', __( 'Bundle Deal - Post Grid and Filter', 'post-grid-and-filter-ultimate' ), '<span class="wpos-upgrade-pro" style="color:#ff2700">' . __( 'Bundle Deal', 'post-grid-and-filter-ultimate' ) . '</span>', 'manage_options', 'pgafu-bundle-deal', array( $this, 'pgafu_redirect_page' ));
	}

	/**
	 * Getting Started Page Html
	 * 
	 * @package Post grid and filter ultimate
	 * @since 1.0
	 */
	function pgafu_designs_page() {
		include_once( PGAFU_DIR . '/includes/admin/pgafu-how-it-work.php' );
	}

	/**
	 * Premium Page Html
	 * 
	 * @package Post grid and filter ultimate
	 * @since 1.0
	 */
	// function pgafu_premium_page() {
	// 	include_once( PGAFU_DIR . '/includes/admin/settings/premium.php' );
	// }

	/**
	 * How It Work Page Html
	 * 
	 * @since 1.0
	 */
	function pgafu_redirect_page() {
	}

	/**
	 * Admin prior processes
	 * 
	 * @package Post grid and filter ultimate
	 * @since 1.1
	 */
	function pgafu_admin_init_process() {

		global $pagenow;

		$current_page = isset( $_REQUEST['page'] ) ? $_REQUEST['page'] : '';

		// If plugin notice is dismissed
		if( isset($_GET['message']) && $_GET['message'] == 'pgafu-plugin-notice' ) {
			set_transient( 'pgafu_install_notice', true, 604800 );
		}

		// Redirect to external page for upgrade to menu
		if( $pagenow == 'admin.php' ) {

			if( $current_page == 'pgafu-upgrade-pro' ) {

				wp_redirect( PGAFU_PLUGIN_LINK_UPGRADE );
				exit;
			}

			if( $current_page == 'pgafu-bundle-deal' ) {

				wp_redirect( PGAFU_PLUGIN_BUNDLE_LINK );
				exit;
			}
		}
	}

	/**
	 * Function to add category row action
	 * 
	 * @package Post grid and filter ultimate
	 * @since 1.1
	 */
	function pgafu_add_tax_row_data( $actions, $tag ) {
		return array_merge( array( 'wpos_id' => esc_html__('ID:', 'post-grid-and-filter-ultimate').' ' .esc_html( $tag->term_id ) ), $actions );
	}

	/**
	 * Function to unique number value
	 * 
	 * @package Post grid and filter ultimate
	 * @since 1.0.0
	 */
	function pgafu_plugin_row_meta( $links, $file ) {

		if ( $file == PGAFU_PLUGIN_BASENAME ) {

			$row_meta = array(
				'docs'    => '<a href="' . esc_url('https://docs.essentialplugin.com/post-grid-and-filter-ultimate/?utm_source=post_grid_filter&utm_medium=plugin_list&utm_campaign=plugin_quick_link') . '" title="' . esc_attr__( 'View Documentation', 'post-grid-and-filter-ultimate' ) . '" target="_blank">' . esc_html__( 'Docs', 'post-grid-and-filter-ultimate' ) . '</a>',
				'support' => '<a href="' . esc_url(PGAFU_SITE_LINK . '/pricing/?utm_source=post_grid_filter&utm_medium=plugin_list&utm_campaign=plugin_quick_link') . '" title="' . esc_attr__( 'go-premium', 'post-grid-and-filter-ultimate' ) . '" target="_blank">' . esc_html__( 'Go Premium', 'post-grid-and-filter-ultimate' ) . '</a>',
			);
			return array_merge( $links, $row_meta );
		}
		return (array) $links;
	}

	/**
	 * Add JS snippet to admin footer to add target _blank in upgrade link
	 * 
	 * @package Post grid and filter ultimate
	 * @since 1.0.0
	 */
	function pgafu_upgrade_page_link_blank() {

		global $wpos_upgrade_link_snippet;

		// Redirect to external page
		if( empty( $wpos_upgrade_link_snippet ) ) {

			$wpos_upgrade_link_snippet = 1;
	?>
		<script type="text/javascript">
			(function ($) {
				$('.wpos-upgrade-pro').parent().attr( { target: '_blank', rel: 'noopener noreferrer' } );
			})(jQuery);
		</script>
	<?php }
	}
}

$pgafu_admin = new PGAFU_Admin();