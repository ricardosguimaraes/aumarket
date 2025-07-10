<div class="listivo-app listivo-compare-preview-wrapper">
    <div class="listivo-compare-preview-wrapper__container">
        <template>
            <lst-compare-preview
                    class="listivo-compare-preview"
                    prefix="listivo"
                    :swiper-config="<?php echo htmlspecialchars(json_encode([
                        'loop' => false,
                        'spaceBetween' => 30,
                        'slidesPerView' => 3,
                    ])); ?>"
                    compare-page-url="<?php echo esc_url(tdf_settings()->getComparePageUrl()); ?>"
            >
                <div
                        slot-scope="props"
                        class="listivo-compare-preview"
                        :class="{
                            'listivo-compare-preview--hidden': props.count === 0,
                            'listivo-compare-preview--open': props.open && props.count > 0
                        }"
                >
                    <div class="listivo-compare-preview__button">
                        <div @click.prevent="props.onOpen" class="listivo-compare-button">
                            <div class="listivo-compare-button__inner">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16"
                                     fill="none">
                                    <path d="M0.0285767 7.56548L3.16525 10.6788L6.27853 7.5421L3.77855 7.55145L3.76686 4.42647C3.76295 3.38271 4.59107 2.54837 5.63483 2.54447L12.627 2.51831C12.8903 3.24111 13.5809 3.76474 14.3894 3.76172C15.4176 3.75787 16.2613 2.90784 16.2574 1.87972C16.2536 0.851592 15.4035 0.00789803 14.3754 0.0117451C13.5669 0.0147706 12.8802 0.543559 12.6223 1.26831L5.63015 1.29448C3.91143 1.30091 2.51043 2.71243 2.51687 4.43115L2.52856 7.55613L0.0285767 7.56548ZM1.29962 13.1858C1.30346 14.2139 2.15349 15.0576 3.18162 15.0537C3.99016 15.0507 4.67685 14.5219 4.93474 13.7972L11.9269 13.771C13.6456 13.7646 15.0466 12.3531 15.0402 10.6343L15.0285 7.50935L17.5285 7.5L14.3918 4.38671L11.2785 7.52339L13.7785 7.51403L13.7902 10.639C13.7941 11.6828 12.966 12.5171 11.9222 12.521L4.93006 12.5472C4.66675 11.8244 3.97613 11.3007 3.16759 11.3038C2.13946 11.3076 1.29577 12.1576 1.29962 13.1858ZM2.54961 13.1811C2.54829 12.8285 2.81969 12.5551 3.17226 12.5538C3.52484 12.5524 3.79828 12.8238 3.7996 13.1764C3.80092 13.529 3.52952 13.8024 3.17694 13.8037C2.82436 13.8051 2.55093 13.5337 2.54961 13.1811ZM13.7574 1.88907C13.7561 1.53649 14.0275 1.26306 14.3801 1.26174C14.7327 1.26042 15.0061 1.53181 15.0074 1.88439C15.0087 2.23697 14.7373 2.51041 14.3848 2.51173C14.0322 2.51305 13.7587 2.24165 13.7574 1.88907Z"
                                          fill="#FDFDFE"/>
                                </svg>

                                <?php echo esc_html(tdf_string('compare')); ?>

                                <div class="listivo-compare-button__count">{{ props.count }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="listivo-compare-preview__content">
                        <div class="listivo-compare-preview__list">
                            <div class="listivo-swiper-container">
                                <div class="listivo-swiper-wrapper">
                                    <div
                                            v-for="model in props.models"
                                            :key="model.id"
                                            class="listivo-swiper-slide"
                                    >
                                        <a
                                                class="listivo-compare-preview-card"
                                                :key="'listivo-compare-model-' + model.id"
                                                :href="model.url"
                                        >
                                            <div class="listivo-compare-preview-card__image">
                                                <img :src="model.image" :alt="model.name">

                                                <div
                                                        class="listivo-compare-preview-card__remove"
                                                        @click.prevent="props.removeModel(model.id)"
                                                >
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"
                                                         viewBox="0 0 8 8" fill="none">
                                                        <path d="M0.889354 0.000385399C0.713166 0.000603672 0.541042 0.0533645 0.394971 0.151928C0.248899 0.250491 0.135512 0.390383 0.0692934 0.553731C0.00307477 0.71708 -0.0129688 0.89647 0.0232121 1.06899C0.059393 1.2415 0.146156 1.39931 0.272417 1.52225L2.74709 3.9981L0.272417 6.47394C0.187381 6.55563 0.119491 6.65346 0.0727219 6.76173C0.0259528 6.86999 0.00124506 6.9865 4.58543e-05 7.10443C-0.00115335 7.22237 0.0211801 7.33935 0.0657381 7.44855C0.110296 7.55774 0.176183 7.65694 0.25954 7.74033C0.342897 7.82373 0.442049 7.88965 0.551188 7.93423C0.660327 7.97881 0.77726 8.00115 0.895139 7.99995C1.01302 7.99875 1.12947 7.97403 1.23768 7.92724C1.34589 7.88045 1.44368 7.81252 1.52533 7.72745L4 5.2516L6.47467 7.72745C6.55631 7.81253 6.6541 7.88045 6.76231 7.92724C6.87052 7.97403 6.98698 7.99875 7.10486 7.99995C7.22274 8.00115 7.33967 7.97881 7.44881 7.93423C7.55795 7.88965 7.6571 7.82373 7.74046 7.74034C7.82382 7.65694 7.88971 7.55774 7.93426 7.44855C7.97882 7.33936 8.00115 7.22237 7.99995 7.10443C7.99875 6.9865 7.97405 6.86999 7.92728 6.76173C7.88051 6.65346 7.81261 6.55563 7.72758 6.47394L5.25291 3.9981L7.72758 1.52225C7.85561 1.39774 7.94306 1.23743 7.97847 1.06234C8.01387 0.887245 7.99558 0.705535 7.92599 0.541021C7.8564 0.376508 7.73876 0.236865 7.58848 0.140392C7.4382 0.0439203 7.26229 -0.00488048 7.08382 0.000385399C6.85363 0.00724757 6.63515 0.103498 6.47467 0.268746L4 2.74459L1.52533 0.268746C1.44266 0.183724 1.34377 0.116165 1.23453 0.0700682C1.12529 0.023972 1.00791 0.000276521 0.889354 0.000385399Z"
                                                              fill="#2A3946"/>
                                                    </svg>
                                                </div>
                                            </div>

                                            <h3 class="listivo-compare-preview-card__label" v-html="model.name"></h3>
                                        </a>
                                    </div>

                                    <div
                                            v-for="index in props.placeholderNumber"
                                            class="listivo-swiper-slide"
                                            :key="index"
                                    >
                                        <div class="listivo-compare-preview-card">
                                            <div class="listivo-compare-preview-card__image listivo-compare-preview-card__image--placeholer">
                                                <img
                                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                                        alt="placeholder"
                                                >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="listivo-compare-preview__bottom">
                            <div>
                                <div
                                        class="listivo-compare-preview__compare-button"
                                        :class="{'listivo-compare-preview__compare-button--visible': props.models.length > 1}"
                                >
                                    <a
                                            class="listivo-button listivo-button--primary-2"
                                            href="<?php echo esc_url(tdf_settings()->getComparePageUrl()); ?>"
                                    >
                                        <span>
                                            <?php echo esc_html(tdf_string('compare')); ?>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11"
                                                 viewBox="0 0 12 11"
                                                 fill="none">
                                                <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                                      fill="#FDFDFE"/>
                                            </svg>
                                        </span>
                                    </a>
                                </div>

                                <div
                                        v-if="props.count === 1"
                                        class="listivo-compare-preview__info"
                                >
                                    <div class="listivo-compare-preview__info-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                             viewBox="0 0 40 40" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M19.1563 37.9119H20.8437C30.3188 37.9119 38 29.8925 38 20C38 10.1075 30.3188 2.08808 20.8437 2.08808H19.1563C9.68115 2.08808 2 10.1075 2 20C2 29.8925 9.68115 37.9119 19.1563 37.9119ZM20.8437 40C31.4234 40 40 31.0457 40 20C40 8.9543 31.4234 0 20.8437 0H19.1563C8.57658 0 0 8.9543 0 20C0 31.0457 8.57658 40 19.1563 40H20.8437Z"
                                                  fill="#F09965"/>
                                            <path d="M20.6641 10.3335C20.6641 10.8858 20.2352 11.3335 19.7062 11.3335H19.6219C19.0929 11.3335 18.6641 10.8858 18.6641 10.3335C18.6641 9.78121 19.0929 9.3335 19.6219 9.3335H19.7062C20.2352 9.3335 20.6641 9.78121 20.6641 10.3335Z"
                                                  fill="#F09965"/>
                                            <path d="M20.6641 29.623C20.6641 30.1996 20.2163 30.667 19.6641 30.667C19.1118 30.667 18.6641 30.1996 18.6641 29.623L18.6641 15.0444C18.6641 14.4678 19.1118 14.0003 19.6641 14.0003C20.2163 14.0003 20.6641 14.4678 20.6641 15.0444L20.6641 29.623Z"
                                                  fill="#F09965"/>
                                        </svg>
                                    </div>

                                    <?php echo tdf_string('compare_info_text'); ?>
                                </div>
                            </div>

                            <div class="listivo-compare-preview__nav listivo-box-arrows">
                                <div
                                        class="listivo-box-arrow"
                                        :class="{'listivo-box-arrow--disabled': props.swiper.isBeginning}"
                                        @click="props.prevSlide"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                         fill="none">
                                        <path d="M4.86195 10.4713C4.99228 10.6017 5.16262 10.6667 5.33329 10.6667C5.50395 10.6667 5.67429 10.6017 5.80462 10.4713C6.06496 10.211 6.06496 9.78898 5.80462 9.52865L2.27593 5.99996H11.3333C11.7013 5.99996 12 5.70129 12 5.33329C12 4.96528 11.7013 4.66662 11.3333 4.66662H2.27593L5.80462 1.13792C6.06496 0.877589 6.06496 0.455586 5.80462 0.195251C5.54429 -0.0650838 5.12229 -0.0650838 4.86195 0.195251L0.195251 4.86195C-0.0650838 5.12229 -0.0650838 5.54429 0.195251 5.80462L4.86195 10.4713Z"/>
                                    </svg>
                                </div>

                                <div
                                        class="listivo-box-arrow"
                                        :class="{'listivo-box-arrow--disabled': props.swiper.isEnd}"
                                        @click="props.nextSlide"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                         fill="none">
                                        <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49604 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455587 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </lst-compare-preview>
        </template>
    </div>
</div>