<?php

use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\RichTextField;
use Tangibledesign\Framework\Models\Model;

/* @var Model $lstModel */

$lstFields = tdf_ordered_fields()->filter(static function ($field) {
    return !$field instanceof RichTextField;
});
?>
<div class="tdf-app">
    <input
            type="hidden"
            name="listivo_nonce"
            value="<?php echo esc_attr(wp_create_nonce('listivo_save_model')); ?>"
    >
    <lst-model-form
            prefix="<?php echo esc_attr(tdf_prefix()); ?>"
            required-text="<?php echo esc_attr(esc_html__('These fields are required:', 'listivo-core')); ?>"
        <?php if (tdf_app('dependency_terms')->isNotEmpty()) : ?>
            :dependency-terms="<?php echo htmlspecialchars(json_encode(tdf_app('dependency_terms'))); ?>"
        <?php endif; ?>
    >
        <div slot-scope="props">
            <div class="tdfm-form">
                <lst-switcher
                        :initial-checked="<?php echo esc_attr($lstModel->isFeatured() ? 'true' : 'false'); ?>"
                >
                    <div
                            slot-scope="switcher"
                            class="tdfm-form__top"
                    >
                        <div class="tdfm-form__featured-switcher">
                            <div
                                    class="tdfm-switcher"
                                    :class="{'tdfm-switcher--active': switcher.checked}"
                                    @click.stop.prevent="switcher.onClick"
                            ></div>

                            <input
                                    id="<?php echo esc_attr(Model::FEATURED); ?>"
                                    name="<?php echo esc_attr(Model::FEATURED); ?>"
                                    type="checkbox"
                                    value="1"
                                    :checked="switcher.checked"
                            >
                        </div>

                        <div
                                class="tdfm-form__label"
                                @click.stop.prevent="switcher.onClick"
                        >
                            <?php esc_html_e('Featured', 'listivo-core'); ?>
                        </div>
                    </div>
                </lst-switcher>

                <template>
                    <div class="tdfm-form__fields">
                        <?php
                        foreach ($lstFields as $lstField) :
                            /* @var Field $lstField */
                            tdf_load_view('model/fields/'.$lstField->getType(), compact('lstField', 'lstModel'));
                        endforeach;
                        ?>
                    </div>
                </template>
            </div>
        </div>
    </lst-model-form>
</div>
