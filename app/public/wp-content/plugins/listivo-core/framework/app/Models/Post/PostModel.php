<?php

namespace Tangibledesign\Framework\Models\Post;

use Elementor\Plugin;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Helpers\HasUser;
use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Queries\QueryPosts;

abstract class PostModel extends Post
{
    use HasUser;

    public function hasContent(): bool
    {
        return !empty($this->post->post_content);
    }

    public function displayContent(): void
    {
        global ${tdf_short_prefix() . 'CurrentWidget'};
        $tempWidget = ${tdf_short_prefix() . 'CurrentWidget'};

        if ($this->checkIfElementorFilterApplied() && Plugin::instance()->editor->is_edit_mode()) {
            Plugin::instance()->frontend->remove_content_filter();

            echo apply_filters('the_content', wp_kses_post($this->post->post_content));

            Plugin::instance()->frontend->add_content_filter();
        } else {
            echo apply_filters('the_content', wp_kses_post($this->post->post_content));
        }

        ${tdf_short_prefix() . 'CurrentWidget'} = $tempWidget;
    }

    private function checkIfElementorFilterApplied(): bool
    {
        global $wp_filter;
        foreach ($wp_filter['the_content'] as $callbacks) {
            foreach ($callbacks as $callbackKey => $callback) {
                if (strpos($callbackKey, 'apply_builder_in_content') !== false) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getPublishDateDiff(): string
    {
        $humanTimeDiff = human_time_diff(get_the_time('U', $this->post), current_time('timestamp'));
        $ago = tdf_string('ago');

        if (strpos($ago, '%s') === false) {
            return sprintf('%s %s', $humanTimeDiff, $ago);
        }

        return sprintf($ago, $humanTimeDiff);
    }

    public function getTeaser(int $limit = 175, string $end = '...'): string
    {
        $excerpt = $this->getExcerpt();

        if (mb_strlen($excerpt, 'UTF-8') <= $limit) {
            return $excerpt;
        }

        return mb_substr($excerpt, 0, $limit, 'UTF-8') . $end;
    }

    public function getStatusLabel(): string
    {
        $status = $this->getStatus();

        if ($status === PostStatus::PUBLISH) {
            return tdf_string('active');
        }

        if ($status === PostStatus::PENDING) {
            return tdf_string('pending');
        }

        if ($status === PostStatus::DRAFT) {
            return tdf_string('draft');
        }

        return '';
    }

    public function isPending(): bool
    {
        return $this->getStatus() === PostStatus::PENDING;
    }

    public function isDraft(): bool
    {
        return $this->getStatus() === PostStatus::DRAFT;
    }

    public function isPublished(): bool
    {
        return $this->getStatus() === PostStatus::PUBLISH;
    }

    public function getUrl(): string
    {
        if (!$this->isDraft() && !$this->isPending()) {
            return parent::getUrl();
        }

        return get_preview_post_link($this->getPost());
    }

    public function setUser(int $userId): void
    {
        wp_update_post([
            'ID' => $this->getId(),
            'post_author' => $userId,
        ]);
    }

    public function getImageId(): int
    {
        return (int)get_post_thumbnail_id($this->post);
    }

    /**
     * @return Image|false
     */
    public function getImage()
    {
        $imageId = $this->getImageId();
        if (empty($imageId)) {
            return false;
        }

        $image = tdf_post_factory()->create($imageId);
        if (!$image instanceof Image) {
            return false;
        }

        return $image;
    }

    /**
     * @param string $size
     * @return string|false
     */
    public function getImageUrl(string $size = 'full')
    {
        $image = $this->getImage();
        if (empty($image)) {
            return false;
        }

        return $image->getImageUrl($size);
    }
}