<?php

/**
 * A helper widget for the main SiteOrigin_Panels_Widgets_PostLoop class
 *
 * Class SiteOrigin_Panels_Widgets_PostLoop_Helper
 */
class SiteOrigin_Panels_Widgets_PostLoop_Helper extends SiteOrigin_Widget {
	/**
	 * SiteOrigin_Panels_Widgets_PostLoop_Helper constructor.
	 *
	 * @param array $templates
	 */
	public function __construct( $templates ) {
		$template_options = array();

		if ( ! empty( $templates ) ) {
			foreach ( $templates as $template ) {
				// Is this template being added by a plugin?
				$filename = SiteOrigin_Panels_Widgets_PostLoop::locate_template( $template );
				$headers = get_file_data( $filename, array(
					'loop_name' => 'Loop Name',
				) );
				$template_options[ $template ] = esc_html( ! empty( $headers['loop_name'] ) ? $headers['loop_name'] : $template );
			}
		}

		parent::__construct(
			'siteorigin-panels-postloop-helper',
			__( 'Post Loop', 'siteorigin-panels' ),
			array(
				'description' => __( 'Displays a post loop.', 'siteorigin-panels' ),
				'help' => 'https://siteorigin.com/page-builder/bundled-widgets/post-loop-widget/',
				'has_preview' => false,
			),
			array(),
			array(
				'title' => array(
					'type' => 'text',
					'label' => __( 'Title', 'siteorigin-panels' ),
				),
				'template' => array(
					'type' => 'select',
					'label' => __( 'Template', 'siteorigin-panels' ),
					'options' => $template_options,
					'default' => 'loop.php',
				),
				'more' => array(
					'type' => 'checkbox',
					'label' => __( 'More link', 'siteorigin-panels' ),
					'description' => __( 'If the template supports it, cut posts and display the more link.', 'siteorigin-panels' ),
					'default' => false,
				),
				'posts' => array(
					'type' => 'posts',
					'label' => __( 'Posts query', 'siteorigin-panels' ),
					'hide' => true,
				),
			)
		);
	}

	/**
	 * Convert this instance into one that's compatible with the posts field
	 *
	 * @return mixed
	 */
	public function modify_instance( $instance ) {
		if ( ! empty( $instance['post_type'] ) ) {
			$value = array();

			if ( ! empty( $instance['post_type'] ) ) {
				$value['post_type'] = $instance['post_type'];
			}

			if ( ! empty( $instance['posts_per_page'] ) ) {
				$value['posts_per_page'] = $instance['posts_per_page'];
			}

			if ( ! empty( $instance['order'] ) ) {
				$value['order'] = $instance['order'];
			}

			if ( ! empty( $instance['orderby'] ) ) {
				$value['orderby'] = $instance['orderby'];
			}

			if ( ! empty( $instance['sticky'] ) ) {
				$value['sticky'] = $instance['sticky'];
			}

			if ( ! empty( $instance['additional'] ) ) {
				$value['additional'] = $instance['additional'];
			}
			$instance[ 'posts' ] = $value;

			unset( $instance[ 'post_type' ] );
			unset( $instance[ 'posts_per_page' ] );
			unset( $instance[ 'order' ] );
			unset( $instance[ 'orderby' ] );
			unset( $instance[ 'sticky' ] );
			unset( $instance[ 'additional' ] );
		}

		return $instance;
	}

	/**
	 * @param array $args
	 * @param array $instance
	 *
	 * @return bool
	 */
	public function widget( $args, $instance ) {
		return false;
	}
}
