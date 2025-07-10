<?php


namespace Tangibledesign\Framework\Models\Template\TemplateType;


use Elementor\Core\Base\Document;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Template\Template;

/**
 * Class TemplateType
 * @package Tangibledesign\Framework\Models\Template\TemplateType
 */
abstract class TemplateType
{
    public const LAYOUT = 'layout';
    public const USER = 'user';
    public const POST_SINGLE = 'post_single';
    public const POST_ARCHIVE = 'post_archive';
    public const PRINT_MODEL = 'print_model';

    /**
     * @return TemplateType
     */
    public static function make(): TemplateType
    {
        return new static;
    }

    /**
     * @return string
     */
    abstract public function getName(): string;

    /**
     * @return string
     */
    abstract public function getType(): string;

    /**
     * @return string
     */
    abstract public function getTemplateClass(): string;

    /**
     * @param string $widgetClass
     * @return bool
     */
    abstract public function isWidgetCompatible(string $widgetClass): bool;

    /**
     * @return Collection
     */
    public function getTemplates(): Collection
    {
        return tdf_app('templates')
            ->filter(function ($template) {
                /* @var Template $template */
                return $template->getType() === $this->getType();
            })
            ->toValues();
    }

    /**
     * @return int
     */
    private function getDefaultTemplateIdSetting(): int
    {
        $defaultTemplates = tdf_settings()->getDefaultTemplates();

        if (isset($defaultTemplates[$this->getType()])) {
            return (int)$defaultTemplates[$this->getType()];
        }

        return 0;
    }

    /**
     * @return int
     */
    public function getDefaultTemplateId(): int
    {
        $defaultTemplate = $this->getDefaultTemplate();

        if (!$defaultTemplate) {
            return 0;
        }

        return $defaultTemplate->getId();
    }

    /**
     * @return Template|false
     */
    public function getDefaultTemplate()
    {
        $defaultTemplateId = $this->getDefaultTemplateIdSetting();
        $templates = $this->getTemplates();

        if ($templates->isEmpty()) {
            return apply_filters(tdf_prefix() . '/template/current', false);
        }

        $defaultTemplate = $templates->find(static function ($template) use ($defaultTemplateId) {
            /* @var Template $template */
            return $template->getId() === $defaultTemplateId;
        });

        return apply_filters(tdf_prefix() . '/template/current', $defaultTemplate !== false ? $defaultTemplate : $templates->first());
    }

    /**
     * @param Document $document
     */
    public function addElementorControls(Document $document): void
    {

    }

    public function prepare(): void
    {

    }

    public function preparePreview(): void
    {

    }

}