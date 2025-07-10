<?php
if (
    class_exists(\Tangibledesign\Framework\Core\App::class)
    && class_exists(\Elementor\Plugin::class)
    && tdf_app('current_template')
) {
    return;
}
?>
<div class="listivo-footer">
    <div class="listivo-footer__inner">
        <?php esc_html_e('Copyright ©', 'listivo'); ?>

        <?php echo esc_html(date('Y') . ' ' . get_bloginfo('name')); ?>
    </div>
</div>