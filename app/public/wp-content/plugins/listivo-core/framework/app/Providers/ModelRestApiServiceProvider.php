<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\HasRestApiValue;
use Tangibledesign\Framework\Models\Model;

class ModelRestApiServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('rest_api_init', [$this, 'registerFields']);
    }

    public function registerFields(): void
    {
        foreach ($this->getFields() as $field) {
            $this->registerField($field);
        }
    }

    /**
     * @param  HasRestApiValue  $field
     * @return void
     */
    private function registerField(HasRestApiValue $field): void
    {
        register_rest_field(tdf_model_post_type(), $field->getKey(), [
            'get_callback' => function ($post) use ($field) {
                return $field->getRestApiValue(new Model(get_post($post['id'])));
            },
        ]);
    }

    /**
     * @return Collection|Field[]
     */
    private function getFields(): Collection
    {
        return tdf_ordered_fields()->filter(static function ($field) {
            return $field instanceof HasRestApiValue;
        });
    }

}