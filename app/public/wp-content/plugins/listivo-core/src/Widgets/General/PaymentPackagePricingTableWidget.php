<?php

namespace Tangibledesign\Listivo\Widgets\General;

use Tangibledesign\Framework\Widgets\General\BasePaymentPackagePricingTableWidget;

class PaymentPackagePricingTableWidget extends BasePaymentPackagePricingTableWidget
{
    protected function register_controls(): void
    {
        $this->startContentControlsSection();

        $this->addPaymentPackagesControl();

        $this->endControlsSection();
    }
}