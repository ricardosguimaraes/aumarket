<?php

/**
 * Admin options page.
 * Please see https://www.webpurify.com/cms-integrations/wordpress/ for more
 * information.
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Setup vars
$userkey = get_option( 'webpurify_userkey', false );
$lang    = get_option( 'webpurify_lang',    'en'  );
$repc    = get_option( 'webpurify_r',       '*'   );
$mode    = get_option( 'webpurify_mode',    false );

// Get supported languages
$languages = webpurify_get_languages();

// Output the settings page HTML
?><div class="wrap">

	<h2><?php esc_html_e( 'Configure: WebPurify Plugin', 'WebPurify' ) ?></h2>

	<form name="form1" method="post" action="">

		<p>
			In order to use this plugin you must enter your <em>WebPurify API Key.</em>
			Purchase a WebPurify License at
			<a href="https://www.webpurify.com/?utm_source=wp_pluginlink&utm_medium=plugin&utm_campaign=wp_pluginlink" target="_blank">
				www.webpurify.com
			</a>.
		</p>

		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						<label for="webpurify_key"><?php esc_html_e( 'Enter WebPurify API Key', 'WebPurify' ) ?>:</label>
					</th>
					<td>
						<input id="webpurify_key" type="text" size="50" name="webpurify_key" value="<?php echo esc_attr( $userkey ); ?>" />
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<?php esc_html_e( 'Language Preference', 'WebPurify' ) ?>:
					</th>
					<td>
						<fieldset>
							<select name="webpurify_lang">
								<option value="default">Select a language...</option>
	            	<?php foreach ( $languages as $code => $name ) { ?>
									<option value="<?php echo esc_attr( $code ); ?>"
										<?php selected( $code, $lang, true ) ?>>
											<?php echo esc_html( $name ); ?>
									</option>
	            	<?php } ?>
							</select>
						</fieldset>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<label for="webpurify_r"><?php esc_html_e( 'Replacement Character', 'WebPurify' ) ?>:</label>
					</th>
					<td>
						<input id="webpurify_r" type="text" size="1" name="webpurify_r" maxlength="1" value="<?php echo esc_attr( $repc ); ?>">
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<label for="webpurify_mode"><?php esc_html_e( 'Check for profanity before comment submission?', 'WebPurify' ) ?></label>
					</th>
					<td>
						<input type="hidden" name="webpurify_mode" value="" />
						<input type="checkbox" name="webpurify_mode" value="1" <?php checked( '1', $mode, true ); ?> />
					</td>
				</tr>

				<tr valign="top">
					<th scope="row" colspan="2">
						<span class="description">
							<?php esc_html_e( 'For the allow list and block list, please enter each word on its own line.', 'WebPurify' ); ?>
						</span>
					</th>
				</tr>

				<tr valign="top">
					<th scope="row">
						<label for="webpurify_whitelist"><?php esc_html_e( 'Allow List', 'WebPurify' ) ?>:</label>
					</th>
					<td>
						<textarea cols="50" rows="10" name="webpurify_whitelist"><?php webpurify_get_list( 'whitelist' ); ?></textarea>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row">
						<label for="webpurify_blacklist"><?php esc_html_e( 'Block List', 'WebPurify' ) ?>:</label>
					</th>
					<td>
						<textarea cols="50" rows="10" name="webpurify_blacklist"><?php webpurify_get_list( 'blacklist' ); ?></textarea>
					</td>
				</tr>

			</tbody>
		</table>

		<p class="submit">
			<?php submit_button(); ?>
		</p>

	</form>

</div>
