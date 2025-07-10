<?php


namespace Tangibledesign\Framework\Factories;


use Tangibledesign\Framework\Models\Template\Template;
use Tangibledesign\Framework\Factories\Helpers\GetPostObject;
use Tangibledesign\Framework\Models\Template\TemplateType\TemplateType;
use WP_Post;

/**
 * Class TemplateFactory
 * @package Tangibledesign\Framework\Factories
 */
class TemplateFactory implements BasePostFactory
{
    use GetPostObject;

    /**
     * @return TemplateFactory
     */
    public static function make(): TemplateFactory
    {
        return new static;
    }

    /**
     * @param WP_Post|int|null $post
     * @return Template|false
     */
    public function create($post)
    {
        $object = $this->getPostObject($post);
        if (!$object) {
            return false;
        }

        $type = $this->getType($object);

        foreach (tdf_app('template_types') as $templateType) {
            /* @var TemplateType $templateType */
            if ($templateType->getType() === $type) {
                $class = $templateType->getTemplateClass();
                return new $class($object);
            }
        }

        return apply_filters(tdf_prefix() . '/factory/template', false, $object, $type);
    }

    /**
     * @param WP_Post $object
     * @return string
     */
    private function getType(WP_Post $object): string
    {
        return (string)get_post_meta($object->ID, Template::TYPE, true);
    }

}