<?php

namespace Tangibledesign\Listivo\Providers;

use Elementor\Plugin;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\GalleryField;
use Tangibledesign\Framework\Models\Payments\BaseUserPaymentPackage;

class DemosServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('listivo/demoImporter/checkGalleries', [$this, 'checkGalleries']);

        add_action('listivo/demoImporter/finished', [$this, 'demoImporter']);
    }

    public function demoImporter(): void
    {
        $this->fixElementor();

        $this->adjustSettings();

        $this->deleteUserPackages();
    }

    private function deleteUserPackages(): void
    {
        tdf_query_user_payment_packages()->get()->each(function ($userPaymentPackage) {
            /* @var BaseUserPaymentPackage $userPaymentPackage */
            $userPaymentPackage->delete();
        });
    }

    private function adjustSettings(): void
    {
        tdf_settings()->setUserRegistration(0);

        tdf_settings()->setEnablePayments(0);

        tdf_settings()->save();
    }

    private function fixElementor(): void
    {
        $kit = Plugin::instance()->kits_manager->get_active_kit_for_frontend();
        if (!$kit) {
            return;
        }

        $kit->set_settings('space_between_widgets', [
            "column" => "0",
            "row" => "0",
            "isLinked" => true,
            "unit" => "px",
            "size" => 0,
            "sizes" => []
        ]);

        $kit->save(['settings' => $kit->get_settings()]);
    }

    public function checkGalleries(): void
    {
        $galleryField = tdf_gallery_fields()->first();
        if (!$galleryField instanceof GalleryField) {
            return;
        }

        foreach (tdf_query_models() as $listing) {
            $gallery = $galleryField->getValue($listing);

            foreach ($gallery as $key => $imageId) {
                $post = get_post($imageId);
                if (!$post) {
                    unset($gallery[$key]);
                }
            }

            $galleryField->setValue($listing, $gallery);
        }

        foreach (tdf_embed_fields() as $embedField) {
            $embedField->setAllowRawHtml(0);
        }
    }
}