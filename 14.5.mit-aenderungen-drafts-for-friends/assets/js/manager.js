jQuery( document ).ready( function () {

	jQuery( '.wp-list-table' ).on( 'click', '.dff-delete', function ( e ) {
		var self = jQuery( this );
		e.preventDefault();

		var key = self.data( 'key' );

		jQuery.ajax( {
			'url':        dff.rest_url + 'drafts-for-friends/posts',
			'type':       'DELETE',
			'dataType':   'json',
			'beforeSend': function ( xhr ) {
				xhr.setRequestHeader( 'X-WP-Nonce', dff.nonce );
				self.addClass( 'updating-message' );
			},
			'data':       {
				'key': key
			}
		} )
			.done( function ( response ) {
				if ( response.hasOwnProperty( 'deleted' ) && response.deleted ) {
					self.closest( 'tr' ).remove();
				}
			} )
			.fail( function ( xhr, text_status, error ) {
				var response = xhr.responseJSON;
				if ( response.hasOwnProperty( 'message' ) ) {
					alert( response.message );
				} else {
					alert( 'An error occurred' );
				}
			} )
			.always( function () {
				self.removeClass( 'updating-message' );
			} );
	} );
} );
