<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Template\TemplateType\ModelArchiveTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\ModelSingleTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\TemplateType;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\Controls\JustifyContentResponsiveControl;
use Tangibledesign\Framework\Widgets\Helpers\Controls\SocialShareControls;
use Tangibledesign\Framework\Widgets\Helpers\HasBreadcrumbs;
use Tangibledesign\Framework\Widgets\Helpers\HasModel;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\BreadcrumbsStyleSection;
use Tangibledesign\Listivo\Widgets\Helpers\Controls\ShareIconsStyleSection;

class BreadcrumbsV2Widget extends BaseGeneralWidget
{
    use HasBreadcrumbs;
    use HasModel;
    use BreadcrumbsStyleSection;
    use JustifyContentResponsiveControl;
    use ShareIconsStyleSection;
    use SocialShareControls;

    public function getKey(): string
    {
        return 'breadcrumbs_v2';
    }

    public function getName(): string
    {
        return esc_html__('Breadcrumbs V2', 'listivo-core');
    }

    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addSocialShareControls();

        $this->endControlsSection();

        $this->addBreadcrumbsStyleSection();

        $this->addSocialShareIconsStyleSection();
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

    private function getListingBreadcrumbs(): array
    {
        $breadcrumbs = $this->getBaseBreadcrumbs();

        $listing = $this->getModel();
        if (!$listing) {
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
                $terms = $taxonomy->getMultilevelValue($listing);
            } else {
                $terms = $taxonomy->getValue($listing);
                if ($terms->isNotEmpty()) {
                    $terms = tdf_collect([$terms->first()]);
                }
            }

            if ($terms->isEmpty()) {
                continue;
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
            'key' => $listing->getKey(),
            'name' => $listing->getName(),
            'url' => $listing->getUrl(),
        ];

        return $breadcrumbs;
    }

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