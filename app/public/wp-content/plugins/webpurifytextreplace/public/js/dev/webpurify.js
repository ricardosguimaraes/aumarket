;(function( $ ) {
	'use strict';
	/* global webpurify, alert */

	/**
	 * Determines if we should be using the Auto Mode as set in the settings
	 * or not.
	 */
	var check_purification_mode = function() {

		$.get( webpurify.ajaxurl, {
			action: 'webpurify_use_auto_mode'
		}, function( response ) {

			if ( 1 === response.length ) {
				halt_submission();
			}

		});

	};

	/**
	 * Scans comment content to determine if there is any profanity.
	 * If so, then the user will be prompted as such and not able to
	 * submit their form.
	 */
	var submit_request = function() {

		var data,
				messages = '';

		// Define the data to be sent in the ajax request.
		data = {

			action:  'webpurify_detects_profanity',
			comment: $( "#comment" ).val(),
			author:  $( '#author' ).val(),

		};

		// Submit a request to the server for the WebPurify API to take a look
		// at the comment and the author name. If they don't check out, then
		// display a message.
		$.post( webpurify.ajaxurl, data, function( response ) {

			// Parse the response into a JSON object;
			response = $.parseJSON( response );

			// Check the comment.
			if ( '1' === response.comment.rsp.found ) {

				messages += "We've detected profanity in your comment.\n";
				messages += "Please remove the words and resubmit your comment.\n";

			}

			// Now check the author.
			if ( '1' === response.author.rsp.found ) {

				messages += "We've detected profanity in your author name.\n";
				messages += "Please remove the words and resubmit your comment.\n";

			}

			// Display errors, if they exist. Otherwise, submit the form.
			if ( '' !== $.trim( messages ) ) {

				alert( messages );
				messages = '';

			} else {
				resume_submission();
			}

		});

	};

	/**
	 * Overrides the default submit button click handler so that we can make a
	 * request to the WebPurify API service to check the contents of the form.
	 */
	var halt_submission = function() {

		$( '#submit' ).on( 'click', function( evt ) {

			evt.preventDefault();
			submit_request();

		});

	};

	/**
	 * After an Ajax request has been completed and there is no profanity,
	 * this message is called to unbind our custom click handler and trigger
	 * the default behavior (which is to submit the form).
	 */
	var resume_submission = function() {

		$( '#submit' )
			.unbind( 'click' )
			.trigger( 'click' );

	};

	$(function() {
		check_purification_mode();
	});

})( jQuery );
