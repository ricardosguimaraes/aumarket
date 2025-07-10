<?php


namespace Tangibledesign\Framework\Models\Template;


/**
 * Class PrintModelTemplate
 * @package Tangibledesign\Framework\Models\Template
 */
class PrintModelTemplate extends Template
{

    public function display(): void
    {
        ?>
        <style>
            -webkit-print-color-adjust: exact !important;   /* Chrome, Safari, Edge */
            color-adjust: exact !important;                 /*Firefox*/
        </style>
        <div class="<?php echo esc_attr(tdf_prefix()); ?>-print-wrapper">
            <?php parent::display(); ?>
        </div>
        <?php

        if (is_singular(tdf_prefix() . '_template')) {
            return;
        }

        add_action('wp_footer', static function () {
            ?>
            <script>
                jQuery(window).on('load', function () {
                    setTimeout(function () {
                        window.print();
                    }, 500)
                })
            </script>
            <?php
        });
    }

}