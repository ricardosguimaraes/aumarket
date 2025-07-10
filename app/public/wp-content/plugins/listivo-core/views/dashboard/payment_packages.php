<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Listivo\Providers\Settings\SettingsServiceProvider;

$tab = $_GET['tab'] ?? 'regular';
?>
<div class="tdf-app">
    <div class="wrap">
        <h1 class="wp-heading-inline">
            <?php esc_html_e('Payment Packages', 'listivo-core'); ?>
        </h1>

        <a
                class="page-title-action"
                href="<?php echo esc_url(admin_url('admin.php?page=listivo-add-new-package')); ?>"
        >
            <?php esc_html_e('Add New Package', 'listivo-core'); ?>
        </a>

        <lst-tabs
                initial-tab="<?php echo esc_attr($tab); ?>"
                base-url="<?php echo esc_url(admin_url('admin.php?page=' . tdf_prefix() . '_payment_packages')); ?>"
        >
            <div slot-scope="tabs">
                <h2 class="nav-tab-wrapper">
                    <a
                            @click="tabs.setTab('regular')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'regular'}"
                    >
                        <?php esc_attr_e('Normal', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('bumps')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'bumps'}"
                    >
                        <?php esc_attr_e('Bump Up', 'listivo-core'); ?>
                    </a>
                </h2>

                <div v-show="tabs.tab === 'regular'" class="tabs-content">
                    <?php tdf_load_view('dashboard/packages/normal'); ?>
                </div>

                <div v-show="tabs.tab === 'bumps'" class="tabs-content">
                    <?php tdf_load_view('dashboard/packages/bump'); ?>
                </div>
            </div>
        </lst-tabs>
    </div>
</div>