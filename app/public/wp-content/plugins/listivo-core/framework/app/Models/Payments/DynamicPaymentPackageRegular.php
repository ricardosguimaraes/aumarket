<?php

namespace Tangibledesign\Framework\Models\Payments;

use Tangibledesign\Framework\Actions\PaymentPackage\CreateRegularUserPaymentPackageAction;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\User\User;

class DynamicPaymentPackageRegular implements RegularUserPaymentPackageInterface, RegularPaymentPackageInterface, PaymentPackageInterface
{
    private string $key;
    private string $name;
    private string $label;
    private int $number;
    private float $price;
    private string $displayPrice;
    private int $expire;
    private int $featuredExpire;
    private array $categories = [];
    private int $bumpsNumber;
    private int $bumpsInterval;
    private string $text;

    public function __construct(array $data)
    {
        $this->key = (string)$data['key'];
        $this->name = (string)$data['name'];
        $this->label = (string)($data['label'] ?? '');
        $this->number = (int)$data['number'];
        $this->price = (float)$data['price'];
        $this->displayPrice = (string)$data['displayPrice'];
        $this->expire = (int)$data['expire'];
        $this->featuredExpire = (int)$data['featuredExpire'];
        $this->bumpsNumber = (int)($data['bumpsNumber'] ?? 0);
        $this->bumpsInterval = (int)($data['bumpsInterval'] ?? 0);
        $this->text = (string)($data['text'] ?? '');

        if (isset($data['categories']) && is_array($data['categories'])) {
            $this->categories = $data['categories'];
        }
    }

    public function createUserPaymentPackage(User $user): ?RegularUserPaymentPackageInterface
    {
        return (new CreateRegularUserPaymentPackageAction())->execute($user, $this);
    }

    public function getId(): int
    {
        return 0;
    }

    public function getNumber(): int
    {
        return $this->number;
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
        return $this->categories;
    }

    public function getExpire(): int
    {
        return $this->expire;
    }

    public function getFeaturedExpire(): int
    {
        return $this->featuredExpire;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getDisplayPrice(): string
    {
        if (empty($this->displayPrice)) {
            return tdf_string('free');
        }

        return $this->displayPrice;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isEmpty(): bool
    {
        return false;
    }

    /**
     * @param Model $model
     * @param TaxonomyField $mainCategory
     * @return bool
     */
    public function verify(Model $model, TaxonomyField $mainCategory): bool
    {
        return true;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function isFeatured(): bool
    {
        return false;
    }

    public function getType(): string
    {
        return BasePaymentPackage::TYPE_REGULAR;
    }

    public function isRegularPackage(): bool
    {
        return true;
    }

    public function getBumpsNumber(): int
    {
        return $this->bumpsNumber;
    }

    public function getBumpsInterval(): int
    {
        return $this->bumpsInterval;
    }

    public function isBumpPackage(): bool
    {
        return false;
    }

    public function getUserAccountType(): string
    {
        return 'any';
    }
}