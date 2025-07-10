<?php


namespace Tangibledesign\Framework\Models;


use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Post\PostModel;
use Tangibledesign\Framework\Models\Term\Term;

/**
 * Class BlogPost
 * @package Tangibledesign\Framework\Models
 */
class BlogPost extends PostModel
{
    /**
     * @return string|int
     */
    public function getCommentsNumber()
    {
        return get_comments_number($this->post);
    }

    /**
     * @return string
     */
    public function getCommentsText(): string
    {
        return get_comments_number_text(false, false, false, $this->getId());
    }

    /**
     * @return bool
     */
    public function hasTags(): bool
    {
        return has_tag('', $this->post);
    }

    /**
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        $tags = wp_get_post_tags($this->getId());
        if (!is_array($tags)) {
            return tdf_collect();
        }

        return tdf_collect($tags)->map(static function ($tag) {
            return tdf_term_factory()->create($tag);
        });
    }

    /**
     * @return bool
     */
    public function hasCategories(): bool
    {
        return has_category('', $this->post);
    }

    /**
     * @return Collection|Term[]
     */
    public function getCategories(): Collection
    {
        $categories = wp_get_post_categories($this->getId());
        if (!is_array($categories)) {
            return tdf_collect();
        }

        return tdf_collect($categories)->map(static function ($category) {
            return tdf_term_factory()->create($category);
        });
    }

    /**
     * @return bool
     */
    public function hasComments(): bool
    {
        return count(get_comments(['post_id' => $this->getId()])) > 0;
    }

    /**
     * @return array|int
     */
    public function getComments()
    {
        return get_comments([
            'post_id' => $this->getId(),
            'status' => 'approve',
            'include_unapproved' => array(
                is_user_logged_in() ? get_current_user_id() : $this->getUnapprovedCommentAuthorEmail()
            )
        ]);
    }

    /**
     * @return string
     */
    private function getUnapprovedCommentAuthorEmail(): string
    {
        $email = '';

        if (!empty($_GET['unapproved']) && !empty($_GET['moderation-hash'])) {
            $commentId = (int)$_GET['unapproved'];
            $comment = get_comment($commentId);

            if ($comment && hash_equals($_GET['moderation-hash'], wp_hash($comment->comment_date_gmt))) {
                $email = $comment->comment_author_email;
            }
        }

        if (!$email) {
            $commenter = wp_get_current_commenter();
            $email = $commenter['comment_author_email'];
        }

        return $email;
    }

    /**
     * @return bool
     */
    public function hasImage(): bool
    {
        return has_post_thumbnail($this->post);
    }

    /**
     * @return Image|false
     */
    public function getImage()
    {
        return tdf_image_factory()->create(get_post_thumbnail_id($this->post));
    }

    /**
     * @param string $size
     * @return string
     */
    public function getImageUrl(string $size = 'full'): string
    {
        if (!$this->hasImage()) {
            return '';
        }

        $image = $this->getImage();
        if (!$image) {
            return '';
        }

        return $image->getImageUrl($size);
    }

}