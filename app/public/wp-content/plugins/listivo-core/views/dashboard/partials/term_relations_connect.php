<div class="tdf-content-section">
    <div class="tdf-content-section__left">
        <h2><?php esc_html_e('Connect Terms (Parent/Child)', 'listivo-core'); ?></h2>
    </div>

    <div class="tdf-content-section__right">
        <div>
            <?php esc_html_e('By clicking "Connect" button Listivo will assign all child terms (e.g. Banana) to Parents (e.g. Fruit) basing on listings that are in your database. It can be useful if you imported database of listings (e.g. via WP All Import) and you wish quickly create this type of parent-child relations for your search form or "submit listing" form.', 'listivo-core'); ?>
        </div>
        <div class="tdf-button-save-wrapper">
            <a
                    href="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/term/relations/connect')); ?>"
                    class="tdf-button-save"
            >
                <i class="fas fa-plug"></i> <?php esc_html_e('Connect', 'listivo-core'); ?>
            </a>
        </div>
    </div>
</div>