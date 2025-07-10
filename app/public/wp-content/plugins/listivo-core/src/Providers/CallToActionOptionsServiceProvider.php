<?php


namespace Tangibledesign\Listivo\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class CallToActionOptionsServiceProvider
 * @package Tangibledesign\Listivo\Providers
 */
class CallToActionOptionsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_listivo/widget/callToActionSection/options', [$this, 'options']);
    }

    public function options(): void
    {
        $options = [
            [
                'id' => 'listing_archive',
                'name' => esc_html__('Search Results', 'listivo-core'),
            ],
            [
                'id' => 'custom_url',
                'name' => esc_html__('Custom Url', 'listivo-core'),
            ]
        ];

        foreach (tdf_pages() as $page) {
            $options[] = [
                'id' => $page->getId(),
                'name' => $page->getName(),
            ];
        }

        if (isset($_REQUEST['include'])) {
            $options = array_filter($options, static function ($option) {
                return (string)$option['id'] === $_REQUEST['include'];
            });
        }

        echo json_encode($options);
    }

}