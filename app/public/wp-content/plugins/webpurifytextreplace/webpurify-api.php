<?php
/**
 * Provides a set of helper functions to communicate with the WebService API.
 *
 * The full documentation for the WebPurify API can be found here:
 * https://www.webpurify.com/documentation/
 *
 * @package WebPurify
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Retrieves the JSON response to the specified URL.
 *
 * @access private
 *
 * @param  string $url      The URL to which we're making the request.
 *
 * @return string $response The JSON response from the specified URL.
 */
function _webpurify_get_url( $url ) {

 	// @codingStandardsIgnoreStart
	// Initialize the curl library.
	$ch = curl_init();

	// Set the options necessary to make the request.
  curl_setopt( $ch, CURLOPT_URL, $url );
  curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

	// Execute the request and close the curl resource.
	$response = curl_exec( $ch );
	curl_close( $ch );
	// @codingStandardsIgnoreEnd

	return $response;

}

/**
 * Determines if the specified list is 'black' or 'white'.
 *
 * @return bool True if the $list is 'black' or 'white'; otherwise, false.
 */
function _webpurify_is_valid_list( $list ) {

	$list = strtolower( $list );
	return ( 'black' !== $list || 'white' !== $list );

}

/**
 * Adds the array of words to the specified list. The list may be either
 * 'black' or 'white'. Any other specified list type will be ignored.
 *
 * @access private
 *
 * @param string $list  The list to which we're making a request (black/white).
 * @param array  $words The array of ords to be added to the specified list.
 */
function _webpurify_add_to( $list, $words ) {

	if ( ! _webpurify_is_valid_list( $list ) ) {
		return;
	}

	// First, clear the list of words that exist in the whitelist.
	$response = _webpurify_clear_list( $list );

	// Next, add the updated list to the whitelist
	$method = "webpurify.live.addto$list";
	$args = array(
		'api_key' => get_option( 'webpurify_userkey' ),
		'method'  => $method,
		'format'  => 'xml',
		'word'    => '',
	);

	/**
	 * First, we need to replace all whitespace with a single space just in case.
	 * Then we need to place each word into an index of an array.
	 */
	$words = preg_replace( '/\s+/', ' ', $words );
	$words = explode( ' ', $words[0] );

	// Now iterate through each word and add it as a listed word to the API
	foreach ( $words as $word ) {

		// First, add the word to the set of arguments.
		$args['word'] = $word;

		// Create the URL for the API request.
		$url = add_query_arg( $args, WEBPURIFY_URL );

		// Now make a call to the web service with this particular word.
		$response = simplexml_load_file( $url, 'SimpleXMLElement', LIBXML_NOCDATA );

	}

}

/**
 * Removes the specified word from the specified list. If the list is not
 * 'black' or 'white' then the method call is ignored.
 *
 * @access private
 *
 * @param string $list The list to which we're making a request (black/white).
 * @param array  $word The array of words to be added to the specified list.
 */
function _webpurify_remove_from( $list, $word ) {

	if ( ! _webpurify_is_valid_list( $list ) ) {
		return;
	}

	/**
	 * First, we need to replace all whitespace with a single space just in case.
	 * Then we need to place each word into an index of an array.
	 */
	$words = preg_replace( '/\s+/', ' ', $word );
	$words = explode( ' ', $word[0] );

	// Now we'll iterare through the array of words and remove them from the list.
	$method  = "webpurify.live.removefrom$list";
	foreach ( $words as $word ) {

		$args = array(
			'api_key' => get_option( 'webpurify_userkey' ),
			'method'  => $method,
			'word'    => $word,
			'format'  => 'xml',
		);

		// Create the URL for the API request.
		$url = add_query_arg( $args, WEBPURIFY_URL );
		simplexml_load_file( $url, 'SimpleXMLElement', LIBXML_NOCDATA );

	}

}

/**
 * Retrievees teh contents of the specified list. If the list is not 'black'
 * or 'white', then the call is ignored.
 *
 * @access private
 *
 * @param string $type To this from which we're retrieving data (black/white).
 *
 * @return stdClass $response An object represetation of the response.
 */
function _webpurify_get_list( $type ) {

	if ( ! _webpurify_is_valid_list( $type ) ) {
		return;
	}

	$args = array(
		'api_key' => get_option( 'webpurify_userkey' ),
		'method'  => "webpurify.live.get$type",
		'format'  => 'json',
	);

	// Create the URL for the API request.
	$url = add_query_arg( $args, WEBPURIFY_URL );
	$response = json_decode(
		_webpurify_get_url( $url )
	);

	return $response;

}

/**
 * Clears the entire contents of the specified list.
 *
 * @param  string $type The type of list to clear (black or white).
 */
function _webpurify_clear_list( $type ) {

	if ( ! _webpurify_is_valid_list( $type ) ) {
		return;
	}

	// Get all of the words on the specified list
	$words = webpurify_get_words_from_list( $type );

	// Now clear each of the words from the list
	foreach ( $words as $word ) {

		$args = array(
			'api_key' => get_option( 'webpurify_userkey' ),
			'method'  => "webpurify.live.removefrom$type",
			'format'  => 'json',
			'word'    => $word,
		);

		$url = add_query_arg( $args, WEBPURIFY_URL );
		$response = json_decode(
			_webpurify_get_url( $url )
		);

	}

}

/**
 * Retrieves the list of words from the speified list.
 *
 * @param  string $type Should be 'black' or 'white' depending on which list to read.
 * @return string       The string of words that are in the requested list.
 */
function webpurify_get_words_from_list( $type ) {

	$args = array(
		'api_key' => get_option( 'webpurify_userkey' ),
		'method'  => "webpurify.live.get$type",
		'format'  => 'json',
	);

	// Create the URL for the API request.
	$url = add_query_arg( $args, WEBPURIFY_URL );
	$response = json_decode(
		_webpurify_get_url( $url )
	);

	return $response->rsp->word;

}

/**
 * Adds the specified array of words to the blacklist.
 *
 * @param array $words The array of words to purify when saving data.
 */
function webpurify_add_to_blacklist( $words ) {
	_webpurify_add_to( 'blacklist', $words );
}

/**
 * Adds the specified array of words to the whitelist.
 *
 * @param array $words The array of words to avoid purification.
 */
function webpurify_add_to_whitelist( $words ) {
	_webpurify_add_to( 'whitelist', $words );
}

function webpurify_update_list( $type ) {

	_webpurify_clear_list( $type );
	_webpurify_get_list( $type );

}

/**
 * Retrieves the list of words from the specified list and echoes a
 * textarea-safe value for the list.
 *
 * @return string $type The list from which to retrieve the results.
 */
function webpurify_get_list( $type ) {

	// Grab the blacklist and the list of words (in the form of an array)
	$response = _webpurify_get_list( $type );
	$words = $response->rsp->word;

	// Bail if no words (prevents debug notice)
	if ( empty( $words ) ) {
		return;
	}

	// Now create a string to display in a textarea
	$values = '';
	foreach ( $words as $word ) {
		$values .= $word . PHP_EOL;
	}
	$values = trim( $values );

	// Provide the response in a sanitized textarea format
	echo esc_textarea( $values );

}

/**
 * Retrieves the whitelist of words.
 *
 * @return array The words that should not be purified.
 */
function webpurify_get_whitelist() {

	// Grab the blacklist and the list of words (in the form of an array)
	$response = _webpurify_get_list( 'whitelist' );
	$words = $response->rsp->word;

	// Bail if no words (prevents debug notice)
	if ( empty( $words ) ) {
		return;
	}

	// Now create a string to display in a textarea
	$values = '';
	foreach ( $words as $word ) {
		$values .= $word . PHP_EOL;
	}
	$values = trim( $values );

	// Provide the response in a sanitized textarea format
	echo esc_textarea( $values );

}
