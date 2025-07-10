<?php


namespace Tangibledesign\Framework\Models;


use Tangibledesign\Framework\Core\BaseModel;
use Tangibledesign\Framework\Models\User\User;
use WP_Comment;

/**
 * Class Comment
 * @package Tangibledesign\Framework\Models
 */
class Comment extends BaseModel
{
    /**
     * @var WP_Comment
     */
    protected $comment;

    /**
     * Comment constructor.
     * @param WP_Comment $comment
     */
    public function __construct(WP_Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->comment->comment_ID;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return get_the_title($this->comment->comment_post_ID);
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return get_comment_link($this->comment);
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->comment->user_id;
    }

    /**
     * @return false|User
     */
    public function getUser()
    {
        $userId = $this->getUserId();

        if (empty($userId)) {
            return false;
        }

        return tdf_user_factory()->create($userId);
    }

    /**
     * @return string
     */
    public function getUserUrl(): string
    {
        return get_comment_author_link($this->comment);
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        $user = $this->getUser();
        if (!$user) {
            return '';
        }

        return $user->getDisplayName();
    }

    /**
     * @param string $size
     * @return string
     */
    public function getUserAvatar(string $size = 'medium'): string
    {
        $user = $this->getUser();
        if (!$user) {
            return (string)get_avatar_url($this->getUserId());
        }

        $image = $user->getImage();
        if (!$image) {
            return (string)get_avatar_url($this->getUserId());
        }

        $imageUrl = $image->getImageUrl($size);
        if (empty($imageUrl)) {
            return (string)get_avatar_url($this->getUserId());
        }

        return $imageUrl;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getMeta(string $key)
    {
        return get_comment_meta($this->getId(), $key, true);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    public function setMeta(string $key, $value): bool
    {
        return update_comment_meta($this->getId(), $key, $value) !== false;
    }

}