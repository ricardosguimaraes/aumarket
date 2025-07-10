<?php

namespace Tangibledesign\Framework\Factories;

use Tangibledesign\Framework\Factories\Helpers\GetPostObject;
use Tangibledesign\Framework\Models\Image;
use WP_Post;

class ImageFactory implements BasePostFactory
{
    use GetPostObject;

    /**
     * @param WP_Post|int $post
     * @return Image|false
     */
    public function create($post)
    {
        $object = $this->getPostObject($post);
        if (!$object) {
            return false;
        }

        if ($object->post_type !== 'attachment') {
            return false;
        }

        return new Image($object);
    }
}