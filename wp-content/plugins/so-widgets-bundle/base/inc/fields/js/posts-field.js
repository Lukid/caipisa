/* global jQuery, soWidgets, sowbForms */

( function( $ ) {

	$( document ).on( 'sowsetupform', '.siteorigin-widget-field-type-posts', function( e ) {
		const $postsField = $( this );
		const hasCount = $postsField.find( '.sow-current-count' ).length > 0;
		const postId = parseInt( jQuery( '#post_ID' ).val() );

		if ( ! hasCount ) {
			return;
		}

		$postsField.on( 'change', function( event ) {
			var postsValues = sowbForms.getWidgetFormValues( $postsField );
			var queryObj = postsValues.hasOwnProperty( 'posts' ) ? postsValues.posts : null;

			var query = '';
			for ( var key in queryObj ) {
				if ( query !== '' ) {
					query += '&';
				}
				query += key + '=' + queryObj[ key ];
			}

			$.post(
				soWidgets.ajaxurl,
				{
					action: 'sow_get_posts_count',
					query: query,
					postId: postId,
				},
				function( data ) {
					$postsField.find( '.sow-current-count' ).text( data.posts_count );

				}
			);
		} );
	} );

} )( jQuery );
