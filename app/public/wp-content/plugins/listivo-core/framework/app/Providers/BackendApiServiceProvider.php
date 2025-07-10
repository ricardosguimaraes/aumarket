<?php

namespace Tangibledesign\Framework\Providers;

use JsonException;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Template\TemplateType\TemplateType;
use Tangibledesign\Framework\Queries\QueryPosts;

class BackendApiServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        $this->registerAction('layouts');
        $this->registerAction('paymentPackages');
    }

    private function registerAction(string $method): void
    {
        add_action('admin_post_tdf/api/' . $method, [$this, $method]);
        add_action('admin_post_nopriv_tdf/api/' . $method, [$this, $method]);
    }

    private function response(Collection $output): void
    {
        try {
            echo json_encode($output, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            /** @noinspection JsonEncodingApiUsageInspection */
            echo json_encode(['error' => 'Failed to encode JSON.']);
        }
    }

    private function handleInclude(QueryPosts $query): void
    {
        if (isset($_REQUEST['include'])) {
            $include = is_array($_REQUEST['include']) ? $_REQUEST['include'] : [$_REQUEST['include']];
            $query->in($include);
        }
    }

    public function layouts(): void
    {
        $query = tdf_query_templates(TemplateType::LAYOUT);

        $this->handleInclude($query);

        $this->response($query->get());
    }

    public function paymentPackages(): void
    {
        $query = tdf_query_payment_packages()->orderByName();

        $this->handleInclude($query);

        $paymentPackagesIds = array_merge(tdf_settings()->getpaymentPackageIds(), tdf_settings()->getBumpsPaymentPackageIds());

        $paymentPackages = $query->get()->filter(static function ($paymentPackage) use ($paymentPackagesIds) {
            return in_array($paymentPackage->getId(), $paymentPackagesIds, true);
        });

        $this->response($paymentPackages);
    }
}