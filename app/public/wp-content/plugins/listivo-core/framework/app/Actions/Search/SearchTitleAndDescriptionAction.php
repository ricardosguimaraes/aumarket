<?php

namespace Tangibledesign\Framework\Actions\Search;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;

class SearchTitleAndDescriptionAction
{
    private const CONTENT_TITLE = 'title';
    private const CONTENT_DESCRIPTION = 'description';

    private string $title = '';
    private string $description = '';

    private function getCachedQuery(string $key, $value): Collection
    {
        static $cache = [];

        if (!isset($cache[$key])) {
            $cache[$key] = tdf_query_terms($key)->in($value)->orderByIn()->get();
        }

        return $cache[$key];
    }

    private function fetchContent(array $filters, Collection $fields, string $contentType): string
    {
        $content = [];
        foreach ($fields as $field) {
            $content[] = $this->processField($field, $filters, $contentType);
        }
        return trim(implode(' ', $content));
    }

    private function processField(TaxonomyField $field, array $filters, string $contentType): string
    {
        foreach ($filters as $filter) {
            if ($this->isValidFilter($field, $filter)) {
                $query = $this->getCachedQuery($field->getKey(), $filter['values'][count($filter['values']) - 1]);
                return $this->processQuery($query, $contentType);
            }
        }

        return '';
    }

    private function isValidFilter(TaxonomyField $field, array $filter): bool
    {
        return !empty($filter['values']) && $filter['key'] === $field->getKey();
    }

    private function processQuery(Collection $query, string $contentType): string
    {
        if ($contentType === self::CONTENT_TITLE) {
            return $query->map(fn($term) => $term->getName())->implode(' ');
        }

        if ($contentType === self::CONTENT_DESCRIPTION) {
            return $query->map(fn($term) => $term->getDescription())->implode(' ');
        }

        return '';
    }


    private function fetchTitleAndDescription(array $filters = []): void
    {
        $this->title = $this->fetchContent($filters, $this->getSecondFields(), self::CONTENT_TITLE);
        if (!empty($this->title)) {
            $this->description = $this->fetchContent($filters, $this->getSecondFields(), self::CONTENT_DESCRIPTION);
            return;
        }

        $this->title = $this->fetchContent($filters, $this->getFirstFields(), self::CONTENT_TITLE);
        if (!empty($this->title)) {
            $this->description = $this->fetchContent($filters, $this->getFirstFields(), self::CONTENT_DESCRIPTION);
        }
    }

    private function loadTitleAndDescription(array $filters): void
    {
        if (!empty($filters)) {
            $this->fetchTitleAndDescription($filters);
            if (!empty($this->title) || !empty($this->description)) {
                return;
            }
        }

        $filters = $this->getCurrentFilters($this->getSecondFields());
        $this->fetchTitleAndDescription($filters);

        if (!empty($this->title) || !empty($this->description)) {
            return;
        }

        $filters = $this->getCurrentFilters($this->getFirstFields());
        $this->fetchTitleAndDescription($filters);

        if (!empty($this->title) || !empty($this->description)) {
            return;
        }

        $this->title = tdf_settings()->getSearchDefaultTitle();
        $this->description = tdf_settings()->getSearchDefaultDescription();
    }

    public function getTitle(array $filters = []): string
    {
        if (!empty($this->title) || !empty($this->description)) {
            return $this->title;
        }

        $this->loadTitleAndDescription($filters);

        return $this->title;
    }

    public function getDescription(array $filters = []): string
    {
        if (!empty($this->title) || !empty($this->description)) {
            return $this->description;
        }

        $this->loadTitleAndDescription($filters);

        return $this->description;
    }

    private function getCurrentFilters(Collection $fields): array
    {
        $filters = [];

        foreach ($fields as $taxonomy) {
            $termIds = [];
            $slug = $taxonomy->getSlug();
            $value = get_query_var($taxonomy->getKey());
            if (empty($value)) {
                if (empty($_GET[$slug])) {
                    break;
                }

                $value = $_GET[$slug];
            }

            $termSlugs = explode(',', $value);
            foreach ($termSlugs as $termSlug) {
                $term = get_term_by('slug', $termSlug, $taxonomy->getKey());
                if ($term) {
                    $termIds[] = $term->term_id;
                }
            }

            $filters[] = [
                'key' => $taxonomy->getKey(),
                'values' => $termIds,
            ];
        }

        return $filters;
    }

    /**
     * @return Collection|TaxonomyField[]
     */
    private function getFirstFields(): Collection
    {
        return tdf_app('search_title_fields');
    }

    /**
     * @return Collection|TaxonomyField[]
     */
    private function getSecondFields(): Collection
    {
        return tdf_app('search_title_fields_2');
    }
}