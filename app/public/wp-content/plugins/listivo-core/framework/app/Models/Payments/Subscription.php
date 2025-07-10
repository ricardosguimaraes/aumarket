<?php

namespace Tangibledesign\Framework\Models\Payments;

use JsonSerializable;
use Tangibledesign\Framework\Actions\PaymentPackage\CreateRegularUserPaymentPackageAction;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Post\PostModel;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Traits\Payments\HasAccountType;
use Tangibledesign\Framework\Traits\Payments\HasRegularPackageAttributes;

class Subscription extends PostModel implements JsonSerializable, PaymentPackageInterface, RegularPaymentPackageInterface, SelectSubscriptionInterface, SubscriptionInterface
{
    use HasRegularPackageAttributes;
    use HasAccountType;

    public function setData(array $data): void
    {
        if (isset($data['name'])) {
            $this->setName($data['name']);
        }

        if (isset($data['user_account_type'])) {
            $this->setUserAccountType($data['user_account_type']);
        }

        if (isset($data['number'])) {
            $this->setNumber($data['number']);
        }

        if (isset($data['expire'])) {
            $this->setExpire($data['expire']);
        }

        if (isset($data['featured_expire'])) {
            $this->setFeaturedExpire($data['featured_expire']);
        }

        if (isset($data['bumps_number'])) {
            $this->setBumpsNumber($data['bumps_number']);
        }

        if (isset($data['bumps_interval'])) {
            $this->setBumpsInterval($data['bumps_interval']);
        }

        if (isset($data['stripe_product_id'])) {
            $this->setStripeProductId($data['stripe_product_id']);
        }

        if (isset($data['stripe_price_id'])) {
            $this->setStripePriceId($data['stripe_price_id']);
        }

        if (isset($data['stripe_price'])) {
            $this->setStripePrice($data['stripe_price']);
        }

        $this->setLabel($data['label'] ?? '');

        $this->setDisplayPrice($data['display_price'] ?? '');

        $this->setText($data['text'] ?? '');

        $this->setFeatured((int)($data['featured'] ?? 0));
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->getId(),
            'key' => $this->getKey(),
            'name' => $this->getName(),
            'userAccountTypeLabel' => $this->getUserAccountTypeLabel(),
        ];
    }

    public function getStripeProductId(): string
    {
        return (string)$this->getMeta('stripe_product_id');
    }

    public function setStripeProductId(string $stripeProductId): void
    {
        $this->setMeta('stripe_product_id', $stripeProductId);
    }

    public function getStripePriceId(): string
    {
        return (string)$this->getMeta('stripe_price_id');
    }

    public function setStripePriceId(string $stripePriceId): void
    {
        $this->setMeta('stripe_price_id', $stripePriceId);
    }

    public function getStripePrice(): float
    {
        return (float)$this->getMeta('stripe_price');
    }

    public function setStripePrice($stripePrice): void
    {
        $this->setMeta('stripe_price', (float)$stripePrice);
    }

    public function getStripeCurrency(): string
    {
        return tdf_settings()->getStripeCurrency();
    }

    public function getText(): string
    {
        return (string)$this->getMeta('text');
    }

    public function setText(string $text): void
    {
        $this->setMeta('text', $text);
    }

    public function isFeatured(): bool
    {
        return !empty($this->getMeta('featured'));
    }

    public function setFeatured($featured): void
    {
        $this->setMeta('featured', (int)$featured);
    }

    public function getLabel(): string
    {
        return (string)$this->getMeta('label');
    }

    public function setLabel($label): void
    {
        $this->setMeta('label', (string)$label);
    }

    public function getDisplayPrice(): string
    {
        return (string)$this->getMeta('display_price');
    }

    public function setDisplayPrice($displayPrice): void
    {
        $this->setMeta('display_price', (string)$displayPrice);
    }

    public function getBackendEditUrl(): string
    {
        return admin_url('admin.php?page=' . tdf_prefix() . '-edit-subscription&subscription_id=' . $this->getId());
    }

    public function isGeneral(): bool
    {
        return true;
    }

    public function getCategories(): Collection
    {
        return tdf_collect();
    }

    public function getCategoryIds(): array
    {
        return [];
    }

    public function getPrice(): float
    {
        return $this->getDisplayPrice();
    }

    public function isRegularPackage(): bool
    {
        return true;
    }

    public function getType(): string
    {
        return 'subscription';
    }

    public function createUserPaymentPackage(User $user): ?RegularUserPaymentPackageInterface
    {
        return (new CreateRegularUserPaymentPackageAction())->execute($user, $this);
    }

}