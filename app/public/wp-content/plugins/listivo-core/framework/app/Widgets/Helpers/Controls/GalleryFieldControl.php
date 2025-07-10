<?php


namespace Tangibledesign\Framework\Widgets\Helpers\Controls;


use Elementor\Controls_Manager;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\Fieldable;
use Tangibledesign\Framework\Models\Field\GalleryField;
use Tangibledesign\Framework\Models\Image;

/**
 * Trait GalleryFieldControl
 * @package Tangibledesign\Framework\Widgets\Helpers\Controls
 */
trait GalleryFieldControl
{
    use Control;

    protected function addGalleryFieldControl(): void
    {
        $options = $this->getGalleryFieldOptions();

        if (empty($options)) {
            $this->addNoGalleryFieldsControl();
            return;
        }

        if (count($options) === 1) {
            $this->addHiddenGalleryFieldControl(key($options));
            return;
        }

        $this->add_control(
            'gallery_field',
            [
                'label' => tdf_admin_string('gallery_field'),
                'type' => Controls_Manager::SELECT,
                'options' => $options,
                'default' => key($options),
            ]
        );
    }

    private function addNoGalleryFieldsControl(): void
    {
        $this->add_control(
            'no_gallery_fields',
            [
                'label' => tdf_admin_string('create_gallery_field'),
                'type' => Controls_Manager::HEADING,
            ]
        );
    }

    /**
     * @param int $galleryFieldId
     * @noinspection PhpMissingParamTypeInspection
     */
    private function addHiddenGalleryFieldControl($galleryFieldId): void
    {
        $this->add_control(
            'gallery_field',
            [
                'label' => tdf_admin_string('gallery_field'),
                'type' => Controls_Manager::HIDDEN,
                'default' => $galleryFieldId,
            ]
        );
    }

    /**
     * @return array
     */
    private function getGalleryFieldOptions(): array
    {
        $options = [];

        foreach (tdf_fields() as $field) {
            if ($field instanceof GalleryField) {
                $options[$field->getId()] = $field->getName();
            }
        }

        return $options;
    }

    /**
     * @return GalleryField|false
     */
    public function getGalleryField()
    {
        $galleryFieldId = (int)$this->get_settings_for_display('gallery_field');
        if (empty($galleryFieldId)) {
            return false;
        }

        return tdf_fields()->find(static function ($field) use ($galleryFieldId) {
            /* @var Field $field */
            return $field->getId() === $galleryFieldId;
        });
    }

    /**
     * @return Collection|Image[]
     */
    public function getGalleryFieldImages(Fieldable $fieldable): Collection
    {
        $galleryField = $this->getGalleryField();
        if (!$galleryField) {
            return tdf_collect();
        }

        return $galleryField->getImages($fieldable);
    }

}