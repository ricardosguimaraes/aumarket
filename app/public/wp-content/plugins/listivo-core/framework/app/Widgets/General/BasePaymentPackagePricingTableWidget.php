<?php

namespace Tangibledesign\Framework\Widgets\General;

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Widgets\Helpers\BaseGeneralWidget;
use Tangibledesign\Framework\Widgets\Helpers\SelectRemoteControl;

abstract class BasePaymentPackagePricingTableWidget extends BaseGeneralWidget
{
    public function getKey(): string
    {
        return 'payment_package_pricing_table';
    }

    public function getName(): string
    {
        return tdf_admin_string('payment_package_pricing_table');
    }

    protected function addPaymentPackagesControl(): void
    {
        $packages = new Repeater();

        $packages->add_control(
            'payment_package',
            [
                'label' => tdf_admin_string('payment_package'),
                'type' => SelectRemoteControl::TYPE,
                'source' => tdf_action_url('tdf/api/paymentPackages'),
            ]
        );

        $this->add_control(
            'payment_packages',
            [
                'label' => tdf_admin_string('payment_packages'),
                'type' => Controls_Manager::REPEATER,
                'fields' => $packages->get_controls(),
                'prevent_empty' => false,
                'title_field' => '{{{ paymentPackageLabels[payment_package] }}}',
            ]
        );
    }

    public function getPaymentPackages(): Collection
    {
        $paymentPackageIds = $this->get_settings_for_display('payment_packages');
        if (empty($paymentPackageIds) || !is_array($paymentPackageIds)) {
            return tdf_collect();
        }

        $paymentPackageIds = tdf_collect($paymentPackageIds)
            ->map(static function ($paymentPackage) {
                return (int)$paymentPackage['payment_package'];
            })
            ->filter(static function ($paymentPackage) {
                return $paymentPackage !== false;
            })
            ->values();

        if (empty($paymentPackageIds)) {
            return tdf_collect();
        }

        return tdf_query_payment_packages()
            ->in($paymentPackageIds)
            ->orderByIn()
            ->get();
    }
}