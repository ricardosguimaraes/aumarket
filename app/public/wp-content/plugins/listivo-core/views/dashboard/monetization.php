<?php

use Tangibledesign\Listivo\Providers\Settings\SettingsServiceProvider;

$tab = $_GET['tab'] ?? 'general';
?>
<div class="tdf-app">
    <div class="wrap">
        <h1 class="wp-heading-inline">
            <?php esc_html_e('Monetization', 'listivo-core'); ?>
        </h1>

        <form
                action="<?php echo esc_url(admin_url('admin-post.php?action=listivo/settings/save&type='.SettingsServiceProvider::TYPE_MONETIZATION)); ?>"
                method="post"
        >
            <lst-tabs
                    initial-tab="<?php echo esc_attr($tab); ?>"
                    base-url="<?php echo esc_url(admin_url('admin.php?page=listivo_monetization')); ?>"
            >
                <div slot-scope="tabs">
                    <input
                            type="hidden"
                            name="redirect"
                            :value="tabs.currentUrl"
                    >

                    <h2 class="nav-tab-wrapper">
                        <a
                                @click="tabs.setTab('general')"
                                href="#"
                                class="nav-tab"
                                :class="{'nav-tab-active': tabs.tab === 'general'}"
                        >
                            <?php esc_attr_e('General', 'listivo-core'); ?>
                        </a>

                        <a
                                @click="tabs.setTab('packages')"
                                href="#"
                                class="nav-tab"
                                :class="{'nav-tab-active': tabs.tab === 'packages'}"
                        >
                            <?php esc_attr_e('Packages', 'listivo-core'); ?>
                        </a>

                        <a
                                @click="tabs.setTab('subscriptions')"
                                href="#"
                                class="nav-tab"
                                :class="{'nav-tab-active': tabs.tab === 'subscriptions'}"
                        >
                            <?php esc_attr_e('Subscriptions', 'listivo-core'); ?>
                        </a>

                        <a
                                @click="tabs.setTab('user_subscriptions')"
                                href="#"
                                class="nav-tab"
                                :class="{'nav-tab-active': tabs.tab === 'user_subscriptions'}"
                        >
                            <?php esc_attr_e('User Subscriptions', 'listivo-core'); ?>
                        </a>

                        <a
                                @click="tabs.setTab('stripe')"
                                href="#"
                                class="nav-tab"
                                :class="{'nav-tab-active': tabs.tab === 'stripe'}"
                        >
                            <?php esc_attr_e('Stripe', 'listivo-core'); ?>
                        </a>
                    </h2>

                    <template>
                        <div v-show="tabs.tab === 'general'" class="tabs-content">
                            <?php tdf_load_view('dashboard/monetization/general'); ?>
                        </div>

                        <div v-show="tabs.tab === 'packages'" class="tabs-content">
                            <?php tdf_load_view('dashboard/monetization/packages'); ?>
                        </div>

                        <div v-show="tabs.tab === 'subscriptions'" class="tabs-content">
                            <?php tdf_load_view('dashboard/monetization/subscriptions'); ?>
                        </div>

                        <div v-show="tabs.tab === 'user_subscriptions'" class="tabs-content">
                            <?php tdf_load_view('dashboard/monetization/user_subscriptions'); ?>
                        </div>

                        <div v-show="tabs.tab === 'stripe'" class="tabs-content">
                            <?php tdf_load_view('dashboard/monetization/stripe'); ?>
                        </div>
                    </template>
                </div>
            </lst-tabs>
        </form>
    </div>
</div>