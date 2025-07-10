<?php

use Tangibledesign\Listivo\Widgets\General\ServicesV5Widget;

/* @var ServicesV5Widget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-services-v5">
    <?php foreach ($lstCurrentWidget->getServices() as $lstService) : ?>
        <div class="listivo-service-v5">
            <div class="listivo-service-v5__arrow">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="25" viewBox="0 0 16 25" fill="none">
                    <path d="M1.11914 23.7492C17.1613 9.08347 19.7173 17.7527 2.72758 1.96159" stroke="#F17851"
                          stroke-width="3"/>
                </svg>
            </div>

            <div class="listivo-service-v5__image">
                <?php if (!empty($lstService['image']['url'])) : ?>
                    <img
                            class="lazyload"
                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                            data-src="<?php echo esc_url($lstService['image']['url']); ?>"
                        <?php if (isset($lstService['alt']))  : ?>
                            alt="<?php echo esc_attr($lstService['image']['alt']); ?>"
                        <?php endif; ?>
                    >
                <?php endif; ?>
            </div>

            <div class="listivo-service-v5__decoration">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
                    <rect x="1.5" y="1.5" width="27" height="27" rx="13.5" fill="#FDFDFE" stroke="#F17851"
                          stroke-width="3"/>
                </svg>
            </div>

            <div class="listivo-service-v5__label">
                <?php echo esc_html($lstService['title']); ?>
            </div>

            <?php if (!empty($lstService['text'])): ?>
                <div class="listivo-service-v5__text">
                    <?php echo esc_html($lstService['text']); ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
