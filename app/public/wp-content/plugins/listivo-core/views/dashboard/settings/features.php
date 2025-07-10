<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::COMPARE_MODELS); ?>">
                <?php esc_html_e('Compare', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::COMPARE_MODELS); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::COMPARE_MODELS); ?>"
                        id="<?php echo esc_attr(SettingKey::COMPARE_MODELS); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isCompareModelsEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Possibility to compare offers.', 'listivo-core'); ?>

                <a
                        href="https://support.listivotheme.com/support/solutions/articles/101000527836-compare-feature-overview-and-how-to-customize-the-compare-page"
                        target="_blank"
                >
                    <?php esc_html_e('Learn more about the Compare feature', 'listivo-core'); ?>
                </a>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::QUICK_VIEW); ?>">
                <?php esc_html_e('Quick View', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::QUICK_VIEW); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::QUICK_VIEW); ?>"
                        id="<?php echo esc_attr(SettingKey::QUICK_VIEW); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isQuickViewEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Adds a button to the offer card that opens a popup displaying key information.', 'listivo-core'); ?>

                <a
                        href="https://support.listivotheme.com/support/solutions/articles/101000527839-quick-view"
                        target="_blank"
                >
                    <?php esc_html_e('Learn more about the Quick View feature', 'listivo-core'); ?>
                </a>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::FAVORITE); ?>">
                <?php esc_html_e('Favorites', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::FAVORITE); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::FAVORITE); ?>"
                        id="<?php echo esc_attr(SettingKey::FAVORITE); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isFavoriteEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Users can add ads to favorites.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>
    </tbody>
</table>

<h2><?php esc_html_e('Message System', 'listivo-core'); ?></h2>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::MESSAGE_SYSTEM); ?>">
                <?php esc_html_e('Enabled', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::MESSAGE_SYSTEM); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::MESSAGE_SYSTEM); ?>"
                        id="<?php echo esc_attr(SettingKey::MESSAGE_SYSTEM); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->messageSystem()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Users can have conversations with each other.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::MESSAGE_SYSTEM_INITIAL_MESSAGE); ?>">
                <?php esc_html_e('Custom Initial Message', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <textarea
                    id="<?php echo esc_attr(SettingKey::MESSAGE_SYSTEM_INITIAL_MESSAGE); ?>"
                    name="<?php echo esc_attr(SettingKey::MESSAGE_SYSTEM_INITIAL_MESSAGE); ?>"
                    class="listivo-backend-text-area"
                    rows="5"
                    cols="30"
            ><?php echo wp_kses_post(tdf_settings()->getMessageSystemInitialMessageOption()); ?></textarea>

            <p class="description">
                <?php esc_html_e('Available variables: {listingName}, {listingPrice}, {listingAddress}, {listingId}, {listingUrl}', 'listivo-core'); ?>
            </p>
        </td>
    </tr>
    </tbody>
</table>

<p class="submit">
    <button class="button button-primary">
        <?php esc_html_e('Save Changes', 'listivo-core'); ?>
    </button>
</p>