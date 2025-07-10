<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div id="tdf-colors" class="tdf-content-section">
    <div class="tdf-content-section__left">
        <h2><?php esc_html_e('Colors Palette', 'listivo-core'); ?></h2>
        <div><?php esc_html_e('Pick colors for your website', 'listivo-core'); ?></div>
    </div>

    <div class="tdf-content-section__right">
        <div class="tdf-color-picker-wrapper">
            <lst-set-color
                    type="primary"
                    initial-color="<?php echo esc_attr(tdf_settings()->getPrimaryColor()); ?>"
                    picker-class="tdf-color-picker"
            >
                <div slot-scope="props">
                    <div
                            @click="props.onShowPicker"
                            class="tdf-color-picker-circle"
                            :style="{'background-color': props.currentColor}"
                    ></div>

                    <div
                            v-if="props.showPicker"
                            @click.prevent
                            class="tdf-color-picker"
                    >
                        <lst-chrome-picker
                                :disable-alpha="true"
                                :value="props.currentColor"
                                @input="props.setCurrentColor"
                        ></lst-chrome-picker>

                        <div class="tdf-color-picker__buttons">
                            <div class="tdf-color-picker__buttons-inner">
                                <button class="tdf-button-add" @click.prevent="props.onSave">
                                    <?php esc_html_e('Apply', 'listivo-core'); ?>
                                </button>

                                <button class="tdf-button-cancel" @click.prevent="props.onCancel">
                                    <?php esc_html_e('Cancel', 'listivo-core'); ?>
                                </button>
                            </div>
                        </div>
                    </div>

                    <input
                            name="<?php echo esc_attr(SettingKey::PRIMARY_COLOR); ?>"
                            :value="props.color"
                            type="hidden"
                    >
                </div>
            </lst-set-color>

            <div class="tdf-color-picker__text">
                <div class="tdf-color-picker__label">
                    <?php esc_html_e('Primary color', 'listivo-core'); ?>
                </div>

                <div class="tdf-color-picker__click">
                    <?php esc_html_e('Click to select', 'listivo-core'); ?>
                </div>
            </div>
        </div>

        <?php tdf_load_view('dashboard/partials/save_changes_button'); ?>
    </div>
</div>