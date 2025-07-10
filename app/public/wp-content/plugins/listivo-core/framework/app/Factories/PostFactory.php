<?php

namespace Tangibledesign\Framework\Factories;

use Tangibledesign\Framework\Models\ContactForm;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Post\Post;
use Tangibledesign\Framework\Factories\Helpers\GetPostObject;
use Tangibledesign\Framework\Models\Attachment;
use Tangibledesign\Framework\Models\BlogPost;
use Tangibledesign\Framework\Models\Image;
use Tangibledesign\Framework\Models\Page;
use WP_Post;

/**
 * Class PostFactory
 * @package Tangibledesign\Framework\Factories
 */
class PostFactory implements BasePostFactory
{
    use GetPostObject;

    /**
     * @param  WP_Post|int|null  $post
     * @return Post|false
     */
    public function create($post)
    {
        $object = $this->getPostObject($post);
        if (!$object) {
            return false;
        }

        if ($object->post_type === tdf_model_post_type()) {
            return new Model($object);
        }

        if ($object->post_type === 'post') {
            return new BlogPost($object);
        }

        if ($object->post_type === 'attachment' && wp_attachment_is_image($object)) {
            return new Image($object);
        }

        if ($object->post_type === 'attachment') {
            return new Attachment($object);
        }

        if ($object->post_type === 'page') {
            return new Page($object);
        }

        if ($object->post_type === ContactForm::POST_TYPE) {
            return new ContactForm($object);
        }

        if ($object->post_type === tdf_prefix().'_template') {
            return tdf_template_factory()->create($object);
        }

        if ($object->post_type === tdf_prefix().'_field') {
            return tdf_field_factory()->create($object);
        }

        if ($object->post_type === tdf_prefix().'_package') {
            return tdf_payment_package_factory()->create($object);
        }

        if ($object->post_type === tdf_prefix().'_user_package') {
            return tdf_user_payment_package_factory()->create($object);
        }

        if ($object->post_type === tdf_prefix().'_notify') {
            return tdf_notification_factory()->create($object);
        }

        if ($object->post_type === tdf_prefix().'_notify_task') {
            return tdf_notification_task_factory()->create($object);
        }

        return apply_filters(tdf_prefix().'/factory/post', false, $object);
    }

}