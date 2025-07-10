<?php

namespace Tangibledesign\Framework\Providers;

use JsonException;
use Tangibledesign\Framework\Core\ServiceProvider;

class ElementorHelpersServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_print_footer_scripts', [$this, 'loadHelpers'], 99);
    }

    public function loadHelpers(): void
    {
        if (!$this->isElementorEditor()) {
            return;
        }

        ob_start();
        ?>
        <script>
            var paymentPackageLabels = <?php echo tdf_filter($this->fetchPaymentPackagesList()) ?>;
        </script>
        <?php
        echo ob_get_clean();
    }

    private function isElementorEditor(): bool
    {
        return isset($_REQUEST['action']) && $_REQUEST['action'] === 'elementor';
    }

    private function fetchPaymentPackagesList(): string
    {
        $paymentPackages = tdf_query_payment_packages()->get();
        $list = [];

        foreach ($paymentPackages as $paymentPackage) {
            $list[$paymentPackage->getId()] = $paymentPackage->getName();
        }

        try {
            return json_encode($list, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return '';
        }
    }
}