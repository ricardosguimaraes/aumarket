<?php


namespace Tangibledesign\Framework\Models\User\Helpers;


/**
 * Interface HasJobTitleInterface
 * @package Tangibledesign\Framework\Models\User\Helpers
 */
interface HasJobTitleInterface
{
    /**
     * @param string $jobTitle
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setJobTitle($jobTitle): void;

    /**
     * @return string
     */
    public function getJobTitle(): string;
}