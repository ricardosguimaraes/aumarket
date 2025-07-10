<div class="tdf-app wrap">
    <h1 class="wp-heading-inline">
        <?php esc_html_e('Translate & Rename', 'listivo-core'); ?>
    </h1>

    <form action="<?php echo esc_url(tdf_action_url('listivo/translateRename/save')); ?>" method="post">
        <lst-tabs initial-tab="strings">
            <div slot-scope="tabs">
                <h2 class="nav-tab-wrapper">
                    <a
                            @click="tabs.setTab('strings')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'strings'}"
                    >
                        <?php esc_attr_e('Strings', 'listivo-core'); ?>
                    </a>

                    <a
                            @click="tabs.setTab('slugs')"
                            href="#"
                            class="nav-tab"
                            :class="{'nav-tab-active': tabs.tab === 'slugs'}"
                    >
                        <?php esc_attr_e('Slugs', 'listivo-core'); ?>
                    </a>
                </h2>

                <div v-show="tabs.tab === 'strings'" class="tabs-content">
                    <?php tdf_load_view('dashboard/translate/strings'); ?>
                </div>

                <template>
                    <div v-show="tabs.tab === 'slugs'" class="tabs-content">
                        <?php tdf_load_view('dashboard/translate/slugs'); ?>
                    </div>
                </template>
            </div>
        </lst-tabs>
    </form>
</div>