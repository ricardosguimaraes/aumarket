<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Actions\Field\DeleteFieldAction;
use Tangibledesign\Framework\Helpers\VerifyNonce;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\Helpers\FieldType;
use Tangibledesign\Framework\Models\Post\PostStatus;

/**
 * Class ManageFieldsServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class ManageFieldsServiceProvider extends ServiceProvider
{
    use VerifyNonce;

    /**
     * @return void
     */
    public function afterInitiation(): void
    {
        add_action('admin_post_'.tdf_prefix().'/field/create', [$this, 'create']);

        add_action('admin_post_'.tdf_prefix().'/field/update', [$this, 'update']);

        add_action('admin_post_'.tdf_prefix().'/field/delete', [$this, 'delete']);

        add_action('admin_post_'.tdf_prefix().'/field/updateOrder', function () {
            if (!isset($_POST['fieldIds']) || !$this->currentUserCanManageOptions()) {
                return;
            }

            tdf_settings()->setFieldsOrder($_POST['fieldIds']);

            tdf_settings()->save();
        });
    }

    /**
     * @return void
     */
    public function create(): void
    {
        if (!$this->verifyNonce($_POST['nonce'] ?? '', tdf_prefix().'/field/create')) {
            return;
        }

        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $name = $_POST[Field::NAME] ?? 'New Field';
        $type = $_POST[Field::TYPE] ?? FieldType::TAXONOMY;

        $fieldId = wp_insert_post([
            'post_title' => $name,
            'post_type' => tdf_prefix().'_field',
            'post_status' => PostStatus::PUBLISH,
            'meta_input' => [
                Field::TYPE => $type,
            ]
        ]);

        if (!is_int($fieldId)) {
            return;
        }

        tdf_settings()->addField($fieldId);

        wp_safe_redirect(admin_url('admin.php?page='.tdf_prefix().'-field-'.$fieldId));
        exit;
    }

    /**
     * @return void
     */
    public function update(): void
    {
        if (!$this->verifyNonce($_POST['nonce'] ?? '', tdf_prefix().'/field/update')) {
            return;
        }

        if (!$this->currentUserCanManageOptions()) {
            return;
        }

        $id = (int)($_POST['id'] ?? 0);
        if (empty($id)) {
            return;
        }

        $field = tdf_post_factory()->create($id);
        if (!$field instanceof Field) {
            return;
        }

        $field->updateSettings($_POST);

        do_action(tdf_prefix().'/fields/updated', $field);

        wp_safe_redirect(admin_url('admin.php?page='.tdf_prefix().'_custom_fields'));
        exit;
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        if (!isset($_POST['fieldId']) || !$this->currentUserCanManageOptions()) {
            return;
        }

        (new DeleteFieldAction())->delete((int)$_POST['fieldId']);
    }

}