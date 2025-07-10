<?php

use Tangibledesign\Framework\Models\Payments\PaymentPackage;

if (!tdf_settings()->isFreeListingEnabled()) {
    return;
}

/* @var PaymentPackage $lstPackage */
$lstPackage = tdf_app('free_package');
?>
<div
        class="listivo-panel-package"
        @click.prevent="props.setPackage('free')"
        :class="{'listivo-panel-package--active': props.package === 'free'}"
>
    <div class="listivo-panel-package__column listivo-panel-package__column--first">
        <div class="listivo-panel-package__price">
            <?php echo esc_html($lstPackage->getName()); ?>
        </div>
    </div>

    <div class="listivo-panel-package__column listivo-panel-package__details">
        <div class="listivo-panel-package__data">
            <?php if (!empty($lstPackage->getNumber()) && $lstPackage->getNumber() !== 1) : ?>
                <div class="listivo-panel-package__value">
                    <div>
                        <?php echo esc_html(tdf_string('listings')); ?>:
                    </div>

                    <div>
                        <span><?php echo esc_html($lstPackage->getNumber()) ?></span>
                        x
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($lstPackage->getExpire())) : ?>
                <div class="listivo-panel-package__value">
                    <div>
                        <?php echo esc_html(tdf_string('duration')); ?>:
                    </div>

                    <div class="listivo-lowercase">
                        <span><?php echo esc_html($lstPackage->getExpire()); ?></span>

                        <?php if ($lstPackage->getExpire() !== 1) : ?>
                            <?php echo esc_html(tdf_string('days')); ?>
                        <?php else : ?>
                            <?php echo esc_html(tdf_string('day')); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($lstPackage->getFeaturedExpire())) : ?>
                <div class="listivo-panel-package__value">
                    <div>
                        <?php echo esc_html(tdf_string('featured')); ?>:
                    </div>

                    <div class="listivo-lowercase">
                        <span><?php echo esc_html($lstPackage->getFeaturedExpire()); ?></span>
                        x

                        <?php if ($lstPackage->getExpire() !== 1) : ?>
                            <?php echo esc_html(tdf_string('days')); ?>
                        <?php else : ?>
                            <?php echo esc_html(tdf_string('day')); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="listivo-panel-package__column">
        <div class="listivo-panel-package__button"></div>
    </div>
</div>