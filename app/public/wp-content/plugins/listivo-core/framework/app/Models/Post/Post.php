<?php

namespace Tangibledesign\Framework\Models\Post;

use Tangibledesign\Framework\Core\BaseModel;
use Tangibledesign\Framework\Models\User\User;
use WP_Post;
use WP_Term;
use WP_User;

abstract class Post extends BaseModel
{
    /**
     * @var WP_Post
     */
    protected $post;

    public function __construct(WP_Post $post)
    {
        $this->post = $post;
    }

    public function getId(): int
    {
        return $this->post->ID;
    }

    public function getName(): string
    {
        return get_the_title($this->post);
    }

    public function getSlug(): string
    {
        return $this->post->post_name;
    }

    /**
     * @param string $name
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setName($name): void
    {
        wp_update_post([
            'ID' => $this->getId(),
            'post_title' => $name,
        ]);
    }

    public function getIntro(): string
    {
        return get_the_excerpt($this->post);
    }

    public function getDescription(): string
    {
        return $this->post->post_content;
    }

    public function getUrl(): string
    {
        return get_permalink($this->post);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function setMeta(string $key, $value): bool
    {
        return update_post_meta($this->getId(), $key, $value) !== false;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getMeta(string $key)
    {
        return get_post_meta($this->getId(), $key, true);
    }

    public function getPostType(): string
    {
        return $this->post->post_type;
    }

    public function getStatus(): string
    {
        return $this->post->post_status;
    }

    public function getUserId(): int
    {
        return $this->post->post_author;
    }

    public function getUser(): ?User
    {
        $user = get_user_by('id', $this->getUserId());
        if (!$user instanceof WP_User) {
            return null;
        }

        return new User($user);
    }

    public function getContent(int $limit = 0): string
    {
        $content = strip_tags($this->post->post_content);

        if (empty($limit) || mb_strlen($content, 'UTF-8') <= $limit) {
            return $content;
        }

        return mb_substr($content, 0, $limit, 'UTF-8') . '...';
    }

    public function getContentLength(): int
    {
        return mb_strlen($this->getContent(), 'UTF-8');
    }

    public function getExcerpt(): string
    {
        return get_the_excerpt($this->post);
    }

    public function getPost(): WP_Post
    {
        return $this->post;
    }

    public function getPublishDate(): string
    {
        return (string)get_the_date(get_option('date_format'), $this->post);
    }

    public function getPublishTime(): string
    {
        return (string)get_the_date(get_option('time_format'), $this->post);
    }

    public function getModifiedDate(): string
    {
        return get_the_modified_date(get_option('date_format'), $this->post);
    }

    public function setDescription(string $description): void
    {
        wp_update_post([
            'ID' => $this->getId(),
            'post_content' => $description,
        ]);
    }

    public function setPublish(): void
    {
        wp_update_post([
            'ID' => $this->getId(),
            'post_status' => PostStatus::PUBLISH,
        ]);
    }

    public function setPending(): void
    {
        wp_update_post([
            'ID' => $this->getId(),
            'post_status' => PostStatus::PENDING,
        ]);
    }

    public function setDraft(): void
    {
        wp_update_post([
            'ID' => $this->getId(),
            'post_status' => PostStatus::DRAFT,
        ]);
    }

    /**
     * @param string $taxonomy
     * @param WP_Term|int $term
     * @return bool
     */
    public function hasTerm(string $taxonomy, $term): bool
    {
        return has_term($term, $taxonomy, $this->post);
    }

    public function getParentId(): int
    {
        return $this->post->post_parent;
    }

    public function getParent()
    {
        if ($this->getParentId() === 0) {
            return null;
        }

        $post = get_post($this->getParentId());
        if (!$post instanceof WP_Post) {
            return null;
        }

        return new static($post);
    }

    public function delete(): void
    {
        wp_delete_post($this->getId(), true);
    }
}