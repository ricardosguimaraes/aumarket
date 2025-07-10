<?php


namespace Tangibledesign\Framework\Models\Template\TemplateType;


use Elementor\Core\Base\Document;
use Elementor\Plugin;
use Tangibledesign\Framework\Models\BlogPost;
use Tangibledesign\Framework\Models\Template\PostSingleTemplate;
use Tangibledesign\Framework\Widgets\Helpers\PostSingleWidget;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

/**
 * Class PostSingleTemplateType
 * @package Tangibledesign\Framework\Models\Template\TemplateType
 */
class PostSingleTemplateType extends TemplateType
{
    public const TYPE = 'post_single';

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('post_single');
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return self::TYPE;
    }

    /**
     * @param string $widgetClass
     * @return bool
     */
    public function isWidgetCompatible(string $widgetClass): bool
    {
        return is_a($widgetClass, PostSingleWidget::class, true);
    }

    /**
     * @return string
     */
    public function getTemplateClass(): string
    {
        return PostSingleTemplate::class;
    }

    /**
     * @param Document $document
     */
    public function addElementorControls(Document $document): void
    {
        $document->add_control(
            'preview_post',
            [
                'label' => tdf_admin_string('preview_post'),
                'type' => SelectRemoteControl::TYPE,
                'source' => get_rest_url() . 'wp/v2/posts'
            ]
        );
    }

    public function prepare(): void
    {
        global $post, ${tdf_short_prefix() . 'BlogPost'};
        $blogPost = tdf_post_factory()->create($post);
        ${tdf_short_prefix() . 'BlogPost'} = $blogPost instanceof BlogPost ? $blogPost : false;
    }

    public function preparePreview(): void
    {
        global ${tdf_short_prefix() . 'BlogPost'};
        ${tdf_short_prefix() . 'BlogPost'} = $this->getPreviewBlogPost();
    }

    /**
     * @return BlogPost|false
     */
    private function getPreviewBlogPost()
    {
        $blogPost = $this->getSelectedPreviewBlogPost();

        if (!$blogPost) {
            return $this->getDefaultBlogPost();
        }

        return $blogPost;
    }

    /**
     * @return BlogPost|false
     */
    private function getSelectedPreviewBlogPost()
    {
        global $post;
        if (!$post) {
            return false;
        }

        $document = Plugin::instance()->documents->get($post->ID);
        if (!$document) {
            return false;
        }

        $blogPostId = (int)$document->get_settings('preview_post');
        $blogPost = tdf_post_factory()->create($blogPostId);
        if (!$blogPost instanceof BlogPost) {
            return false;
        }

        return $blogPost;
    }

    /**
     * @return BlogPost|false
     */
    private function getDefaultBlogPost()
    {
        $posts = tdf_query_posts()->anyStatus()->take(1)->get();

        return $posts->isNotEmpty() ? $posts->first() : false;
    }

}