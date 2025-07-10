<?php


namespace Tangibledesign\Framework\Factories;


use Tangibledesign\Framework\Models\Template\TemplateType\LayoutTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\PostArchiveTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\PostSingleTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\PrintModelTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\TemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\UserTemplateType;


/**
 * Class TemplateTypeFactory
 * @package Tangibledesign\Framework\Factories
 */
class TemplateTypeFactory
{
    /**
     * @param string $type
     * @return TemplateType|false
     */
    public function create(string $type)
    {
        foreach (tdf_app('template_types') as $templateType) {
            /* @var TemplateType $templateType */
            if ($templateType->getType() === $type) {
                return $templateType;
            }
        }

        return apply_filters(tdf_prefix() . '/factory/templateType', false, $type);
    }

    /**
     * @return TemplateType|false
     */
    public function getCurrent()
    {
        $type = $this->getCurrentType();
        if (!$type) {
            return false;
        }

        return $this->create($type);
    }

    /**
     * @return string|false
     */
    private function getCurrentType()
    {
        if (is_singular('elementor_library')) {
            return false;
        }

        if (is_home() || is_category() || is_tag() || is_search()) {
            return PostArchiveTemplateType::TYPE;
        }

        if (is_singular('post')) {
            return PostSingleTemplateType::TYPE;
        }

        if (is_author()) {
            return UserTemplateType::TYPE;
        }

        if (is_singular(tdf_prefix() . '_template')) {
            return $this->getTemplateTypeFromCurrentTemplate();
        }

        if (isset($_POST['editor_post_id']) && !is_singular('page')) {
            global $post;
            if ($post && $post->post_type === 'elementor_library') {
                return false;
            }

            return $this->getTemplateTypeByEditorPostId();
        }

        if (!empty($_GET['print']) && is_singular(tdf_model_post_type())) {
            return PrintModelTemplateType::TYPE;
        }

        if (is_singular(tdf_model_post_type())) {
            return tdf_app('model_single_template_type');
        }

        if (is_post_type_archive(tdf_model_post_type())) {
            return tdf_app('model_archive_template_type');
        }

        return apply_filters(tdf_prefix() . '/templateType/current', false);
    }

    /**
     * @return string|false
     */
    private function getTemplateTypeByEditorPostId()
    {
        $postId = (int)$_POST['editor_post_id'];
        $post = get_post($postId);

        if (!$post || $post->post_type !== tdf_prefix() . '_template') {
            return false;
        }

        $template = TemplateFactory::make()->create($post);
        if (!$template) {
            return false;
        }

        return $template->getType();
    }

    /**
     * @return string|false
     */
    private function getTemplateTypeFromCurrentTemplate()
    {
        global $post;

        $template = TemplateFactory::make()->create($post);
        if (!$template) {
            return false;
        }

        return $template->getType();
    }

}