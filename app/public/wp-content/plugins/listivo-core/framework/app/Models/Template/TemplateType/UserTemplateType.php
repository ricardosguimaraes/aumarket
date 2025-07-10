<?php


namespace Tangibledesign\Framework\Models\Template\TemplateType;


use Elementor\Core\Base\Document;
use Elementor\Plugin;
use Tangibledesign\Framework\Models\Template\UserTemplate;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;
use Tangibledesign\Framework\Widgets\Helpers\UserWidget;

/**
 * Class UserTemplateType
 * @package Tangibledesign\Framework\Models\Template\TemplateType
 */
class UserTemplateType extends TemplateType
{
    public const TYPE = 'user';

    /**
     * @return string
     */
    public function getName(): string
    {
        return tdf_admin_string('user_page');
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
        return is_a($widgetClass, UserWidget::class, true);
    }

    /**
     * @return string
     */
    public function getTemplateClass(): string
    {
        return UserTemplate::class;
    }

    /**
     * @param Document $document
     */
    public function addElementorControls(Document $document): void
    {
        $document->add_control(
            'preview_user',
            [
                'label' => tdf_admin_string('preview_user'),
                'type' => SelectRemoteControl::TYPE,
                'source' => get_rest_url() . 'wp/v2/users',
            ]
        );
    }

    public function prepare(): void
    {
        $user = get_user_by('slug', get_query_var('author_name'));

        global ${tdf_short_prefix() . 'User'};
        ${tdf_short_prefix() . 'User'} = $user ? tdf_user_factory()->create($user) : false;
    }

    public function preparePreview(): void
    {
        global ${tdf_short_prefix() . 'User'};
        ${tdf_short_prefix() . 'User'} = $this->getPreviewUser();
    }

    /**
     * @return false|User
     */
    private function getPreviewUser()
    {
        $user = $this->getSelectedPreviewUser();

        if (!$user) {
            return $this->getDefaultPreviewUser();
        }

        return $user;
    }

    /**
     * @return false|User
     */
    private function getSelectedPreviewUser()
    {
        global $post;
        if (!$post) {
            return false;
        }

        $document = Plugin::instance()->documents->get($post->ID);
        if (!$document) {
            return false;
        }

        $userId = (int)$document->get_settings('preview_user');
        return tdf_user_factory()->create($userId);
    }

    /**
     * @return User|false
     */
    private function getDefaultPreviewUser()
    {
        $users = tdf_query_users()->take(1)->get();

        return $users->isNotEmpty() ? $users->first() : false;
    }

}