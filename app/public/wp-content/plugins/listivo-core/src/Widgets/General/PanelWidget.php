<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Payments\RegularUserPaymentPackage;
use Tangibledesign\Framework\Models\Post\PostStatus;
use Tangibledesign\Framework\Models\PanelFields\CustomPanelField;

class PanelWidget extends \Tangibledesign\Framework\Widgets\General\PanelWidget
{

    protected function register_controls(): void
    {
        $this->addMainContentSection();

        $this->addStyleSections();
    }

    public function getModels(): Collection
    {
        if (!is_user_logged_in()) {
            return tdf_collect();
        }

        $query = tdf_query_models()
            ->setPage($this->getPage())
            ->take($this->getLimit())
            ->setStatus(PostStatus::ANY);

        if (!current_user_can('manage_options')) {
            $query->userIn(get_current_user_id());
        }

        return $query->get();
    }

    public function getModerationModels(): Collection
    {
        if (!current_user_can('manage_options')) {
            return tdf_collect();
        }

        return tdf_query_models()
            ->setPage($this->getPage())
            ->take($this->getLimit())
            ->setStatus(PostStatus::ANY)
            ->get();
    }

    public function getInitialModel(): array
    {
        if (empty($_GET['id'])) {
            return $this->getDefaultModel();
        }

        $model = $this->getModel((int)$_GET['id']);
        if (!$model) {
            return $this->getDefaultModel();
        }

        return $model;
    }

    private function getDefaultModel(): array
    {
        return [
            'name' => '',
            'description' => '',
            'attributes' => [],
        ];
    }

    /**
     * @param int $id
     * @return array|false
     */
    private function getModel(int $id)
    {
        $model = tdf_post_factory()->create($id);
        if (!$model instanceof Model) {
            return false;
        }

        $modelData = [
            'id' => $id,
            'name' => $model->getName(),
            'description' => tdf_settings()->isDescriptionSimpleEditorEnabled() ? $model->getDescription() : wpautop($model->getDescription()),
            'attributes' => [],
        ];

        foreach (tdf_app('panel_fields') as $field) {
            if (!$field instanceof CustomPanelField) {
                continue;
            }

            $modelData['attributes'][] = $field->getModelAttribute($model);
        }

        return $modelData;
    }

    public function get_style_depends(): array
    {
        return array_merge(['sweetalert2', 'dropzone'], $this->getMapStyleDeps());
    }

    public function getPackageId(): int
    {
        if (!is_user_logged_in()) {
            return 0;
        }

        $packageId = (int)($_GET['package'] ?? 0);
        if (empty($packageId)) {
            return 0;
        }

        /** @noinspection NullPointerExceptionInspection */
        $package = tdf_current_user()->getPaymentPackage($packageId);
        if (!$package) {
            return 0;
        }

        return $packageId;
    }

    public function getPackage(): ?RegularUserPaymentPackage
    {
        $package = $this->getModelPackage();
        if ($package) {
            return $package;
        }

        $packageId = $this->getPackageId();
        if (empty($packageId)) {
            return null;
        }

        $package = tdf_current_user()->getPaymentPackage($packageId);
        if (!$package) {
            return null;
        }

        return $package;
    }

    private function getModelPackage(): ?RegularUserPaymentPackage
    {
        if (empty($_GET['id'])) {
            return null;
        }

        $model = tdf_model_factory()->create((int)$_GET['id']);
        if (!$model instanceof Model) {
            return null;
        }

        $package = $model->getAssignedPackage();
        if ($package instanceof RegularUserPaymentPackage) {
            return $package;
        }

        $package = $model->getPendingPackage();
        if ($package instanceof RegularUserPaymentPackage) {
            return $package;
        }

        return null;
    }

    public function getTitle(): string
    {
        $action = self::getAction();

        if ($action === self::ACTION_LIST) {
            return tdf_string('my_listings');
        }

        return parent::getTitle();
    }

    private function addStyleSections(): void
    {
        $this->addGeneralStyleSection();

        $this->addUserMenuStyleSection();

        $this->addTabsStyleSection();

        $this->addListingCardStyleSection();

        $this->addFormStyleSection();

        $this->addFieldHintStyleSection();
    }

    private function addListingCardStyleSection(): void
    {
        $this->startStyleControlsSection('listing_card_style', esc_html__('Ad card', 'listivo-core'));

        $this->add_control(
            'listing_card_name_heading',
            [
                'label' => esc_html__('Name', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listing_card_name_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__name' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'listing_card_name_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-panel-listing-card-v2__name',
            ]
        );

        $this->add_control(
            'listing_card_category_heading',
            [
                'label' => esc_html__('Category', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listing_card_category_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__category' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'listing_card_category_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-panel-listing-card-v2__category',
            ]
        );

        $this->add_control(
            'listing_card_category_border_color',
            [
                'label' => esc_html__('Border color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__category' => 'border-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listing_card_category_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__category' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listing_card_date_label_heading',
            [
                'label' => esc_html__('Date label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listing_card_date_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__date span' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'listing_card_date_label_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-panel-listing-card-v2__date span',
            ]
        );

        $this->add_control(
            'listing_card_date_value_heading',
            [
                'label' => esc_html__('Date value', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listing_card_date_value_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__date:not(span)' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'listing_card_date_value_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-panel-listing-card-v2__date:not(span)',
            ]
        );

        $this->add_control(
            'listing_card_main_value_heading',
            [
                'label' => esc_html__('Main value', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listing_card_main_value_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__main-value' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'listing_card_main_value_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-panel-listing-card-v2__main-value',
            ]
        );

        $this->add_control(
            'listing_card_stats_heading',
            [
                'label' => esc_html__('Stats', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listing_card_stats_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__stat-icon path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__stat-value' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listing_card_stats_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__stats' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'listing_card_stats_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-panel-listing-card-v2__stat-value',
            ]
        );

        $this->add_control(
            'listing_card_primary_button_heading',
            [
                'label' => esc_html__('Primary button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listing_card_primary_button_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__primary-button path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__primary-button' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listing_card_primary_button_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__primary-button' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listing_card_secondary_button_heading',
            [
                'label' => esc_html__('Secondary button', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listing_card_secondary_button_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__secondary-button path' => 'fill: {{VALUE}};',
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__secondary-button' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listing_card_secondary_button_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-listing-card-v2__secondary-button' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

    private function addGeneralStyleSection(): void
    {
        $this->startStyleControlsSection();

        $this->add_control(
            'section_background',
            [
                'label' => esc_html__('Section background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-section' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

    private function addUserMenuStyleSection(): void
    {
        $this->startStyleControlsSection('menu_style', esc_html__('Menu', 'listivo-core'));

        $this->add_control(
            'item_heading',
            [
                'label' => esc_html__('Item', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'item_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-menu__item:not(.listivo-panel-menu__item--active)' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'item_hover_color',
            [
                'label' => esc_html__('Hover color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-menu__item:not(.listivo-panel-menu__item--active):hover' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'item_typography',
                'selector' => '{{WRAPPER}} .listivo-panel-menu__item:not(.listivo-panel-menu__item--active)',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Hover typography', 'listivo-core'),
                'name' => 'item_hover_typography',
                'selector' => '{{WRAPPER}} .listivo-panel-menu__item:not(.listivo-panel-menu__item--active):hover',
            ]
        );

        $this->add_control(
            'active_item_heading',
            [
                'label' => esc_html__('Active item', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'active_item_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-menu__item--active' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'active_item_typography',
                'selector' => '{{WRAPPER}} .listivo-panel-menu__item--active',
            ]
        );

        $this->add_control(
            'active_item_underline_color',
            [
                'label' => esc_html__('Underline color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-menu__item--active' => 'border-bottom-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'menu_count_heading',
            [
                'label' => esc_html__('Count', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'menu_count_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-menu__count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'menu_count_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-menu__count' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

    private function addTabsStyleSection(): void
    {
        $this->startStyleControlsSection('tabs_style', esc_html__('Tabs', 'listivo-core'));

        $this->add_control(
            'tab_border_radius',
            [
                'label' => esc_html__('Border radius (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-tab' => 'border-radius: {{VALUE}}px;',
                ]
            ]
        );

        $this->add_control(
            'tab_heading',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'tab_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-tab:not(.listivo-panel-tab--active)' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'tab_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-tab:not(.listivo-panel-tab--active)' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'tab_count_color',
            [
                'label' => esc_html__('Number color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-tab:not(.listivo-panel-tab--active) .listivo-panel-tab__count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'tab_count_background',
            [
                'label' => esc_html__('Number background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-tab:not(.listivo-panel-tab--active) .listivo-panel-tab__count' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'tab_active_heading',
            [
                'label' => esc_html__('Active', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'tab_active_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-tab--active' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'tab_active_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-tab--active' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'tab_active_count_color',
            [
                'label' => esc_html__('Number color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-tab--active .listivo-panel-tab__count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'tab_active_count_background',
            [
                'label' => esc_html__('Number background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-panel-tab--active .listivo-panel-tab__count' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }

    private function addFieldHintStyleSection(): void
    {
        $this->startStyleControlsSection('field_hint_style', esc_html__('Field Hint', 'listivo-core'));

        $this->add_control(
            'field_hint_icon_color',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-field-hint__icon svg path' => 'fill: {{VALUE}};',
                ]
            ]
        );


        $this->add_control(
            'field_hint_style_text_heading',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'field_hint_text_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-field-hint__text' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'field_hint_text_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-field-hint__text' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-field-hint__text:before' => 'border-color: transparent {{VALUE}} transparent transparent;',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'field_hint_text_typo',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-field-hint__text',
            ]
        );

        $this->add_responsive_control(
            'field_hint_text_width',
            [
                'label' => esc_html__('Width (px)', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'selectors' => [
                    '{{WRAPPER}} .listivo-field-hint__text' => 'max-width: {{VALUE}}px; min-width: {{VALUE}}px;',
                ]
            ]
        );

        $this->add_responsive_control(
            'field_hint_text_padding',
            [
                'label' => esc_html__('Padding', 'listivo-core'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors' => [
                    '{{WRAPPER}} .listivo-field-hint__text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ],
            ]
        );

        $this->endControlsSection();
    }

    private function addFormStyleSection(): void
    {
        $this->startStyleControlsSection('form_style', esc_html__('Form', 'listivo-core'));

        $this->add_control(
            'form_field_asterisk_color',
            [
                'label' => esc_html__('Asterisk', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-field-group__label span' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .listivo-panel-form-label__text span' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->endControlsSection();
    }
}