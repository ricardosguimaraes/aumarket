<?php

namespace Tangibledesign\Listivo\Widgets\Helpers\Controls;

use Tangibledesign\Framework\Models\BlogPost;

interface BlogPostCard
{
    /**
     * @return bool
     */
    public function showUser(): bool;

    /**
     * @return bool
     */
    public function showPublishDate(): bool;

    /**
     * @return bool
     */
    public function showCategories(): bool;

    /**
     * @return bool
     */
    public function showExcerpt(): bool;

    /**
     * @return int
     */
    public function getExcerptLength(): int;

    /**
     * @return string
     */
    public function getExcerptEnd(): string;

    /**
     * @return bool
     */
    public function showReadMoreButton(): bool;

    /**
     * @param BlogPost $blogPost
     */
    public function displayExcerpt(BlogPost $blogPost): void;

}