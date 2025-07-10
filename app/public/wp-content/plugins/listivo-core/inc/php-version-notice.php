<?php
add_action('admin_notices', static function () { ?>
    <div class="notice notice-error">
        <h1><?php esc_html_e('Your PHP Version is Too Low! Update Required.', 'listivo-core'); ?></h1>

        <p><?php esc_html_e('Dear User,

We have detected that your current PHP version is below 8.0. To ensure the proper functionality of Listivo, you need to update your PHP version.', 'listivo-core'); ?></p>

        <h3><?php esc_html_e('Why is This Important?', 'listivo-core'); ?></h3>

        <ol>
            <li>
                <?php
                echo sprintf(
                    esc_html__('%s Newer PHP versions offer significantly better performance. PHP 8.0 and above are optimized for faster code processing, leading to better responsiveness and faster load times for your site.', 'listivo-core'),
                    '<strong>' . esc_html__('Performance:', 'listivo-core') . '</strong>'
                );
                ?>
            </li>
            <li>
                <?php
                echo sprintf(
                    esc_html__('%s Older PHP versions no longer receive security updates. Using an outdated PHP version exposes your site to potential attacks and vulnerabilities. Even minor security flaws can be exploited by malicious software.', 'listivo-core'),
                    '<strong>' . esc_html__('Security:', 'listivo-core') . '</strong>'
                );
                ?>
            </li>
            <li>
                <?php
                echo sprintf(
                    esc_html__('%s Our theme, along with many other modern tools and plugins, does not support older PHP versions. This means you won\'t be able to benefit from the latest features, bug fixes, and enhancements that we regularly introduce.', 'listivo-core'),
                    '<strong>' . esc_html__('Technical Support:', 'listivo-core') . '</strong>'
                );
                ?>
            </li>
        </ol>

        <h3><?php esc_html_e('Recommendation', 'listivo-core'); ?></h3>

        <p>
            <?php esc_html_e('We recommend updating to PHP version 8.2. This will allow you to fully leverage the capabilities of our theme and ensure optimal performance and security for your site.', 'listivo-core'); ?>
        </p>

        <p>
            <?php echo sprintf(esc_html__('Your current PHP version: %s', 'listivo-core'), '<strong>' . PHP_VERSION . '</strong>'); ?>
        </p>

        <p>
            <?php
            echo sprintf(
                esc_html__('For more information on supported PHP versions, visit the %s.', 'listivo-core'),
                '<a href="https://www.php.net/supported-versions.php" target="_blank">' . esc_html__('PHP Supported Versions page', 'listivo-core') . '</a>'
            );
            ?>
        </p>

        <p>
            <?php esc_html_e('If you need assistance with updating PHP, please contact your hosting provider or site administrator. Thank you for your understanding and cooperation.', 'listivo-core'); ?>
        </p>

        <p>
            <?php esc_html_e('Best regards,', 'listivo-core'); ?><br>
            <?php esc_html_e('TangibleWP Team', 'listivo-core'); ?>
        </p>
    </div>
    <?php
});