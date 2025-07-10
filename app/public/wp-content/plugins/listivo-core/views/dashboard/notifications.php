<?php
$tab = $_GET['tab'] ?? 'notifications';
?>
<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Notifications', 'listivo-core'); ?>
    </h1>

    <a
            class="page-title-action"
            href="<?php echo esc_url(admin_url('admin.php?page=listivo-add-new-notification')); ?>"
    >
        <?php esc_html_e('Add New Notification', 'listivo-core'); ?>
    </a>

    <form
            action="<?php echo esc_url(tdf_action_url('listivo/notifications/save')); ?>"
            method="post"
    >
        <lst-tabs
                initial-tab="<?php echo esc_attr($tab); ?>"
                base-url="<?php echo esc_url(admin_url('admin.php?page='.tdf_prefix().'_notifications')); ?>"
        >
            <div slot-scope="tabs">
                <input
                        type="hidden"
                        name="redirect"
                        :value="tabs.currentUrl"
                >

                <h2 class="nav-tab-wrapper">
                    <a
                            @click="tabs.setTab('notifications')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'notifications'}"
                    >
                        <?php esc_attr_e('Notifications', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('system')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'system'}"
                    >
                        <?php esc_attr_e('System Messages', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('logs')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'logs'}"
                    >
                        <?php esc_attr_e('Logs', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('mail')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'mail'}"
                    >
                        <?php esc_attr_e('Mail', 'listivo-core'); ?>
                    </a>
                </h2>

                <template>
                    <div v-show="tabs.tab === 'notifications'" class="tabs-content">
                        <?php tdf_load_view('dashboard/notifications/list'); ?>
                    </div>

                    <div v-show="tabs.tab === 'system'" class="tabs-content">
                        <?php tdf_load_view('dashboard/notifications/system'); ?>
                    </div>

                    <div v-show="tabs.tab === 'logs'" class="tabs-content">
                        <?php tdf_load_view('dashboard/notifications/tasks'); ?>
                    </div>

                    <div v-show="tabs.tab === 'mail'" class="tabs-content">
                        <?php tdf_load_view('dashboard/notifications/mail'); ?>
                    </div>
                </template>
            </div>
        </lst-tabs>
    </form>
</div>