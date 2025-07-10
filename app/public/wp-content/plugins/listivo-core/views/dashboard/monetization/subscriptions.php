<?php
$packagesTab = $_GET['subscriptions_type'] ?? 'list';
?>
<div class="listivo-backend-content">
    <a
            class="page-title-action"
            href="<?php echo esc_url(admin_url('admin.php?page=listivo-add-new-subscription')); ?>"
    >
        <?php esc_html_e('Add New Subscription', 'listivo-core'); ?>
    </a>

    <lst-tabs
            base-url="<?php echo esc_url(admin_url('admin.php?page=listivo_monetization&tab=subscriptions')); ?>"
            initial-tab="<?php echo esc_attr($packagesTab); ?>"
            tab-url-name="subscriptions_type"
    >
        <div slot-scope="subscriptionsTabs">
            <div>
                <ul class="subsubsub">
                    <li>
                        <a
                                @click="subscriptionsTabs.setTab('list')"
                                :class="{'current': subscriptionsTabs.tab === 'list'}"
                                href="#"
                        >
                            <?php esc_html_e('List', 'listivo-core'); ?>
                        </a>
                        |
                    </li>

                    <li>
                        <a
                                @click="subscriptionsTabs.setTab('free')"
                                :class="{'current': subscriptionsTabs.tab === 'free'}"
                                href="#"
                        >
                            <?php esc_html_e('Free', 'listivo-core'); ?>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="listivo-backend-content">
                <template>
                    <div v-show="subscriptionsTabs.tab === 'list'">
                        <?php tdf_load_view('dashboard/subscriptions/list'); ?>
                    </div>

                    <div v-show="subscriptionsTabs.tab === 'free'">
                        <?php tdf_load_view('dashboard/subscriptions/free'); ?>
                    </div>
                </template>
            </div>
        </div>
    </lst-tabs>
</div>
