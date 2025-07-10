<?php
/* @var Review $lstReview $ */

use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Review;
use Tangibledesign\Framework\Models\User\User;

?>
<input
        name="listivo_nonce"
        type="hidden"
        value="<?php echo esc_attr(wp_create_nonce('listivo/review/update')); ?>"
>

<div class="tdf-app">
    <template>
        <lst-review-type initial-review-type="<?php echo esc_attr($lstReview->getType()); ?>">
            <div
                    class="tdfm-form"
                    slot-scope="reviewTypeProps"
            >
                <div class="tdfm-form__top tdfm-form__top--auto-height">
                    <div class="tdfm-form__fields tdfm-form__fields--cols-3 tdfm-form__fields--padding-x-0">
                        <div class="tdfm-field-group">
                            <label
                                    class="tdfm-field-group__label"
                                    for="tdf-rating"
                            >
                                <?php esc_html_e('Rating (from 1 to 5)', 'listivo-core'); ?>
                            </label>

                            <div class="tdfm-field-group__field">
                                <div class="tdfm-input">
                                    <input
                                            id="tdf-rating"
                                            name="rating"
                                            value="<?php echo esc_attr($lstReview->getRating()); ?>"
                                            type="text"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="tdfm-field-group">
                            <label
                                    class="tdfm-field-group__label"
                                    for="tdf-thumb-up"
                            >
                                <?php esc_html_e('Thumb Up', 'listivo-core'); ?>
                            </label>

                            <div class="tdfm-field-group__field">
                                <div class="tdfm-input">
                                    <input
                                            id="tdf-thumb-up"
                                            name="thumb_up_count"
                                            value="<?php echo esc_attr($lstReview->getThumbUpCount()); ?>"
                                            type="text"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="tdfm-field-group">
                            <label
                                    class="tdfm-field-group__label"
                                    for="tdf-thumb-down"
                            >
                                <?php esc_html_e('Thumb Down', 'listivo-core'); ?>
                            </label>

                            <div class="tdfm-field-group__field">
                                <div class="tdfm-input">
                                    <input
                                            id="tdf-thumb-down"
                                            name="thumb_down_count"
                                            value="<?php echo esc_attr($lstReview->getThumbDownCount()); ?>"
                                            type="text"
                                    >
                                </div>
                            </div>
                        </div>

                        <div class="tdfm-form__field tdfm-form__field--full-width">
                            <div class="tdfm-field-group">
                                <label
                                        class="tdfm-field-group__label"
                                        for="tdf-model"
                                >
                                    <?php echo sprintf(esc_html__('Review Type', 'listivo-core'), tdf_string('listing')); ?>
                                </label>

                                <div class="tdfm-field-group__field">
                                    <input
                                            name="<?php echo esc_attr(Review::TYPE); ?>"
                                            :value="reviewTypeProps.reviewType"
                                            type="hidden"
                                    >

                                    <lst-select>
                                        <div slot-scope="select">
                                            <div
                                                    class="tdfm-select"
                                                    @click.stop.prevent="select.onOpen"
                                                    @focusin="select.focusIn"
                                                    @focusout="select.focusOut"
                                                    @keyup.esc="select.onClose"
                                                    tabindex="0"
                                            >
                                                <div class="tdfm-select__placeholder">
                                                    <span v-if="reviewTypeProps.reviewType === '<?php echo esc_attr(tdf_model_post_type()); ?>'">
                                                        <?php echo esc_html(tdf_string('listing')); ?>
                                                    </span>

                                                    <span v-if="reviewTypeProps.reviewType === '<?php echo esc_attr(Review::TYPE_USER); ?>'">
                                                        <?php echo esc_html(tdf_string('user')); ?>
                                                    </span>
                                                </div>

                                                <div
                                                        v-show="select.open"
                                                        class="tdfm-select__dropdown"
                                                >

                                                    <div
                                                            class="tdfm-select__option"
                                                            @click.stop.prevent="reviewTypeProps.setReviewType('<?php echo esc_attr(tdf_model_post_type()); ?>'); select.onClose();"
                                                    >
                                                        <?php echo esc_html(tdf_string('listing')); ?>
                                                    </div>

                                                    <div
                                                            class="tdfm-select__option"
                                                            @click.stop.prevent="reviewTypeProps.setReviewType('<?php echo esc_attr(Review::TYPE_USER); ?>'); select.onClose();"
                                                    >
                                                        <?php echo esc_html(tdf_string('user')); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </lst-select>
                                </div>
                            </div>
                        </div>

                        <div class="tdfm-form__field tdfm-form__field--full-width">
                            <div class="tdfm-field-group">
                                <label
                                        class="tdfm-field-group__label"
                                        for="tdf-model"
                                >
                                    <?php echo sprintf(esc_html__('Assigned %s', 'listivo-core'), tdf_string('listing')); ?>
                                </label>

                                <div class="tdfm-field-group__field">
                                    <lst-fetch-review-subjects
                                            :review-type="reviewTypeProps.reviewType"
                                            request-url="<?php echo esc_url(tdf_action_url('tdf/models/search')); ?>"
                                        <?php
                                        $lstReviewSubject = $lstReview->getModel();
                                        if ($lstReviewSubject instanceof Model) :?>
                                            :initial-selected-option="<?php echo htmlspecialchars(json_encode([
                                                'id' => $lstReviewSubject->getId(),
                                                'name' => $lstReviewSubject->getName(),
                                            ])); ?>"
                                        <?php elseif ($lstReviewSubject instanceof User) : ?>
                                            :initial-selected-option="<?php echo htmlspecialchars(json_encode([
                                                'id' => $lstReviewSubject->getId(),
                                                'name' => $lstReviewSubject->getDisplayName(),
                                            ])); ?>"
                                        <?php endif; ?>
                                    >
                                        <div slot-scope="fetchModelsProps">
                                            <input
                                                    name="<?php echo esc_attr(Review::MODEL); ?>"
                                                    type="hidden"
                                                    :value="fetchModelsProps.value"
                                            >

                                            <lst-select>
                                                <div slot-scope="select">
                                                    <div
                                                            class="tdfm-select"
                                                            @click.stop.prevent="select.onOpen"
                                                            @focusin="select.focusIn"
                                                            @focusout="select.focusOut"
                                                            @keyup.esc="select.onClose"
                                                            tabindex="0"
                                                    >
                                                        <div
                                                                v-if="fetchModelsProps.value.length === 0"
                                                                class="tdfm-select__input"
                                                        >
                                                            <input
                                                                    :value="fetchModelsProps.keyword"
                                                                    @input="fetchModelsProps.setKeyword($event.target.value)"
                                                                    type="text"
                                                                    placeholder="<?php echo sprintf(esc_html__('Start typing %s name', 'listivo-core'), mb_strtolower(tdf_string('listing'))); ?>"
                                                            >
                                                        </div>

                                                        <div
                                                                v-if="fetchModelsProps.selectedOption"
                                                                class="tdfm-select__placeholder"
                                                        >
                                                            <span v-html="fetchModelsProps.selectedOption.name"></span>
                                                        </div>

                                                        <div
                                                                v-if="fetchModelsProps.value !== ''"
                                                                class="tdfm-select__clear"
                                                                @click.stop.prevent="fetchModelsProps.clear(); select.onClose()"
                                                        >
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"
                                                                 viewBox="0 0 8 8"
                                                                 fill="none">
                                                                <path d="M0.889354 0.000385399C0.713166 0.000603672 0.541042 0.0533645 0.394971 0.151928C0.248899 0.250491 0.135512 0.390383 0.0692934 0.553731C0.00307477 0.71708 -0.0129688 0.89647 0.0232121 1.06899C0.059393 1.2415 0.146156 1.39931 0.272417 1.52225L2.74709 3.9981L0.272417 6.47394C0.187381 6.55563 0.119491 6.65346 0.0727219 6.76173C0.0259528 6.86999 0.00124506 6.9865 4.58543e-05 7.10443C-0.00115335 7.22237 0.0211801 7.33935 0.0657381 7.44855C0.110296 7.55774 0.176183 7.65694 0.25954 7.74033C0.342897 7.82373 0.442049 7.88965 0.551188 7.93423C0.660327 7.97881 0.77726 8.00115 0.895139 7.99995C1.01302 7.99875 1.12947 7.97403 1.23768 7.92724C1.34589 7.88045 1.44368 7.81252 1.52533 7.72745L4 5.2516L6.47467 7.72745C6.55631 7.81253 6.6541 7.88045 6.76231 7.92724C6.87052 7.97403 6.98698 7.99875 7.10486 7.99995C7.22274 8.00115 7.33967 7.97881 7.44881 7.93423C7.55795 7.88965 7.6571 7.82373 7.74046 7.74034C7.82382 7.65694 7.88971 7.55774 7.93426 7.44855C7.97882 7.33936 8.00115 7.22237 7.99995 7.10443C7.99875 6.9865 7.97405 6.86999 7.92728 6.76173C7.88051 6.65346 7.81261 6.55563 7.72758 6.47394L5.25291 3.9981L7.72758 1.52225C7.85561 1.39774 7.94306 1.23743 7.97847 1.06234C8.01387 0.887245 7.99558 0.705535 7.92599 0.541021C7.8564 0.376508 7.73876 0.236865 7.58848 0.140392C7.4382 0.0439203 7.26229 -0.00488048 7.08382 0.000385399C6.85363 0.00724757 6.63515 0.103498 6.47467 0.268746L4 2.74459L1.52533 0.268746C1.44266 0.183724 1.34377 0.116165 1.23453 0.0700682C1.12529 0.023972 1.00791 0.000276521 0.889354 0.000385399Z"
                                                                      fill="#EA6A6A"/>
                                                            </svg>
                                                        </div>

                                                        <div
                                                                v-show="select.open && fetchModelsProps.options.length > 0"
                                                                class="tdfm-select__dropdown"
                                                        >
                                                            <div
                                                                    v-for="option in fetchModelsProps.options"
                                                                    :key="option.id"
                                                                    class="tdfm-select__option"
                                                                    v-html="option.name"
                                                                    @click.stop.prevent="fetchModelsProps.setValue(option.id); select.onClose();"
                                                            >
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </lst-select>
                                        </div>
                                    </lst-fetch-review-subjects>
                                </div>
                            </div>
                        </div>

                        <div class="tdfm-form__field tdfm-form__field--full-width">
                            <div class="tdfm-field-group">
                                <label
                                        class="tdfm-field-group__label"
                                        for="tdf-author"
                                >
                                    <?php esc_html_e('Author Display Name (for anonymous reviews)', 'listivo-core'); ?>
                                </label>

                                <div class="tdfm-field-group__field">
                                    <div class="tdfm-input">
                                        <input
                                                id="tdf-author"
                                                name="<?php echo esc_attr(Review::AUTHOR); ?>"
                                                value="<?php echo esc_attr($lstReview->getAuthor()); ?>"
                                                type="text"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tdfm-form__fields">
                    <lst-review-backend-gallery
                            title-text="<?php esc_html_e('Select or Upload Media', 'listivo-core'); ?>"
                            button-text="<?php esc_html_e('Use this media', 'listivo-core'); ?>"
                            :initial-images="<?php echo htmlspecialchars(json_encode($lstReview->getImages()->map(static function ($image) {
                                /* @var Image $image */
                                return [
                                    'id' => $image->getId(),
                                    'url' => $image->getImageUrl(),
                                ];
                            })->values())); ?>"
                    >
                        <div
                                slot-scope="galleryProps"
                                class="tdfm-field-group tdfm-form__field tdfm-form__field--full-width"
                        >
                            <label class="tdfm-field-group__label">
                                <?php esc_html_e('Gallery', 'listivo-core'); ?>
                            </label>

                            <div class="tdfm-field-group__field">
                                <div v-if="galleryProps.images.length > 0">
                                    <lst-draggable
                                            class="tdfm-form__media-container"
                                            :list="galleryProps.images"
                                    >
                                        <div
                                                v-for="image in galleryProps.images"
                                                :key="image.url"
                                                class="tdfm-media-card"
                                        >
                                            <button
                                                    class="tdfm-media-card__close"
                                                    @click.prevent="galleryProps.delete(image.id)"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"
                                                     viewBox="0 0 8 8"
                                                     fill="none">
                                                    <path d="M0.889354 0.000385399C0.713166 0.000603672 0.541042 0.0533645 0.394971 0.151928C0.248899 0.250491 0.135512 0.390382 0.0692934 0.553731C0.00307477 0.71708 -0.0129688 0.89647 0.0232121 1.06899C0.059393 1.2415 0.146156 1.39931 0.272417 1.52225L2.74709 3.9981L0.272417 6.47394C0.187381 6.55563 0.119491 6.65346 0.0727219 6.76173C0.0259528 6.86999 0.00124506 6.9865 4.58543e-05 7.10443C-0.00115335 7.22237 0.0211801 7.33935 0.0657381 7.44855C0.110296 7.55774 0.176183 7.65694 0.25954 7.74033C0.342897 7.82373 0.442049 7.88965 0.551188 7.93423C0.660327 7.97881 0.77726 8.00115 0.895139 7.99995C1.01302 7.99875 1.12947 7.97403 1.23768 7.92724C1.34589 7.88045 1.44368 7.81253 1.52533 7.72745L4 5.2516L6.47467 7.72745C6.55631 7.81253 6.6541 7.88045 6.76231 7.92724C6.87052 7.97403 6.98698 7.99875 7.10486 7.99995C7.22274 8.00116 7.33967 7.97881 7.44881 7.93423C7.55795 7.88965 7.6571 7.82373 7.74046 7.74034C7.82382 7.65694 7.8897 7.55774 7.93426 7.44855C7.97882 7.33936 8.00115 7.22237 7.99995 7.10443C7.99875 6.9865 7.97405 6.86999 7.92728 6.76173C7.88051 6.65346 7.81261 6.55563 7.72758 6.47394L5.25291 3.9981L7.72758 1.52225C7.85561 1.39774 7.94306 1.23743 7.97847 1.06234C8.01387 0.887245 7.99558 0.705535 7.92599 0.541021C7.8564 0.376508 7.73876 0.236865 7.58848 0.140392C7.4382 0.0439203 7.26229 -0.00488048 7.08382 0.000385399C6.85363 0.00724757 6.63515 0.103498 6.47467 0.268746L4 2.74459L1.52533 0.268746C1.44266 0.183724 1.34377 0.116165 1.23453 0.0700682C1.12529 0.023972 1.00791 0.000276521 0.889354 0.000385399Z"
                                                          fill="#EA6A6A"/>
                                                </svg>
                                            </button>

                                            <div class="tdfm-media-card__image">
                                                <img :src="image.url" alt="">
                                            </div>
                                        </div>
                                    </lst-draggable>
                                </div>
                            </div>

                            <input
                                    v-for="image in galleryProps.images"
                                    :key="image.url"
                                    name="gallery[]"
                                    type="hidden"
                                    :value="image.id"
                            >

                            <button
                                    class="tdfm-button tdfm-form__add-button"
                                    @click.prevent="galleryProps.openMedia"
                            >
                                <?php esc_html_e('Add images', 'listivo-core'); ?>

                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                     fill="none">
                                    <path d="M10 0C4.486 0 0 4.486 0 10C0 15.514 4.486 20 10 20C15.514 20 20 15.514 20 10C20 4.486 15.514 0 10 0ZM10 2C14.411 2 18 5.589 18 10C18 14.411 14.411 18 10 18C5.589 18 2 14.411 2 10C2 5.589 5.589 2 10 2ZM9 6V9H6V11H9V14H11V11H14V9H11V6H9Z"
                                          fill="white"/>
                                </svg>
                            </button>
                        </div>
                    </lst-review-backend-gallery>
                </div>
            </div>
        </lst-review-type>
    </template>
</div>