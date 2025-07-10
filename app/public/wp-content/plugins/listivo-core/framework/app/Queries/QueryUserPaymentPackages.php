<?php

namespace Tangibledesign\Framework\Queries;

use Tangibledesign\Framework\Factories\BasePostFactory;
use Tangibledesign\Framework\Models\Payments\BaseUserPaymentPackage;
use Tangibledesign\Framework\Models\Payments\RegularUserPaymentPackage;

class QueryUserPaymentPackages extends QueryPosts
{
    /** @var string */
    protected string $postType = 'user_package';

    /** @var bool */
    protected bool $prefixPostType = true;

    public function regularType(): QueryUserPaymentPackages
    {
        $this->metaQuery[] = [
            'relation' => 'OR',
            [
                'key' => BaseUserPaymentPackage::TYPE,
                'value' => BaseUserPaymentPackage::TYPE_REGULAR,
            ],
            [
                'key' => BaseUserPaymentPackage::TYPE,
                'compare' => 'NOT EXISTS',
            ]
        ];

        return $this;
    }

    public function bumpType(): QueryUserPaymentPackages
    {
        $this->metaQuery[] = [
            'key' => BaseUserPaymentPackage::TYPE,
            'value' => BaseUserPaymentPackage::TYPE_BUMP,
        ];

        return $this;
    }

    protected function getFactory(): BasePostFactory
    {
        return tdf_user_payment_package_factory();
    }

    public function subscriptionSource(): QueryUserPaymentPackages
    {
        $this->metaQuery[] = [
            'key' => RegularUserPaymentPackage::SOURCE_TYPE,
            'value' => 'subscription',
        ];

        return $this;
    }

    public function expired(): QueryUserPaymentPackages
    {
        $this->metaQuery[] = [
            'relation' => 'AND',
            [
                'key' => RegularUserPaymentPackage::EXPIRE_DATE,
                'compare' => 'EXISTS',
            ],
            [
                'key' => RegularUserPaymentPackage::EXPIRE_DATE,
                'value' => '',
                'compare' => '!=',
            ],
            [
                'key' => RegularUserPaymentPackage::EXPIRE_DATE,
                'value' => time(),
                'compare' => '<',
                'type' => 'NUMERIC',
            ]
        ];

        return $this;
    }

    public function withExpireDate(): QueryUserPaymentPackages
    {
        $this->metaQuery[] = [
            'key' => RegularUserPaymentPackage::EXPIRE_DATE,
            'compare' => 'EXISTS',
        ];

        return $this;
    }

    public function withoutExpireDate(): QueryUserPaymentPackages
    {
        $this->metaQuery[] = [
            'key' => RegularUserPaymentPackage::EXPIRE_DATE,
            'compare' => 'NOT EXISTS',
        ];

        return $this;
    }
}