<?php

namespace Tangibledesign\Listivo\Widgets\General;

class TermsWithImagesV2Widget extends TermsWithImagesWidget
{
    /**
     * @return string
     */
    public function getKey(): string
    {
        return 'terms_with_images_v2';
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return esc_html__('Terms With Images V2', 'listivo-core');
    }

}