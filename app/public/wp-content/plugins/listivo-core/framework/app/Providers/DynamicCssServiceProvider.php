<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;

class DynamicCssServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('wp_enqueue_scripts', [$this, 'settings'], 9999);
    }

    public function settings(): void
    {
        ob_start();

        do_action(tdf_prefix() . '/dynamicCss');

        $this->selectCountryFlagPolyfill();

        wp_add_inline_style($this->getInlineStyleHandle(), ob_get_clean());
    }

    private function getInlineStyleHandle(): string
    {
        if (is_rtl()) {
            return tdf_prefix() . '-rtl';
        }

        return tdf_prefix();
    }

    private function selectCountryFlagPolyfill(): void
    {
        $typographies = tdf_current_kit()->get_settings_for_display('system_typography');
        foreach ($typographies as $typography) {
            if ($typography['_id'] === 'ltext1') {
                ?>
                .<?php echo esc_html(tdf_prefix()); ?>-phone-with-country-code select {
                font-family: "Twemoji Country Flags", "<?php echo esc_attr($typography['typography_font_family']); ?>";
                }
                <?php
            }
        }
    }
}