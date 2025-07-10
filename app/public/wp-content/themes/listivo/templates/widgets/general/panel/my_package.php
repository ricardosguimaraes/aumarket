<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\Payments\RegularUserPaymentPackage;

/* @var RegularUserPaymentPackage $lstPackage */
global $lstPackage;
?>
<div
        class="listivo-panel-package"
        :class="{'listivo-panel-package--active': props.package === '<?php echo esc_attr($lstPackage->getId()); ?>'}"
        @click="props.setPackage('<?php echo esc_attr($lstPackage->getId()); ?>')"
>
    <div class="listivo-panel-package__column listivo-panel-package__column--first">
        <?php if (!empty($lstPackage->getDisplayPrice()) && $lstPackage->getDisplayPrice() !== tdf_string('free'))  : ?>
            <div class="listivo-panel-package__name">
                <?php echo esc_html($lstPackage->getName()); ?>
            </div>
        <?php endif; ?>

        <div
            <?php if ($lstPackage->getDisplayPrice() === tdf_string('free')) : ?>
                class="listivo-panel-package__price listivo-panel-package__price--no-margin-top"
            <?php else : ?>
                class="listivo-panel-package__price"
            <?php endif; ?>
        >
            <?php if (!empty($lstPackage->getDisplayPrice())) : ?>
                <?php echo esc_html($lstPackage->getDisplayPrice()); ?>
            <?php else : ?>
                <?php echo esc_html($lstPackage->getName()); ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="listivo-panel-package__column listivo-panel-package__details">
        <div class="listivo-panel-package__data">
            <?php if (!empty($lstPackage->getNumber())) : ?>
                <div class="listivo-panel-package__value">
                    <div>
                        <?php echo esc_html(tdf_string('listings')); ?>:
                    </div>

                    <div class="listivo-lowercase">
                        <span><?php echo esc_html($lstPackage->getNumber()) ?></span> x
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($lstPackage->getExpire())) : ?>
                <div class="listivo-panel-package__value">
                    <div>
                        <?php echo esc_html(tdf_string('duration')); ?>:
                    </div>

                    <div class="listivo-lowercase">
                        <span>
                            <?php echo esc_html($lstPackage->getExpire()); ?>
                        </span>

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
                        <span>
                            <?php echo esc_html($lstPackage->getFeaturedExpire()); ?>
                        </span>

                        <?php if ($lstPackage->getExpire() !== 1) : ?>
                            <?php echo esc_html(tdf_string('days')); ?>
                        <?php else : ?>
                            <?php echo esc_html(tdf_string('day')); ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (!empty($lstPackage->getBumpsNumber()) && !empty($lstPackage->getBumpsInterval())) : ?>
                <div class="listivo-panel-package__value">
                    <div>
                        <?php echo esc_html(tdf_string('bump_up')); ?>:
                    </div>

                    <div class="listivo-lowercase">
                        <span>
                            <?php echo esc_html($lstPackage->getBumpsNumber()); ?>
                        </span>
                    </div>
                </div>

                <div class="listivo-panel-package__value">
                    <div>
                        <?php echo esc_html(tdf_string('bumps_interval')); ?>:
                    </div>

                    <div class="listivo-lowercase">
                        <span>
                            <?php echo esc_html($lstPackage->getBumpsInterval()); ?>
                        </span>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($lstPackage->getCategories()->isNotEmpty()) : ?>
                <div class="listivo-panel-package__value">
                    <div>
                        <?php echo esc_html(tdf_string('categories')); ?>:
                    </div>

                    <div class="listivo-panel-package__categories">
                        <?php foreach ($lstPackage->getCategories() as $category) : ?>
                            <span>
                                <?php echo esc_html($category->getName()); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (
                !empty($lstPackage->getExpireDate())
                && tdf_settings()->getSubscriptionRenewalPolicy() === SettingKey::SUBSCRIPTION_RENEWAL_POLICY_RESET
            ) : ?>
                <div class="listivo-panel-package__value">
                    <div><?php echo esc_html(tdf_string('expire')); ?>:</div>

                    <div><?php echo esc_html($lstPackage->getExpireDate()) ?></div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="listivo-panel-package__column">
        <div class="listivo-panel-package__button"></div>
    </div>
</div>