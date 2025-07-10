<?php

namespace Tangibledesign\Framework\Models\Payments;


use Tangibledesign\Framework\Actions\PaymentPackage\ApplyBumpPackageAction;
use Tangibledesign\Framework\Models\Model;

class BumpUserPaymentPackage extends BaseUserPaymentPackage
{
    public const BUMPS_NUMBER = 'bumps_number';

    /**
     * @param int $number
     * @return void
     */
    public function setBumpsNumber(int $number): void
    {
        $this->setMeta(self::BUMPS_NUMBER, $number);
    }

    /**
     * @return int
     */
    public function getBumpsNumber(): int
    {
        $number = (int)$this->getMeta(self::BUMPS_NUMBER);
        if ($number < 0) {
            return 0;
        }

        return $number;
    }

    /**
     * @return void
     */
    public function decreaseBumpsNumber(): void
    {
        $this->setBumpsNumber($this->getBumpsNumber() - 1);
    }

    /**
     * @return void
     */
    public function decrease(): void
    {
        $this->decreaseBumpsNumber();
    }

    /**
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->getBumpsNumber() <= 0;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'key' => $this->getKey(),
            'name' => $this->getName(),
            self::BUMPS_NUMBER => $this->getBumpsNumber(),
        ];
    }

    /**
     * @param Model $model
     * @return bool
     */
    public function apply(Model $model): bool
    {
        return (new ApplyBumpPackageAction())->apply($this, $model);
    }

}