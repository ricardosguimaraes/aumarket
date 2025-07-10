<?php


namespace Tangibledesign\Framework\Queries;


use Tangibledesign\Framework\Models\ContactForm;

/**
 * Class QueryContactForms
 * @package Tangibledesign\Framework\Queries
 */
class QueryContactForms extends QueryPosts
{
    /**
     * @var string
     */
    protected string $postType = ContactForm::POST_TYPE;
}