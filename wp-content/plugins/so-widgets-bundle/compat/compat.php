<?php

class SiteOrigin_Widgets_Bundle_Compatibility {
	/**
	 * Get the singleton instance
	 *
	 * @return SiteOrigin_Widgets_Bundle_Compatibility
	 */
	public static function single() {
		static $single;

		return empty( $single ) ? $single = new self() : $single;
	}

	public function __construct() {
		add_action( 'init' , array( $this, 'init' ) );
	}

	public function init() {
		$builder = $this->get_active_builder();

		if ( ! empty( $builder ) ) {
			require_once $builder['file_path'];
		}

		if ( function_exists( 'register_block_type' ) ) {
			require_once plugin_dir_path( __FILE__ ) . 'block-editor/widget-block.php';
		}

		// These actions handle alerting cache plugins that they need to regenerate a page cache.
		if ( apply_filters( 'siteorigin_widgets_load_cache_compatibility', true ) ) {
			add_action( 'siteorigin_widgets_stylesheet_deleted', array( $this, 'clear_page_cache' ) );
			add_action( 'siteorigin_widgets_stylesheet_added', array( $this, 'clear_page_cache' ) );
			add_action( 'siteorigin_widgets_stylesheet_cleared', array( $this, 'clear_all_cache' ) );
		}

		// Compatibility with AMP plugin.
		if (
			function_exists( 'amp_is_enabled' ) &&
			amp_is_enabled()
		) {
			// AMP plugin is installed and enabled. Remove Slider Lazy Loading.
			add_filter( 'siteorigin_widgets_slider_attr', function ( $attr ) {
				if ( ! empty( $attr['class'] ) ) {
					$attr['class'] = str_replace( ' skip-lazy', '', $attr['class'] );
				}
				$attr['loading'] = false;

				return $attr;
			} );
		}

		// Compatibility with WooCommerce.
		if ( function_exists( 'WC' ) ) {
			add_filter( 'woocommerce_format_content', array( $this, 'woocommerce_shop_page_content' ), 10, 2 );
		}
	}

	public function get_active_builder() {
		$builders = include_once 'builders.php';

		foreach ( $builders as $builder ) {
			if ( $this->is_builder_active( $builder ) ) {
				return $builder;
			}
		}

		return null;
	}

	public function is_builder_active( $builder ) {
		switch ( $builder[ 'name' ] ) {
			case 'Beaver Builder':
				return class_exists( 'FLBuilderModel', false );
				break;

			case 'Elementor':
				return class_exists( 'Elementor\\Plugin', false );
				break;

			case 'Visual Composer':
				return class_exists( 'Vc_Manager' );
				break;
		}
	}

	/**
	 * Tell cache plugins that they need to regenerate a page cache.
	 *
	 * @param $name The name of the file that's been deleted.
	 * @param $instance The current instance of the related widget.
	 */
	public function clear_page_cache( $name, $instance = array() ) {
		$id = explode( '-', $name );
		$id = end( $id );
		$id = explode( '.', $id )[0];

		if ( is_numeric( $id ) ) {
			if ( function_exists( 'w3tc_flush_post' ) ) {
				w3tc_flush_post( $id );
			}

			if ( class_exists( 'Swift_Performance_Cache' ) ) {
				Swift_Performance_Cache::clear_post_cache( $id );
			}

			if ( class_exists( '\Hummingbird\\WP_Hummingbird' ) ) {
				do_action( 'wphb_clear_page_cache', $id );
			}

			if ( function_exists( 'breeze_varnish_purge_cache' ) ) {
				breeze_varnish_purge_cache( get_the_permalink( $id ) );
			}

			if ( function_exists( 'run_litespeed_cache' ) ) {
				$url = parse_url( get_the_permalink( $id ) );

				if ( ! empty( $url ) ) {
					header( 'x-litespeed-purge: ' . $url['path'] );
				}
			}

			if ( function_exists( 'rocket_clean_post' ) ) {
				rocket_clean_post( $id );
			}

			if ( class_exists( 'WP_Optimize' ) ) {
				WPO_Page_Cache::instance()->delete_single_post_cache( $id );
			}
		}
	}

	/**
	 * Tell cache plugins that they need to regenerate their all page cache.
	 */
	public function clear_all_cache() {
		if ( function_exists( 'w3tc_flush_all' ) ) {
			w3tc_flush_all();
		}

		if ( class_exists( 'Swift_Performance_Cache' ) ) {
			Swift_Performance_Cache::clear_all_cache();
		}

		if ( class_exists( '\Hummingbird\\WP_Hummingbird' ) ) {
			do_action( 'wphb_clear_page_cache' );
		}

		if ( class_exists( 'Breeze_PurgeCache' ) ) {
			Breeze_PurgeCache::breeze_cache_flush();
		}

		if ( function_exists( 'run_litespeed_cache' ) && ! headers_sent() ) {
			header( 'x-litespeed-purge: *' );
		}

		if ( function_exists( 'rocket_clean_domain' ) && function_exists( 'rocket_clean_minify' ) ) {
			rocket_clean_domain();
			rocket_clean_minify( 'css' );
		}

		if ( class_exists( 'WP_Optimize' ) ) {
			// WP Optimize does a filter check to see if it should purge the cache.
			// This filter will allow us to bypass that check.
			add_filter( 'wpo_purge_page_cache_on_activate_deactivate_plugin', '__return_true' );
			WPO_Page_Cache::instance()->purge();
		}
	}

	/**
	 * Filter the content of the WooCommerce shop page to ensure that our widgets are rendered correctly.
	 *
	 * @param $content
	 *
	 * @return string
	 */
	public function woocommerce_shop_page_content( $content ) {
		if ( is_search() ) {
			return $content;
		}

		if (
			! is_post_type_archive( 'product' ) ||
			! in_array( absint( get_query_var( 'paged' ) ), array( 0, 1 ), true )
		) {
			return $content;
		}

		$shop_page = get_post( wc_get_page_id( 'shop' ) );
		if ( empty( $shop_page ) ) {
			return $content;
		}

		$blocks = parse_blocks( $shop_page->post_content );

		// Check if any SiteOrigin Widgets Bundle blocks.
		$blocks = array_filter( $blocks, array( $this, 'find_sowb_block' ) );
		if ( ! empty( $blocks ) ) {
			$content = do_blocks( $shop_page->post_content );
		}

		return $content;
	}

	public function find_sowb_block( $block ) {
		if (
			! empty( $block['blockName'] ) &&
			strpos( $block['blockName'], 'sowb/' ) === 0
		) {
			return true;
		}

		foreach ( $block['innerBlocks'] as $inner ) {
			if ( $this->find_sowb_block( $inner ) ) {
				return true;
			}
		}

		return false;
	}
}

SiteOrigin_Widgets_Bundle_Compatibility::single();
