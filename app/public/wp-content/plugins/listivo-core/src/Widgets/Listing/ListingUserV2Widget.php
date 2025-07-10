<?php

namespace Tangibledesign\Listivo\Widgets\Listing;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\General\PanelWidget;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Listivo\Traits\Widgets\ListingUserV2StyleControlsTrait;

class ListingUserV2Widget extends BaseModelSingleWidget
{
    use ListingUserV2StyleControlsTrait;

    public function getKey(): string
    {
        return 'listing_user_v2';
    }

    public function getName(): string
    {
        return esc_html__('Ad Owner V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->addGeneralContentSection();

        $this->addGeneralStyleSection();

        $this->addRatingStyleSection();

        $this->addPhoneStyleSection();

        $this->addUserStateStyleSection();

        $this->addVisibilitySection();
    }

    private function addGeneralContentSection(): void
    {
        $this->startContentControlsSection();

        $this->addUserRatingControls();

        $this->addShowMemberSinceControl();

        $this->addShowAccountTypeControl();

        $this->addShowAddressControl();

        $this->addPhoneControls();

        $this->addContactFormControls();

        $this->addUserActiveControls();

        $this->addChatButtonLabelControl();

        $this->addEmailButtonLabelControl();

        $this->endControlsSection();
    }

    private function addUserRatingControls(): void
    {
        $this->add_control(
            'show_user_rating',
            [
                'label' => esc_html__('Display User Rating', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'show_user_ratings_number',
            [
                'label' => esc_html__('Display User Rating Number', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
                'condition' => [
                    'show_user_rating' => '1',
                ]
            ]
        );
    }

    public function showUserRating(): bool
    {
        if (empty($this->get_settings_for_display('show_user_rating'))) {
            return false;
        }

        $lstUser = $this->getUser();
        if (!$lstUser) {
            return false;
        }

        return $lstUser->getReviewNumber() > 0;
    }

    public function showUserRatingsNumber(): bool
    {
        return !empty($this->get_settings_for_display('show_user_ratings_number'));
    }

    private function addContactFormControls(): void
    {
        $this->add_control(
            'show_email_button',
            [
                'label' => esc_html__('Display Email Button', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'contact_form',
            [
                'label' => esc_html__('Contact Form', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => tdf_app('contact_form_list'),
                'condition' => [
                    'show_email_button' => '1',
                ]
            ]
        );
    }

    public function showContactForm(): bool
    {
        return !empty($this->get_settings_for_display('show_email_button'));
    }

    public function getContactFormId(): int
    {
        return (int)$this->get_settings_for_display('contact_form');
    }

    /**
     * @return User|false
     */
    public function getUser()
    {
        $model = $this->getModel();
        if (!$model) {
            return false;
        }

        return $model->getUser();
    }

    public function displayForm(): void
    {
        $user = $this->getUser();
        if (!$user) {
            return;
        }

        if (is_singular()) {
            global $post;
            $tempPost = $post;

            the_post();
        }

        echo do_shortcode('[contact-form-7 ' . tdf_prefix() . '-user-id="' . $user->getId()
            . '" id="' . $this->getContactFormId() . '"][/contact-form-7]');

        if (isset($tempPost)) {
            $post = $tempPost;
        }
    }

    private function addPhoneControls(): void
    {
        $this->add_control(
            'show_phone',
            [
                'label' => esc_html__('Display phone', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'hide_phone_number',
            [
                'label' => esc_html__('Hide number', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
                'condition' => [
                    'show_phone' => '1',
                ]
            ]
        );
    }

    public function showPhone(): bool
    {
        return !empty($this->get_settings_for_display('show_phone'));
    }

    public function hidePhoneNumber(): bool
    {
        return !empty($this->get_settings_for_display('hide_phone_number'));
    }

    private function addShowMemberSinceControl(): void
    {
        $this->add_control(
            'show_member_since',
            [
                'label' => esc_html__('Display member since', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    public function showMemberSince(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_member_since'));
    }

    private function addShowAddressControl(): void
    {
        $this->add_control(
            'show_address',
            [
                'label' => esc_html__('Display address', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    public function showAddress(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_address'));
    }

    private function addShowAccountTypeControl(): void
    {
        $this->add_control(
            'show_account_type',
            [
                'label' => esc_html__('Display Account Type', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    public function showAccountType(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_account_type'));
    }

    public function getChatRedirectUrl(int $userId): string
    {
        if (!is_user_logged_in()) {
            return tdf_settings()->getLoginPageUrl();
        }

        return PanelWidget::getUrl(PanelWidget::ACTION_MESSAGES) . '/?' . tdf_slug('user') . '=' . $userId;
    }

    private function addUserActiveControls(): void
    {
        $this->add_control(
            'show_user_state',
            [
                'label' => esc_html__('Show when user is online', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'user_online_minutes',
            [
                'label' => esc_html__('Online when active in the last X minutes', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'description' => esc_html__('Consider a user online when active in the last X minutes.',
                    'listivo-core'),
                'default' => '5',
            ]
        );
    }

    public function showUserState(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_user_state'));
    }

    public function isUserOnline(): bool
    {
        $user = $this->getUser();
        if (!$user) {
            return false;
        }

        $limit = (int)$this->get_settings_for_display('user_online_minutes');
        if (empty($limit)) {
            return false;
        }

        return apply_filters('listivo/user/isOnline', $user->wasActiveInLastMinutes($limit), $user);
    }

    private function addChatButtonLabelControl(): void
    {
        $this->add_control(
            'chat_button_label',
            [
                'label' => esc_html__('Chat button label', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    public function getChatButtonLabel(): string
    {
        $label = $this->get_settings_for_display('chat_button_label');
        if (empty($label)) {
            return tdf_string('chat');
        }

        return $label;
    }

    private function addEmailButtonLabelControl(): void
    {
        $this->add_control(
            'email_button_label',
            [
                'label' => esc_html__('Email button label', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    public function getEmailButtonLabel(): string
    {
        $label = $this->get_settings_for_display('email_button_label');
        if (empty($label)) {
            return tdf_string('email');
        }

        return $label;
    }
}