<?php

namespace Tangibledesign\Framework\Widgets\Helpers;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Tangibledesign\Framework\Models\User\Helpers\UserSettingKey;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\Helpers\Controls\Control;

trait HasVisibilitySection
{
    use Control;

    protected function addVisibilitySection(): void
    {
        $this->start_controls_section(
            tdf_prefix() . '_visibility',
            [
                'tab' => Controls_Manager::TAB_SETTINGS,
                'label' => tdf_admin_string('visibility'),
            ]
        );

        $this->add_control(
            'visibility_by_owner_account_type',
            [
                'label' => tdf_admin_string('user_account_type'),
                'description' => tdf_admin_string('visibility_by_owner_account_type_description'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'any' => tdf_admin_string('any'),
                    UserSettingKey::ACCOUNT_TYPE_PRIVATE => tdf_admin_string('private'),
                    UserSettingKey::ACCOUNT_TYPE_BUSINESS => tdf_admin_string('business'),
                ],
                'default' => 'any',
            ]
        );

        $this->add_control(
            'visibility_by_logged',
            [
                'label' => tdf_admin_string('only_logged_in_users'),
                'description' => tdf_admin_string('visibility_by_logged_description'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->endControlsSection();
    }

    public function isVisible(): bool
    {
        if (Plugin::instance()->editor->is_edit_mode()) {
            return true;
        }

        if (!$this->checkVisibilityByLoggedUsers()) {
            return false;
        }

        if (!$this->checkVisibilityByOwnerAccountType()) {
            return false;
        }

        return true;
    }

    private function checkVisibilityByLoggedUsers(): bool
    {
        $enabled = (int)$this->get_settings_for_display('visibility_by_logged');

        return empty($enabled) || is_user_logged_in();
    }

    private function checkVisibilityByOwnerAccountType(): bool
    {
        $userAccountType = $this->get_settings_for_display('visibility_by_owner_account_type');
        if ($userAccountType === 'any') {
            return true;
        }

        $user = tdf_current_user();
        if (!$user instanceof User) {
            return false;
        }

        return $user->getAccountType() === $userAccountType;
    }

    /**
     * @return User|false
     */
    abstract public function getUser();

}