<?php

namespace Tangibledesign\Framework\Models\Payments;

use Tangibledesign\Framework\Models\Model;

interface UserPaymentPackageInterface
{
    /**
     * @return int
     */
    public function getId(): int;

    /**
     * @return string
     */
    public function getKey(): string;

    /**
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * @return string
     */
    public function getDisplayPrice(): string;

    /**
     * @param int $paymentPackageId
     * @return void
     * @noinspection PhpMissingParamTypeInspection
     */
    public function setPaymentPackage($paymentPackageId): void;

    /**
     * @return int
     */
    public function getPaymentPackageId(): int;

    /**
     * @return PaymentPackageInterface|false
     */
    public function getPaymentPackage();

    /**
     * @param int $orderId
     * @return void
     */
    public function assignOrder(int $orderId): void;

    /**
     * @param Model $model
     * @return bool
     */
    public function apply(Model $model): bool;

    /**
     * @return void
     */
    public function decrease(): void;

}