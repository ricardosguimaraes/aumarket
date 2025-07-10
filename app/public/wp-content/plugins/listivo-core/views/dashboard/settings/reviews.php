<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::REVIEWS_ENABLED); ?>">
                <?php esc_html_e('Enabled', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::REVIEWS_ENABLED); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::REVIEWS_ENABLED); ?>"
                        id="<?php echo esc_attr(SettingKey::REVIEWS_ENABLED); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->reviewsEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Enable reviews.', 'listivo-core'); ?>
            </label>

            <p class="description">
                <a
                        href="https://support.listivotheme.com/support/solutions/articles/101000506362-reviews"
                        target="_blank"
                >
                    <?php esc_html_e('How to configure', 'listivo-core'); ?>
                </a>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::REVIEWS_MODERATION_ENABLED); ?>">
                <?php esc_html_e('Moderation', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::REVIEWS_MODERATION_ENABLED); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::REVIEWS_MODERATION_ENABLED); ?>"
                        id="<?php echo esc_attr(SettingKey::REVIEWS_MODERATION_ENABLED); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->isReviewsModerationEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Enable reviews moderation.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::REVIEWS_ALLOW_GUESTS); ?>">
                <?php esc_html_e('Allow Guests to Review', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::REVIEWS_ALLOW_GUESTS); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::REVIEWS_ALLOW_GUESTS); ?>"
                        id="<?php echo esc_attr(SettingKey::REVIEWS_ALLOW_GUESTS); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->reviewsAllowGuests()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Enable this option to allow unauthenticated users to submit reviews.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th>
            <label for="<?php echo esc_attr(SettingKey::REVIEW_MIN_LENGTH); ?>">
                <?php esc_html_e('Min Length', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::REVIEW_MIN_LENGTH); ?>"
                    name="<?php echo esc_attr(SettingKey::REVIEW_MIN_LENGTH); ?>"
                    class="regular-text"
                    type="number"
                    value="<?php echo esc_attr(tdf_settings()->getReviewMinLength()); ?>"
            >

            <p class="description">
                <?php esc_html_e('The minimum number of characters required for a review. 0 for unlimited.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th>
            <label for="<?php echo esc_attr(SettingKey::REVIEW_MAX_LENGTH); ?>">
                <?php esc_html_e('Max Length', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::REVIEW_MAX_LENGTH); ?>"
                    name="<?php echo esc_attr(SettingKey::REVIEW_MAX_LENGTH); ?>"
                    class="regular-text"
                    type="number"
                    value="<?php echo esc_attr(tdf_settings()->getReviewMaxLength()); ?>"
            >

            <p class="description">
                <?php esc_html_e('The maximum number of characters allowed for a review. 0 for unlimited.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th>
            <label for="<?php echo esc_attr(SettingKey::REVIEWS_IMAGES_ENABLED); ?>">
                <?php esc_html_e('Images', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::REVIEWS_IMAGES_ENABLED); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::REVIEWS_IMAGES_ENABLED); ?>"
                        id="<?php echo esc_attr(SettingKey::REVIEWS_IMAGES_ENABLED); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->reviewsImagesEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Enables users to upload images with their reviews.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th>
            <label for="<?php echo esc_attr(SettingKey::REVIEWS_IMAGES_NUMBER); ?>">
                <?php esc_html_e('Max Images', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::REVIEWS_IMAGES_NUMBER); ?>"
                    name="<?php echo esc_attr(SettingKey::REVIEWS_IMAGES_NUMBER); ?>"
                    class="regular-text"
                    type="number"
                    value="<?php echo esc_attr(tdf_settings()->getReviewsImagesNumber()); ?>"
            >

            <p class="description">
                <?php esc_html_e('The maximum number of images that can be uploaded with reviews.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th>
            <label for="<?php echo esc_attr(SettingKey::REVIEWS_IMAGES_SIZE); ?>">
                <?php esc_html_e('Max Image Size', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::REVIEWS_IMAGES_SIZE); ?>"
                    name="<?php echo esc_attr(SettingKey::REVIEWS_IMAGES_SIZE); ?>"
                    class="regular-text"
                    type="number"
                    value="<?php echo esc_attr(tdf_settings()->getReviewsImagesSize()); ?>"
            >

            <p class="description">
                <?php esc_html_e('The maximum size (MB) of images that can be uploaded with reviews.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::REVIEWS_THUMBS_ENABLED); ?>">
                <?php esc_html_e('Thumbs', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::REVIEWS_THUMBS_ENABLED); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::REVIEWS_THUMBS_ENABLED); ?>"
                        id="<?php echo esc_attr(SettingKey::REVIEWS_THUMBS_ENABLED); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->reviewsThumbsEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Enables users to rate reviews as helpful or not helpful using thumbs up/thumbs down icons.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>

    <tr>
        <th>
            <label for="<?php echo esc_attr(SettingKey::REVIEW_CUTOFF_LENGTH); ?>">
                <?php esc_html_e('Review Cutoff Length', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <input
                    id="<?php echo esc_attr(SettingKey::REVIEW_CUTOFF_LENGTH); ?>"
                    name="<?php echo esc_attr(SettingKey::REVIEW_CUTOFF_LENGTH); ?>"
                    class="regular-text"
                    type="number"
                    value="<?php echo esc_attr(tdf_settings()->getReviewCutoffLength()); ?>"
            >

            <p class="description">
                <?php esc_html_e('The number of characters after which the "read more" button will appear.', 'listivo-core'); ?>
            </p>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label for="<?php echo esc_attr(SettingKey::DELETE_REVIEW_IMAGES_ON_DELETE); ?>">
                <?php esc_html_e('Delete Images on Delete', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <label for="<?php echo esc_attr(SettingKey::DELETE_REVIEW_IMAGES_ON_DELETE); ?>">
                <input
                        name="<?php echo esc_attr(SettingKey::DELETE_REVIEW_IMAGES_ON_DELETE); ?>"
                        id="<?php echo esc_attr(SettingKey::DELETE_REVIEW_IMAGES_ON_DELETE); ?>"
                        type="checkbox"
                        value="1"
                    <?php if (tdf_settings()->deleteReviewImagesOnDelete()) : ?>
                        checked
                    <?php endif; ?>
                >

                <?php esc_html_e('Delete review images when a review is deleted.', 'listivo-core'); ?>
            </label>
        </td>
    </tr>
    </tbody>
</table>

<p class="submit">
    <button class="button button-primary">
        <?php esc_html_e('Save Changes', 'listivo-core'); ?>
    </button>
</p>