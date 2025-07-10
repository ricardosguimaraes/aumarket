<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Controls_Manager;
use Elementor\Repeater;
use Exception;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Search\SearchModels;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\AlignmentModifierControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SearchFieldsControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\WidthControl;

/**
 * Class SearchFormWidget
 * @package Tangibledesign\Listivo\Widgets\General
 */
class SearchFormWidget extends BaseGeneralWidget
{
    use SearchFieldsControl;
    use WidthControl;
    use AlignmentModifierControl;

    public const FIELDS = 'fields';

    /**
     * MapWidget constructor.
     * @param  array  $data
     * @param  null  $args
     * @throws Exception
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $this->registerMapDeps();
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'search_form';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Search Form', 'listivo-core');
    }

    /**
     * @return array
     */
    public function get_script_depends(): array
    {
        return ['google-maps'];
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addFieldsControl();

        $this->addAlignControl();

        $this->addMaxWidthControl('.listivo-search');

        $this->endControlsSection();
    }

    protected function addFieldsControl(): void
    {
        $fields = new Repeater();

        $options = $this->getFieldOptions();

        $fields->add_control(
            'field',
            [
                'label' => tdf_admin_string('field'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
            ]
        );

        $this->addTaxonomyFieldSettings($fields);

        $this->addNumberFieldSettings($fields);

        $this->addPriceFieldSettings($fields);

        $this->addTextFieldSettings($fields);

        $this->addLocationFieldSettings($fields, false);

        $this->addKeywordFieldSettings($fields);

        $this->add_control(
            self::FIELDS,
            [
                'label' => esc_html__('Fields', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getFields(): Collection
    {
        return $this->getSearchFields(self::FIELDS);
    }

    /**
     * @return array
     */
    public function getTermCount(): array
    {
        return (new SearchModels())->getTermsCount();
    }

}