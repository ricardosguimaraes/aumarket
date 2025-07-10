<div
        class="listivo-skeleton-listing-card-v4"
        v-for="n in 6"
>
    <div class="listivo-skeleton-listing-card-v4__gallery">
        <img
                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                alt="skeleton"
        >
    </div>

    <div class="listivo-skeleton-listing-card-v4__content">
        <div class="listivo-skeleton-listing-card-v4__line listivo-skeleton-listing-card-v4__line--no-margin listivo-skeleton-listing-card-v4__line--first"></div>

        <div class="listivo-skeleton-listing-card-v4__line listivo-skeleton-listing-card-v4__line--second"></div>

        <div class="listivo-skeleton-listing-card-v4__line listivo-skeleton-listing-card-v4__line--third"></div>
    </div>

    <?php if (tdf_settings()->showUserOnCard() || tdf_settings()->isCompareModelsEnabled() || tdf_settings()->isFavoriteEnabled()): ?>
        <div class="listivo-skeleton-listing-card-v4__bottom">
            <div class="listivo-skeleton-listing-card-v4__bottom-right">
                <div class="listivo-skeleton-listing-card-v4__circle listivo-skeleton-listing-card-v4__circle--margin-right"></div>

                <?php if (tdf_settings()->isFavoriteEnabled()) : ?>
                    <div class="listivo-skeleton-listing-card-v4__circle"></div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>