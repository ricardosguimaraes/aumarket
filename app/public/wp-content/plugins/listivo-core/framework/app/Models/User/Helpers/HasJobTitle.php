<?php


namespace Tangibledesign\Framework\Models\User\Helpers;


use Tangibledesign\Framework\Models\Helpers\HasMeta;

/**
 * Trait HasJobTitle
 * @package Tangibledesign\Framework\Models\User\Helpers
 */
trait HasJobTitle
{
    use HasMeta;

    /**
     * @param string $jobTitle
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setJobTitle($jobTitle): void
    {
        $this->setMeta(UserSettingKey::JOB_TITLE, $jobTitle);
    }

    /**
     * @return string
     */
    public function getJobTitle(): string
    {
        return (string)$this->getMeta(UserSettingKey::JOB_TITLE);
    }

}