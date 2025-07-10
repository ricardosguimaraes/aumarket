<?php


namespace Tangibledesign\Listivo\Providers\Listing;


use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Template\TemplateType\ModelSingleTemplateType;


/**
 * Class ListingServiceProvider
 * @package Tangibledesign\Listivo\Providers
 */
class ListingServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_filter('listivo/templateType/user', static function ($user, $templateType) {
            if (!$templateType instanceof ModelSingleTemplateType) {
                return $user;
            }

            global $lstModel;
            if (!$lstModel instanceof Model) {
                return false;
            }

            return $lstModel->getUser();
        }, 10, 2);

        add_filter('listivo/button/destinations', static function (array $destinations) {
            $destinations[] = [
                'id' => 'listing_archive',
                'name' => esc_html__('Listing Archive', 'listivo-core'),
            ];

            return $destinations;
        });

        add_filter('listivo/button/destination', static function ($output, $destination) {
            if ($destination !== 'listing_archive') {
                return $output;
            }

            return get_post_type_archive_link(tdf_model_post_type());
        }, 10, 2);

        add_action('listivo/model/update', static function ($listing, $isBackend) {
            if (!$isBackend) {
                return;
            }

            if (!$listing instanceof Model) {
                return;
            }

            $isFeatured = !empty($_POST[Model::FEATURED]) ? 1 : 0;
            $listing->setFeatured($isFeatured);
        }, 10, 2);

        add_filter('listivo/modelForm/name', static function () {
            return tdf_string('listing_name');
        });
    }

}