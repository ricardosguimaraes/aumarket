<?php


namespace Tangibledesign\Framework\Models\Helpers;


/**
 * Interface HasViewsInterface
 * @package Tangibledesign\Framework\Models\Helpers
 */
interface HasViewsInterface
{
    /**
     * @param int $views
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setViews($views): void;

    /**
     * @return int
     */
    public function getViews(): int;

    public function increase(): void;

}