<?php

use Tangibledesign\Listivo\Widgets\General\LoginAndRegisterWidget;

/* @var LoginAndRegisterWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div
    <?php if (!empty($lstCurrentWidget->getBackgroundImage())) : ?>
        class="listivo-app listivo-login-widget listivo-login-widget--with-background"
        style="background-image: url('<?php echo esc_url($lstCurrentWidget->getBackgroundImage()); ?>');"
    <?php else : ?>
        class="listivo-app listivo-login-widget"
    <?php endif; ?>
>
    <div class="listivo-login-widget__form">
        <?php if ($lstCurrentWidget->getWidgetType() === 'login') : ?>
            <div class="listivo-login-form">
                <div
                    <?php if (tdf_settings()->userRegistrationOpen()) : ?>
                        class="listivo-login-form__inner"
                    <?php else : ?>
                        class="listivo-login-form__inner listivo-login-form__inner--rounded"
                    <?php endif; ?>
                >
                    <?php get_template_part('templates/widgets/general/login/login'); ?>
                </div>
            </div>
        <?php elseif ($lstCurrentWidget->getWidgetType() === 'register') : ?>
            <div class="listivo-login-form">
                <div
                    <?php if (tdf_settings()->userRegistrationOpen()) : ?>
                        class="listivo-login-form__inner"
                    <?php else : ?>
                        class="listivo-login-form__inner listivo-login-form__inner--rounded"
                    <?php endif; ?>
                >
                    <?php get_template_part('templates/widgets/general/login/register'); ?>
                </div>
            </div>
        <?php else : ?>
            <?php get_template_part('templates/partials/login_and_register'); ?>
        <?php endif; ?>
    </div>
</div>