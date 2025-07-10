<?php

namespace Tangibledesign\Framework\Providers;

use Elementor\Controls_Manager;
use Elementor\Core\Base\Document;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Template\TemplateType\LayoutTemplateType;
use Tangibledesign\Framework\Models\Template\TemplateType\TemplateType;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;
use WP_Post;

class ElementorTemplateSettingsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('elementor/documents/register_controls', [$this, 'elementorSettingControls'], 9999);

        add_action('elementor/documents/register_controls', [$this, 'removeSettingControls']);

        add_action('elementor/documents/register_controls', [$this, 'pageSettingControls']);

        add_action('elementor/editor/footer', [$this, 'elementorEditor']);
    }

    public function elementorEditor(): void
    {
        tdf_load_view('elementor/editor');
    }

    public function pageSettingControls(Document $document): void
    {
        $post = $this->getPost($document);
        if (!$post instanceof WP_Post || $post->post_type !== 'page') {
            return;
        }

        $this->addSelectLayoutControl($document);

        $this->addTransparentMenuControl($document);
    }

    public function elementorSettingControls(Document $document): void
    {
        $post = $this->getPost($document);
        if (!$post instanceof WP_Post) {
            return;
        }

        if ($post->post_type !== tdf_prefix().'_template') {
            return;
        }

        $templateType = tdf_template_type_factory()->getCurrent();
        if (!$templateType) {
            return;
        }

        $this->addSettingControls($document, $templateType);
    }

    private function addSettingControls(Document $document, TemplateType $templateType): void
    {
        if ($templateType->getType() !== LayoutTemplateType::TYPE) {
            $this->addSelectLayoutControl($document);

            $this->addTransparentMenuControl($document);
        }

        $document->start_injection([
            'of' => 'post_status'
        ]);

        $templateType->addElementorControls($document);

        $document->end_injection();
    }

    private function getPost(Document $document): ?WP_Post
    {
        $post = $document->get_post();

        if (($postId = wp_is_post_revision($post)) !== false) {
            $post = get_post($postId);
        }

        return $post;
    }

    private function addTransparentMenuControl(Document $document): void
    {
        $document->start_injection([
            'of' => 'post_status'
        ]);

        $document->add_control(
            'tdf_transparent_menu',
            [
                'label' => tdf_admin_string('transparent_menu'),
                'type' => Controls_Manager::SWITCHER,
                'return_value' => '1',
                'default' => '0',
            ]
        );

        $document->end_injection();
    }

    private function addSelectLayoutControl(Document $document): void
    {
        $document->start_injection([
            'of' => 'post_status'
        ]);

        $document->add_control(
            'tdf_layout',
            [
                'label' => tdf_admin_string('layout'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url('tdf/api/layouts'),
                'description' => tdf_admin_string('change_layout_description')
            ]
        );

        $document->end_injection();
    }

    public function removeSettingControls(Document $document): void
    {
        $controls = $document->get_controls();

        if (isset($controls['template'])) {
            $document->remove_control('template');
        }

        if (isset($controls['template_default_description'])) {
            $document->remove_control('template_default_description');
        }

        if (isset($controls['template_canvas_description'])) {
            $document->remove_control('template_canvas_description');
        }

        if (isset($controls['template_header_footer_description'])) {
            $document->remove_control('template_header_footer_description');
        }

        if (isset($controls['hide_title'])) {
            $document->remove_control('hide_title');
        }
    }

}