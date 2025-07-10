<?php


namespace Tangibledesign\Framework\Models\Template;


use Elementor\Core\Base\Document;
use Elementor\Plugin;
use JsonSerializable;
use Tangibledesign\Framework\Models\Post\Post;
use Tangibledesign\Framework\Helpers\HasSettings;
use Tangibledesign\Framework\Models\Template\Helpers\HasTransparentMenu;
use WP_Post;

/**
 * Class Template
 * @package Tangibledesign\Framework\Models\Template
 */
abstract class Template extends Post implements JsonSerializable
{
    use HasSettings;
    use HasTransparentMenu;

    public const TYPE = 'type';
    public const NAME = 'name';

    /**
     * @var Document
     */
    protected $document;

    /**
     * Template constructor.
     *
     * @param WP_Post $post
     */
    public function __construct(WP_Post $post)
    {
        parent::__construct($post);

        $this->document = Plugin::instance()->documents->get($this->getId());
    }

    /**
     * @return Document|false
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @return string[]
     */
    public function getSettingKeys(): array
    {
        return [
            self::TYPE,
            self::NAME,
        ];
    }

    public function display(): void
    {
        if (is_singular(tdf_prefix() . '_template')) {
            $this->preparePreview();

            echo apply_filters('the_content', $this->post->post_content);
            return;
        }

        setup_postdata($this->post);
        echo Plugin::instance()->frontend->get_builder_content_for_display($this->getId());
        wp_reset_postdata();
    }

    public function preparePreview(): void
    {
        //
    }

    /**
     * @return string
     */
    public function getElementorEditUrl(): string
    {
        return $this->document->get_edit_url();
    }

    /**
     * @param string $type
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setType($type): void
    {
        $this->setMeta(self::TYPE, $type);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return (string)$this->getMeta(self::TYPE);
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'url' => $this->getUrl(),
            'name' => $this->getName(),
            'type' => $this->getType(),
            'editUrl' => $this->getElementorEditUrl(),
        ];
    }

}