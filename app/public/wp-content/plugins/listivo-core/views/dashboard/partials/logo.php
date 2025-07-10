<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;

?>
<div id="tdf-logo" class="tdf-content-section">
    <div class="tdf-content-section__left">
        <h2><?php esc_html_e('Logo', 'listivo-core'); ?></h2>

        <div>
            <?php esc_html_e('Upload your logo files (jpg/png). A reversed logo is another version of the logo that can be placed on a
            dark background.', 'listivo-core'); ?>
        </div>
    </div>

    <div class="tdf-content-section__right">
        <div class="tdf-upload-logos">
            <div class="tdf-upload-logos__single tdf-upload-logos__single--left">
                <h3>
                    <?php esc_html_e('Default', 'listivo-core'); ?>
                </h3>

                <lst-set-image :initial-image-id="<?php echo esc_attr(tdf_settings()->getLogoId()); ?>">
                    <div slot-scope="props">
                        <div v-if="props.imageId" class="tdf-upload-logos__preview">
                            <img :src="props.imageUrl" alt="">

                            <button class="tdf-button-round-remove" @click.prevent="props.remove"></button>

                            <input
                                    name="<?php echo esc_attr(SettingKey::LOGO); ?>"
                                    :value="props.imageId"
                                    type="hidden"
                            >
                        </div>

                        <button @click.prevent="props.openUploader" class="tdf-button-add">
                            <?php esc_html_e('Add logo', 'listivo-core'); ?> <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                </lst-set-image>
            </div>

            <div class="tdf-upload-logos__single tdf-upload-logos__single--right">
                <h3>
                    <?php esc_html_e('Reversed', 'listivo-core'); ?>
                </h3>

                <lst-set-image :initial-image-id="<?php echo esc_attr(tdf_settings()->getInverseLogoId()); ?>">
                    <div slot-scope="props">
                        <div class="tdf-upload-logos__preview tdf-upload-logos__preview--inverse" v-if="props.imageId">
                            <img :src="props.imageUrl" alt="">

                            <button class="tdf-button-round-remove" @click.prevent="props.remove"></button>

                            <input
                                    name="<?php echo esc_attr(SettingKey::INVERSE_LOGO); ?>"
                                    :value="props.imageId"
                                    type="hidden"
                            >
                        </div>

                        <button @click.prevent="props.openUploader" class="tdf-button-add">
                            <?php esc_html_e('Add logo', 'listivo-core'); ?> <i class="fas fa-plus-circle"></i>
                        </button>
                    </div>
                </lst-set-image>
            </div>
        </div>

        <?php tdf_load_view('dashboard/partials/save_changes_button'); ?>
    </div>
</div>