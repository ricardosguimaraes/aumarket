<?php

namespace Tangibledesign\Framework\Widgets\User;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\General\PanelWidget;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;

class ContactUserWidget extends BaseUserWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'contact_user';
    }

    protected function register_controls(): void
    {
        $this->start_controls_section(
            'general',
            [
                'label' => tdf_admin_string('general'),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );

        $this->add_control(
            'type',
            [
                'label' => tdf_admin_string('type'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getOptions(),
                'default' => 'global'
            ]
        );

        $this->end_controls_section();

        $this->addVisibilitySection();
    }

    /**
     * @return string[]
     */
    protected function getOptions(): array
    {
        $options = [
            'global' => tdf_admin_string('global'),
        ];

        if (tdf_settings()->messageSystem()) {
            $options['messages'] = tdf_admin_string('direct_messages');
        }

        return $options + tdf_app('contact_form_list');
    }

    /**
     * @return int|string
     */
    private function getType()
    {
        $type = $this->get_settings_for_display('type');

        if (empty($type) || $type === 'global') {
            if (tdf_settings()->messageSystem()) {
                return 'messages';
            }

            return tdf_settings()->getContactUserFormId();
        }

        if ($type === 'messages') {
            return 'messages';
        }

        return (int)$type;
    }

    /**
     * @return bool
     */
    public function isMessagesType(): bool
    {
        return $this->getType() === 'messages';
    }

    /**
     * @return bool
     */
    public function isContactFormType(): bool
    {
        return !$this->isMessagesType();
    }

    /**
     * @return int|string
     */
    private function getFormId()
    {
        return $this->getType();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('contact_user');
    }

    public function displayForm(): void
    {
        $user = $this->getUser();
        if (!$user) {
            return;
        }

        if (is_singular()) {
            the_post();
        }

        echo do_shortcode('[contact-form-7 ' . tdf_prefix() . '-user-id="' . $user->getId()
            . '" id="' . $this->getFormId() . '"][/contact-form-7]');
    }

    /**
     * @param int $userId
     * @return string
     */
    public function getRedirectUrl(int $userId): string
    {
        if (!is_user_logged_in()) {
            return tdf_settings()->getLoginPageUrl();
        }

        return PanelWidget::getUrl(PanelWidget::ACTION_MESSAGES) . '/?' . tdf_slug('user') . '=' . $userId;
    }

}