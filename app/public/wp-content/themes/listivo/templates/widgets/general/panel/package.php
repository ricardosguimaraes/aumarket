<?php

use Tangibledesign\Framework\Models\Payments\PaymentPackage;

/* @var PaymentPackage $lstPaymentPackage */
global $lstPaymentPackage;
?>
<div
        class="listivo-panel-package"
        :class="{'listivo-panel-package--active': props.package === '<?php echo esc_attr($lstPaymentPackage->getKey()); ?>'}"
        @click.prevent="props.setPackage('<?php echo esc_attr($lstPaymentPackage->getKey()); ?>')"
>
    <div class="listivo-panel-package__column listivo-panel-package__column--first">
        <?php if ($lstPaymentPackage->getName() !== $lstPaymentPackage->getDisplayPrice()) : ?>
            <div class="listivo-panel-package__name">
                <?php echo esc_html($lstPaymentPackage->getName()); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($lstPaymentPackage->getDisplayPrice())) : ?>
            <div class="listivo-panel-package__price">
                <?php echo esc_html($lstPaymentPackage->getDisplayPrice()); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($lstPaymentPackage->getLabel())) : ?>
            <div class="listivo-panel-package__label">
                <?php echo esc_html($lstPaymentPackage->getLabel()); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="listivo-panel-package__column listivo-panel-package__details">
        <div class="listivo-panel-package__data">
            <?php if (!empty($lstPaymentPackage->getNumber()) && $lstPaymentPackage->getNumber() !== 1) : ?>
                <div class="listivo-panel-package__value">
                    <div>
                        <?php echo esc_html(tdf_string('listings')); ?>:
                    </div>

                    <div class="listivo-lowercase">
                        <span><?php echo esc_html($lstPaymentPackage->getNumber()) ?></span> x
                    </div>
                </div>
            <?php endif; ?>

            <div class="listivo-panel-package__value">
                <div>
                    <?php echo esc_html(tdf_string('duration')); ?>:
                </div>

                <div class="listivo-lowercase">
                    <?php if (!empty($lstPaymentPackage->getExpire())) : ?>
                        <span>
                            <?php echo esc_html($lstPaymentPackage->getExpire()); ?>
                        </span>

                        <?php if ($lstPaymentPackage->getExpire() !== 1) : ?>
                            <?php echo esc_html(tdf_string('days')); ?>
                        <?php else : ?>
                            <?php echo esc_html(tdf_string('day')); ?>
                        <?php endif; ?>
                    <?php else : ?>
                        <span>
                            <?php echo esc_html(tdf_string('unlimited')); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if (!empty($lstPaymentPackage->getFeaturedExpire())) : ?>
                <div class="listivo-panel-package__value">
                    <div>
                        <?php echo esc_html(tdf_string('featured')); ?>:
                    </div>

                    <div class="listivo-lowercase">
                        <span>
                            <?php echo esc_html($lstPaymentPackage->getFeaturedExpire()); ?>
                        </span>

                        <?php if ($lstPaymentPackage->getFeaturedExpire() !== 1) : ?>
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