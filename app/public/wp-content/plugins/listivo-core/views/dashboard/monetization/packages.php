<?php
$packagesTab = $_GET['package_type'] ?? 'regular';
?>
<div class="listivo-backend-content">
    <a
            class="page-title-action"
            href="<?php echo esc_url(admin_url('admin.php?page=listivo-add-new-package')); ?>"
    >
        <?php esc_html_e('Add New Package', 'listivo-core'); ?>
    </a>

    <lst-tabs initial-tab="<?php echo esc_attr($packagesTab); ?>">
        <div slot-scope="packagesTabs">
            <div>
                <ul class="subsubsub">
                    <li>
                        <a
                                @click="packagesTabs.setTab('regular')"
                                :class="{'current': packagesTabs.tab === 'regular'}"
                                href="#"
                        >
                            <?php esc_html_e('Regular', 'listivo-core'); ?>
                        </a>
                        |
                    </li>

                    <li>
                        <a
                                @click="packagesTabs.setTab('bumps')"
                                :class="{'current': packagesTabs.tab === 'bumps'}"
                                href="#"
                        >
                            <?php esc_html_e('Bump Up', 'listivo-core'); ?>
                        </a>
                        |
                    </li>

                    <li>
                        <a
                                @click="packagesTabs.setTab('free')"
                                :class="{'current': packagesTabs.tab === 'free'}"
                                href="#"
                        >
                            <?php esc_html_e('Free', 'listivo-core'); ?>
                        </a>
                        |
                    </li>

                    <li>
                        <a
                                @click="packagesTabs.setTab('register')"
                                :class="{'current': packagesTabs.tab === 'register'}"
                                href="#"
                        >
                            <?php esc_html_e('Register', 'listivo-core'); ?>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="listivo-backend-content">
                <template>
                    <div v-show="packagesTabs.tab === 'regular'">
                        <?php tdf_load_view('dashboard/packages/normal'); ?>
                    </div>

                    <div v-show="packagesTabs.tab === 'bumps'">
                        <?php tdf_load_view('dashboard/packages/bump'); ?>
                    </div>

                    <div v-show="packagesTabs.tab === 'free'">
                        <?php tdf_load_view('dashboard/packages/free'); ?>
                    </div>

                    <div v-show="packagesTabs.tab === 'register'">
                        <?php tdf_load_view('dashboard/packages/register'); ?>
                    </div>
                </template>
            </div>
        </div>
    </lst-tabs>
</div>