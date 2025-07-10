<?php
/* @var \Tangibledesign\Listivo\Widgets\General\AccordionWidget $lstCurrentWidget */
global $lstCurrentWidget;
?>
<div class="listivo-app">
    <lst-accordion
            class="listivo-accordions"
            item-selector=".listivo-accordion__text--"
        <?php if ($lstCurrentWidget->openFirst()) : ?>
            initial-open="0"
        <?php endif; ?>
    >
        <div class="listivo-accordions" slot-scope="props">
            <?php foreach ($lstCurrentWidget->getItems() as $lstIndex => $lstItem) : ?>
                <div
                        class="listivo-accordions__item listivo-accordion"
                        :class="{'listivo-accordion--open': props.open === '<?php echo esc_attr($lstIndex); ?>'}"
                >
                    <div
                            class="listivo-accordion__head"
                            @click.prevent="props.onOpen('<?php echo esc_attr($lstIndex); ?>')"
                    >
                        <h3 class="listivo-accordion__label">
                            <?php echo esc_html($lstItem['label']); ?>
                        </h3>

                        <div class="listivo-accordion__arrow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14"
                                 fill="none">
                                <path d="M6.0872 0.243855C6.25012 0.0809372 6.46304 -0.000312964 6.67637 -0.000312964C6.88971 -0.000312964 7.10263 0.0809372 7.26554 0.243855C7.59096 0.569274 7.59096 1.09678 7.26554 1.4222L2.85468 5.83306L14.1764 5.83306C14.6364 5.83306 15.0098 6.2064 15.0098 6.6664C15.0098 7.1264 14.6364 7.49974 14.1764 7.49974L2.85468 7.49974L7.26554 11.9106C7.59096 12.236 7.59096 12.7635 7.26554 13.0889C6.94013 13.4144 6.41262 13.4144 6.0872 13.0889L0.25383 7.25557C-0.0715891 6.93015 -0.0715891 6.40265 0.25383 6.07723L6.0872 0.243855Z"
                                      fill="#2A3946"/>
                            </svg>
                        </div>
                    </div>

                    <?php if (!$lstIndex && $lstCurrentWidget->openFirst()) : ?>
                        <div class="listivo-accordion__text listivo-accordion__text--<?php echo esc_attr($lstIndex); ?>">
                            <?php echo wp_kses_post($lstItem['text']); ?>
                        </div>
                    <?php else : ?>
                        <template>
                            <div
                                    class="listivo-accordion__text listivo-accordion__text--<?php echo esc_attr($lstIndex); ?>"
                                    style="display: none;"
                            >
                                <?php echo wp_kses_post($lstItem['text']); ?>
                            </div>
                        </template>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </lst-accordion>
</div>
