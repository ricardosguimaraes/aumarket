<?php

use Tangibledesign\Listivo\Widgets\Listing\ListingTopWidget;

/* @var ListingTopWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}

$lstMainValue = $lstCurrentWidget->getMainValue();
$lstAddress = $lstCurrentWidget->getAddress();
?>
<div
    <?php if (!empty($lstMainValue)) : ?>
        class="listivo-listing-top"
    <?php else : ?>
        class="listivo-listing-top listivo-listing-top--no-price"
    <?php endif; ?>
>
    <div class="listivo-listing-top__left">
        <h1 class="listivo-listing-top__name">
            <?php echo esc_html($lstModel->getName()); ?>
        </h1>

        <?php if (!empty($lstAddress)) : ?>
            <div class="listivo-listing-top__address listivo-app">
                <div class="listivo-listing-top__address-icon listivo-small-icon listivo-small-icon--circle listivo-small-icon--primary-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M5 0C2.24609 0 0 2.27981 0 5.07505C0 5.8601 0.316406 6.72048 0.753906 7.62843C1.19141 8.54036 1.76172 9.49193 2.33594 10.3602C3.47656 12.1008 4.61328 13.5163 4.61328 13.5163L5 14L5.38672 13.5163C5.38672 13.5163 6.52344 12.1008 7.66797 10.3602C8.23828 9.49193 8.80859 8.54036 9.24609 7.62843C9.68359 6.72048 10 5.8601 10 5.07505C10 2.27981 7.75391 0 5 0ZM5 1.01514C7.21484 1.01514 9 2.82709 9 5.07518C9 5.55096 8.75391 6.33997 8.34766 7.18449C7.94141 8.03298 7.38672 8.95283 6.83594 9.80132C5.99563 11.0789 5.40082 11.8315 5.08146 12.2356L5 12.3388L4.91854 12.2356C4.59919 11.8315 4.00437 11.0789 3.16406 9.80132C2.61328 8.95283 2.05859 8.03298 1.65234 7.18449C1.24609 6.33997 1 5.55096 1 5.07518C1 2.82709 2.78516 1.01514 5 1.01514ZM4.00002 5.06006C4.00002 4.50928 4.44924 4.06006 5.00002 4.06006C5.5508 4.06006 6.00002 4.50928 6.00002 5.06006C6.00002 5.61084 5.5508 6.06006 5.00002 6.06006C4.44924 6.06006 4.00002 5.61084 4.00002 5.06006Z"
                              fill="#FDFDFE"/>
                    </svg>
                </div>

                <?php echo esc_html($lstAddress); ?>

                <?php if ($lstCurrentWidget->getSeeMapType() === 'open_new_window') : ?>
                    <a
                            class="listivo-listing-top__see-map"
                            href="<?php echo esc_url('https://www.google.com/maps/search/?api=1&query=' . urlencode($lstAddress)); ?>"
                            target="_blank"
                    >
                        <?php echo esc_html(tdf_string('see_map')); ?>
                    </a>
                <?php else : ?>
                    <template>
                        <lst-scroll-to-link selector=".listivo-listing-map-anchor" prefix="listivo">
                            <a
                                    slot-scope="props"
                                    v-if="props.visible"
                                    @click.prevent="props.onClick"
                                    class="listivo-listing-top__see-map"
                                    href="#"
                            >
                                <?php echo esc_html(tdf_string('see_map')); ?>
                            </a>
                        </lst-scroll-to-link>
                    </template>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!empty($lstMainValue)) : ?>
        <div class="listivo-listing-top__right">
            <div class="listivo-listing-top__price">
                <?php echo wp_kses_post($lstMainValue); ?>
            </div>

            <div class="listivo-app listivo-listing-top__finance">
                <template>
                    <lst-scroll-to-link selector=".listivo-loan-calculator-anchor" prefix="listivo">
                        <a slot-scope="props" v-if="props.visible" @click.prevent="props.onClick" href="#">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="18" viewBox="0 0 14 18"
                                 fill="none">
                                <path d="M2.62501 0.666748C1.36677 0.666748 0.333344 1.70018 0.333344 2.95841V15.0417C0.333344 16.3 1.36677 17.3334 2.62501 17.3334H11.375C12.6332 17.3334 13.6667 16.3 13.6667 15.0417V2.95841C13.6667 1.70018 12.6332 0.666748 11.375 0.666748H2.62501ZM2.62501 1.91675H11.375C11.9576 1.91675 12.4167 2.37582 12.4167 2.95841V15.0417C12.4167 15.6243 11.9576 16.0834 11.375 16.0834H2.62501C2.04242 16.0834 1.58334 15.6243 1.58334 15.0417V2.95841C1.58334 2.37582 2.04242 1.91675 2.62501 1.91675ZM3.85873 3.5826C3.30007 3.5826 2.83334 4.05014 2.83334 4.60881V7.14136C2.83334 7.70002 3.30007 8.16675 3.85873 8.16675H10.1413C10.6999 8.16675 11.1664 7.7002 11.1675 7.14217V4.60881C11.1675 4.05014 10.6999 3.5826 10.1413 3.5826H3.85873ZM4.08334 4.8326H9.91749V6.91675H4.08334V4.8326ZM3.87501 9.41675C3.59874 9.41675 3.33379 9.52649 3.13844 9.72185C2.94309 9.9172 2.83334 10.1821 2.83334 10.4584C2.83334 10.7347 2.94309 10.9996 3.13844 11.195C3.33379 11.3903 3.59874 11.5001 3.87501 11.5001C4.15128 11.5001 4.41623 11.3903 4.61158 11.195C4.80693 10.9996 4.91668 10.7347 4.91668 10.4584C4.91668 10.1821 4.80693 9.9172 4.61158 9.72185C4.41623 9.52649 4.15128 9.41675 3.87501 9.41675ZM7.00001 9.41675C6.72374 9.41675 6.45879 9.52649 6.26344 9.72185C6.06809 9.9172 5.95834 10.1821 5.95834 10.4584C5.95834 10.7347 6.06809 10.9996 6.26344 11.195C6.45879 11.3903 6.72374 11.5001 7.00001 11.5001C7.27628 11.5001 7.54123 11.3903 7.73658 11.195C7.93193 10.9996 8.04168 10.7347 8.04168 10.4584C8.04168 10.1821 7.93193 9.9172 7.73658 9.72185C7.54123 9.52649 7.27628 9.41675 7.00001 9.41675ZM10.125 9.41675C9.54959 9.41675 9.08334 9.883 9.08334 10.4584V13.3751C9.08334 13.9505 9.54959 14.4167 10.125 14.4167C10.7004 14.4167 11.1667 13.9505 11.1667 13.3751V10.4584C11.1667 9.883 10.7004 9.41675 10.125 9.41675ZM3.87501 12.3334C3.59874 12.3334 3.33379 12.4432 3.13844 12.6385C2.94309 12.8339 2.83334 13.0988 2.83334 13.3751C2.83334 13.6513 2.94309 13.9163 3.13844 14.1117C3.33379 14.307 3.59874 14.4167 3.87501 14.4167C4.15128 14.4167 4.41623 14.307 4.61158 14.1117C4.80693 13.9163 4.91668 13.6513 4.91668 13.3751C4.91668 13.0988 4.80693 12.8339 4.61158 12.6385C4.41623 12.4432 4.15128 12.3334 3.87501 12.3334ZM7.00001 12.3334C6.72374 12.3334 6.45879 12.4432 6.26344 12.6385C6.06809 12.8339 5.95834 13.0988 5.95834 13.3751C5.95834 13.6513 6.06809 13.9163 6.26344 14.1117C6.45879 14.307 6.72374 14.4167 7.00001 14.4167C7.27628 14.4167 7.54123 14.307 7.73658 14.1117C7.93193 13.9163 8.04168 13.6513 8.04168 13.3751C8.04168 13.0988 7.93193 12.8339 7.73658 12.6385C7.54123 12.4432 7.27628 12.3334 7.00001 12.3334Z"
                                      fill="#537CD9"/>
                            </svg>

                            <?php echo esc_html(tdf_string('calculate_financing')); ?>
                        </a>
                    </lst-scroll-to-link>
                </template>
            </div>
        </div>
    <?php endif; ?>
</div>
