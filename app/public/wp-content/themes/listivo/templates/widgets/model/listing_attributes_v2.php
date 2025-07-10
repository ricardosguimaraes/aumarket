<?php
/* @var \Tangibledesign\Listivo\Widgets\Listing\ListingAttributesV2Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstAttributes = $lstCurrentWidget->getAttributes();
if ($lstAttributes->isEmpty()) {
    return;
}
?>
<?php if ($lstCurrentWidget->showTeaser()) : ?>
    <div class="listivo-app">
        <lst-show>
            <div slot-scope="props">
                <div class="listivo-attributes-v2">
                    <?php foreach ($lstCurrentWidget->getTeaserAttributes() as $lstAttribute) : ?>
                        <div v-if="!props.show" class="listivo-attributes-v2__attribute">
                            <div class="listivo-attributes-v2__name">
                                <?php echo esc_html($lstAttribute['label']); ?>:
                            </div>

                            <div class="listivo-attributes-v2__values">
                                <?php echo esc_html($lstAttribute['value']); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                    <template>
                        <?php foreach ($lstAttributes as $lstAttribute) : ?>
                            <div v-if="props.show" class="listivo-attributes-v2__attribute">
                                <div class="listivo-attributes-v2__name">
                                    <?php echo esc_html($lstAttribute['label']); ?>:
                                </div>

                                <div class="listivo-attributes-v2__values">
                                    <?php echo esc_html($lstAttribute['value']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </template>

                </div>

                <div class="listivo-show-more-wrapper">
                    <button
                            v-if="!props.show"
                            class="listivo-show-more"
                            @click.prevent="props.onClick"
                    >
                        <?php echo esc_html(tdf_string('show_more')); ?>
                    </button>

                    <template>
                        <button
                                v-if="props.show"
                                class="listivo-show-more"
                                @click.prevent="props.onClick"
                        >
                            <?php echo esc_html(tdf_string('show_less')); ?>
                        </button>
                    </template>
                </div>
            </div>
        </lst-show>
    </div>
<?php else : ?>
    <div class="listivo-attributes-v2">
        <?php foreach ($lstAttributes as $lstAttribute) : ?>
            <div class="listivo-attributes-v2__attribute">
                <div class="listivo-attributes-v2__name">
                    <?php echo esc_html($lstAttribute['label']); ?>:
                </div>

                <div class="listivo-attributes-v2__values">
                    <?php echo esc_html($lstAttribute['value']); ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
