<?php

namespace Tangibledesign\Listivo\Widgets\User;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\TextControls;
use Tangibledesign\Framework\Widgets\Helpers\HasModel;
use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;

class UserFullNameWidget extends BaseUserWidget implements ModelSingleWidget
{
    use HasModel;
    use TextControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'user_full_name';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('User Name', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addTypeControl();

        $this->endControlsSection();

        $this->startStyleControlsSection();

        $this->addTextControls('.listivo-user-full-name');

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addTypeControl(): void
    {
        $this->add_control(
            'type',
            [
                'label' => esc_html__('Type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'full_name' => esc_html__('Full name', 'listivo-core'),
                    'first_name' => esc_html__('First name', 'listivo-core'),
                    'last_name' => esc_html__('Last Name', 'listivo-core'),
                ],
                'default' => 'full_name',
            ]
        );
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        $type = $this->get_settings_for_display('type');
        if (empty($type)) {
            return 'full_name';
        }

        return $type;
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        $user = $this->getUser();
        if (!$user) {
            return '';
        }

        if (
            !(
                ($user->isPrivateAccount() && tdf_settings()->isFullNameEnabledForPrivateAccount())
                || ($user->isBusinessAccount() && tdf_settings()->isFullNameEnabledForBusinessAccount())
            )
        ) {
            return '';
        }

        $type = $this->getType();

        if ($type === 'first_name') {
            return $user->getFirstName();
        }

        if ($type === 'last_name') {
            return $user->getLastName();
        }

        return implode(' ', [$user->getFirstName(), $user->getLastName()]);
    }

}