<?php


namespace Tangibledesign\Framework\Providers;


use JsonException;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Page;

/**
 * Class ButtonDestinationServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class ButtonDestinationServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function afterInitiation(): void
    {
        add_action('admin_post_'.tdf_prefix().'/button/destinations', [$this, 'destinations']);

        add_filter(tdf_prefix().'/button/destination', [$this, 'destination'], 15, 2);
    }

    /**
     * @param  string|false  $url
     * @param  string|int  $destination
     * @return string
     */
    public function destination($url, $destination): string
    {
        if ($url) {
            return $url;
        }

        if ($destination === 'blog') {
            return get_post_type_archive_link('post');
        }

        $page = tdf_post_factory()->create((int)$destination);
        if (!$page instanceof Page) {
            return '#';
        }

        return $page->getUrl();
    }

    /**
     * @throws JsonException
     */
    public function destinations(): void
    {
        $options = apply_filters(tdf_prefix().'/button/destinations', [
            [
                'id' => 'blog',
                'name' => tdf_admin_string('blog'),
            ],
        ]);

        foreach (tdf_pages() as $page) {
            $options[] = [
                'id' => $page->getId(),
                'name' => $page->getName(),
            ];
        }

        if (isset($_REQUEST['include'])) {
            $id = is_numeric($_REQUEST['include']) ? (int)$_REQUEST['include'] : (string)$_REQUEST['include'];

            $options = array_filter($options, static function ($option) use ($id) {
                return $option['id'] === $id;
            });
        }

        echo json_encode($options, JSON_THROW_ON_ERROR);
    }

}