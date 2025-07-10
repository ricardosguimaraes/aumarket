<?php

namespace Tangibledesign\Framework\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Actions\Panel\GetOrderedModelFormFieldsAction;
use Tangibledesign\Framework\Actions\Panel\GetCurrentActionAction;
use Tangibledesign\Framework\Actions\Panel\GetModelFormFieldsAction;
use Tangibledesign\Framework\Actions\Panel\GetPanelTemplateAction;
use Tangibledesign\Framework\Actions\Panel\GetPanelTitleAction;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Models\PanelFields\AttachmentsPanelField;
use Tangibledesign\Framework\Models\PanelFields\DescriptionPanelField;
use Tangibledesign\Framework\Models\PanelFields\EmbedPanelField;
use Tangibledesign\Framework\Models\PanelFields\GalleryPanelField;
use Tangibledesign\Framework\Models\PanelFields\LocationPanelField;
use Tangibledesign\Framework\Models\PanelFields\NamePanelField;
use Tangibledesign\Framework\Models\PanelFields\PanelField;
use Tangibledesign\Framework\Models\PanelFields\RichTextPanelField;
use Tangibledesign\Framework\Models\PanelFields\TaxonomyPanelField;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;

abstract class PanelWidget extends BaseGeneralWidget
{
    public const ACTION = 'action';
    public const ACTION_LIST = 'list';
    public const ACTION_MODERATION = 'moderation';
    public const ACTION_SETTINGS = 'settings';
    public const ACTION_CREATE = 'create';
    public const ACTION_EDIT = 'edit';
    public const ACTION_MESSAGES = 'messages';
    public const ACTION_FAVORITES = 'favorites';
    public const ACTION_SELECT_PACKAGE = 'select_package';
    public const ACTION_BUY_PACKAGE = 'buy_package';
    public const ACTION_MY_PACKAGES = 'my_packages';
    public const ACTION_PROMOTE = 'promote';
    public const ACTION_EXTEND = 'extend';
    public const ACTION_BUMP_UP = 'bump_up';
    public const ACTION_MY_ORDERS = 'my_orders';
    public const ACTION_ORDERS = 'orders';
    public const ACTION_VERIFY_PHONE = 'verify_phone';
    public const ACTION_SET_PHONE = 'set_phone';
    public const ACTION_SELECT_SUBSCRIPTION = 'select_subscription';
    public const ACTION_SELECT_SUBSCRIPTION_SUCCESS = 'select_subscription_success';
    public const ACTION_SELECT_SUBSCRIPTION_CANCEL = 'select_subscription_cancel';
    public const ACTION_SUBSCRIPTION_CANCELED = 'subscription_canceled';
    public const ACTION_UPDATE_PAYMENT_METHOD_SUCCESS = 'update_payment_method_success';
    public const ACTION_UPDATE_PAYMENT_METHOD_CANCEL = 'update_payment_method_cancel';

    protected ?Collection $formFields = null;

    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $this->registerMapDeps();
    }

    public function get_script_depends(): array
    {
        return $this->getMapScriptDeps();
    }

    public function getKey(): string
    {
        return 'panel';
    }

    public function getName(): string
    {
        return tdf_admin_string('panel');
    }

    protected function loadTemplate(): void
    {
        get_template_part('templates/widgets/' . $this->getTemplateDirectory() . 'panel/' . $this->getKey());
    }

    public static function getAction(): string
    {
        return (new GetCurrentActionAction())->execute();
    }

    public function isActionActive(string $action): bool
    {
        return $action === self::getAction();
    }

    public function getTitle(): string
    {
        return (new GetPanelTitleAction())->execute(self::getAction());
    }

    public function loadPanelTemplate(): void
    {
        get_template_part((new GetPanelTemplateAction())->execute(self::getAction()));
    }

    public static function getUrl(string $action): string
    {
        return site_url() . '/' . tdf_slug('panel') . '/' . tdf_slug($action) . '/';
    }

    abstract public function getModels(): Collection;

    protected function getPage(): int
    {
        return (int)($_GET[tdf_slug('pagination')] ?? 1);
    }

    protected function getLimit(): int
    {
        return 10;
    }

    public function getSortByOptions(): array
    {
        return [
            [
                'id' => tdf_slug('newest'),
                'name' => tdf_string('newest'),
            ],
            [
                'id' => tdf_slug('oldest'),
                'name' => tdf_string('oldest'),
            ]
        ];
    }

    /**
     * @return Collection|PanelField[]
     */
    public function getFields(): Collection
    {
        if ($this->formFields) {
            return $this->formFields;
        }

        return $this->formFields = (new GetModelFormFieldsAction())->execute();
    }

    public function getOrderedFields(): Collection
    {
        $fieldsData = $this->get_settings_for_display('form_fields') ?? [];
        if (empty($fieldsData)) {
            return tdf_collect();
        }

        return (new GetOrderedModelFormFieldsAction())->execute($fieldsData);
    }

    /**
     * @return Collection|PanelField[]
     */
    public function getSingleValueFields(): Collection
    {
        return $this->getFields()->filter(static function ($field) {
            /* @var PanelField $field */
            return $field->isSingleValue();
        });
    }

    public function getNameField(): NamePanelField
    {
        return $this->getFields()->find(static function ($field) {
            return $field instanceof NamePanelField;
        });
    }

    /**
     * @return Collection|EmbedPanelField[]
     */
    public function getEmbedFields(): Collection
    {
        return $this->getFields()->filter(static function ($field) {
            return $field instanceof EmbedPanelField;
        });
    }

    /**
     * @return TaxonomyPanelField|false
     */
    public function getMainCategoryField()
    {
        $mainCategory = tdf_settings()->getMainCategory();
        if (!$mainCategory instanceof TaxonomyField) {
            return false;
        }

        return $this->getFields()->find(static function ($panelField) use ($mainCategory) {
            /* @var PanelField $panelField */
            return $panelField->getKey() === $mainCategory->getKey();
        });
    }

    /**
     * @return Collection|GalleryPanelField[]
     */
    public function getGalleryFields(): Collection
    {
        return $this->getFields()->filter(static function ($field) {
            return $field instanceof GalleryPanelField;
        });
    }

    /**
     * @return Collection|AttachmentsPanelField[]
     */
    public function getAttachmentsFields(): Collection
    {
        return $this->getFields()->filter(static function ($field) {
            return $field instanceof AttachmentsPanelField;
        });
    }

    /**
     * @return Collection|DescriptionPanelField[]
     */
    public function getDescriptionFields(): Collection
    {
        return $this->getFields()->filter(static function ($field) {
            return $field instanceof DescriptionPanelField;
        });
    }

    /**
     * @return Collection|RichTextPanelField[]
     */
    public function getRichTextFields(): Collection
    {
        return $this->getFields()->filter(static function ($field) {
            return $field instanceof RichTextPanelField;
        });
    }

    /**
     * @return Collection|LocationField[]
     */
    public function getLocationFields(): Collection
    {
        return $this->getFields()->filter(static function ($field) {
            return $field instanceof LocationPanelField;
        });
    }

    public function getMultipleValueTaxonomyFields(): Collection
    {
        return $this->getFields()->filter(static function ($field) {
            if (!$field instanceof TaxonomyPanelField) {
                return false;
            }

            $taxonomyField = $field->getField();
            /* @var TaxonomyField $taxonomyField */
            return $taxonomyField->multipleValues() && !$taxonomyField->isMultilevel();
        });
    }

    public function getMultilevelTaxonomyFields(): Collection
    {
        return $this->getFields()->filter(static function ($field) {
            if (!$field instanceof TaxonomyPanelField) {
                return false;
            }

            $taxonomyField = $field->getField();
            /* @var TaxonomyField $taxonomyField */
            return $taxonomyField->isMultilevel();
        });
    }

    public function getUserSettings(): array
    {
        $user = tdf_current_user();
        if (!$user instanceof User) {
            return [];
        }

        return [
            'name' => $user->getDisplayName(),
            'email' => $user->getMail(),
            'phone' => $user->getPhone(),
            'whatsApp' => $user->isWhatsAppEnabled(),
            'viber' => $user->isViberEnabled(),
            'description' => $user->getDescription(),
            'address' => $user->getAddress(),
            'accountType' => $user->getAccountType(),
            'website' => $user->getWebsite(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
            'companyInformation' => $user->getCompanyInformation(),
            'phoneCountryCode' => $user->getPhoneCountryCode(),
            'marketingConsent' => $user->hasMarketingConsent(),
        ];
    }

    public function getUserSocials(): array
    {
        $user = tdf_current_user();
        if (!$user instanceof User) {
            return [];
        }

        return [
            'youtube' => $user->getYouTubeProfile(),
            'facebook' => $user->getFacebookProfile(),
            'twitter' => $user->getTwitterProfile(),
            'linkedin' => $user->getLinkedInProfile(),
            'instagram' => $user->getInstagramProfile(),
            'tiktok' => $user->getTikTokProfile(),
            'telegram' => $user->getTelegramProfile(),
            'ebay' => $user->getEbayProfile(),
        ];
    }

    public function getUserImageDropZoneConfig(): array
    {
        return [
            'url' => tdf_action_url(tdf_prefix() . '/user/image/save'),
            'thumbnailWidth' => 200,
            'addRemoveLinks' => false,
            'dictDefaultMessage' => '<i class="far fa-images"></i> ' . tdf_string('add_image'),
            'parallelUploads' => 1,
            'acceptedFiles' => 'image/*',
            'maxFiles' => 1,
        ];
    }

    public function getUserImageData(User $user): array
    {
        return [
            'id' => $user->getImageId(),
            'url' => $user->getImageUrl()
        ];
    }

    public function getUserCoverImageDropZoneConfig(): array
    {
        return [
            'url' => admin_url('admin-ajax.php?action=' . tdf_prefix() . '/user/cover_image/save'),
            'thumbnailWidth' => 600,
            'addRemoveLinks' => false,
            'dictDefaultMessage' => '<i class="far fa-images"></i> ' . tdf_string('add_cover_image'),
            'parallelUploads' => 1,
            'acceptedFiles' => 'image/*',
            'maxFiles' => 1,
        ];
    }

    public function getUserCoverImageData(User $user): array
    {
        return [
            'id' => $user->getCoverImageId(),
            'url' => $user->getCoverImageUrl()
        ];
    }

    public function getModelFormRedirectUrl(): string
    {
        if (!is_user_logged_in() || !tdf_settings()->paymentsEnabled()) {
            return tdf_settings()->getPanelPageUrl();
        }

        return self::getUrl(self::ACTION_SELECT_PACKAGE);
    }

    public function getUpdateModelFormRedirectUrl(Model $model): string
    {
        if ($this->isModerationMode()) {
            return self::getUrl(self::ACTION_MODERATION);
        }

        if (!is_user_logged_in() || !tdf_settings()->paymentsEnabled()) {
            return tdf_settings()->getPanelPageUrl();
        }

        if (!$model->isExpired() && ($model->isPublished() || $model->isPending())) {
            return tdf_settings()->getPanelPageUrl();
        }

        return self::getUrl(self::ACTION_SELECT_PACKAGE);
    }

    private function isModerationMode(): bool
    {
        /** @noinspection NullPointerExceptionInspection */
        if (!is_user_logged_in() || !tdf_current_user()->isModerator()) {
            return false;
        }

        return !empty($_GET['type']) && $_GET['type'] === 'moderation';
    }

    public function getAllListingNumber(): int
    {
        return $this->getActiveListingNumber() + $this->getPendingListingNumber() + $this->getDraftListingNumber();
    }

    public function getActiveListingNumber(): int
    {
        return wp_count_posts(tdf_model_post_type())->publish;
    }

    public function getPendingListingNumber(): int
    {
        return wp_count_posts(tdf_model_post_type())->pending;
    }

    public function getDraftListingNumber(): int
    {
        return wp_count_posts(tdf_model_post_type())->draft;
    }

    /**
     * @return Model|false
     */
    public function getSelectPackageModel()
    {
        if (empty($_GET['id'])) {
            return false;
        }

        $model = tdf_post_factory()->create((int)$_GET['id']);
        if (!$model instanceof Model) {
            return false;
        }

        return $model;
    }

    private function addFormFieldsControl(): void
    {
        $fields = new Repeater();
        $fieldLabels = json_encode($this->getFormFieldsOptions());

        $fields->add_control(
            'field',
            [
                'label' => tdf_admin_string('field'),
                'type' => Controls_Manager::SELECT,
                'options' => $this->getFormFieldsOptions(),
            ]
        );

        $this->add_control(
            'form_fields',
            [
                'label' => tdf_admin_string('form_fields'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $fields->get_controls(),
                'prevent_empty' => false,
                'title_field' => "<# "
                    . "let labels = $fieldLabels; "
                    . "let label = labels[field]; "
                    . "#>"
                    . "{{{ label }}}",
            ]
        );
    }

    private function getFormFieldsOptions(): array
    {
        $fields = [];

        if (tdf_settings()->getAutoGenerateModelTitleFields()->isEmpty()) {
            $fields['name'] = tdf_admin_string('name');
        }

        $fields['description'] = tdf_admin_string('description');

        foreach (tdf_ordered_fields() as $field) {
            $fields[$field->getKey()] = $field->getName();
        }

        return $fields;
    }

    protected function addMainContentSection(): void
    {
        $this->startContentControlsSection();

        $this->add_control(
            'form_fields_warning',
            [
                'type' => Controls_Manager::RAW_HTML,
                'raw' => tdf_admin_string('form_fields_warning'),
                'content_classes' => 'elementor-panel-alert elementor-panel-alert-warning',
            ]
        );

        $this->addFormFieldsControl();

        $this->endControlsSection();
    }

}