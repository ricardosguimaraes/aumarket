<?php

namespace Tangibledesign\Listivo\Providers\Listing;

use Tangibledesign\Framework\Actions\PaymentPackage\ApplyPackageAction;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\Field\NumberField;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\SalaryField;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Notification\Trigger;
use Tangibledesign\Framework\Models\Post\PostStatus;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Models\PanelFields\CustomPanelField;
use Tangibledesign\Framework\Models\PanelFields\PanelField;
use Tangibledesign\Framework\Widgets\General\PanelWidget;
use WP_Error;
use WP_Post;

class ListingFormServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/listings/create', [$this, 'create']);
        add_action('admin_post_nopriv_' . tdf_prefix() . '/listings/create', [$this, 'create']);

        add_action('admin_post_' . tdf_prefix() . '/listings/update', [$this, 'update']);
    }

    public function create(): void
    {
        if (!wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_create_model')) {
            $this->errorJsonResponse();
            return;
        }

        if (!is_user_logged_in() && !tdf_settings()->submitWithoutLogin()) {
            $this->errorJsonResponse();
            return;
        }

        $this->save();
    }

    public function update(): void
    {
        if (!wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_update_model')) {
            $this->errorJsonResponse();
            return;
        }

        $modelId = (int)($_POST['model']['id'] ?? 0);
        if (empty($modelId)) {
            $this->errorJsonResponse();
            return;
        }

        $post = get_post($modelId);
        /** @noinspection NullPointerExceptionInspection */
        if (!$post instanceof WP_Post || ((int)$post->post_author !== get_current_user_id() && !current_user_can('manage_options') && !tdf_current_user()->isModerator())) {
            $this->errorJsonResponse();
            return;
        }

        $this->setModelStatus($modelId);

        $this->save($modelId, true);
    }

    private function setModelStatus(int $modelId): void
    {
        $model = tdf_post_factory()->create($modelId);
        if (!$model instanceof Model) {
            return;
        }

        if (tdf_settings()->paymentsEnabled()) {
            if ($model->isPublished() && !$model->isExpired() && tdf_settings()->moderationEnabled() && tdf_settings()->moderationRequiredReApprove()) {
                $model->setPending();
            }
            return;
        }

        if (tdf_settings()->moderationEnabled() && (!$model->isApproved() || tdf_settings()->moderationRequiredReApprove())) {
            $model->setPending();
            return;
        }

        if (!$model->isPublished()) {
            $model->setPublish();
        }
    }

    /**
     * @param int|false $modelId
     * @param bool $update
     */
    public function save($modelId = false, bool $update = false): void
    {
        if (empty($_POST['model'])) {
            $this->errorJsonResponse();
            return;
        }

        $modelData = $_POST['model'];

        if ($modelId) {
            $this->updateModel($modelId, $modelData);
        } else {
            $modelId = $this->createNewModel($modelData);
            if ($modelId === false) {
                $this->errorJsonResponse();
                return;
            }
        }

        $model = tdf_post_factory()->create($modelId);
        if (!$model instanceof Model) {
            $this->errorJsonResponse();
            return;
        }

        $panelFields = $this->getPanelFields($modelData);

        foreach ($panelFields as $panelField) {
            /* @var PanelField $panelField */
            if (!$panelField->validate($modelData)) {
                $this->errorJsonResponse([
                    'title' => 'Required field is empty ' . $panelField->getLabel(),
                ]);
                return;
            }
        }

        foreach ($panelFields as $panelField) {
            /* @var PanelField $panelField */
            $panelField->update($model, $modelData);
        }

        $this->clearFields($model, $panelFields);

        if ($model->isPending()) {
            $userId = $model->getUserId();
            if (empty($userId)) {
                $userId = get_current_user_id();
            }

            do_action(tdf_prefix() . '/notifications/trigger', Trigger::USER_MODEL_PENDING, [
                'user' => $userId,
                'model' => $model->getId(),
            ]);

            do_action(tdf_prefix() . '/notifications/trigger', Trigger::MODERATION_MODEL_PENDING, [
                'user' => $userId,
                'model' => $model->getId(),
            ]);
        }

        if ($this->setExpireDate($model)) {
            $model->setExpireDateFromDays(tdf_settings()->getListingExpireAfter());
        }

        $response = [
            'title' => $this->getSuccessTitle($model->getStatus(), $update),
            'text' => $this->getSuccessText(),
            'modelId' => $modelId,
            'monetization' => tdf_settings()->paymentsEnabled(),
            'isUserLoggedIn' => is_user_logged_in(),
        ];

        /** @noinspection NotOptimalIfConditionsInspection */
        if (tdf_settings()->paymentsEnabled() && $this->assignPackage($model, (int)($modelData['packageId'] ?? 0))) {
            $response['redirect'] = PanelWidget::getUrl(PanelWidget::ACTION_LIST);
        }

        do_action(tdf_prefix() . '/model/update', $model, false);

        $this->successJsonResponse($response);
    }

    private function setExpireDate(Model $model): bool
    {
        return $model->isPublished()
            && !$model->hasExpireDate()
            && !tdf_settings()->paymentsEnabled()
            && !empty(tdf_settings()->getListingExpireAfter());
    }

    private function clearFields(Model $model, Collection $excludedFields): void
    {
        $excludedFieldKeys = $excludedFields
            ->map(function (PanelField $panelField) {
                return $panelField->getKey();
            })
            ->values();

        tdf_ordered_fields()
            ->filter(static function ($field) use ($excludedFieldKeys) {
                return !in_array($field->getKey(), $excludedFieldKeys, true);
            })
            ->each(static function (Field $field) use ($model) {
                if ($field instanceof PriceField || $field instanceof SalaryField || $field instanceof NumberField) {
                    $field->setValue($model, 0);
                }
            });
    }

    private function assignPackage(Model $model, int $packageId): bool
    {
        if (empty($packageId)) {
            return false;
        }

        /** @noinspection NullPointerExceptionInspection */
        $package = tdf_current_user()->getPaymentPackage($packageId);
        if (!$package) {
            return false;
        }

        if (!$model->isApproved() && tdf_settings()->moderationEnabled()) {
            $model->setPendingPackage($packageId);

            $model->setPending();

            do_action(tdf_prefix() . '/notifications/trigger', Trigger::USER_MODEL_PENDING, [
                'user' => $model->getUserId(),
                'model' => $model->getId(),
            ]);

            do_action(tdf_prefix() . '/notifications/trigger', Trigger::MODERATION_MODEL_PENDING, [
                'user' => $model->getUserId(),
                'model' => $model->getId(),
            ]);

            /** @noinspection NullPointerExceptionInspection */
            tdf_current_user()->decreasePackage($packageId);

            return true;
        }

        $mainCategory = tdf_settings()->getMainCategory();
        if ($mainCategory && !$package->verify($model, $mainCategory)) {
            return false;
        }

        $action = new ApplyPackageAction();
        if (!$action->apply($package, $model)) {
            return false;
        }

        if (!$model->isPublished()) {
            $model->setPublish();
        }

        if (!$model->hasExpireDate()) {
            $date = current_time('mysql');
            $dateGmt = get_gmt_from_date($date);

            $args = [
                'ID' => $model->getId(),
                'post_date' => $date,
                'post_date_gmt' => $dateGmt,
            ];

            wp_update_post($args);
        }

        return true;
    }

    private function getSuccessText(): string
    {
        if (!is_user_logged_in()) {
            return tdf_string('model_saved_success_text_when_user_not_logged_in');
        }

        return '';
    }

    private function getSuccessTitle(string $status, bool $update = false): string
    {
        if (!is_user_logged_in()) {
            return tdf_string('almost_there');
        }

        if ($status === PostStatus::DRAFT) {
            return tdf_string('listing_has_been_saved');
        }

        if ($status === PostStatus::PENDING) {
            return tdf_string('listing_is_awaiting_moderation');
        }

        if ($status === PostStatus::PUBLISH && !$update) {
            return tdf_string('listing_has_been_added');
        }

        return tdf_string('listing_has_been_saved');
    }

    /**
     * @param array $modelData
     * @return int|false
     */
    private function createNewModel(array $modelData)
    {
        $modelId = wp_insert_post([
            'post_title' => $modelData['name'] ?? '',
            'post_content' => $modelData['description'] ?? '',
            'post_type' => tdf_model_post_type(),
            'post_status' => $this->getNewModelStatus(),
            'author' => $this->getNewModelUserId(),
            'meta_input' => [
                Model::FEATURED => '0',
            ]
        ]);

        if ($modelId instanceof WP_Error) {
            return false;
        }

        if (!is_user_logged_in()) {
            setcookie(tdf_prefix() . '/model/new', $modelId, time() + (60 * 60), '/');
        }

        return $modelId;
    }

    private function updateModel(int $modelId, array $modelData): void
    {
        wp_update_post([
            'ID' => $modelId,
            'post_title' => $modelData['name'] ?? '',
            'post_content' => $modelData['description'] ?? '',
            'post_type' => tdf_model_post_type(),
        ]);
    }

    private function getNewModelUserId(): int
    {
        if (!is_user_logged_in()) {
            return 0;
        }

        return get_current_user_id();
    }

    private function getNewModelStatus(): string
    {
        if (!is_user_logged_in()) {
            return PostStatus::DRAFT;
        }

        if (tdf_settings()->paymentsEnabled()) {
            return PostStatus::DRAFT;
        }

        if (tdf_settings()->moderationEnabled()) {
            return PostStatus::PENDING;
        }

        return PostStatus::PUBLISH;
    }

    private function getPanelFields(array $modelData): Collection
    {
        $terms = tdf_collect();
        $dependencyTaxonomyFieldIds = $this->getDependencyTaxonomyFieldIds();
        $taxonomyFieldIds = tdf_taxonomy_fields()->map(static function ($field) {
            /* @var TaxonomyField $field */
            return $field->getId();
        })->values();
        $selectedTermIds = [];

        foreach ($modelData['attributes'] as $attribute) {
            if (!isset($attribute['value'])) {
                $attribute['value'] = [];
            }

            if (in_array((int)$attribute['id'], $dependencyTaxonomyFieldIds, true)) {
                foreach ($attribute['value'] as $termData) {
                    $terms[] = tdf_term_factory()->create((int)$termData['id']);
                }
            }

            if (in_array((int)$attribute['id'], $taxonomyFieldIds, true)) {
                foreach ($attribute['value'] as $termData) {
                    $selectedTermIds[] = (int)$termData['id'];
                }
            }
        }

        /** @noinspection NullPointerExceptionInspection */
        $userRole = is_user_logged_in() ? tdf_current_user()->getUserRole() : '';

        return tdf_ordered_fields()->filter(static function ($field) use ($terms, $selectedTermIds) {
            if ($field instanceof LocationField && empty(tdf_settings()->getGoogleMapsApiKey())) {
                return false;
            }

            foreach ($field->getHideTermIds() as $termId) {
                if (in_array($termId, $selectedTermIds, true)) {
                    return false;
                }
            }

            /* @var Field $field */
            foreach ($terms as $term) {
                /* @var CustomTerm $term */
                if (in_array($field->getId(), $term->getFieldDependencies(), true)) {
                    return true;
                }
            }

            $check = true;

            foreach (tdf_app('dependency_terms') as $term) {
                /* @var CustomTerm $term */
                if (in_array($field->getId(), $term->getFieldDependencies(), true)) {
                    $check = false;
                }
            }

            return $check;
        })->map(static function ($field) {
            /* @var Field $field */
            return CustomPanelField::create($field);
        })->filter(static function ($panelField) use ($userRole) {
            return $panelField instanceof PanelField && $panelField->visibleByUserRole($userRole);
        });
    }

    private function getDependencyTaxonomyFieldIds(): array
    {
        return tdf_taxonomy_fields()->filter(static function ($taxonomyField) {
            /* @var TaxonomyField $taxonomyField */
            return $taxonomyField->fieldDependency();
        })->map(static function ($taxonomyField) {
            /* @var TaxonomyField $taxonomyField */
            return $taxonomyField->getId();
        })->values();
    }
}