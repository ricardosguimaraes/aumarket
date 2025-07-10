<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Exception;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Search\SearchField;
use Tangibledesign\Framework\Search\SearchModels;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\PopularTermsControls;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SearchFieldsControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SimpleLabelControl;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

abstract class HeroSearchWidget extends BaseGeneralWidget
{
    use SearchFieldsControl;
    use PopularTermsControls;
    use SimpleLabelControl;

    /**
     * @param $data
     * @param $args
     * @throws Exception
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $this->registerMapDeps();
    }

    /**
     * @return array
     */
    public function get_script_depends(): array
    {
        return ['google-maps'];
    }

    protected function addHeadingControl(): void
    {
        $this->add_control(
            'heading',
            [
                'label' => esc_html__('Heading', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getHeading(): string
    {
        return (string)$this->get_settings_for_display('heading');
    }

    protected function addTextControl(): void
    {
        $this->add_control(
            'text',
            [
                'label' => esc_html__('Text', 'listivo-core'),
                'type' => Controls_Manager::TEXTAREA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return (string)$this->get_settings_for_display('text');
    }

    protected function addTermsControl(): void
    {
        $fields = new Repeater();

        $fields->add_control(
            'image',
            [
                'label' => esc_html__('Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $fields->add_control(
            'taxonomy',
            [
                'label' => esc_html__('Taxonomy', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getTaxonomyFieldOptions(),
            ]
        );

        foreach (tdf_taxonomy_fields() as $taxonomy) {
            $fields->add_control(
                'term_'.$taxonomy->getKey(),
                [
                    'label' => esc_html__('Term', 'listivo-core'),
                    'type' => SelectRemoteControl::TYPE,
                    'source' => $taxonomy->getApiEndpoint(),
                    'prevent_empty' => false,
                    'condition' => [
                        'taxonomy' => $taxonomy->getKey(),
                    ]
                ]
            );
        }

        $this->add_control(
            'terms',
            [
                'label' => esc_html__('Categories', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
            ]
        );
    }

    /**
     * @return array
     */
    protected function getTaxonomyFieldOptions(): array
    {
        $options = [];

        foreach (tdf_taxonomy_fields() as $taxonomy) {
            $options[$taxonomy->getKey()] = $taxonomy->getName();
        }

        return $options;
    }

    /**
     * @return Collection
     */
    public function getTerms(): Collection
    {
        $terms = $this->get_settings_for_display('terms');
        if (!is_array($terms) || empty($terms)) {
            return tdf_collect();
        }

        return tdf_collect($terms)
            ->map(static function ($data) {
                $termId = (int)($data['term_'.$data['taxonomy']] ?? 0);
                if (empty($termId)) {
                    return false;
                }

                $term = tdf_term_factory()->create($termId);
                if (!$term) {
                    return false;
                }

                $data['term'] = $term;

                return $data;
            })
            ->filter(static function ($data) {
                return $data !== false;
            });
    }

    /**
     * @return Collection|SearchField[]
     */
    public function getFields(): Collection
    {
        return $this->getSearchFields('fields');
    }

    /**
     * @param  array  $params
     * @return array
     */
    public function getTermCount(array $params = []): array
    {
        if (!isset($params['filters'])) {
            return (new SearchModels($params))->getTermsCount();
        }

        return (new SearchModels($params))
            ->getTermsCount($params['filters']);
    }

    protected function addWhatsPopularSection(): void
    {
        $this->startContentControlsSection('popular_terms', esc_html__('Popular Terms', 'listivo-core'));

        $this->addLabelControl(esc_html__("What's popular:", 'listivo-core'));

        $this->addTaxonomyControl();

        $this->addLimitControl('', 4);

        $this->addRandomizeControls();

        $this->endControlsSection();
    }

    /**
     * @return string
     */
    public function getPopularTermsLabel(): string
    {
        $label = $this->getLabel();
        if (empty($label)) {
            return tdf_string('whats_popular');
        }

        return $label;
    }

}