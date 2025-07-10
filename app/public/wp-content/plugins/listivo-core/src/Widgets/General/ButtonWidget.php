<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Widgets\General\BaseButtonWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\FlexAlignmentControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\IconControl;

class ButtonWidget extends BaseButtonWidget
{
    use FlexAlignmentControl;
    use IconControl;

    public function getKey(): string
    {
        return 'button';
    }

    public function getName(): string
    {
        return esc_html__('Button', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addButtonTextControl();

        $this->addButtonDestinationControl();

        $this->addButtonTypeControl();

        $this->addIconControl();

        $this->addFlexAlignmentControl('.listivo-button-wrapper');

        $this->endControlsSection();
    }

    private function addButtonTypeControl(): void
    {
        $this->add_control(
            'button_type',
            [
                'label' => esc_html__('Type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'primary_1' => esc_html__('Primary 1', 'listivo-core'),
                    'primary_2' => esc_html__('Primary 2', 'listivo-core'),
                ],
                'default' => 'primary_1',
            ]
        );
    }

    /**
     * @return string
     */
    public function getButtonType(): string
    {
        $buttonType = $this->get_settings_for_display('button_type');

        if (empty($buttonType) || !in_array($buttonType, [
                'primary_1',
                'primary_2',
            ], true)) {
            return 'primary_1';
        }

        return $buttonType;
    }

    public function isPrimary1Type(): bool
    {
        return $this->getButtonType() === 'primary_1';
    }

    public function isPrimary2Type(): bool
    {
        return $this->getButtonType() === 'primary_2';
    }
}