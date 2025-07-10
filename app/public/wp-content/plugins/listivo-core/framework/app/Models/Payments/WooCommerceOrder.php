<?php

namespace Tangibledesign\Framework\Models\Payments;

class WooCommerceOrder extends Order
{
    public function getOrderId(): string
    {
        return $this->getWooCommerceOrderId();
    }

    public function getLabel(): string
    {
        $paymentPackage = $this->getPaymentPackage();
        if ($paymentPackage === null) {
            return '';
        }

        return $paymentPackage->getName();
    }

    public function getPrice(): string
    {
        return (string)$this->getMeta('price');
    }

    public function getPaymentMethod(): string
    {
        return (string)$this->getMeta('payment_method');
    }

    public function setStatus(string $status): void
    {
        parent::setStatus($status);

        $wcOrderId = $this->getWooCommerceOrderId();
        if (empty($wcOrderId)) {
            return;
        }

        $wcOrder = wc_get_order($wcOrderId);
        if (empty($wcOrder)) {
            return;
        }

        $wcOrder->update_status($status, '', true);
    }

    public function getWooCommerceOrderId(): int
    {
        return (int)$this->getMeta('wc_order_id');
    }

    public function getInvoiceUrl(): string
    {
        return '';
    }

    public function getPaymentPackageId(): int
    {
        $key = $this->getMeta('payment_package_id');
        if (empty($key)) {
            return 0;
        }

        return (int)str_replace(tdf_prefix() . '_', '', $key);
    }

    public function getPaymentPackage(): ?PaymentPackageInterface
    {
        return tdf_payment_package_factory()->create($this->getPaymentPackageId());
    }

    public function delete(): void
    {
        parent::delete();

        $wcOrderId = $this->getWooCommerceOrderId();
        if (empty($wcOrderId)) {
            return;
        }

        $wcOrder = wc_get_order($wcOrderId);
        if (empty($wcOrder)) {
            return;
        }

        $wcOrder->delete(true);
    }
}