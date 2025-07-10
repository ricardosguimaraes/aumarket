<?php

namespace Tangibledesign\Framework\Search\Field;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Search\SearchField;
use Tangibledesign\Framework\Models\Field\Field;

abstract class BaseSearchField extends SearchField
{
    /**
     * @var Field
     */
    protected $field;

    public function getId(): int
    {
        return $this->field->getId();
    }

    public function getField(): Field
    {
        return $this->field;
    }

    public function getName(): string
    {
        return $this->field->getName();
    }

    public function getKey(): string
    {
        return $this->field->getKey();
    }

    public function getType(): string
    {
        return $this->field->getType();
    }

    public function jsonSerialize(): array
    {
        return parent::jsonSerialize() + [
                'id' => $this->getId(),
                'type' => $this->getType(),
                'hideTerms' => $this->field->getHideTermIds(),
            ];
    }

    /**
     * @param  Collection|CustomTerm[]  $selectedDependencyTerms
     * @return bool
     */
    public function displayAtStart(Collection $selectedDependencyTerms): bool
    {
        foreach ($selectedDependencyTerms as $term) {
            /* @var CustomTerm $term */
            if (in_array($this->getId(), $term->getFieldDependencies(), true)) {
                return true;
            }

            if (in_array($term->getId(), $this->field->getHideTermIds(), true)) {
                return false;
            }
        }

        foreach (tdf_app('dependency_terms') as $term) {
            /* @var CustomTerm $term */
            if (in_array($this->getId(), $term->getFieldDependencies(), true)) {
                return false;
            }
        }

        return true;
    }

    public function checkDependency(): bool
    {
        foreach (tdf_app('dependency_terms') as $term) {
            /* @var CustomTerm $term */
            if (in_array($this->getId(), $term->getFieldDependencies(), true)) {
                return true;
            }
        }

        return false;
    }
}