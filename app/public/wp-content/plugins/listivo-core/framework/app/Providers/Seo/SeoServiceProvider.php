<?php

namespace TangibleDesign\Framework\Providers\Seo;

class SeoServiceProvider extends BaseSeoServiceProvider
{
    public function afterInitiation(): void
    {
        add_filter('wp_title', function ($title) {
            if (class_exists(\WPSEO_Options::class)) {
                return $title;
            }

            if (!is_tax() && !is_post_type_archive(tdf_model_post_type()) && !tdf_settings()->searchOverrideTitleTag()) {
                return $title;
            }

            return $this->getFullTitle();
        }, 9999);

        add_action('wp_head', [$this, 'modelArchiveCanonicalUrl']);
    }

    public function modelArchiveCanonicalUrl(): void
    {
        if (!is_post_type_archive(tdf_model_post_type())) {
            return;
        }

        $term = $this->getCurrentTitleTerm();

        $url = $term ? $term->getUrl() : get_post_type_archive_link(tdf_model_post_type());
        ?>
        <link rel="canonical" href="<?php echo esc_url($url); ?>"/>
        <?php
    }
}