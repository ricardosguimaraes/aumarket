<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Factories\CommentFactory;
use Tangibledesign\Framework\Factories\FieldFactory;
use Tangibledesign\Framework\Factories\ImageFactory;
use Tangibledesign\Framework\Factories\ModelFactory;
use Tangibledesign\Framework\Factories\NotificationFactory;
use Tangibledesign\Framework\Factories\NotificationTaskFactory;
use Tangibledesign\Framework\Factories\OrderFactory;
use Tangibledesign\Framework\Factories\PaymentPackageFactory;
use Tangibledesign\Framework\Factories\PostFactory;
use Tangibledesign\Framework\Factories\ReviewFactory;
use Tangibledesign\Framework\Factories\SubscriptionFactory;
use Tangibledesign\Framework\Factories\TemplateFactory;
use Tangibledesign\Framework\Factories\TemplateTypeFactory;
use Tangibledesign\Framework\Factories\TermFactory;
use Tangibledesign\Framework\Factories\UserFactory;
use Tangibledesign\Framework\Factories\UserPaymentPackageFactory;
use Tangibledesign\Framework\Factories\UserSubscriptionFactory;
use Tangibledesign\Framework\Factories\WooProductFactory;

class FactoryServiceProvider extends ServiceProvider
{
    public function initiation(): void
    {
        $this->container['post_factory'] = static function () {
            return new PostFactory();
        };

        $this->container['user_factory'] = static function () {
            return new UserFactory();
        };

        $this->container['template_factory'] = static function () {
            return new TemplateFactory();
        };

        $this->container['template_type_factory'] = static function () {
            return new TemplateTypeFactory();
        };

        $this->container['field_factory'] = static function () {
            return new FieldFactory();
        };

        $this->container['payment_package_factory'] = static function () {
            return new PaymentPackageFactory();
        };

        $this->container['user_payment_package_factory'] = static function () {
            return new UserPaymentPackageFactory();
        };

        $this->container['order_factory'] = static function () {
            return new OrderFactory();
        };

        $this->container['image_factory'] = static function () {
            return new ImageFactory();
        };

        $this->container['comment_factory'] = static function () {
            return new CommentFactory();
        };

        $this->container['notification_factory'] = static function () {
            return new NotificationFactory();
        };

        $this->container['notification_task_factory'] = static function () {
            return new NotificationTaskFactory();
        };

        $this->container['term_factory'] = static function () {
            return new TermFactory();
        };

        $this->container['woo_product_factory'] = static function () {
            return new WooProductFactory();
        };

        $this->container['model_factory'] = static function () {
            return new ModelFactory();
        };

        $this->container['subscription_factory'] = static function () {
            return new SubscriptionFactory();
        };

        $this->container['user_subscription_factory'] = static function () {
            return new UserSubscriptionFactory();
        };

        $this->container['review_factory'] = static function () {
            return new ReviewFactory();
        };
    }
}