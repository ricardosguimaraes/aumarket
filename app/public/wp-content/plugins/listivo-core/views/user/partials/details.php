<?php

use Tangibledesign\Framework\Models\User\Helpers\HasImageInterface;
use Tangibledesign\Framework\Models\User\Helpers\HasJobTitleInterface;
use Tangibledesign\Framework\Models\User\Helpers\HasPhoneInterface;
use Tangibledesign\Framework\Models\User\Helpers\UserSettingKey;
use Tangibledesign\Framework\Models\User\User;

/* @var User $user */
?>
<table class="form-table" role="presentation">
    <?php if (tdf_settings()->isMarketingConsentsEnabled()) : ?>
        <tr class="user-marketing-consent-wrap">
            <th>
                <label for="<?php echo esc_attr(UserSettingKey::MARKETING_CONSENT); ?>">
                    <?php esc_html_e('Marketing Consent', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <input
                        id="<?php echo esc_attr(UserSettingKey::MARKETING_CONSENT); ?>"
                        name="<?php echo esc_attr(UserSettingKey::MARKETING_CONSENT); ?>"
                        type="checkbox"
                        value="1"
                    <?php if ($user->hasMarketingConsent()) : ?>
                        checked
                    <?php endif; ?>
                >
            </td>
        </tr>
    <?php endif; ?>

    <?php if (tdf_settings()->isAccountTypeEnabled()) : ?>
        <tr class="user-first-name-wrap">
            <th>
                <label for="<?php echo esc_attr(UserSettingKey::ACCOUNT_TYPE); ?>">
                    <?php esc_html_e('Account Type', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <select
                        name="<?php echo esc_attr(UserSettingKey::ACCOUNT_TYPE); ?>"
                        id="<?php echo esc_attr(UserSettingKey::ACCOUNT_TYPE); ?>"
                >
                    <option
                            value="<?php echo esc_attr(UserSettingKey::ACCOUNT_TYPE_PRIVATE); ?>"
                        <?php if ($user->isPrivateAccount()) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo esc_html__('Private', 'listivo-core'); ?>
                    </option>

                    <option
                            value="<?php echo esc_attr(UserSettingKey::ACCOUNT_TYPE_BUSINESS); ?>"
                        <?php if ($user->isBusinessAccount()) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo esc_html__('Business', 'listivo-core'); ?>
                    </option>
                </select>
            </td>
        </tr>

        <?php if ($user->isBusinessAccount()) : ?>
            <tr class="user-first-name-wrap">
                <th>
                    <label for="<?php echo esc_attr(UserSettingKey::COMPANY_INFORMATION); ?>">
                        <?php esc_html_e('Company Information', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <textarea
                            name="<?php echo esc_attr(UserSettingKey::COMPANY_INFORMATION); ?>"
                            id="<?php echo esc_attr(UserSettingKey::COMPANY_INFORMATION); ?>"
                            cols="30"
                            rows="5"
                    ><?php echo esc_html($user->getCompanyInformation()); ?></textarea>
                </td>
            </tr>
        <?php endif; ?>
    <?php endif; ?>

    <?php if ($user instanceof HasImageInterface) : ?>
        <tr class="user-first-name-wrap">
            <th>
                <label for="<?php echo esc_attr(UserSettingKey::IMAGE); ?>">
                    <?php esc_html_e('Profile Image (Listivo Theme)', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <lst-set-image :initial-image-id="<?php echo esc_attr($user->getImageId()); ?>">
                    <div slot-scope="props">
                        <div v-if="props.imageId" class="tdf-user-image">
                            <img :src="props.imageUrl" alt="">

                            <button class="tdf-button-round-remove " @click.prevent="props.remove"></button>

                            <input
                                    name="<?php echo esc_attr(UserSettingKey::IMAGE); ?>"
                                    :value="props.imageId"
                                    type="hidden"
                            >
                        </div>

                        <button class="tdf-button-add" @click.prevent="props.openUploader">
                            <?php esc_html_e('Set Image', 'listivo-core'); ?>
                        </button>
                    </div>
                </lst-set-image>
            </td>
        </tr>
    <?php endif; ?>

    <?php if ($user instanceof HasPhoneInterface) : ?>
        <tr class="user-first-name-wrap">
            <th>
                <label for="<?php echo esc_attr(UserSettingKey::ADDRESS); ?>">
                    <?php esc_html_e('Address (Listivo Theme)', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <input
                        name="<?php echo esc_attr(UserSettingKey::ADDRESS); ?>"
                        id="<?php echo esc_attr(UserSettingKey::ADDRESS); ?>"
                        class="regular-text"
                        type="text"
                        value="<?php echo esc_attr($user->getAddress()); ?>"
                >
            </td>
        </tr>
    <?php endif; ?>

    <?php if ($user instanceof HasPhoneInterface) : ?>
        <?php if (tdf_settings()->isPhoneCountryCodeSelectEnabled()) : ?>
            <tr class="user-first-name-wrap">
                <th>
                    <label for="<?php echo esc_attr(UserSettingKey::PHONE_COUNTRY_CODE); ?>">
                        <?php esc_html_e('Phone Country Code', 'listivo-core'); ?>
                    </label>
                </th>

                <td>
                    <select
                            name="<?php echo esc_attr(UserSettingKey::PHONE_COUNTRY_CODE); ?>"
                            id="<?php echo esc_attr(UserSettingKey::PHONE_COUNTRY_CODE); ?>"
                    >
                        <?php foreach (tdf_app('phone_country_codes_with_flags') as $text => $code) : ?>
                            <option
                                    value="<?php echo esc_attr($text); ?>"
                                <?php if ($user->getPhoneCountryCode() === $text) : ?>
                                    selected
                                <?php endif; ?>
                            >
                                <?php echo tdf_filter($text); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
        <?php endif; ?>

        <tr class="user-first-name-wrap">
            <th>
                <label for="<?php echo esc_attr(UserSettingKey::PHONE); ?>">
                    <?php esc_html_e('Phone (Listivo Theme)', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <input
                        name="<?php echo esc_attr(UserSettingKey::PHONE); ?>"
                        id="<?php echo esc_attr(UserSettingKey::PHONE); ?>"
                        class="regular-text"
                        type="text"
                        value="<?php echo esc_attr($user->getPhone()); ?>"
                >
            </td>
        </tr>

        <tr class="user-first-name-wrap">
            <th>
                <label for="<?php echo esc_attr(UserSettingKey::VERIFIED); ?>">
                    <?php esc_html_e('Phone Number Verified', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <input
                        name="<?php echo esc_attr(UserSettingKey::VERIFIED); ?>"
                        id="<?php echo esc_attr(UserSettingKey::VERIFIED); ?>"
                        class="regular-text"
                        type="checkbox"
                        value="1"
                    <?php if ($user->isVerified()) : ?>
                        checked
                    <?php endif; ?>
                >
            </td>
        </tr>

        <tr class="user-first-name-wrap">
            <th>
                <label for="<?php echo esc_attr(UserSettingKey::WHATS_APP); ?>">
                    <?php esc_html_e('Enable WhatsApp', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <input
                        name="<?php echo esc_attr(UserSettingKey::WHATS_APP); ?>"
                        id="<?php echo esc_attr(UserSettingKey::WHATS_APP); ?>"
                        class="regular-text"
                        type="checkbox"
                        value="1"
                    <?php if ($user->isWhatsAppEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >
            </td>
        </tr>

        <tr class="user-first-name-wrap">
            <th>
                <label for="<?php echo esc_attr(UserSettingKey::VIBER); ?>">
                    <?php esc_html_e('Enable Viber', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <input
                        name="<?php echo esc_attr(UserSettingKey::VIBER); ?>"
                        id="<?php echo esc_attr(UserSettingKey::VIBER); ?>"
                        class="regular-text"
                        type="checkbox"
                        value="1"
                    <?php if ($user->isViberEnabled()) : ?>
                        checked
                    <?php endif; ?>
                >
            </td>
        </tr>
    <?php endif; ?>

    <?php if ($user instanceof HasJobTitleInterface) : ?>
        <tr class="user-first-name-wrap">
            <th>
                <label for="<?php echo esc_attr(UserSettingKey::JOB_TITLE); ?>">
                    <?php esc_html_e('Job Title', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <input
                        name="<?php echo esc_attr(UserSettingKey::JOB_TITLE); ?>"
                        id="<?php echo esc_attr(UserSettingKey::JOB_TITLE); ?>"
                        class="regular-text"
                        type="text"
                        value="<?php echo esc_attr($user->getJobTitle()); ?>"
                >
            </td>
        </tr>
    <?php endif; ?>

    <?php if (tdf_settings()->subscriptionsEnabled()) : ?>
        <tr class="user-first-name-wrap">
            <th>
                <label for="<?php echo esc_attr(UserSettingKey::STRIPE_CUSTOMER_ID); ?>">
                    <?php esc_html_e('Stripe Customer ID', 'listivo-core'); ?>
                </label>
            </th>

            <td>
                <input
                        name="<?php echo esc_attr(UserSettingKey::STRIPE_CUSTOMER_ID); ?>"
                        id="<?php echo esc_attr(UserSettingKey::STRIPE_CUSTOMER_ID); ?>"
                        class="regular-text"
                        type="text"
                        value="<?php echo esc_attr($user->getStripeCustomerId()); ?>"
                >
            </td>
        </tr>
    <?php endif; ?>
</table>