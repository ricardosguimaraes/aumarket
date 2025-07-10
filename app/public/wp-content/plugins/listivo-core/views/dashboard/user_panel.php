<?php

use Tangibledesign\Listivo\Providers\Settings\SettingsServiceProvider;

$tab = $_GET['tab'] ?? 'general';
?>
<div class="tdf-app">
    <div class="wrap">
        <h1 class="wp-heading-inline">
            <?php esc_html_e('User Panel', 'listivo-core'); ?>
        </h1>

        <form
                action="<?php echo esc_url(admin_url('admin-post.php?action=listivo/settings/save&type='.SettingsServiceProvider::TYPE_USER_PANEL)); ?>"
                method="post"
        >
            <lst-tabs
                    initial-tab="<?php echo esc_attr($tab); ?>"
                    base-url="<?php echo esc_url(admin_url('admin.php?page=listivo_user_panel')); ?>"
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
                                @click="tabs.setTab('moderation')"
                                href="#"
                                class="nav-tab"
                                :class="{'nav-tab-active': tabs.tab === 'moderation'}"
                        >
                            <?php esc_attr_e('Moderation', 'listivo-core'); ?>
                        </a>

                        <a
                                @click="tabs.setTab('user')"
                                href="#"
                                class="nav-tab"
                                :class="{'nav-tab-active': tabs.tab === 'user'}"
                        >
                            <?php esc_attr_e('User', 'listivo-core'); ?>
                        </a>

                        <a
                                @click="tabs.setTab('private_account')"
                                href="#"
                                class="nav-tab"
                                :class="{'nav-tab-active': tabs.tab === 'private_account'}"
                        >
                            <?php esc_attr_e('Private Account', 'listivo-core'); ?>
                        </a>

                        <a
                                @click="tabs.setTab('business_account')"
                                href="#"
                                class="nav-tab"
                                :class="{'nav-tab-active': tabs.tab === 'business_account'}"
                        >
                            <?php esc_attr_e('Business Account', 'listivo-core'); ?>
                        </a>

                        <a
                                @click="tabs.setTab('social_auth')"
                                href="#"
                                class="nav-tab"
                                :class="{'nav-tab-active': tabs.tab === 'social_auth'}"
                        >
                            <?php esc_attr_e('Social Authentication', 'listivo-core'); ?>
                        </a>

                        <a
                                @click="tabs.setTab('re_captcha')"
                                href="#"
                                class="nav-tab"
                                :class="{'nav-tab-active': tabs.tab === 're_captcha'}"
                        >
                            <?php esc_attr_e('ReCaptcha', 'listivo-core'); ?>
                        </a>

                        <a
                                @click="tabs.setTab('redirects')"
                                href="#"
                                class="nav-tab"
                                :class="{'nav-tab-active': tabs.tab === 'redirects'}"
                        >
                            <?php esc_attr_e('Redirects', 'listivo-core'); ?>
                        </a>
                    </h2>

                    <template>
                        <div v-show="tabs.tab === 'general'" class="tabs-content">
                            <?php tdf_load_view('dashboard/users/general'); ?>
                        </div>

                        <div v-show="tabs.tab === 'social_auth'" class="tabs-content">
                            <?php tdf_load_view('dashboard/users/social_auth'); ?>
                        </div>

                        <div v-show="tabs.tab === 'moderation'" class="tabs-content">
                            <?php tdf_load_view('dashboard/users/moderation'); ?>
                        </div>

                        <div v-show="tabs.tab === 'user'" class="tabs-content">
                            <?php tdf_load_view('dashboard/users/user'); ?>
                        </div>

                        <div v-show="tabs.tab === 'private_account'" class="tabs-content">
                            <?php tdf_load_view('dashboard/users/private_account'); ?>
                        </div>

                        <div v-show="tabs.tab === 'business_account'" class="tabs-content">
                            <?php tdf_load_view('dashboard/users/business_account'); ?>
                        </div>

                        <div v-show="tabs.tab === 're_captcha'" class="tabs-content">
                            <?php tdf_load_view('dashboard/users/re_captcha'); ?>
                        </div>

                        <div v-show="tabs.tab === 'redirects'" class="tabs-content">
                            <?php tdf_load_view('dashboard/users/redirects'); ?>
                        </div>
                    </template>
                </div>
            </lst-tabs>
        </form>
    </div>
</div>