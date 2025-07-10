<?php

namespace Tangibledesign\Framework\Widgets\Helpers;


use Elementor\Base_Data_Control;

/**
 * Class SelectRemoteControl
 * @package Tangibledesign\Framework\Widgets\Helpers
 */
class SelectRemoteControl extends Base_Data_Control
{
    public const TYPE = 'tdf_select_remote';

    /**
     * @return string
     */
    public function get_type(): string
    {
        return self::TYPE;
    }

    public function enqueue(): void
    {
        wp_register_script(
            'tdf-select-remote-control',
            tdf_app('url') . '/assets/js/select-remote-control.js',
            ['jquery'],
            '1.0.0'
        );
        wp_enqueue_script('tdf-select-remote-control');
    }

    /**
     * @return array
     */
    protected function get_default_settings(): array
    {
        return [
            'options' => [],
            'multiple' => false,
            'source' => '',
            'placeholder' => tdf_admin_string('select')
        ];
    }

    public function content_template(): void
    {
        $controlUid = $this->get_control_uid();
        ?>
        <div class="elementor-control-field">
            <label for="<?php echo esc_attr($controlUid); ?>" class="elementor-control-title">
                {{{ data.label }}}
            </label>

            <div class="elementor-control-input-wrapper" style="width:135px !important;">
                <# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
                <select
                        id="<?php echo esc_attr($controlUid); ?>"
                        class="tdf-select-remote"
                        type="tdf_select_remote"
                        data-setting="{{ data.name }}"
                        data-selected="{{ data.controlValue }}"
                        data-source="{{ data.source }}"
                        data-placeholder="{{ data.placeholder }}"
                        style="width: 135px !important;"
                        {{ multiple }}
                >
                </select>
                <style>
                    .tdf-select-remote {
                        width: 135px !important;
                    }

                    .select2-selection select2-selection--multiple {
                        width: 135px !important;
                    }
                </style>
            </div>
        </div>
        <# if ( data.description ) { #>
        <div class="elementor-control-field-description">{{{ data.description }}}</div>
        <# } #>
        <?php
    }

    /**
     * @return array
     */
    public function get_default_value(): array
    {
        return [];
    }

}