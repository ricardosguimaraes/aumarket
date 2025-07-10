<?php

namespace Tangibledesign\Framework\Providers\Images;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Field\GalleryField;
use Tangibledesign\Framework\Models\Model;
use WP_Post;

class ModelImagesDeletionServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('before_delete_post', [$this, 'delete'], 10, 2);
    }

    public function delete($postId, WP_Post $post): void
    {
        if ($post->post_type !== tdf_model_post_type()) {
            return;
        }

        if (!tdf_settings()->deleteModelImagesOnDelete()) {
            return;
        }

        $model = tdf_model_factory()->create($post);
        if (!$model) {
            return;
        }

        foreach (tdf_gallery_fields() as $galleryField) {
            $this->deleteGalleryFieldImages($model, $galleryField);
        }
    }

    private function deleteGalleryFieldImages(Model $model, GalleryField $galleryField): void
    {
        $galleryField->getImages($model)->each(function ($image) {
            $image->delete();
        });
    }
}