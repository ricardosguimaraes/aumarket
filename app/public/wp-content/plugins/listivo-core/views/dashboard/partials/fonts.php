<?php use Tangibledesign\Framework\Core\Settings\SettingKey; ?>
<div id="tdf-fonts" class="tdf-content-section">
    <div class="tdf-content-section__left">
        <h2><?php esc_html_e('Fonts', 'listivo-core'); ?></h2>

        <div>
            <?php esc_html_e('You have access to 800+ Google Fonts.', 'listivo-core'); ?>
        </div>
    </div>

    <div class="tdf-content-section__right">
        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::HEADING_FONT); ?>">
                <i class="fas fa-heading"></i> <?php esc_html_e('Heading Font', 'listivo-core'); ?>
            </label>

            <select
                    name="<?php echo esc_attr(SettingKey::HEADING_FONT); ?>"
                    id="<?php echo esc_attr(SettingKey::HEADING_FONT); ?>"
                    class="tdf-selectize tdf-selectize-init"
            >
                <?php foreach (tdf_app('fonts') as $lstFont) : ?>
                    <option
                            value="<?php echo esc_attr($lstFont); ?>"
                        <?php if (tdf_settings()->getHeadingFont() === $lstFont) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo esc_html($lstFont); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="tdf-field">
            <label for="<?php echo esc_attr(SettingKey::TEXT_FONT); ?>">
                <i class="fas fa-font"></i> <?php esc_html_e('Text Font', 'listivo-core'); ?>
            </label>

            <select
                    name="<?php echo esc_attr(SettingKey::TEXT_FONT); ?>"
                    id="<?php echo esc_attr(SettingKey::TEXT_FONT); ?>"
                    class="tdf-selectize tdf-selectize-init"
            >
                <?php foreach (tdf_app('fonts') as $lstFont) : ?>
                    <option
                            value="<?php echo esc_attr($lstFont); ?>"
                        <?php if (tdf_settings()->getTextFont() === $lstFont) : ?>
                            selected
                        <?php endif; ?>
                    >
                        <?php echo esc_html($lstFont); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php tdf_load_view('dashboard/partials/save_changes_button'); ?>
    </div>
</div>