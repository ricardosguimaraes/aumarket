<div
        class="listivo-skeleton-listing-row"
        v-for="n in 6"
>
    <div class="listivo-skeleton-listing-row__gallery">
        <img
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                alt="skeleton"
        >
    </div>

    <div class="listivo-skeleton-listing-row__right">
        <div class="listivo-skeleton-listing-row__content">
            <div class="listivo-skeleton-listing-row__line listivo-skeleton-listing-row__line--no-margin listivo-skeleton-listing-row__line--first"></div>

            <div class="listivo-skeleton-listing-row__line listivo-skeleton-listing-row__line--second"></div>

            <div class="listivo-skeleton-listing-row__line listivo-skeleton-listing-row__line--third"></div>

            <div class="listivo-skeleton-listing-row__attributes">
                <div class="listivo-skeleton-listing-row__attribute"></div>

                <div class="listivo-skeleton-listing-row__attribute"></div>

                <div class="listivo-skeleton-listing-row__attribute"></div>
            </div>
        </div>

        <?php if (tdf_settings()->showUserOnCard() || tdf_settings()->isCompareModelsEnabled() || tdf_settings()->isFavoriteEnabled()): ?>
            <div class="listivo-skeleton-listing-row__bottom">
                <?php if (tdf_settings()->showUserOnCard()) : ?>
                    <div class="listivo-skeleton-listing-row__bottom-left">
                        <div class="listivo-skeleton-listing-row__circle listivo-skeleton-listing-row__circle--margin-right"></div>

                        <div class="listivo-skeleton-listing-row__bottom-line"></div>
                    </div>
                <?php endif; ?>

                <div class="listivo-skeleton-listing-row__bottom-right">
                    <div class="listivo-skeleton-listing-row__circle listivo-skeleton-listing-row__circle--margin-right"></div>

                    <?php if (tdf_settings()->isFavoriteEnabled()) : ?>
                        <div class="listivo-skeleton-listing-row__circle"></div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>