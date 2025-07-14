;(function( $ ) {
	'use strict';

	/**
	 * When the user clicks on the 'Save Changes' button in the options page,
	 * this will change disable the button to prevent double-clicks and display
	 * a message to let them know the options are being updated.
	 */
	var init_save_button = function() {

		// The text to update the button when it's been clicked.
		var wait_text = 'Saving. Please wait...';

		$( '#submit' ).on( 'click', function( evt ) {

			// If the user has clicked wait, don't let them keep clicking the button.
			if ( wait_text === $( this ).val() ) {
				evt.preventDefault();
			}

			// Update the button's texxt.
			$( this ).val( 'Saving. Please wait...' );

		});

	};

	$(function() {
		init_save_button();
	});

})( jQuery );
