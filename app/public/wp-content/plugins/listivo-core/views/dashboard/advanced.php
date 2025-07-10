<?php
$tab = $_GET['tab'] ?? 'settings';
?>
<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Advanced', 'listivo-core'); ?>
    </h1>

    <lst-tabs
            initial-tab="<?php echo esc_attr($tab); ?>"
            base-url="<?php echo esc_url(admin_url('admin.php?page=listivo_advanced')); ?>"
    >
        <div slot-scope="tabs">
            <h2 class="nav-tab-wrapper">
                <a
                        @click="tabs.setTab('settings')"
                        href="#"
                        class="nav-tab"
                        :class="{'nav-tab-active': tabs.tab === 'settings'}"
                >
                    <?php esc_attr_e('Settings', 'listivo-core'); ?>
                </a>

                <a
                        @click="tabs.setTab('tools')"
                        href="#"
                        class="nav-tab"
                        :class="{'nav-tab-active': tabs.tab === 'tools'}"
                >
                    <?php esc_attr_e('Tools', 'listivo-core'); ?>
                </a>

                <a
                        @click="tabs.setTab('terms_importer')"
                        href="#"
                        class="nav-tab"
                        :class="{'nav-tab-active': tabs.tab === 'terms_importer'}"
                >
                    <?php esc_attr_e('Terms Importer', 'listivo-core'); ?>
                </a>
            </h2>

            <template>
                <div v-show="tabs.tab === 'settings'" class="tabs-content">
                    <?php tdf_load_view('dashboard/advanced/settings'); ?>
                </div>

                <div v-show="tabs.tab === 'tools'" class="tabs-content">
                    <?php tdf_load_view('dashboard/advanced/tools'); ?>
                </div>

                <div v-show="tabs.tab === 'terms_importer'" class="tabs-content">
                    <?php tdf_load_view('dashboard/advanced/terms_importer'); ?>
                </div>
            </template>
        </div>
    </lst-tabs>
</div>