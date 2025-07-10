<?php

use Tangibledesign\Listivo\Widgets\General\ServicesV4Widget;

/* @var ServicesV4Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-services-v4">
    <div class="listivo-services-v4__list">
        <?php foreach ($lstCurrentWidget->getServices() as $lstService) : ?>
            <div
                <?php if ($lstCurrentWidget->iconCirclesEnabled()) : ?>
                    class="listivo-service-v4 listivo-service-v4--with-circle"
                <?php else : ?>
                    class="listivo-service-v4"
                <?php endif; ?>
            >

                <div
                    <?php if ($lstCurrentWidget->iconCirclesEnabled()) : ?>
                        class="listivo-service-v4__circle"
                    <?php else : ?>
                        class="listivo-service-v4__image"
                    <?php endif; ?>
                >
                    <?php if (!empty($lstService['image']['url'])) : ?>
                        <img
                                src="<?php echo esc_url($lstService['image']['url']); ?>"
                                alt="<?php echo esc_attr($lstService['title']); ?>"
                        >
                    <?php endif; ?>
                </div>

                <h3 class="listivo-service-v4__label">
                    <?php echo esc_html($lstService['title']); ?>
                </h3>

                <?php if (!empty($lstService['text'])) : ?>
                    <div class="listivo-service-v4__text">
                        <?php if ($lstService['type'] === 'text' || $lstService['type'] === 'address') : ?>
                            <?php echo wp_kses_post(nl2br($lstService['text'])); ?>
                        <?php elseif ($lstService['type'] === 'mail') : ?>
                            <a href="mailto:<?php echo esc_attr($lstService['text']); ?>">
                                <?php echo wp_kses_post(nl2br($lstService['text'])); ?>
                            </a>
                        <?php elseif ($lstService['type'] === 'phone') : ?>
                            <a href="tel:<?php echo esc_attr(apply_filters(tdf_prefix() . '/phoneUrl', $lstService['text'])); ?>">
                                <?php echo wp_kses_post(nl2br($lstService['text'])); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
