<?php

namespace Tangibledesign\Listivo\Widgets\Helpers;

use WP_Query;
use WP_Widget;

class PostsWidget extends WP_Widget
{

    public function __construct()
    {
        parent::__construct(
            'listivo-posts',
            esc_html__('Listivo Posts', 'listivo')
        );
    }

    /**
     * @param array $args
     * @param array $instance
     */
    public function widget($args, $instance): void
    {
        get_template_part('templates/blog/posts_widget', null, [
            'posts' => $this->getPosts(explode(',', $instance['post_ids'])),
            'title' => apply_filters('widget_title', $instance['title'] ?? ''),
        ]);
    }

    /**
     * @param array $postIds
     * @return array
     * @noinspection PhpMissingParamTypeInspection
     */
    private function getPosts($postIds): array
    {
        if (!is_array($postIds)) {
            $postIds = [];
        }

        return (new WP_Query([
            'posts_per_page' => 3,
            'orderby' => 'post__in',
            'post__in' => $postIds,
        ]))->posts;
    }

    public function form($instance)
    {
        $title = $instance['title'] ?? esc_html__('Posts', 'listivo');
        $postIds = $instance['post_ids'] ?? '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('title')); ?>">
                <?php esc_html_e('Title:', 'listivo'); ?>
            </label>

            <input
                    class="widefat"
                    id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                    type="text"
                    value="<?php echo esc_attr($title); ?>"
            />
        </p>

        <p>
            <label for="<?php echo esc_attr($this->get_field_name('post_ids')); ?>">
                <?php esc_html_e('Post IDs:', 'listivo'); ?>
            </label>

            <input
                    class="widefat"
                    id="<?php echo esc_attr($this->get_field_id('post_ids')); ?>"
                    name="<?php echo esc_attr($this->get_field_name('post_ids')); ?>"
                    type="text"
                    value="<?php echo esc_attr($postIds); ?>"
            />
        </p>
        <?php
    }

    /**
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update($new_instance, $old_instance): array
    {
        $instance = [];
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['post_ids'] = (!empty($new_instance['post_ids'])) ? $new_instance['post_ids'] : '';

        return $instance;
    }

}