<?php

namespace Tangibledesign\Framework\Models\Payments;

use DateTime;
use Exception;
use Tangibledesign\Framework\Models\Post\PostModel;

abstract class Order extends PostModel
{
    public const TYPE_STRIPE = 'stripe';
    public const TYPE_WOOCOMMERCE = 'woocommerce';

    abstract public function getOrderId(): string;

    abstract public function getLabel(): string;

    abstract public function getPrice(): string;

    abstract public function getPaymentMethod(): string;

    public function setType(string $type): void
    {
        $this->setMeta('type', $type);
    }

    public function getType(): string
    {
        return $this->getMeta('type');
    }

    public function setStatus(string $status): void
    {
        $this->setMeta('status', $status);
    }

    public function getStatus(): string
    {
        return (string)$this->getMeta('status');
    }

    /**
     * @return string
     */
    public function getFormattedStatus(): string
    {
        $status = $this->getStatus();

        if ($status === OrderStatus::ON_HOLD) {
            return tdf_string('on_hold');
        }

        if ($status === OrderStatus::PENDING) {
            return tdf_string('pending');
        }

        if ($status === OrderStatus::PROCESSING) {
            return tdf_string('processing');
        }

        if ($status === OrderStatus::COMPLETED) {
            return tdf_string('completed');
        }

        if ($status === OrderStatus::CANCELLED) {
            return tdf_string('cancelled');
        }

        if ($status === OrderStatus::REFUNDED) {
            return tdf_string('refunded');
        }

        if ($status === OrderStatus::FAILED) {
            return tdf_string('failed');
        }

        return tdf_string('pending');
    }

    public function getCreatedAt(): ?DateTime
    {
        $createdAt = (int)$this->getMeta('created_at');
        if (empty($createdAt)) {
            return null;
        }

        try {
            return new DateTime(date('Y-m-d H:i:s', $createdAt));
        } catch (Exception $e) {
            return null;
        }
    }

    public function getUpdatedAt(): ?DateTime
    {
        $updatedAt = (int)$this->getMeta('updated_at');
        if (empty($updatedAt)) {
            return null;
        }

        try {
            return new DateTime(date('Y-m-d H:i:s', $updatedAt));
        } catch (Exception $e) {
            return null;
        }
    }

    abstract public function getInvoiceUrl(): string;

}