<?php


namespace Tangibledesign\Framework\Models\Helpers;


use Tangibledesign\Framework\Models\Model;

/**
 * Trait HasViews
 * @package Tangibledesign\Framework\Models\Helpers
 */
trait HasViews
{
    use HasMeta;

    /**
     * @param int $views
     */
    public function setViews($views): void
    {
        $this->setMeta(Model::VIEWS, $views);
    }

    /**
     * @return int
     */
    public function getViews(): int
    {
        return (int)$this->getMeta(Model::VIEWS);
    }

    public function increase(): void
    {
        $this->setViews($this->getViews() + 1);
    }

}