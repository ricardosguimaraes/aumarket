<?php

namespace Tangibledesign\Framework\Models\Term;

use JsonSerializable;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\BaseModel;
use Tangibledesign\Framework\Helpers\HasSettings;
use WP_Term;

abstract class Term extends BaseModel implements JsonSerializable
{
    use HasSettings;

    protected ?WP_Term $term;

    public function __toString(): string
    {
        return $this->getKey();
    }

    public function __construct(WP_Term $term)
    {
        $this->term = $term;
    }

    public function getWpTerm(): ?WP_Term
    {
        return $this->term;
    }

    public function getId(): int
    {
        return $this->term->term_id;
    }

    public function getName(): string
    {
        return $this->term->name;
    }

    public function getDescription(): string
    {
        return $this->term->description;
    }

    public function getSlug(): string
    {
        return $this->term->slug;
    }

    public function getUrl(): string
    {
        $url = get_term_link($this->term);

        if (is_wp_error($url)) {
            return '';
        }

        return $url;
    }

    public function getCount(): int
    {
        return $this->term->count;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function setMeta(string $key, $value): bool
    {
        $return = update_term_meta($this->getId(), $key, $value);

        return is_int($return) || $return === true;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getMeta(string $key)
    {
        return get_term_meta($this->getId(), $key, true);
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'key' => $this->getKey(),
            'name' => $this->getName(),
            'parent' => $this->term->parent,
        ];
    }

    public function getSettingKeys(): array
    {
        return [];
    }

    public function getTaxonomyKey(): string
    {
        return $this->term->taxonomy;
    }

    /**
     * @param int $limit
     * @param string $orderBy
     * @return Collection|CustomTerm[]
     */
    public function getMultilevelChildren(int $limit = 0, string $orderBy = 'name'): Collection
    {
        $query = tdf_query_terms($this->getTaxonomyKey())->setParent($this->getId());

        if (!empty($limit)) {
            $query->take($limit);
        }

        if ($orderBy === 'count') {
            $query->orderByCount();
        }

        return $query->get();
    }
}