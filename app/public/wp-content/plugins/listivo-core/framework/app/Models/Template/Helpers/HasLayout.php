<?php


namespace Tangibledesign\Framework\Models\Template\Helpers;


use Elementor\Core\Base\Document;
use Tangibledesign\Framework\Factories\TemplateFactory;
use Tangibledesign\Framework\Models\Template\LayoutTemplate;

/**
 * Trait HasLayout
 * @package Tangibledesign\Framework\Models\Template
 */
trait HasLayout
{
    /**
     * @return Document|false
     */
    abstract public function getDocument();

    /**
     * @return int
     */
    public function getLayoutId(): int
    {
        return apply_filters(tdf_prefix() . '/layoutId', (int)$this->getDocument()->get_settings('tdf_layout'), $this);
    }

    /**
     * @param int $id
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setLayoutId($id): void
    {
        $this->getDocument()->update_settings([
            'tdf_layout' => $id,
        ]);
    }

    /**
     * @return LayoutTemplate|false
     */
    public function getLayout()
    {
        $layoutId = $this->getLayoutId();
        if (empty($layoutId)) {
            return tdf_app('default_layout') ?? false;
        }

        $layout = TemplateFactory::make()->create($layoutId);
        if (!$layout instanceof LayoutTemplate) {
            return tdf_app('default_layout') ?? false;
        }

        return $layout;
    }

}