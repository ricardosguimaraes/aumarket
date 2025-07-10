<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Page;

?>
<div class="tdf-field">
    <label for="<?php echo esc_attr(SettingKey::HOMEPAGE); ?>">
        <i class="fas fa-home"></i> <?php esc_html_e('Homepage', 'listivo-core'); ?>
    </label>

    <select
            id="<?php echo esc_attr(SettingKey::HOMEPAGE); ?>"
            name="<?php echo esc_attr(SettingKey::HOMEPAGE); ?>"
            class="tdf-selectize tdf-selectize-init"
    >
        <option value="0">
            <?php esc_html_e('Not set', 'listivo-core'); ?>
        </option>

        <?php foreach (tdf_app('pages') as $lstPage) : /* @var Page $lstPage */ ?>
            <option
                    value="<?php echo esc_attr($lstPage->getId()); ?>"
                <?php if (tdf_settings()->getHomepageId() === $lstPage->getId()) : ?>
                    selected
                <?php endif; ?>
            >
                <?php echo esc_html($lstPage->getName()); ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>