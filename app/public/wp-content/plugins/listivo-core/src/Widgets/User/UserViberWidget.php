<?php

namespace Tangibledesign\Listivo\Widgets\User;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Widgets\Helpers\BaseUserWidget;
use Tangibledesign\Framework\Widgets\Helpers\HasModel;
use Tangibledesign\Framework\Widgets\Helpers\ModelSingleWidget;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ContactButtonStyleControls;

class UserViberWidget extends BaseUserWidget implements ModelSingleWidget
{
    use HasModel;
    use ContactButtonStyleControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'user_viber';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('User Viber', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addGlobalInitialMessage();

        $this->addContactButtonStyleControls();

        $this->addMarginControl();

        $this->endControlsSection();

        $this->addVisibilitySection();
    }

    private function addMarginControl(): void
    {
        $this->add_responsive_control(
            'viber_margin',
            [
                'label' => esc_html__('Margin', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-contact-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    }

    private function addGlobalInitialMessage(): void
    {
        $this->add_control(
            'global_initial_message',
            [
                'label' => esc_html__('Global initial message', 'listivo-core'),
                'description' => esc_html__('Setting from wp-admin -> Listivo Panel -> User Panel -> Custom Initial Message', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );
    }

    /**
     * @return bool
     */
    public function useGlobalInitialMessage(): bool
    {
        return !empty((int)$this->get_settings_for_display('global_initial_message'));
    }

    /**
     * @param Model|false $model
     * @return string
     */
    public function getInitialMessage($model): string
    {
        if (!$model || !is_singular(tdf_model_post_type())) {
            return '';
        }

        if (!$this->useGlobalInitialMessage()) {
            return tdf_string('i_m_interested_in') . ' ' . $model->getName();
        }

        return tdf_settings()->getMessageSystemInitialMessage($model);
    }

}