<?php


namespace Tangibledesign\Listivo\Widgets\General;


use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Template\TemplateType\ModelArchiveTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\ModelSingleTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\TemplateType;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\JustifyContentResponsiveControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SocialShareControls;
use Tangibledesign\Framework\Widgets\Helpers\HasBreadcrumbs;
use Tangibledesign\Framework\Widgets\Helpers\HasModel;


/**
 * Class BreadcrumbsWidget
 * @package Tangibledesign\Listivo\Widgets\General
 */
class BreadcrumbsWidget extends BaseGeneralWidget
{
    use HasBreadcrumbs;
    use HasModel;
    use JustifyContentResponsiveControl;
    use SocialShareControls;

    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'breadcrumbs';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Breadcrumbs', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startStyleControlsSection();

        $this->addJustifyContentControl('.listivo-breadcrumbs');

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'typography',
                'label' => esc_html__('Typography', 'listivo-core'),
                'selector' => '{{WRAPPER}} .listivo-breadcrumbs'
            ]
        );

        $this->add_control(
            'color',
            [
                'label' => esc_html__('Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-breadcrumbs__link' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'color_hover',
            [
                'label' => esc_html__('Color Hover', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-breadcrumbs__link:hover' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'color_last',
            [
                'label' => esc_html__('Color Last Element', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-breadcrumbs__last' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_control(
            'separator_color',
            [
                'label' => esc_html__('Separator Color', 'listivo-core'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .listivo-breadcrumbs__separator svg' => 'fill: {{VALUE}};'
                ]
            ]
        );

        $this->endControlsSection();
    }

    /**
     * @param TemplateType|false $templateType
     * @return array
     * @noinspection NotOptimalIfConditionsInspection
     */
    public function getCustomBreadcrumbs($templateType): array
    {
        if (is_singular(tdf_model_post_type()) || $templateType instanceof ModelSingleTemplateType) {
            return $this->getListingBreadcrumbs();
        }

        if (is_post_type_archive(tdf_model_post_type()) || $templateType instanceof ModelArchiveTemplateType) {
            return $this->getListingArchiveBreadcrumbs();
        }

        return [];
    }

    /**
     * @return array
     */
    private function getListingBreadcrumbs(): array
    {
        $breadcrumbs = $this->getBaseBreadcrumbs();

        $model = $this->getModel();
        if (!$model) {
            return $breadcrumbs;
        }

        $baseUrl = get_post_type_archive_link(tdf_model_post_type());

        $breadcrumbs[] = [
            'key' => 'search_results',
            'name' => tdf_string('search_results'),
            'url' => $baseUrl,
        ];

        $currentTerms = tdf_collect();

        foreach (tdf_app('breadcrumbs_taxonomies') as $taxonomy) {
            if ($taxonomy->isMultilevel()) {
                $terms = $taxonomy->getMultilevelValue($model);
            } else {
                $terms = $taxonomy->getValue($model);
                if ($terms->isNotEmpty()) {
                    $terms = tdf_collect([$terms->first()]);
                }
            }

            if ($terms->isEmpty()) {
                break;
            }

            foreach ($terms as $term) {
                $currentTerms[] = $term;

                $breadcrumbs[] = [
                    'key' => $term->getKey(),
                    'name' => $term->getName(),
                    'url' => apply_filters(
                        'listivo/breadcrumbs/listing/url',
                        $baseUrl,
                        $currentTerms
                    ),
                ];
            }
        }

        $breadcrumbs[] = [
            'key' => $model->getKey(),
            'name' => $model->getName(),
            'url' => $model->getUrl(),
        ];

        return $breadcrumbs;
    }

    /**
     * @return array
     */
    private function getListingArchiveBreadcrumbs(): array
    {
        $args = $_GET;

        foreach (tdf_app('breadcrumbs_taxonomies') as $taxonomy) {
            /* @var TaxonomyField $taxonomy */
            $value = get_query_var($taxonomy->getKey());
            if (!empty($value)) {
                $args[$taxonomy->getSlug()] = $value;
            }
        }

        return apply_filters('listivo/breadcrumbs/listings', $args);
    }

}