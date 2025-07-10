<?php

namespace Tangibledesign\Listivo\Elementor;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Tab_Base;
use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\SalaryField;

class ListingCardTab extends Tab_Base
{
    public function get_id(): string
    {
        return 'listivo-listing-card';
    }

    public function get_title(): string
    {
        return esc_html__('Ad Card', 'listivo-core');
    }

    public function get_group(): string
    {
        return 'theme-style';
    }

    public function get_icon(): string
    {
        return 'fas fa-paint-brush';
    }

    protected function register_tab_controls(): void
    {
        $this->start_controls_section(
            'listivo_listing_card',
            [
                'label' => esc_html__('Listivo Ad Card', 'listivo-core'),
                'tab' => $this->get_id(),
            ]
        );

        $this->addLabelControls();

        $this->addMainValueControls();

        $this->addGalleryFieldControl();

        $this->addGalleryControls();

        $this->addAttributesControl();

        $this->addRowAttributesControl();

        $this->addLocationTypeControl();

        $this->addShowUserControl();

        $this->addShowViewsControl();

        $this->addCardImageSizeControl();

        $this->addRowImageSizeControl();

        $this->addUserPhoneControls();

        $this->addNameControls();


        $this->addFeaturedLabelControls();

        $this->addLocationIconControls();

        $this->addAddressControls();

        $this->addAttributeStyleControls();

        $this->addPriceStyleControls();

        $this->addUserControls();

        $this->addMetaStyleControls();

        $this->addDescriptionControls();

        $this->addRatingStyleControls();

        $this->addCardV4Controls();

        $this->addRowV2Controls();

        $this->end_controls_section();
    }

    private function addCardImageSizeControl(): void
    {
        $this->add_control(
            'listivo_listing_card_image_size',
            [
                'label' => esc_html__('Card Image Size', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => tdf_app('image_size_options'),
                'default' => tdf_prefix() . '_360_240',
            ]
        );
    }

    private function addRowImageSizeControl(): void
    {
        $this->add_control(
            'listivo_listing_row_image_size',
            [
                'label' => esc_html__('Row Image Size', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => tdf_app('image_size_options'),
                'default' => tdf_prefix() . '_360_240',
            ]
        );
    }

    private function addMainValueControls(): void
    {
        $fields = tdf_ordered_fields()->filter(static function ($field) {
            return $field instanceof PriceField || $field instanceof SalaryField;
        });

        $options = [];

        foreach ($fields as $field) {
            /*  @var Field $field */
            $options[$field->getKey()] = $field->getName();
        }

        $this->add_control(
            'listivo_listing_main_value',
            [
                'label' => esc_html__('Main Value Field', 'listivo-core'),
                'type' => Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => $options,
            ]
        );

        $this->add_control(
            'listivo_listing_main_value_when_empty',
            [
                'label' => esc_html__('Main Value When Empty', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
            ]
        );
    }

    private function addAttributesControl(): void
    {
        $options = [];
        foreach (tdf_simple_text_value_fields() as $field) {
            $options[tdf_prefix() . '_' . $field->getId()] = $field->getName();
        }

        $fields = new Repeater();

        $fields->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $fields->add_control(
            'field',
            [
                'label' => esc_html__('Field', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
            ]
        );

        $this->add_control(
            'listivo_listing_attributes',
            [
                'label' => esc_html__('Attributes', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    private function addRowAttributesControl(): void
    {
        $options = [];
        foreach (tdf_simple_text_value_fields() as $field) {
            $options[tdf_prefix() . '_' . $field->getId()] = $field->getName();
        }

        $fields = new Repeater();

        $fields->add_control(
            'icon',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::ICONS,
            ]
        );

        $fields->add_control(
            'field',
            [
                'label' => esc_html__('Field', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
            ]
        );

        $this->add_control(
            'listivo_row_listing_attributes',
            [
                'label' => esc_html__('Row attributes', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    private function addLabelControls(): void
    {
        $this->add_control(
            'listivo_listing_card_label_type',
            [
                'label' => esc_html__('Label type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'default' => esc_html__('Default', 'listivo-core'),
                    'featured' => esc_html__('Featured only', 'listivo-core'),
                ],
                'default' => 'default',
            ]
        );

        $options = [
            'featured' => esc_html__('Featured', 'listivo-core'),
        ];

        foreach (tdf_taxonomy_fields() as $field) {
            $options[$field->getKey()] = $field->getName();
        }

        foreach (tdf_text_fields() as $field) {
            $options[$field->getKey()] = $field->getName();
        }

        $fields = new Repeater();

        $fields->add_control(
            'value',
            [
                'label' => esc_html__('Value', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
            ]
        );

        $this->add_control(
            'listivo_listing_card_label',
            [
                'label' => esc_html__('Label', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
                'condition' => [
                    'listivo_listing_card_label_type' => 'default',
                ]
            ]
        );
    }

    private function addGalleryFieldControl(): void
    {
        if (tdf_gallery_fields()->count() <= 1) {
            return;
        }

        $fields = tdf_gallery_fields();

        $options = [];
        foreach ($fields as $field) {
            $options[$field->getKey()] = $field->getName();
        }

        $this->add_control(
            'listivo_listing_card_gallery_field',
            [
                'label' => esc_html__('Gallery Field', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
            ]
        );
    }

    private function addGalleryControls(): void
    {
        $this->add_control(
            'listivo_listing_card_gallery',
            [
                'label' => esc_html__('Gallery', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'listivo_listing_card_max_images',
            [
                'label' => esc_html__('Max Image Number', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => 20,
                'condition' => [
                    'listivo_listing_card_gallery' => '1',
                ]
            ]
        );

        $this->add_control(
            'listivo_listing_card_active_color',
            [
                'label' => esc_html__('Active color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v3__pagination .listivo-swiper-pagination-bullet-active:before' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-v4__pagination .listivo-swiper-pagination-bullet-active:before' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row__pagination .listivo-swiper-pagination-bullet-active:before' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__pagination .listivo-swiper-pagination-bullet-active:before' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addLocationTypeControl(): void
    {
        $options = [
            'user_location' => esc_html__('User Location', 'listivo-core'),
        ];

        foreach (tdf_location_fields() as $field) {
            $options[$field->getKey()] = $field->getName();
        }

        foreach (tdf_text_fields() as $field) {
            $options[$field->getKey()] = $field->getName();
        }

        $fields = new Repeater();

        $fields->add_control(
            'field',
            [
                'label' => esc_html__('Type', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
            ]
        );

        $this->add_control(
            'listivo_listing_card_location',
            [
                'label' => esc_html__('Location', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    private function addShowUserControl(): void
    {
        $this->add_control(
            'listivo_listing_card_show_user',
            [
                'label' => esc_html__('Display User', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    private function addShowViewsControl(): void
    {
        $this->add_control(
            'listivo_listing_card_show_views',
            [
                'label' => esc_html__('Display Views', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );
    }

    private function addFeaturedLabelControls(): void
    {
        $this->add_control(
            'listivo_listing_card_label_heading',
            [
                'label' => esc_html__('Featured Label', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_listing_card_label_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v3__label--featured' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-v4__label--featured' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row__featured' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__featured' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__label--featured' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-v3__featured' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-v4__featured' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_listing_card_label_bg_color',
            [
                'label' => esc_html__('Background Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v3__label--featured' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-v4__label--featured' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row__featured' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__featured' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__label--featured' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-v3__featured' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-v4__featured' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'listivo_listing_card_label_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => $this->getWrapper() . ' .listivo-listing-card-v3__label--featured, ' . $this->getWrapper() . ' .listivo-listing-card-v4__label--featured, ' . $this->getWrapper() . ' .listivo-listing-card-row__featured, ' . $this->getWrapper() . ' .listivo-listing-card-row-v2__featured, ' . $this->getWrapper() . ' .listivo-listing-card-v3__featured, ' . $this->getWrapper() . ' .listivo-listing-card-v4__featured',
            ]
        );
    }

    private function addAddressControls(): void
    {
        $this->add_control(
            'card_address_heading',
            [
                'label' => esc_html__('Address', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'card_address_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v3__address' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-v4__address' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row__address' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__address' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'card_address_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => $this->getWrapper() . ' .listivo-listing-card-address-selector',
            ]
        );
    }

    private function addLocationIconControls(): void
    {
        $this->add_control(
            'listivo_listing_card_location_icon_label',
            [
                'label' => esc_html__('Location icon', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'listivo_listing_card_location_icon_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v3__address-icon path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-v4__address-icon path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row__address-icon path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__address-icon path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-quick-view__address-icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'listivo_listing_card_location_icon_bg',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v3__address-icon' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-v4__address-icon' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row__address-icon' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__address-icon' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-quick-view__address-icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addAttributeStyleControls(): void
    {
        $this->add_control(
            'attributes_style_heading',
            [
                'label' => esc_html__('Attributes', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'attributes_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v3__attribute' => 'color: {{VALUE}}',
                    $this->getWrapper() . ' .listivo-listing-card-v3__attribute path' => 'fill: {{VALUE}}',
                    $this->getWrapper() . ' .listivo-listing-card-v4__attribute' => 'color: {{VALUE}}',
                    $this->getWrapper() . ' .listivo-listing-card-v4__attribute path' => 'fill: {{VALUE}}',
                    $this->getWrapper() . ' .listivo-listing-card-row__attribute' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row__attribute path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__category' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__category path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'attributes_background',
            [
                'label' => esc_html__('Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v3__attribute' => 'background-color: {{VALUE}}',
                    $this->getWrapper() . ' .listivo-listing-card-v4__attribute' => 'background-color: {{VALUE}}',
                    $this->getWrapper() . ' .listivo-listing-card-row__attribute' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addPriceStyleControls(): void
    {
        $this->add_control(
            'card_price_style_heading',
            [
                'label' => esc_html__('Price', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'card_price_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-value-selector' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'card_price_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => $this->getWrapper() . ' .listivo-listing-card-value-selector',
            ]
        );
    }

    private function addUserControls(): void
    {
        $this->add_control(
            'card_user_heading',
            [
                'label' => esc_html__('User', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'card_user_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-user-selector' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'card_user_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => $this->getWrapper() . ' .listivo-listing-card-user-selector',
            ]
        );

        $this->add_control(
            'card_user_icon_color',
            [
                'label' => esc_html__('Icon Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-user-icon-selector path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'card_user_icon_bg',
            [
                'label' => esc_html__('Icon Background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-user-icon-selector' => 'background-color: {{VALUE}};',
                ]
            ]
        );
    }

    private function addDescriptionControls(): void
    {
        $this->add_control(
            'card_description_heading',
            [
                'label' => esc_html__('Description', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'card_description_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-description-selector' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'card_description_typo',
                'selector' => $this->getWrapper() . ' .listivo-listing-card-description-selector',
            ]
        );
    }

    private function addCardV4Controls(): void
    {
        $this->add_control(
            'card_v4_heading',
            [
                'label' => esc_html__('Card V2', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'card_v4_show_description',
            [
                'label' => esc_html__('Description', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'card_v4_description_lines',
            [
                'label' => esc_html__('Description max lines number', 'listivo-core'),
                'type' => Controls_Manager::NUMBER,
                'default' => '2',
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v4__description' => '-webkit-line-clamp: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'card_v4_date',
            [
                'label' => esc_html__('Date', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'card_v4_user',
            [
                'label' => esc_html__('Display user', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'card_v4_rating',
            [
                'label' => esc_html__('Rating', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'listivo-core'),
                    'user' => esc_html__('User Rating', 'listivo-core'),
                    'listing' => esc_html__('Ad Rating', 'listivo-core'),
                ],
                'default' => 'none',
            ]
        );

        $this->add_control(
            'card_v4_show_ratings_count',
            [
                'label' => esc_html__('Display Ratings Number', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
                'condition' => [
                    'card_v4_rating' => ['user', 'listing'],
                ]
            ]
        );

        $this->addAccountTypeControls();
    }

    private function addRowV2Controls(): void
    {
        $this->add_control(
            'row_v2_heading',
            [
                'label' => esc_html__('Row V2', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_responsive_control(
            'row_v2_height',
            [
                'label' => esc_html__('Height', 'listivo-core'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', 'vh'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 800,
                    ],
                    'vh' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-row-v2' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'row_v2_date',
            [
                'label' => esc_html__('Date', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'row_v2_user',
            [
                'label' => esc_html__('Display user', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
            ]
        );

        $this->add_control(
            'row_v2_rating',
            [
                'label' => esc_html__('Rating', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__('None', 'listivo-core'),
                    'user' => esc_html__('User Rating', 'listivo-core'),
                    'listing' => esc_html__('Ad Rating', 'listivo-core'),
                ],
                'default' => 'none',
            ]
        );

        $this->add_control(
            'row_v2_show_ratings_count',
            [
                'label' => esc_html__('Display Ratings Number', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
                'condition' => [
                    'row_v2_rating' => ['user', 'listing'],
                ]
            ]
        );
    }

    private function addRatingStyleControls(): void
    {
        $this->add_control(
            'card_rating_style_heading',
            [
                'label' => esc_html__('Rating', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'card_rating_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v4__rating' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__rating' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'card_rating_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => $this->getWrapper() . ' .listivo-listing-card-v4__rating, ' . $this->getWrapper() . ' .listivo-listing-card-row-v2__rating',
            ]
        );

        $this->add_control(
            'card_rating_stars_heading',
            [
                'label' => esc_html__('Rating Stars', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->start_controls_tabs('card_rating_stars_tabs');

        $this->start_controls_tab(
            'card_rating_stars_normal_tab',
            [
                'label' => esc_html__('Normal', 'listivo-core'),
            ]
        );

        $this->add_control(
            'card_rating_stars_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v4__stars .listivo-listing-card-v4__star:not(.listivo-listing-card-v4__star--active) path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__stars .listivo-listing-card-row-v2__star:not(.listivo-listing-card-row-v2__star--active) path' => 'fill: {{VALUE}};',

                ]
            ]
        );

        $this->add_control(
            'card_rating_stars_border',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v4__stars .listivo-listing-card-v4__star:not(.listivo-listing-card-v4__star--active) path' => 'stroke: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__stars .listivo-listing-card-row-v2__star:not(.listivo-listing-card-row-v2__star--active) path' => 'stroke: {{VALUE}};',

                ]
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'card_rating_stars_active_tab',
            [
                'label' => esc_html__('Active', 'listivo-core'),
            ]
        );

        $this->add_control(
            'card_rating_stars_active_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v4__stars .listivo-listing-card-v4__star--active path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__stars .listivo-listing-card-row-v2__star--active path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'card_rating_stars_active_border',
            [
                'label' => esc_html__('Border', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v4__stars .listivo-listing-card-v4__star--active path' => 'stroke: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__stars .listivo-listing-card-row-v2__star--active path' => 'stroke: {{VALUE}};',
                ]
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_control(
            'card_reviews_number_heading',
            [
                'label' => esc_html__('Reviews number', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'card_reviews_number_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-v4__rating-count' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__rating-count' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'card_reviews_number_typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => $this->getWrapper() . ' .listivo-listing-card-v4__rating-count, ' . $this->getWrapper() . ' .listivo-listing-card-row-v2__rating-count',
            ]
        );
    }

    private function addMetaStyleControls(): void
    {
        $this->add_control(
            'card_meta_style_heading',
            [
                'label' => esc_html__('Meta info', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'card_meta_icon_color',
            [
                'label' => esc_html__('Icon color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__meta-icon path' => 'fill: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-v4__meta-icon path' => 'fill: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'card_meta_icon_bg',
            [
                'label' => esc_html__('Icon background', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__meta-icon' => 'background-color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-v4__meta-icon' => 'background-color: {{VALUE}};',
                ]
            ]
        );

        $this->add_control(
            'card_meta_text_color',
            [
                'label' => esc_html__('Text color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-row-v2__meta-value' => 'color: {{VALUE}};',
                    $this->getWrapper() . ' .listivo-listing-card-v4__meta-value' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'card_meta_typo',
                'selector' => $this->getWrapper() . ' .listivo-listing-card-row-v2__meta-value, ' . $this->getWrapper() . ' .listivo-listing-card-v4__meta-value',
            ]
        );
    }

    private function addNameControls(): void
    {
        $this->add_control(
            'card_name_heading',
            [
                'label' => esc_html__('Name', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'card_name_color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    $this->getWrapper() . ' .listivo-listing-card-name-selector' => 'color: {{VALUE}};',
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'label' => esc_html__('Typography', 'listivo-core'),
                'name' => 'card_name_typo',
                'selector' => $this->getWrapper() . ' .listivo-listing-card-name-selector',
            ]
        );
    }

    private function addUserPhoneControls(): void
    {
        $this->add_control(
            'listivo_card_user_phone_heading',
            [
                'label' => esc_html__('User phone', 'listivo-core'),
                'type' => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'listivo_card_show_user_phone',
            [
                'label' => esc_html__('Show user phone', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'listivo_card_hide_user_phone_at_start',
            [
                'label' => esc_html__('Hide user phone at start', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '1',
                'condition' => [
                    'listivo_card_show_user_phone' => '1',
                ]
            ]
        );
    }

    private function addAccountTypeControls(): void
    {
        $this->add_control(
            'card_v4_show_account_type',
            [
                'label' => esc_html__('Display Account Type', 'listivo-core'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $this->add_control(
            'card_v4_account_type_label',
            [
                'label' => esc_html__('Account Type Text', 'listivo-core'),
                'type' => Controls_Manager::TEXT,
                'placeholder' => esc_html__('Account type: %s', 'listivo-core'),
                'condition' => [
                    'card_v4_show_account_type' => '1',
                ]
            ]
        );
    }

    private function getWrapper(): string
    {
        if (is_rtl()) {
            return '[dir] {{WRAPPER}}';
        }

        return '{{WRAPPER}}';
    }
}