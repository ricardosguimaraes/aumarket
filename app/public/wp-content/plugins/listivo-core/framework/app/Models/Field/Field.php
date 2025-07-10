<?php


namespace Tangibledesign\Framework\Models\Field;


use JsonSerializable;
use Tangibledesign\Framework\Models\Field\Helpers\HasSlugInterface;
use Tangibledesign\Framework\Models\Field\Helpers\Hintable;
use Tangibledesign\Framework\Models\Post\Post;
use Tangibledesign\Framework\Helpers\HasSettings;
use Tangibledesign\Framework\Models\Field\Helpers\FieldType;

/**
 * Class Field
 * @package Tangibledesign\Framework\Models\Field
 */
abstract class Field extends Post implements JsonSerializable
{
    use HasSettings;
    use Hintable;

    public const NAME = 'name';
    public const TYPE = 'type';
    public const REQUIRED = 'required';
    public const SLUG = 'slug';
    public const INPUT_PLACEHOLDER = 'input_placeholder';
    public const VALUE_VISIBILITY_BY_USER_ROLE = 'value_visibility_by_user_role';
    public const FRONTEND_PANEL_VISIBILITY_BY_USER_ROLE = 'frontend_panel_visibility_by_user_role';
    public const TEXT_BEFORE_VALUE = 'text_before_value';
    public const TEXT_AFTER_VALUE = 'text_after_value';
    public const HIDE_TERMS = 'hide_terms';
    public const DISPLAY_VALUE_WITH_FIELD_NAME = 'display_value_with_field_name';
    public const HINT = 'hint';

    /**
     * @return string[]
     */
    public function getSettingKeys(): array
    {
        return [
            self::NAME,
            self::REQUIRED,
            self::VALUE_VISIBILITY_BY_USER_ROLE,
            self::FRONTEND_PANEL_VISIBILITY_BY_USER_ROLE,
            self::HIDE_TERMS,
            self::HINT,
        ];
    }

    /**
     * @param  string  $type
     */
    public function setType(string $type): void
    {
        $this->setMeta(self::TYPE, $type);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        $type = $this->getMeta(self::TYPE);

        if (empty($type)) {
            return FieldType::TEXT;
        }

        return $type;
    }

    abstract public function getTypeLabel(): string;

    /**
     * @param  int  $required
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setRequired($required): void
    {
        $this->setMeta(self::REQUIRED, (int) $required);
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return !empty($this->getMeta(self::REQUIRED));
    }

    /**
     * @param $userRoles
     */
    public function setValueVisibilityByUserRole($userRoles): void
    {
        $this->setMeta(self::VALUE_VISIBILITY_BY_USER_ROLE, $userRoles);
    }

    /**
     * @return array
     */
    public function getValueVisibilityByUserRole(): array
    {
        $userRoles = $this->getMeta(self::VALUE_VISIBILITY_BY_USER_ROLE);

        if (!is_array($userRoles)) {
            return [];
        }

        return $userRoles;
    }

    /**
     * @return bool
     */
    public function isValueVisibleForAllUserRoles(): bool
    {
        return empty($this->getValueVisibilityByUserRole());
    }

    /**
     * @param  string  $userRole
     * @return bool
     */
    public function isValueVisibleForUserRole(string $userRole): bool
    {
        if ($this->isValueVisibleForAllUserRoles()) {
            return true;
        }

        return in_array($userRole, $this->getValueVisibilityByUserRole(), true);
    }

    /**
     * @return bool
     */
    public function isValueVisible(): bool
    {
        /** @noinspection NullPointerExceptionInspection */
        $userRole = is_user_logged_in() ? tdf_current_user()->getUserRole() : '';

        return $this->isValueVisibleForUserRole($userRole);
    }

    /**
     * @param  array  $userRoles
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setFrontendPanelVisibilityByUserRole($userRoles): void
    {
        $this->setMeta(self::FRONTEND_PANEL_VISIBILITY_BY_USER_ROLE, $userRoles);
    }

    /**
     * @return array
     */
    public function getFrontendPanelVisibilityByUserRole(): array
    {
        $userRoles = $this->getMeta(self::FRONTEND_PANEL_VISIBILITY_BY_USER_ROLE);

        if (!is_array($userRoles)) {
            return [];
        }

        return $userRoles;
    }

    /**
     * @return bool
     */
    public function isVisibleOnFrontendPanelForEveryone(): bool
    {
        return empty($this->getFrontendPanelVisibilityByUserRole());
    }

    /**
     * @param  string  $userRole
     * @return bool
     */
    public function isVisibleOnFrontendPanelForUserRole(string $userRole): bool
    {
        if ($this->isVisibleOnFrontendPanelForEveryone()) {
            return true;
        }

        return in_array($userRole, $this->getFrontendPanelVisibilityByUserRole(), true);
    }

    /**
     * @return string
     */
    public function getEditUrl(): string
    {
        return admin_url('admin.php?page='.tdf_app('slug').'-field-'.$this->getId());
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
                'id' => $this->getId(),
                'key' => $this->getKey(),
                'name' => $this->getName(),
                'slug' => $this instanceof HasSlugInterface ? $this->getSlug() : '',
                'type' => $this->getType(),
                'typeLabel' => $this->getTypeLabel(),
                'editUrl' => $this->getEditUrl(),
                'isRequired' => $this->isRequired(),
                'hideTerms' => $this->getHideTermIds(),
            ] + $this->getAdditionalJsonData();
    }

    /**
     * @return array
     */
    protected function getAdditionalJsonData(): array
    {
        return [];
    }

    /**
     * @param  array  $termIds
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setHideTerms($termIds): void
    {
        $this->setMeta(self::HIDE_TERMS, $termIds);
    }

    /**
     * @return array
     */
    public function getHideTermIds(): array
    {
        $termIds = $this->getMeta(self::HIDE_TERMS);
        if (!is_array($termIds) || empty($termIds)) {
            return [];
        }

        return tdf_collect($termIds)->map(static function ($termId) {
            return (int) $termId;
        })->filter(static function ($termId) {
            return !empty($termId);
        })->values();
    }

}