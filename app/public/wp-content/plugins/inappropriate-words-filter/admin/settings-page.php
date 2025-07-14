<div class="wrap">
    <h1>Inappropriate Words Settings</h1>
    <form method="post" action="options.php">
        <?php
        settings_fields('inappropriate_words_settings');
        do_settings_sections('inappropriate_words_settings');
        $words = get_option('inappropriate_words', '');
        ?>
        <table class="form-table">
            <tr valign="top">
                <th scope="row">Word list (comma-separated)</th>
                <td>
                    <textarea name="inappropriate_words" rows="5" cols="50"><?php echo esc_textarea($words); ?></textarea>
                    <p class="description">Example: badword1, badword2, slur1</p>
                </td>
            </tr>
        </table>
        <?php submit_button(); ?>
    </form>
</div>
