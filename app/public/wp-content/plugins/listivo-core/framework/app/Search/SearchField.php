<?php

namespace Tangibledesign\Framework\Search;

use JsonSerializable;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Term\CustomTerm;

abstract class SearchField implements JsonSerializable
{
    /**
     * @var array
     */
    protected $config;

    abstract public function getName(): string;

    abstract public function getKey(): string;

    abstract public function getType(): string;

    /**
     * @return string[]
     */
    public function jsonSerialize(): array
    {
        return [
            'key' => $this->getKey(),
        ];
    }

    public function displayAtStart(Collection $selectedDependencyTerms): bool
    {
        return true;
    }

    public function getIcon(): array
    {
        return $this->config['icon'] ?? [];
    }

    public function hasIcon(): bool
    {
        if (!isset($this->config['icon'])) {
            return false;
        }

        if (empty($this->config['icon']['library'])) {
            return false;
        }

        return true;
    }
}