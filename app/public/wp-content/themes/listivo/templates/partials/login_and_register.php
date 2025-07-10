<?php
$lstInitialTab = tdf_settings()->getInitialTab();
?>
<lst-tabs
        class="listivo-login-form"
        initial-tab="<?php echo esc_attr($lstInitialTab); ?>"
        tabs-id="account"
        :allow-close="false"
>
    <div
            class="listivo-login-form"
            slot-scope="tabs"
    >
        <?php if (tdf_settings()->userRegistrationOpen()) : ?>
            <div class="listivo-login-form__tabs">
                <button
                        class="listivo-login-form__tab"
                        :class="{'listivo-login-form__tab--active': tabs.tab === 'login'}"
                        @click.prevent="tabs.setTab('login')"
                >
                    <?php echo esc_html(tdf_string('login')); ?>
                </button>

                <button
                        class="listivo-login-form__tab"
                        :class="{'listivo-login-form__tab--active': tabs.tab === 'register'}"
                        @click.prevent="tabs.setTab('register')"
                >
                    <?php echo esc_html(tdf_string('register')); ?>
                </button>
            </div>
        <?php endif; ?>

        <div
            <?php if (tdf_settings()->userRegistrationOpen()) : ?>
                class="listivo-login-form__inner"
            <?php else : ?>
                class="listivo-login-form__inner listivo-login-form__inner--rounded"
            <?php endif; ?>
        >
            <?php if ($lstInitialTab === 'register') : ?>
            <template>
                <?php endif; ?>

                <div v-if="tabs.tab === 'login'">
                    <?php get_template_part('templates/widgets/general/login/login'); ?>
                </div>

                <?php if ($lstInitialTab === 'register') : ?>
            </template>
        <?php endif; ?>

            <?php if (tdf_settings()->userRegistrationOpen()) : ?>
                <?php if ($lstInitialTab === 'login') : ?>
                    <template>
                <?php endif; ?>

                <div v-if="tabs.tab === 'register'">
                    <?php get_template_part('templates/widgets/general/login/register'); ?>
                </div>

                <?php if ($lstInitialTab === 'login') : ?>
                    </template>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</lst-tabs>