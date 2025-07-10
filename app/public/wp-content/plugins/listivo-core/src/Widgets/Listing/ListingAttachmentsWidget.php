<?php


namespace Tangibledesign\Listivo\Widgets\Listing;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseModelSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\AttachmentsFieldControl;

/**
 * Class ListingAttachmentsWidget
 * @package Tangibledesign\Listivo\Widgets\Listing
 */
class ListingAttachmentsWidget extends BaseModelSingleWidget
{
    use AttachmentsFieldControl;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'listing_attachments';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Ad Attachments', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addLabelControls();

        $this->addAttachmentsFieldControl();

        $this->addMarginControl();

        $this->addPaddingControl();

        $this->endControlsSection();

        $this->addStyleSection();

        $this->addVisibilitySection();
    }

    private function addStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->add_control(
            'label_heading',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-section__label' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-listing-section__label',
            ]
        );

        $this->add_control(
            'attachment_heading',
            [
                'label' => esc_html__('Attachment', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'attachment_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-attachment' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'attachment_typography',
                'selector' => '{{WRAPPER}} .listivo-attachment',
            ]
        );

        $this->endControlsSection();
    }

    private function addMarginControl(): void
    {
        $this->add_responsive_control(
            'attachments_margin',
            [
                'label' => esc_html__('Margin', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-section' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    }

    private function addPaddingControl(): void
    {
        $this->add_responsive_control(
            'attachments_padding',
            [
                'label' => esc_html__('Padding', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-listing-section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getAttachments(): Collection
    {
        $listing = $this->getModel();
        $attachmentsField = $this->getAttachmentsField();

        if (!$listing || !$attachmentsField) {
            return tdf_collect();
        }

        return $this->getAttachmentFieldAttachments($listing);
    }

    protected function addLabelControls(): void
    {
        $this->add_control(
            'show_label',
            [
                'label' => tdf_admin_string('show_label'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'label',
            [
                'label' => tdf_admin_string('label'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => tdf_string('attachments'),
                'condition' => [
                    'show_label' => '1',
                ]
            ]
        );
    }

    /**
     * @return bool
     */
    public function showLabel(): bool
    {
        return !empty((int)$this->get_settings_for_display('show_label'));
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        $label = (string)$this->get_settings_for_display('label');

        if (empty($label)) {
            return tdf_string('attachments');
        }

        return $label;
    }

}