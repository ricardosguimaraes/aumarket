<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\BlogPost;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

trait QueryPostsControl
{
    use Control;
    use LimitControl;
    use OffsetControl;

    protected function addQueryPostsControls(): void
    {
        $this->addLimitControl();

        $this->addOffsetControl();

        $this->addCategoriesControl();

        $this->addTagsControl();

        $this->addAuthorsControl();
    }

    protected function addCategoriesControl(): void
    {
        $this->add_control(
            'categories',
            [
                'label' => tdf_admin_string('categories'),
                'type' => SelectRemoteControl::TYPE,
                'multiple' => true,
                'source' => get_rest_url() . 'wp/v2/categories',
            ]
        );
    }

    protected function addTagsControl(): void
    {
        $this->add_control(
            'tags',
            [
                'label' => tdf_admin_string('tags'),
                'type' => SelectRemoteControl::TYPE,
                'multiple' => true,
                'source' => get_rest_url() . 'wp/v2/tags',
            ]
        );
    }

    protected function addAuthorsControl(): void
    {
        $this->add_control(
            'authors',
            [
                'label' => tdf_admin_string('authors'),
                'type' => SelectRemoteControl::TYPE,
                'multiple' => true,
                'source' => get_rest_url() . 'wp/v2/users',
            ]
        );
    }

    /**
     * @return Collection|BlogPost[]
     */
    public function getPosts(): Collection
    {
        return tdf_query_blog_posts()
            ->userIn($this->getAuthors())
            ->tagIn($this->getTags())
            ->categoryIn($this->getCategories())
            ->take($this->getLimit())
            ->skip($this->getOffset())
            ->get();
    }

    /**
     * @return array
     */
    protected function getTags(): array
    {
        $tags = $this->get_settings_for_display('tags');

        if (empty($tags) || !is_array($tags)) {
            return [];
        }

        return $tags;
    }

    /**
     * @return array
     */
    protected function getCategories(): array
    {
        $categories = $this->get_settings_for_display('categories');

        if (empty($categories) || !is_array($categories)) {
            return [];
        }

        return $categories;
    }

    /**
     * @return array
     */
    protected function getAuthors(): array
    {
        $authors = $this->get_settings_for_display('authors');

        if (empty($authors) || !is_array($authors)) {
            return [];
        }

        return $authors;
    }

}