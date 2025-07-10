<?php


namespace Tangibledesign\Framework\Queries;


use Tangibledesign\Framework\Factories\BasePostFactory;
use Tangibledesign\Framework\Models\Template\Template;

/**
 * Class QueryTemplates
 * @package Tangibledesign\Framework\Queries
 */
class QueryTemplates extends QueryPosts
{
    /** @var string */
    protected string $postType = 'template';

    /** @var bool */
    protected bool $prefixPostType = true;

    /**
     * @param  string  $type
     * @return static
     * @noinspection PhpMissingReturnTypeInspection
     */
    public function setType(string $type)
    {
        $this->metaQuery['type'] = [
            'key' => Template::TYPE,
            'value' => $type,
        ];

        return $this;
    }

    protected function getFactory(): BasePostFactory
    {
        return tdf_template_factory();
    }

}