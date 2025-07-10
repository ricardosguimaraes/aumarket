<?php


namespace Tangibledesign\Framework\Models\Field\Helpers;


use Cocur\Slugify\Slugify;
use Tangibledesign\Framework\Models\Helpers\HasMeta;

/**
 * Trait HasSlug
 * @package Tangibledesign\Framework\Models\Field\Helpers
 */
trait HasSlug
{
    use HasMeta;

    /**
     * @var string[]
     */
    protected $preventSlugs = [
        'p', 'year', 'month', 'id',
    ];

    /**
     * @param string $slug
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setSlug($slug): void
    {
        $slug = Slugify::create()->slugify($slug);

        if (in_array($slug, $this->preventSlugs, true)) {
            $slug = Slugify::create()->slugify($this->getName());
        }

        $this->setMeta('slug', $slug);
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        $slug = $this->getMeta('slug');

        if (empty($slug)) {
            return Slugify::create()->slugify($this->getName());
        }

        return $slug;
    }

    /**
     * @return string
     */
    abstract public function getName(): string;

}