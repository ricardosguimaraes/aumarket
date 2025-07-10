<?php

class ListivoMenuWalker extends \Walker_Nav_Menu
{
    /**
     * @param string $output
     * @param WP_Post $item
     * @param int $depth
     * @param array $args
     * @param int $id
     */
    public function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
    {
        global $lstMenuElement;
        $lstMenuElement = new ListivoMenuElement($item, $depth);
        ob_start();
        get_template_part('templates/widgets/general/menu/item', 'start');
        $output .= ob_get_clean();
    }

    /**
     * @param string $output
     * @param \WP_Post $item
     * @param int $depth
     * @param array $args
     */
    public function end_el(&$output, $item, $depth = 0, $args = [])
    {
        global $lstMenuElement;
        $lstMenuElement = new ListivoMenuElement($item, $depth);
        ob_start();
        get_template_part('templates/widgets/general/menu/item', 'end');
        $output .= ob_get_clean();
    }

    /**
     * @param string $output
     * @param int $depth
     * @param array $args
     */
    public function start_lvl(&$output, $depth = 0, $args = [])
    {
        global $lstMenuLevel;
        $lstMenuLevel = new ListivoMenuLevel($depth);
        ob_start();
        get_template_part('templates/widgets/general/menu/level', 'start');
        $output .= ob_get_clean();
    }

    /**
     * @param string $output
     * @param int $depth
     * @param array $args
     */
    public function end_lvl(&$output, $depth = 0, $args = [])
    {
        global $lstMenuLevel;
        $lstMenuLevel = new ListivoMenuLevel($depth);
        ob_start();
        get_template_part('templates/widgets/general/menu/level', 'end');
        $output .= ob_get_clean();
    }

}

class ListivoMenuElement
{
    /**
     * @var int
     */
    protected $depth;

    /**
     * @var WP_Post
     */
    protected $model;

    /**
     * MenuElement constructor.
     *
     * @param WP_Post $post
     * @param int $depth
     */
    public function __construct(WP_Post $post, $depth = 0)
    {
        $this->model = $post;
        $this->depth = $depth;
    }

    /**
     * @return string
     */
    public function getName()
    {
        if (property_exists($this->model, 'title')) {
            return $this->model->title;
        }

        return $this->model->post_title;
    }

    /**
     * @return false|mixed|string
     */
    public function getLink()
    {
        if (property_exists($this->model, 'url')) {
            return $this->model->url;
        }

        return get_the_permalink($this->model);
    }

    /**
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @return string
     */
    public function getElementId()
    {
        return 'menu-item-' . $this->model->ID;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        $classes = !empty($this->model->classes) ? $this->model->classes : [];
        $classes[] = 'menu-item-' . $this->model->ID;
        $classes = implode(
            ' ',
            apply_filters('nav_menu_css_class',
                array_filter($classes),
                $this->model,
                [],
                $this->depth
            )
        );

        return $classes;
    }

    /**
     * @return bool
     */
    public function isTargetBlank()
    {
        return get_post_meta($this->model->ID, '_menu_item_target', true) === '_blank';
    }
}

class ListivoMenuLevel
{
    /**
     * @var int
     */
    protected $depth;

    /**
     * MenuLevel constructor.
     *
     * @param int $depth
     */
    public function __construct($depth)
    {
        $this->depth = $depth;
    }

    /**
     * @return int
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @return string
     */
    public function getClass()
    {
        $classes = ['listivo-submenu listivo-submenu--level-' . $this->getDepth()];

        return implode(' ', $classes);
    }

}

add_action('wp_enqueue_scripts', static function () {
    if (is_singular('post') && comments_open()) {
        wp_enqueue_script('comment-reply', '/wp-includes/js/comment-reply.min.js', [], false, true);
    }
});

add_filter('get_the_archive_title', function ($title) {
    if (is_home()) {
        if (function_exists('tdf_string')) {
            return tdf_string('our_latest_news');
        }

        return esc_html__('Our Latest News', 'listivo');
    }

    return $title;
}, 20);

add_filter('get_the_archive_title', function ($title) {
    if (is_category()) {
        $title = single_cat_title('', false);
    } elseif (is_tag()) {
        $title = single_tag_title('', false);
    } elseif (is_author()) {
        $title = get_the_author();
    } elseif (is_post_type_archive()) {
        $title = post_type_archive_title('', false);
    }

    return $title;
});

add_filter('get_comment_author_link', function ($return, $author, $commentId) {
    $comment = get_comment($commentId);
    if (!$comment || empty($comment->user_id)) {
        return $return;
    }

    $url = get_author_posts_url($comment->user_id);
    if (empty($url)) {
        return $return;
    }

    $user = get_user_by('ID', $comment->user_id);
    if (!$user) {
        return $return;
    }

    return '<a href="' . $url . '">' . $user->display_name . '</a>';
}, 10, 3);

/**
 * @param string $template
 */
function listivo_load_template(string $template): void
{
    do_action('listivo/templates/prepareCss');

    get_header();

    if (class_exists(\Tangibledesign\Framework\Core\App::class)) :
        do_action('listivo/templates/render');
    else :
        get_template_part($template);
    endif;

    get_footer();
}