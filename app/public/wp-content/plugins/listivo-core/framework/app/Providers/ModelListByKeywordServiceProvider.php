<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use WP_Query;

class ModelListByKeywordServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/model/list/keyword', [$this, 'list']);
    }

    public function list(): void
    {
        $options = [];
        $query = new WP_Query($this->getArgs());

        foreach ($query->posts as $post) {
            $options[] = [
                'id' => $post->ID,
                'name' => $post->post_title,
            ];
        }

        if (isset($_REQUEST['include'])) {
            $id = is_numeric($_REQUEST['include']) ? (int)$_REQUEST['include'] : (string)$_REQUEST['include'];

            $options = array_filter($options, static function ($option) use ($id) {
                return $option['id'] === $id;
            });
        }


        echo json_encode($options);
    }

    /**
     * @return array
     */
    private function getArgs(): array
    {
        $keyword = $_REQUEST['search'] ?? '';

        $args = [
            'posts_per_page' => 200,
            'post_type' => tdf_model_post_type(),
        ];

        if (!empty($keyword)) {
            $args['s'] = $keyword;
        }

        return $args;
    }

}