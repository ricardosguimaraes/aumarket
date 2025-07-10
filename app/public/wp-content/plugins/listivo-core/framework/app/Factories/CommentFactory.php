<?php


namespace Tangibledesign\Framework\Factories;


use Tangibledesign\Framework\Models\Comment;
use WP_Comment;

/**
 * Class CommentFactory
 * @package Tangibledesign\Framework\Factories
 */
class CommentFactory implements BasePostFactory
{
    /**
     * @param $post
     * @return Comment|false
     */
    public function create($post)
    {
        $object = $this->getObject($post);

        if ($object instanceof WP_Comment) {
            return new Comment($object);
        }

        return false;
    }

    /**
     * @param $comment
     * @return false|WP_Comment
     */
    private function getObject($comment)
    {
        if ($comment instanceof WP_Comment) {
            return $comment;
        }

        if (is_int($comment)) {
            $object = get_comment($comment);
            return $object instanceof WP_Comment ? $object : false;
        }

        return false;
    }

}