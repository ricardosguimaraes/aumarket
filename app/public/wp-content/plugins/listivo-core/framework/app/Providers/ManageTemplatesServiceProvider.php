<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Actions\Template\DuplicateTemplateAction;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Helpers\VerifyNonce;
use Tangibledesign\Framework\Models\Post\PostStatus;
use Tangibledesign\Framework\Models\Template\Helpers\HasLayoutInterface;
use Tangibledesign\Framework\Models\Template\Template;
use Tangibledesign\Framework\Helpers\CurrentUserCan;
use Tangibledesign\Framework\Models\Template\TemplateType\TemplateType;

class ManageTemplatesServiceProvider extends ServiceProvider
{
    use CurrentUserCan;
    use VerifyNonce;

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/template/create', [$this, 'create']);

        add_action('admin_post_' . tdf_prefix() . '/template/delete', [$this, 'delete']);

        add_action('admin_post_' . tdf_prefix() . '/template/duplicate', [$this, 'duplicate']);

        add_action('admin_post_' . tdf_prefix() . '/template/setDefault', [$this, 'setDefault']);
    }

    public function duplicate(): void
    {
        if (!$this->currentUserCanManageOptions()) {
            $this->errorJsonResponse();
            return;
        }

        $templateId = (int)($_POST['templateId'] ?? 0);
        if (empty($templateId)) {
            $this->errorJsonResponse();
            return;
        }

        $template = (new DuplicateTemplateAction())->duplicate($templateId);
        if (!$template) {
            $this->errorJsonResponse();
            return;
        }

        $this->successJsonResponse(compact('template'));
    }

    public function delete(): void
    {
        if (!$this->verifyNonce($_POST['nonce'] ?? '', tdf_prefix() . '/template/delete')) {
            return;
        }

        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $templateId = (int)($_POST['templateId'] ?? 0);
        if (empty($templateId)) {
            $this->errorJsonResponse();
            return;
        }

        wp_delete_post($templateId, true);

        $this->successJsonResponse();
    }

    /**
     * @return void
     */
    public function create(): void
    {
        if (!$this->verifyNonce($_POST['nonce'] ?? '', tdf_prefix() . '/template/create')) {
            return;
        }

        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $name = $_POST[Template::NAME] ?? 'New Template';
        $type = $_POST[Template::TYPE] ?? TemplateType::LAYOUT;

        $templateId = wp_insert_post([
            'post_title' => $name,
            'post_type' => tdf_prefix() . '_template',
            'post_status' => PostStatus::PUBLISH,
            'meta_input' => [
                Template::TYPE => $type,
            ]
        ]);

        if (is_wp_error($templateId)) {
            return;
        }

        $template = tdf_template_factory()->create($templateId);
        if (!$template instanceof Template) {
            return;
        }

        if ($template instanceof HasLayoutInterface && tdf_app('default_layout')) {
            /** @noinspection NullPointerExceptionInspection */
            $template->setLayoutId(tdf_app('default_layout')->getId());
        }

        wp_safe_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_templates&tab=' . $type));
        exit;
    }

    public function setDefault(): void
    {
        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $templateType = (string)($_POST['type'] ?? '');
        $templateId = (int)($_POST['templateId'] ?? 0);

        if (empty($templateType) || empty($templateId)) {
            $this->errorJsonResponse();
            return;
        }

        tdf_settings()->setDefaultTemplates([
            $templateType => $templateId
        ]);

        tdf_settings()->save();

        $this->successJsonResponse();
    }
}