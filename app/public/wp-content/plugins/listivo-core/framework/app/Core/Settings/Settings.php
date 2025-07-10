<?php

namespace Tangibledesign\Framework\Core\Settings;

class Settings
{
    use SetReviews;
    use SetListingExpireAfter;
    use SetStripeSettings;
    use SetTwilioCredentials;
    use SetMaps;
    use SetUserRegistration;
    use SetModeration;
    use SetReCaptcha;
    use SetFacebookAuth;
    use SetGoogleAuth;
    use SetMailSettings;
    use SetFieldsOrder;
    use SetNumberFormat;
    use SetDefaultTemplates;
    use SetLogo;
    use SetPrimaryColor;
    use SetHomepage;
    use SetPublicInformation;
    use SetHeaderSettings;
    use SetFooterSettings;
    use SetSocialMedia;
    use SetFonts;
    use SetDisableDemoImporter;
    use SetPages;
    use SetMessageSystem;
    use SetFavorite;
    use SetPolicyLabel;
    use SetBreadcrumbs;
    use SetPrettyUrls;
    use SetExcludeFromSearch;
    use SetDescriptionRequired;
    use SetSubmitWithoutLogin;
    use SetContactUserForm;
    use SetMainCategory;
    use SetDeleteModelImagesOnDelete;
    use SetAutoGenerateModelTitle;
    use SetPaymentSettings;
    use SetListingCardShowUser;
    use SetModerators;
    use SetPhoneSettings;
    use SetAccountInitialTab;
    use SetLoginMinLength;
    use SetKeywordSearchDescription;
    use SetMessageSystemInitialMessage;
    use SetDescriptionSimpleEditor;
    use SetKeywordSearchTerms;
    use SetMapDefaultRadius;
    use SetDisableWhatsApp;
    use SetDisableViber;
    use SetSearchTitleFields;
    use SetSearchDefaultTitle;
    use SetModelCardImageSizes;
    use SetSearchOverrideTitleTag;
    use SetDesign;
    use SetCardSettings;
    use SetLegacyMode;
    use SetCompareModels;
    use SetQuickView;
    use SetAccountType;
    use SetEnableWebsiteField;
    use SetNameRequired;
    use SetBusinessAccountSettings;
    use SetPrivateAccountSettings;
    use SetNameLength;
    use SetListingHints;
    use SetUserPhoneVerification;
    use SetPanelRedirects;
    use SetFreeSubscription;
    use SetMarketingConsents;
    use SetChatAppsActivationTrait;
    use SetSubscriptionsSettingsTrait;
    use SetCacheSettingsTrait;

    protected const OPTION = 'settings';

    protected array $config = [];

    public function __construct()
    {
        $this->fetchConfig();
    }

    private function fetchConfig(): void
    {
        $config = get_option($this->getOptionKey());

        if (is_array($config)) {
            $this->config = $config;
        }
    }

    private function getOptionKey(): string
    {
        return tdf_prefix() . '_' . self::OPTION;
    }

    public function save(): void
    {
        update_option($this->getOptionKey(), $this->config, true);

        do_action(tdf_prefix() . '/settings/saved');
    }

    public function update(array $settingKeys, array $data): void
    {
        foreach ($settingKeys as $settingKey) {
            $value = array_key_exists($settingKey, $data) ? $data[$settingKey] : '';
            $method = $this->getMethodName($settingKey);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }

        $this->save();
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function setSetting(string $key, $value): void
    {
        $this->config[$key] = $value;
    }

    public function getSetting(string $key)
    {
        return isset($this->config[$key]) ? stripslashes_deep($this->config[$key]) : null;
    }

    private function getMethodName(string $settingKey): string
    {
        return 'set' . str_replace(
                ' ',
                '',
                ucwords(str_replace('_', ' ', str_replace(tdf_prefix(), '', $settingKey)))
            );
    }

    public static function getNotificationSettings(): array
    {
        return [
            SettingKey::SENDER_NAME,
            SettingKey::SENDER_EMAIL,
            SettingKey::MAIL_FOOTER,
        ];
    }

}