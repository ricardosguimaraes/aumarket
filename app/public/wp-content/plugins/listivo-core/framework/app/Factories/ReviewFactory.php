<?php

namespace Tangibledesign\Framework\Factories;

use Tangibledesign\Framework\Factories\Helpers\GetPostObject;
use Tangibledesign\Framework\Models\Post\Post;
use Tangibledesign\Framework\Models\Review;
use WP_Post;

class ReviewFactory implements BasePostFactory
{
    use GetPostObject;

    public function create($post)
    {
        $object = $this->getPostObject($post);
        if (!$object) {
            return false;
        }

        if ($object->post_type !== tdf_prefix() . '_review') {
            return false;
        }

        return new Review($object);
    }
}