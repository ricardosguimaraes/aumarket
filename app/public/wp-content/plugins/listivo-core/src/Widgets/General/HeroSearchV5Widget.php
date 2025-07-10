<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Exception;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Search\SearchField;
use Tangibledesign\Framework\Search\SearchModels;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SearchFields\SearchFieldsControl;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

class HeroSearchV5Widget extends BaseGeneralWidget
{
    use SearchFieldsControl;

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
     * @return string
     */
    public function getKey(): string
    {
        return 'hero_search_v5';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Hero Search V5', 'listivo-core');
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

        $this->addHeadingControl();

        $this->addBackgroundImageControl();

        $this->addTermsControl();

        $this->endControlsSection();

        $this->startContentControlsSection(
            'listivo_hero_v4_search_form',
            esc_html__('Search Form', 'listivo-core')
        );

        $this->addMainFieldControls();

        $fields = new Repeater();

        $this->addSearchFieldsControls($fields);

        $this->add_control(
            'fields',
            [
                'label' => esc_html__('Fields', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
                'title_field' => "<# "
                    ."let labels = ".json_encode($this->getFieldOptions())."; "
                    ."let label = labels[field]; "
                    ."#>"
                    ."{{{ label }}}",
            ]
        );

        $this->endControlsSection();
    }

    private function addHeadingControl(): void
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
        $heading = $this->get_settings_for_display('heading');
        if (empty($heading)) {
            return '';
        }

        return $heading;
    }

    private function addBackgroundImageControl(): void
    {
        $this->add_control(
            'background_image',
            [
                'label' => esc_html__('Background Image', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );
    }

    /**
     * @return string
     */
    public function getBackgroundImage(): string
    {
        $data = $this->get_settings_for_display('background_image');

        return $data['url'] ?? '';
    }

    /**
     * @return Collection|SearchField[]
     */
    public function getFields(): Collection
    {
        return $this->getSearchFields('fields');
    }

    /**
     * @return array
     */
    public function getTermCount(): array
    {
        return (new SearchModels())->getTermsCount();
    }

    private function addTermsControl(): void
    {
        $terms = new Repeater();

        $terms->add_control(
            'image',
            [
                'label' => esc_html__('Icon', 'listivo-core'),
                'type' => Controls_Manager::MEDIA,
            ]
        );

        $terms->add_control(
            'taxonomy',
            [
                'label' => esc_html__('Taxonomy', 'listivo-core'),
                'type' => Controls_Manager::SELECT,
                'options' => tdf_app('taxonomy_list'),
            ]
        );

        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            $terms->add_control(
                'term_'.$taxonomyField->getKey(),
                [
                    'label' => esc_html__('Term', 'listivo-core'),
                    'type' => SelectRemoteControl::TYPE,
                    'source' => $taxonomyField->getApiEndpoint(),
                    'multiple' => false,
                    'condition' => [
                        'taxonomy' => $taxonomyField->getKey(),
                    ]
                ]
            );
        }

        $this->add_control(
            'terms',
            [
                'label' => esc_html__('Terms', 'listivo-core'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $terms->get_controls(),
                'prevent_empty' => false,
            ]
        );
    }

    /**
     * @return Collection
     */
    public function getTerms(): Collection
    {
        $tabs = $this->get_settings_for_display('terms');

        if (empty($tabs) || !is_array($tabs)) {
            return tdf_collect();
        }

        return tdf_collect($tabs)
            ->map(static function ($tab) {
                $taxonomyKey = $tab['taxonomy'];
                if (empty($taxonomyKey)) {
                    return false;
                }

                $termId = (int)$tab['term_'.$taxonomyKey];
                if (empty($termId)) {
                    return false;
                }

                $term = tdf_term_factory()->create($termId);
                if (!$term) {
                    return false;
                }

                return [
                    'image' => $tab['image']['url'] ?? '',
                    'label' => $term->getName(),
                    'url' => $term->getUrl(),
                ];
            })
            ->filter(static function ($term) {
                return $term !== false && $term !== null;
            });
    }

}