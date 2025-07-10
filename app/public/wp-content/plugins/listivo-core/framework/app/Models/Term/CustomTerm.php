<?php

namespace Tangibledesign\Framework\Models\Term;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Post\PostStatus;
use Tangibledesign\Framework\Models\Template\Template;
use WP_Query;

class CustomTerm extends Term
{
    public const PARENT_TERMS = 'parent_terms';
    public const FIELD_DEPENDENCIES = 'field_dependencies';
    public const SEARCH_FORM_PLACEHOLDER = 'search_form_placeholder';
    public const CUSTOM_MODEL_TEMPLATE = 'custom_model_template';
    public const CARD_HIDE = 'card_hide';
    public const LABEL_COLOR = 'label_color';
    public const LABEL_BG_COLOR = 'label_bg_color';

    /**
     * @return string[]
     */
    public function getSettingKeys(): array
    {
        return [
            self::PARENT_TERMS,
            self::FIELD_DEPENDENCIES,
            self::SEARCH_FORM_PLACEHOLDER,
            self::CUSTOM_MODEL_TEMPLATE,
            self::CARD_HIDE,
            self::LABEL_COLOR,
            self::LABEL_BG_COLOR,
        ];
    }

    public function setCardHide($hide): void
    {
        $this->setMeta(self::CARD_HIDE, (int)$hide);
    }

    public function showLabel(): bool
    {
        return empty((int)$this->getMeta(self::CARD_HIDE));
    }

    /**
     * @param  string  $color
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setLabelColor($color): void
    {
        $this->setMeta(self::LABEL_COLOR, $color);
    }

    /**
     * @return string
     */
    public function getLabelColor(): string
    {
        return (string)$this->getMeta(self::LABEL_COLOR);
    }

    /**
     * @param  string  $color
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setLabelBgColor($color): void
    {
        $this->setMeta(self::LABEL_BG_COLOR, $color);
    }

    /**
     * @return string
     */
    public function getLabelBgColor(): string
    {
        return (string)$this->getMeta(self::LABEL_BG_COLOR);
    }

    /**
     * @param  string  $placeholder
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setSearchFormPlaceholder($placeholder): void
    {
        $this->setMeta(self::SEARCH_FORM_PLACEHOLDER, $placeholder);
    }

    /**
     * @return string
     */
    public function getSearchFormPlaceholder(): string
    {
        $placeholder = (string)$this->getMeta(self::SEARCH_FORM_PLACEHOLDER);
        if (empty($placeholder)) {
            return tdf_string('choose_category');
        }

        return $placeholder;
    }

    /**
     * @param  array  $termIds
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setParentTerms($termIds): void
    {
        $this->setMeta(self::PARENT_TERMS, $termIds);
    }

    /**
     * @return array
     */
    public function getParentTermIds(): array
    {
        $ids = $this->getMeta(self::PARENT_TERMS);

        if (empty($ids) || !is_array($ids)) {
            return [];
        }

        return tdf_collect($ids)->map(static function ($id) {
            return (int)$id;
        })->filter(static function ($id) {
            return !empty($id);
        })->values();
    }

    /**
     * @return Collection|CustomTerm[]
     */
    public function getParentTerms(): Collection
    {
        $taxonomyField = $this->getTaxonomyField();
        if (!$taxonomyField) {
            return tdf_collect();
        }


        if ($taxonomyField->getParentTaxonomyFields()->isEmpty()) {
            return tdf_collect();
        }

        $parentTermIds = $this->getParentTermIds();
        if (empty($parentTermIds)) {
            return tdf_collect();
        }

        return tdf_collect($parentTermIds)->map(static function ($term) {
            return tdf_term_factory()->create($term);
        })->filter(static function ($term) {
            return $term !== false && $term !== null;
        });
    }

    /**
     * @return TaxonomyField|false
     */
    public function getTaxonomyField()
    {
        foreach (tdf_taxonomy_fields() as $taxonomyField) {
            if ($taxonomyField->getKey() === $this->getTaxonomyKey()) {
                return $taxonomyField;
            }
        }

        return false;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return parent::jsonSerialize() + [
                'searchFormPlaceholder' => $this->getSearchFormPlaceholder(),
                'parentTermIds' => $this->getParentTermIds(),
                'dependencies' => $this->getFieldDependencies(),
                'hasMultilevelChildren' => $this->hasMultiLevelChildren(),
            ];
    }

    public function setFieldDependencies($dependencies = '0'): void
    {
        $this->setMeta(self::FIELD_DEPENDENCIES, $dependencies);
    }

    public function getFieldDependencies(): array
    {
        $fieldDependencies = $this->getMeta(self::FIELD_DEPENDENCIES);

        if (!is_array($fieldDependencies) || empty($fieldDependencies)) {
            return [];
        }

        return array_map(static function ($fieldId) {
            return (int)$fieldId;
        }, $fieldDependencies);
    }

    /**
     * @return int
     */
    public function getMultiLevelParent(): int
    {
        return $this->term->parent;
    }

    /**
     * @return bool
     */
    public function hasMultiLevelChildren(): bool
    {
        return count(get_term_children($this->term->term_id, $this->term->taxonomy)) > 0;
    }

    /**
     * @return int
     */
    public function getMultilevelParentId(): int
    {
        return $this->term->parent;
    }

    public function getMultilevelParentIds(): array
    {
        return get_ancestors($this->getId(), $this->getTaxonomyKey());
    }

    public function getMultilevelIds(): array
    {
        if (!$this->getTaxonomyField()->isMultilevel()) {
            return [$this->getId()];
        }

        return array_merge([$this->getId()], $this->getMultilevelParentIds());
    }

    /**
     * @return Collection|CustomTerm
     */
    public function getMultilevelParents(): Collection
    {
        $ids = $this->getMultilevelParentIds();
        if (empty($ids)) {
            return tdf_collect();
        }

        return tdf_query_terms($this->getTaxonomyKey())
            ->in($this->getMultilevelParentIds())
            ->orderByIn()
            ->get();
    }

    /**
     * @param  CustomTerm|null  $term
     * @param  bool  $first
     * @return Collection|CustomTerm[]
     * @noinspection PhpMissingParamTypeInspection
     */
    public function getAllParentTerms($term = null, bool $first = true): Collection
    {
        if ($term === null) {
            $term = $this;
        }

        $parentTerms = tdf_collect();

        foreach ($term->getParentTerms() as $parentTerm) {
            $parentTerms = $parentTerms->merge($this->getAllParentTerms($parentTerm, false));
        }

        $parentTerms = $parentTerms->merge($term->getMultilevelParents());

        if (!$first) {
            $parentTerms[] = $term;
        }

        return $parentTerms;
    }

    public function getAllParentTermIds(): array
    {
        return $this->getAllParentTerms()->map(static function ($term) {
            /* @var CustomTerm $term */
            return $term->getId();
        })->values();
    }

    public function getMultilevelLabel(): string
    {
        $label = '';

        foreach ($this->getMultilevelParents() as $parent) {
            $label .= $parent->getName().' > ';
        }

        $label .= $this->getName();

        return $label;
    }

    public function getCount(): int
    {
        /** @noinspection NullPointerExceptionInspection */
        if (empty(tdf_app('models_excluded_from_search')) && tdf_app('terms_excluded_from_search')->isEmpty()) {
            return $this->term->count;
        }

        $query = new WP_Query([
            'post_status' => PostStatus::PUBLISH,
            'posts_per_page' => -1,
            'fields' => 'ids',
            'post_type' => tdf_model_post_type(),
            'post__not_in' => tdf_app('models_excluded_from_search'),
            'tax_query' => [
                [
                    'taxonomy' => $this->getTaxonomyKey(),
                    'field' => 'term_id',
                    'terms' => [$this->getId()],
                ]
            ]
        ]);

        return count($query->posts);
    }

    public function getFieldsCount(): int
    {
        $fieldDependencies = $this->getFieldDependencies();
        $count = count($fieldDependencies);

        $alwaysVisible = 0;

        foreach (tdf_fields() as $field) {
            $check = true;

            /* @var Field $field */
            foreach (tdf_app('dependency_terms') as $term) {
                /*  @var CustomTerm $term */
                if (in_array($field->getId(), $term->getFieldDependencies(), true)) {
                    $check = false;
                }
            }

            if (in_array($this->getId(), $field->getHideTermIds(), true)) {
                $check = false;
            }

            if ($check) {
                ++$alwaysVisible;
            }
        }

        return $count + $alwaysVisible;
    }

    /**
     * @param  int  $templateId
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setCustomModelTemplate($templateId): void
    {
        $this->setMeta(self::CUSTOM_MODEL_TEMPLATE, (int)$templateId);
    }

    /**
     * @return int
     */
    public function getCustomTemplateId(): int
    {
        return (int)$this->getMeta(self::CUSTOM_MODEL_TEMPLATE);
    }

    /**
     * @return Template|false
     */
    public function getCustomTemplate()
    {
        $templateId = $this->getCustomTemplateId();
        if (empty($templateId)) {
            return false;
        }

        return tdf_app('templates')
            ->find(static function ($template) use ($templateId) {
                /* @var Template $template */
                return $template->getId() === $templateId;
            });
    }
}