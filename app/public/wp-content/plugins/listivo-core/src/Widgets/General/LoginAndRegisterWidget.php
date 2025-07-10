<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Tangibledesign\Framework\Models\User\Helpers\UserSettingKey;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

class LoginAndRegisterWidget extends BaseGeneralWidget
{
    public const VIEW = 'view';
    public const VIEW_DEFAULT = 'default';
    public const VIEW_SET_PASSWORD = 'set-password';

    public function getKey(): string
    {
        return 'login_and_register';
    }

    protected function getTemplateDirectory(): string
    {
        return 'general/login/';
    }

    public function getName(): string
    {
        return esc_html__('Login & Register', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addWidgetTypeControl();

        if (tdf_settings()->isAccountTypeEnabled()) {
            $this->addInitialUserTypeControl();

            $this->addShowAccountTypeSelectControl();
        }

        $this->addBackgroundControl();

        $this->endControlsSection();

        $this->addStyleSection();
    }

    public function getWidgetType(): string
    {
        $type = $this->get_settings_for_display('widget_type');

        if (empty($type)) {
            return 'login_and_register';
        }

        return $type;
    }

    public function getView(): string
    {
        if (!isset($_GET[tdf_slug(self::VIEW)]) || empty($_GET[tdf_slug(self::VIEW)])) {
            return self::VIEW_DEFAULT;
        }

        $view = $_GET[tdf_slug(self::VIEW)];
        if ($view !== tdf_slug(self::VIEW_SET_PASSWORD)) {
            return self::VIEW_DEFAULT;
        }

        return $view;
    }

    public function isSetPasswordView(): bool
    {
        return $this->getView() === tdf_slug(self::VIEW_SET_PASSWORD);
    }

    protected function loadTemplate(): void
    {
        if ($this->isSetPasswordView()) {
            get_template_part('templates/widgets/'.$this->getTemplateDirectory().'set_password');
            return;
        }

        parent::loadTemplate();
    }

    public function getSelector(): string
    {
        return $_GET['selector'] ?? '';
    }

    public function getValidator(): string
    {
        return $_GET['v'] ?? '';
    }

    public function addWidgetTypeControl(): void
    {
        $this->add_control(
            'widget_type',
            [
                'label' => esc_html__('Type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'description' => 'Registration will works correctly only if turned it on in the /wp-admin/ > Listivo Panel > User Panel > Registration - enable user registration',
                'options' => [
                    'login_and_register' => esc_html__('Login and Register', 'listivo-core'),
                    'login' => esc_html__('Login', 'listivo-core'),
                    'register' => esc_html__('Register', 'listivo-core'),
                ],
                'default' => 'login_and_register',
            ]
        );
    }

    public function addBackgroundControl(): void
    {
        $this->add_control(
            'background',
            [
                'label' => esc_html__('Background Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    public function getBackgroundImage(): string
    {
        $image = $this->get_settings_for_display('background');

        return $image['url'] ?? '';
    }

    private function addStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->add_control(
            'mask_heading',
            [
                'label' => esc_html__('Mask', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'mask_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-login-widget--with-background:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'mask_opacity',
            [
                'label' => esc_html__('Opacity', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'max' => 1,
                        'min' => 0,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .listivo-login-widget--with-background:before' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->endControlsSection();
    }

    private function addInitialUserTypeControl(): void
    {
        $this->add_control(
            'initial_account_type',
            [
                'label' => esc_html__('Initial User Account Type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    UserSettingKey::ACCOUNT_TYPE_PRIVATE => esc_html__('Private', 'listivo-core'),
                    UserSettingKey::ACCOUNT_TYPE_BUSINESS => esc_html__('Business', 'listivo-core'),
                ],
                'default' => UserSettingKey::ACCOUNT_TYPE_PRIVATE,
            ]
        );
    }

    public function getInitialUserType(): string
    {
        if (!tdf_settings()->isAccountTypeEnabled()) {
            return UserSettingKey::ACCOUNT_TYPE_PRIVATE;
        }

        $accountType = $this->get_settings_for_display('initial_account_type');
        if (empty($accountType)) {
            return UserSettingKey::ACCOUNT_TYPE_PRIVATE;
        }

        return $accountType;
    }

    private function addShowAccountTypeSelectControl(): void
    {
        $this->add_control(
            'show_account_type_select',
            [
                'label' => esc_html__('Display Account Type Select', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    public function showAccountTypeSelect(): bool
    {
        if (!tdf_settings()->isAccountTypeEnabled()) {
            return false;
        }

        return !empty((int)$this->get_settings_for_display('show_account_type_select'));
    }
}