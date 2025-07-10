<?php

use Tangibledesign\Listivo\Providers\Settings\SettingsServiceProvider;

$tab = $_GET['tab'] ?? 'basic';
?>
<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        Listivo
    </h1>

    <form
            action="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/settings/save&type=' . SettingsServiceProvider::TYPE_BASIC)); ?>"
            method="post"
    >
        <lst-tabs
                initial-tab="<?php echo esc_attr($tab); ?>"
                base-url="<?php echo esc_url(admin_url('admin.php?page=listivo_basic_setup')); ?>"
        >
            <div slot-scope="tabs">
                <input
                        type="hidden"
                        name="redirect"
                        :value="tabs.currentUrl"
                >

                <h2 class="nav-tab-wrapper">
                    <a
                            @click="tabs.setTab('basic')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'basic'}"
                    >
                        <?php esc_attr_e('Basic', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('menu')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'menu'}"
                    >
                        <?php esc_attr_e('Menu', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('features')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'features'}"
                    >
                        <?php esc_attr_e('Features', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('search')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'search'}"
                    >
                        <?php esc_attr_e('Search', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('seo')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'seo'}"
                    >
                        <?php esc_attr_e('SEO', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('maps')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'maps'}"
                    >
                        <?php esc_attr_e('Maps', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('socials')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'socials'}"
                    >
                        <?php esc_attr_e('Socials', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('currency')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'currency'}"
                    >
                        <?php esc_attr_e('Currency', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('numbers')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'numbers'}"
                    >
                        <?php esc_attr_e('Numbers', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('reviews')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'reviews'}"
                    >
                        <?php esc_attr_e('Reviews', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('twilio')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'twilio'}"
                    >
                        <?php esc_attr_e('Twilio', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('other')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'other'}"
                    >
                        <?php esc_attr_e('Other', 'listivo-core'); ?>
                    </a>
                </h2>

                <template>
                    <div v-show="tabs.tab === 'basic'" class="tabs-content">
                        <?php tdf_load_view('dashboard/settings/basic'); ?>
                    </div>

                    <div v-show="tabs.tab === 'menu'" class="tabs-content">
                        <?php tdf_load_view('dashboard/settings/menu'); ?>
                    </div>

                    <div v-show="tabs.tab === 'features'" class="tabs-content">
                        <?php tdf_load_view('dashboard/settings/features'); ?>
                    </div>

                    <div v-show="tabs.tab === 'search'" class="tabs-content">
                        <?php tdf_load_view('dashboard/settings/search'); ?>
                    </div>

                    <div v-show="tabs.tab === 'seo'" class="tabs-content">
                        <?php tdf_load_view('dashboard/settings/seo'); ?>
                    </div>

                    <div v-show="tabs.tab === 'maps'" class="tabs-content">
                        <?php tdf_load_view('dashboard/settings/maps'); ?>
                    </div>

                    <div v-show="tabs.tab === 'socials'" class="tabs-content">
                        <?php tdf_load_view('dashboard/settings/socials'); ?>
                    </div>

                    <div v-show="tabs.tab === 'currency'" class="tabs-content">
                        <?php tdf_load_view('dashboard/settings/currency'); ?>
                    </div>

                    <div v-show="tabs.tab === 'numbers'" class="tabs-content">
                        <?php tdf_load_view('dashboard/settings/numbers'); ?>
                    </div>

                    <div v-show="tabs.tab === 'reviews'" class="tabs-content">
                        <?php tdf_load_view('dashboard/settings/reviews'); ?>
                    </div>

                    <div v-show="tabs.tab === 'twilio'" class="tabs-content">
                        <?php tdf_load_view('dashboard/settings/twilio'); ?>
                    </div>

                    <div v-show="tabs.tab === 'other'" class="tabs-content">
                        <?php tdf_load_view('dashboard/settings/other'); ?>
                    </div>
                </template>
            </div>
        </lst-tabs>
    </form>
</div>