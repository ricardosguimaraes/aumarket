<?php

namespace Tangibledesign\Framework\Models\Payments;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Post\Post;
use Tangibledesign\Framework\Models\Post\PostStatus;
use Tangibledesign\Framework\Models\Term\CustomTerm;
use Tangibledesign\Framework\Traits\Payments\HasAccountType;
use WC_Product;
use WP_Query;

abstract class BasePaymentPackage extends Post implements PaymentPackageInterface, SavePaymentPackage
{
    use HasAccountType;

    public const NAME = 'name';
    public const PRICE = 'price';
    public const DISPLAY_PRICE = 'display_price';
    public const LABEL = 'label';
    public const PRODUCT_ID = 'product_id';
    public const TYPE = 'type';
    public const TYPE_REGULAR = 'regular';
    public const TYPE_BUMP = 'bumps';
    public const TEXT = 'text';
    public const FEATURED = 'featured';
    public const CATEGORIES = 'categories';
    public const USER_ACCOUNT_TYPE = 'user_account_type';

    public function getType(): string
    {
        $type = $this->getMeta(self::TYPE);
        if (empty($type)) {
            return self::TYPE_REGULAR;
        }

        return $type;
    }

    public function setType($type): void
    {
        $this->setMeta(self::TYPE, (string) $type);
    }

    public function getName(): string
    {
        $name = parent::getName();

        if (empty($name)) {
            return sprintf(tdf_admin_string('payment_package_#'), $this->getId());
        }

        return $name;
    }

    /**
     * @param  float  $price
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setPrice($price): void
    {
        $this->setMeta(self::PRICE, $price);
    }

    public function getPrice(): float
    {
        return (float) $this->getMeta(self::PRICE);
    }

    public function getDisplayPrice(): string
    {
        return (string) $this->getMeta(self::DISPLAY_PRICE);
    }

    public function setDisplayPrice($displayPrice): void
    {
        $this->setMeta(self::DISPLAY_PRICE, $displayPrice);
    }

    public function getLabel(): string
    {
        return (string) $this->getMeta(self::LABEL);
    }

    public function setLabel($label): void
    {
        $this->setMeta(self::LABEL, $label);
    }

    public function getProductId(): int
    {
        return (int) $this->getMeta(self::PRODUCT_ID);
    }

    /**
     * @return WC_Product|false
     */
    public function getProduct()
    {
        $productId = $this->getProductId();

        if (empty($productId)) {
            return false;
        }

        if (!function_exists('wc_get_product')) {
            return false;
        }

        return wc_get_product($productId);
    }

    public function isProductAssigned(): bool
    {
        return $this->getProduct() !== false;
    }

    public function assignProduct($productId): void
    {
        $productId = (int) $productId;

        $this->setMeta(self::PRODUCT_ID, $productId);
    }

    /**
     * @param  int  $productId
     * @return PaymentPackageInterface|false
     * @noinspection PhpMissingParamTypeInspection
     */
    public static function getByAssignedProduct($productId)
    {
        $query = new WP_Query([
            'post_type' => tdf_prefix().'_package',
            'post_status' => PostStatus::PUBLISH,
            'posts_per_page' => -1,
            'meta_key' => self::PRODUCT_ID,
            'meta_value' => (string) $productId
        ]);

        foreach ($query->posts as $post) {
            $paymentPackage = tdf_post_factory()->create($post);
            if ($paymentPackage instanceof PaymentPackageInterface) {
                return $paymentPackage;
            }
        }

        return false;
    }

    public function getText(): string
    {
        return (string) $this->getMeta(self::TEXT);
    }

    public function setText($text): void
    {
        $this->setMeta(self::TEXT, (string) $text);
    }

    public function isFeatured(): bool
    {
        return !empty((int) $this->getMeta(self::FEATURED));
    }

    public function setFeatured($isFeatured): void
    {
        $this->setMeta(self::FEATURED, (int) $isFeatured);
    }

    public function isRegularPackage(): bool
    {
        return $this instanceof PaymentPackage;
    }

    public function isBumpPackage(): bool
    {
        return $this instanceof BumpPaymentPackage;
    }

    public function setCategories($categoryIds): void
    {
        if (is_array($categoryIds)) {
            $categoryIds = array_unique($categoryIds);
        }

        $this->setMeta(self::CATEGORIES, $categoryIds);
    }

    public function getCategoryIds(): array
    {
        $categoryIds = $this->getMeta(self::CATEGORIES);

        if (empty($categoryIds) || !is_array($categoryIds)) {
            return [];
        }

        return tdf_collect($categoryIds)->map(static function ($categoryId) {
            return (int) $categoryId;
        })->values();
    }

    public function isGeneral(): bool
    {
        if (!tdf_settings()->getMainCategory()) {
            return true;
        }

        return $this->getCategories()->isEmpty();
    }

    /**
     * @return Collection|CustomTerm[]
     */
    public function getCategories(): Collection
    {
        if (!tdf_settings()->getMainCategory()) {
            return tdf_collect();
        }

        $categoryIds = $this->getCategoryIds();
        if (empty($categoryIds)) {
            return tdf_collect();
        }

        return tdf_query_terms(tdf_settings()
            ->getMainCategory()->getKey())
            ->in($categoryIds)
            ->get();
    }
}