<?php
/**
 * Plugin Name: WebPurify Profanity Filter
 * Plugin URI:  http://www.webpurify.com/cms-integrations/wordpress/
 * Version:     4.0.2
 * Author:      WebPurify
 * Author URI:  http://www.webpurify.com
 * Text Domain: WebPurify
 * Domain Path: /languages
 * Description: Uses the powerful WebPurify Profanity Filter API to stop profanity in comments.
 *
 * @package WebPurify
 */

/*
  Copyright 2016  WebPurify  (email : support@webpurify.com)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	 die;
}

// WebPurify Service URL.
define( 'WEBPURIFY_URL', 'https://api1.webpurify.com/services/rest/?' );

// Include the WebPurify REST API wrapper functions.
include_once( 'webpurify-api.php' );

add_action( 'plugins_loaded', 'webpurify_load_textdomain' );
/**
 * Loads the text domain for the plugin so that the internationalized strings are
 * properly localized for the user's locale.
 */
function webpurify_load_textdomain() {

	$plugin_path  = plugin_basename( dirname( __FILE__ ) );
	$plugin_path .= '/languages';

	load_plugin_textdomain(
		'WebPurify',
		false,
		$plugin_path
	);

}

add_action( 'admin_menu', 'webpurify_options_page' );
/**
 * Options page callback.
 */
function webpurify_options_page() {

	add_options_page(
		__( 'WebPurify Options', 'WebPurify' ),
		__( 'WebPurify', 'WebPurify' ),
		'manage_options',
		'webpurify-options',
		'webpurify_display'
	);

}

/**
 * Renders the WebPurify Options Page.
 */
function webpurify_display() {
	include_once( 'WebPurifyTextReplace.php' );
}

add_action( 'admin_init', 'webpurify_save_options' );
/**
 * Maybe save options from admin page, and redirect on success
 *
 * @todo introduce nonce verification on the front-end form
 * @todo use register_meta()
 */
function webpurify_save_options() {

	// detect option update.
	$update = false;

	// update webpurify key if any.
	if ( isset( $_POST['webpurify_key'] ) ) { // Input var okay.

		$update = true;

		update_option( 'webpurify_userkey', sanitize_text_field(
			wp_unslash( $_POST['webpurify_key'] ) // Input var okay.
		) );

	}

	// update language if any.
	if ( isset( $_POST['webpurify_lang'] ) ) { // Input var okay.

		$update = true;

		update_option( 'webpurify_lang', sanitize_text_field(
			wp_unslash( $_POST['webpurify_lang'] ) // Input var okay.
		) );

	}

	// update replacement if any.
	if ( isset( $_POST['webpurify_r'] ) ) { // Input var okay.

		$update = true;

		if ( empty( $_POST['webpurify_r'] ) ) { // Input var okay.
			$_POST['webpurify_r'] = '*';
		}

		update_option( 'webpurify_r', sanitize_text_field(
			wp_unslash( $_POST['webpurify_r'] ) // Input var okay.
		) );
	}

	// update mode
	if ( isset( $_POST['webpurify_mode'] ) ) { // Input var okay.

		$update = true;

		update_option( 'webpurify_mode', sanitize_text_field(
			wp_unslash( $_POST['webpurify_mode'] ) // Input var okay.
		) );
	}

	// Push/pull whitelist
	if ( isset( $_POST['webpurify_whitelist'] ) ) {

		$update = true;

		// First, update the list by clearing the existing contents
		webpurify_update_list( 'whitelist' );

		// Now split the list on each new line character.
		$words = preg_split( '/\r\n|[\r\n]/',
			sanitize_text_field( wp_unslash( $_POST['webpurify_whitelist'] ) ) // Input var okay.
		);

		// Finally, send the array of current words to the WebPurify service.
		webpurify_add_to_whitelist( $words );
		update_option( 'webpurify_whitelist', $words );
	}

	// Push/pull blacklist
	if ( isset( $_POST['webpurify_blacklist'] ) ) {

		$update = true;

		// First, update the list by clearing the existing contents
		webpurify_update_list( 'blacklist' );

		// Now split the list on each new line character.
		$words = preg_split( '/\r\n|[\r\n]/',
			sanitize_text_field( wp_unslash( $_POST['webpurify_blacklist'] ) ) // Input var okay.
		);

		// Finally, send the array of current words to the WebPurify service.
		webpurify_add_to_blacklist( $words );
		update_option( 'webpurify_blacklist', $words );
	}

	// Bail if no update
	if ( false === $update ) {
		return;
	}

	// Safely redirect
	wp_safe_redirect( add_query_arg( array(
		'page'    => 'webpurify-options',
		'updated' => 'true'
	), admin_url( 'options-general.php' ) ) );
	die;
}

add_filter( 'preprocess_comment', 'webpurify_preprocess_comment' );
/**
 * Purifies the content of the comment author and the actual content of the
 * comment by querying the WebPurify service and returning the updated content
 * to WordPress for serialization.
 *
 * @param array $comment_data The array of comment data that will be saved.
 *
 * @return array $comment_data The purified comment data.
 */
function webpurify_preprocess_comment( $comment_data ) {

	$comment_data['comment_author']  = webpurify_query( $comment_data['comment_author'] );
	$comment_data['comment_content'] = webpurify_query( $comment_data['comment_content'] );

	return $comment_data;
}

add_filter( 'wp_insert_post_data', 'webpurify_insert_post_data', 99 );
/**
 * When the user saves a post, the title, content, and slug (which is called
 * the 'post_name') are all purified. This data is then returned to WordPress
 * to be saved to the database.
 *
 * @param  array $data The set of data to be saved as part of the post.
 *
 * @return array $data The purified set of data to be added to the post.
 */
function webpurify_insert_post_data( $data = array() ) {

	// Make sure this isn't an auto-draft.
	if ( empty( $data['post_status'] ) || ( 'auto-draft' === $data['post_status'] ) ) {
		return $data;
	}

	// Make sure this isn't a revision.
	if ( empty( $data['post_type'] ) || ( 'revision' === $data['post_type'] ) ) {
		return $data;
	}

	// Purify the title, content, and post name (which is for the permalink).
	$_data                 = $data;
	$_data['post_title']   = webpurify_query( $data['post_title'] );
	$_data['post_content'] = webpurify_query( $data['post_content'] );
	$_data['post_name']    = webpurify_query( $data['post_name'] );

	/**
	 * Purify the post name then remove all instaces of the mask.
	 *
	 * If all instances of the characters are removed, then the post_name will
	 * default to the ID of the post (via WordPress).
	 */
	$_data['post_name'] = str_ireplace( get_option( 'webpurify_r', '*' ), '', $_data['post_name'] );

	return $_data;
}

/**
 * Query the web purify service
 *
 * @param  string $content content to be filtered.
 * @return string filtered content
 */
function webpurify_query( $content = '' ) {

	$params = array(
		'api_key'       => get_option( 'webpurify_userkey' ),
		'lang'          => get_option( 'webpurify_lang', 'en' ),
		'replacesymbol' => get_option( 'webpurify_r', '*' ),

		'method'        => 'webpurify.live.replace',
		'text'          => $content,
		'cdata'         => 1,
		'plugin'        => 'wp',
	);

	$encoded_params = array();
	foreach ( $params as $k => $v ) {
		$encoded_params[] = urlencode( $k ) . '=' . urlencode( $v );
	}

	$url = WEBPURIFY_URL . implode( '&', $encoded_params );
	$response = simplexml_load_file( $url, 'SimpleXMLElement', LIBXML_NOCDATA );

	// Error handling for response text
	if ( isset( $response->text ) ) {

		// Came back as string, so use it
		if ( is_string( $response->text ) ) {
			$retval = $response->text;

		// Came back as object/array, so use the first variable
		} elseif ( is_array( $response->text ) || is_object( $response->text ) ) {
			$retval = reset( $response->text );
		}

	// Fallback on default content if no response text exists
	} else {
		$retval = $content;
	}

	return $retval;
}

add_action( 'bp_init', 'webpurify_buddypress_init' );
/**
 * Init buddypress - hook to buddypress filters.
 */
function webpurify_buddypress_init() {
	$filter_keys = array(

		// Activity
		'bp_activity_content_before_save',
		'bp_activity_action_before_save',
		'bp_activity_latest_update_content',
		'bp_activity_post_update_content',
		'bp_activity_post_comment_content',

		// Groups
		'groups_group_name_before_save',
		'groups_group_description_before_save',
		'groups_activity_new_update_content',

		// Legacy Group Forums (bbPress 1.x)
		'groups_activity_new_forum_post_content',
		'groups_activity_new_forum_topic_content',
		'group_forum_topic_title_before_save',
		'group_forum_topic_text_before_save',
		'group_forum_post_text_before_save',

		// Messages
		'messages_message_content_before_save',
		'messages_message_subject_before_save',
		'messages_notice_message_before_save',
		'messages_notice_subject_before_save',

		// XProfile
		'xprofile_group_name_before_save',
		'xprofile_group_description_before_save',
		'xprofile_field_name_before_save',
		'xprofile_field_description_before_save',
		'xprofile_filtered_data_value_before_save',
	);

	// Won't be this easy, but we'll let it ride for now
	foreach ( $filter_keys as $tag ) {
		add_filter( $tag, 'webpurify_query', 10 );
	}
}

add_action( 'admin_enqueue_scripts', 'webpurify_admin_enqueue_scripts' );
/**
 * Adds the JavaScript files to their respective pages.
 */
function webpurify_admin_enqueue_scripts() {

	// Determine if we're on one of the two available screens.
	$is_valid_screen =
		( 'settings_page_webpurify-options' === get_current_screen()->id ) ||
		( 'post' === get_current_screen()->id );

	if ( $is_valid_screen ) {

		wp_enqueue_script(
			'webpurify-admin',
			plugins_url( 'admin/js/webpurify.min.js', __FILE__ ),
			array( 'jquery' ),
			false,
			false
		);

	}

}

add_action( 'wp_enqueue_scripts', 'webpurify_wp_enqueue_scripts', 99 );
/**
 * Adds the JavaScript files to the public view of the site.
 */
function webpurify_wp_enqueue_scripts() {

	// We only care about these scripts on a single post page.
	if ( ! is_single() ) {
		return;
	}

	wp_enqueue_script(
		'webpurify-public',
		plugins_url( 'public/js/webpurify.min.js', __FILE__ ),
		array( 'jquery' ),
		rand(),
		true
	);

	wp_localize_script(
		'webpurify-public',
		'webpurify',
		array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) )
	);

}

/**
 * Checks the specified text agains the WebPurify API to determine if any
 * profanity or blacklisted words are present.
 *
 * @access private
 * @param  string $text The text to check against the API.
 * @return bool         True if the content is pure; otherwise, false.
 */
function _webpurify_check_text( $text = '' ) {

	$args = array(
		'api_key' => get_option( 'webpurify_userkey' ),
		'method'  => 'webpurify.live.check',
		'text'    => urlencode($text),
		'format'  => 'json',
	);

	// Create the URL for the API request.
	$url = add_query_arg( $args, WEBPURIFY_URL );

	return _webpurify_get_url( $url );

}

add_action( 'wp_ajax_webpurify_detects_profanity', 'webpurify_detects_profanity' );
add_action( 'wp_ajax_nopriv_webpurify_detects_profanity', 'webpurify_detects_profanity' );
/**
 * Sends a request to the WebPurify API service that will check the contents
 * of the comment form and the author field to check for profanity.
 *
 * It will then echo the contents of the response back to the caller.
 */
function webpurify_detects_profanity() {

	$messages = array();

	// @codingStandardsIgnoreStart
	$comment = sanitize_text_field( $_POST['comment'] );
	$author  = sanitize_text_field( $_POST['author'] );
	// @codingStandardsIgnoreEnd

	// Check the title and the content.
	$messages['comment'] = json_decode( _webpurify_check_text( $comment ) );
	$messages['author']  = json_decode( _webpurify_check_text( $author  ) );

	// Send the data base to the client.
	echo json_encode( $messages );
	wp_die();

}

add_action( 'wp_ajax_webpurify_use_auto_mode',        'webpurify_use_auto_mode' );
add_action( 'wp_ajax_nopriv_webpurify_use_auto_mode', 'webpurify_use_auto_mode' );
/**
 * Reads the mode of scanning the content and echos it back to the caller
 * which is invoked by an Ajax request.
 */
function webpurify_use_auto_mode() {
	echo esc_html( get_option( 'webpurify_mode' ) );
	wp_die();
}

/**
 * Get available languages
 *
 * @return array associative array of languages in format language code => human name
 */
function webpurify_get_languages() {
	return array(
		'en' => 'English',
		'ar' => 'Arabic',
		'zh' => 'Chinese',
		'fr' => 'French',
		'de' => 'German',
		'hi' => 'Hindi',
		'it' => 'Italian',
		'jp' => 'Japanese',
		'kr' => 'Korean',
		'pt' => 'Portuguese',
		'pa' => 'Punjabi',
		'ru' => 'Russian',
		'sp' => 'Spanish',
		'th' => 'Thai',
		'tr' => 'Turkish',
	);
}
