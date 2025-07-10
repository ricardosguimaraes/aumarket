<?php

use Tangibledesign\Listivo\Widgets\Listing\ListingReportAbuseWidget;

/* @var ListingReportAbuseWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstModel = $lstCurrentWidget->getModel();
if (!$lstModel) {
    return;
}
?>
<div class="listivo-app">
    <lst-show>
        <div slot-scope="showProps" class="listivo-report-abuse-button-wrapper">
            <div
                    class="listivo-report-abuse-button"
                    @click="showProps.onClick"
            >
                <div class="listivo-report-abuse-button__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                        <path d="M9.91804 8.89643e-05C9.23321 0.00563136 8.55081 0.270265 8.03664 0.792843L0.762291 8.18722C-0.266032 9.23236 -0.252158 10.9347 0.792997 11.963L8.18738 19.2374C9.23252 20.2657 10.9349 20.2518 11.9632 19.2067L19.2375 11.8132C19.2379 11.8129 19.2382 11.8126 19.2385 11.8123C20.266 10.7667 20.252 9.06483 19.2068 8.03649L11.8125 0.762137C11.2899 0.247976 10.6029 -0.00545358 9.91804 8.89643e-05ZM9.93013 1.41997C10.2462 1.41742 10.5631 1.53768 10.8104 1.78099L18.2047 9.05535C18.6993 9.54195 18.7052 10.3161 18.2187 10.8111L10.9443 18.2046C10.4577 18.6991 9.68406 18.7052 9.18949 18.2185L1.7951 10.9442C1.30055 10.4576 1.29453 9.68391 1.78115 9.18933L9.0555 1.79495C9.2988 1.54767 9.61405 1.42253 9.93013 1.41997ZM9.98875 4.74917C9.79956 4.75213 9.61926 4.83 9.48739 4.9657C9.35552 5.1014 9.28286 5.28386 9.28532 5.47307V11.1898C9.28398 11.2845 9.30148 11.3785 9.33679 11.4664C9.3721 11.5543 9.42452 11.6343 9.49101 11.7017C9.5575 11.7691 9.63673 11.8227 9.72409 11.8592C9.81146 11.8958 9.90522 11.9146 9.99992 11.9146C10.0946 11.9146 10.1884 11.8958 10.2757 11.8592C10.3631 11.8227 10.4423 11.7691 10.5088 11.7017C10.5753 11.6343 10.6277 11.5543 10.663 11.4664C10.6984 11.3785 10.7159 11.2845 10.7145 11.1898V5.47307C10.7158 5.3775 10.6978 5.28265 10.6618 5.19414C10.6257 5.10563 10.5723 5.02525 10.5046 4.95775C10.4369 4.89026 10.3564 4.83702 10.2678 4.80119C10.1792 4.76537 10.0843 4.74768 9.98875 4.74917ZM9.99992 13.3336C9.74722 13.3336 9.50488 13.434 9.32619 13.6127C9.14751 13.7914 9.04712 14.0337 9.04712 14.2864C9.04712 14.5391 9.14751 14.7814 9.32619 14.9601C9.50488 15.1388 9.74722 15.2392 9.99992 15.2392C10.2526 15.2392 10.495 15.1388 10.6736 14.9601C10.8523 14.7814 10.9527 14.5391 10.9527 14.2864C10.9527 14.0337 10.8523 13.7914 10.6736 13.6127C10.495 13.434 10.2526 13.3336 9.99992 13.3336Z"
                              fill="#ED5E4F"/>
                    </svg>
                </div>

                <?php echo esc_html(tdf_string('report_abuse')); ?>
            </div>

            <template>
                <portal v-if="showProps.show" to="footer">
                    <div
                            class="listivo-popup-wrapper"
                            @click="showProps.onClick"
                    >
                        <div class="listivo-popup-wrapper__container">
                            <div
                                    class="listivo-popup-wrapper__modal"
                                    @click.stop.prevent
                            >
                                <div
                                        class="listivo-popup-wrapper__close"
                                        @click="showProps.onClick"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8"
                                         viewBox="0 0 8 8" fill="none">
                                        <path d="M0.889354 0.000385399C0.713166 0.000603672 0.541042 0.0533645 0.394971 0.151928C0.248899 0.250491 0.135512 0.390383 0.0692934 0.553731C0.00307477 0.71708 -0.0129688 0.89647 0.0232121 1.06899C0.059393 1.2415 0.146156 1.39931 0.272417 1.52225L2.74709 3.9981L0.272417 6.47394C0.187381 6.55563 0.119491 6.65346 0.0727219 6.76173C0.0259528 6.86999 0.00124506 6.9865 4.58543e-05 7.10443C-0.00115335 7.22237 0.0211801 7.33935 0.0657381 7.44855C0.110296 7.55774 0.176183 7.65694 0.25954 7.74033C0.342897 7.82373 0.442049 7.88965 0.551188 7.93423C0.660327 7.97881 0.77726 8.00115 0.895139 7.99995C1.01302 7.99875 1.12947 7.97403 1.23768 7.92724C1.34589 7.88045 1.44368 7.81252 1.52533 7.72745L4 5.2516L6.47467 7.72745C6.55631 7.81253 6.6541 7.88045 6.76231 7.92724C6.87052 7.97403 6.98698 7.99875 7.10486 7.99995C7.22274 8.00115 7.33967 7.97881 7.44881 7.93423C7.55795 7.88965 7.6571 7.82373 7.74046 7.74034C7.82382 7.65694 7.88971 7.55774 7.93426 7.44855C7.97882 7.33936 8.00115 7.22237 7.99995 7.10443C7.99875 6.9865 7.97405 6.86999 7.92728 6.76173C7.88051 6.65346 7.81261 6.55563 7.72758 6.47394L5.25291 3.9981L7.72758 1.52225C7.85561 1.39774 7.94306 1.23743 7.97847 1.06234C8.01387 0.887245 7.99558 0.705535 7.92599 0.541021C7.8564 0.376508 7.73876 0.236865 7.58848 0.140392C7.4382 0.0439203 7.26229 -0.00488048 7.08382 0.000385399C6.85363 0.00724757 6.63515 0.103498 6.47467 0.268746L4 2.74459L1.52533 0.268746C1.44266 0.183724 1.34377 0.116165 1.23453 0.0700682C1.12529 0.023972 1.00791 0.000276521 0.889354 0.000385399Z"
                                              fill="#FDFDFE"/>
                                    </svg>
                                </div>

                                <lst-model-report-abuse
                                        :model-id="<?php echo esc_attr($lstModel->getId()); ?>"
                                        request-url="<?php echo esc_url(tdf_action_url('listivo/model/reportAbuse')); ?>"
                                >
                                    <div slot-scope="reportAbuse" class="listivo-listing-report-abuse-form">
                                        <div
                                                class="listivo-listing-report-abuse-form__inner"
                                                v-if="!reportAbuse.reported"
                                        >
                                            <h3 class="listivo-listing-report-abuse-form__label">
                                                <?php echo esc_html(tdf_string('report_abuse')); ?>
                                            </h3>

                                            <div class="listivo-listing-report-abuse-form__mail">
                                                <div class="listivo-input-v2">
                                                    <input
                                                            id="email"
                                                            type="text"
                                                            :value="reportAbuse.mail"
                                                            @input="reportAbuse.setMail($event.target.value)"
                                                            placeholder="<?php echo esc_attr(tdf_string('email')); ?>"
                                                            required
                                                    >
                                                </div>
                                            </div>

                                            <div class="listivo-listing-report-abuse-form__text">
                                                <textarea
                                                        @input="reportAbuse.setText($event.target.value)"
                                                        :value="reportAbuse.text"
                                                        placeholder="<?php echo esc_attr(tdf_string('report_abuse_reason')); ?>"
                                                ></textarea>
                                            </div>

                                            <div class="listivo-listing-report-abuse-form__button">
                                                <button
                                                        class="listivo-button listivo-button--primary-1"
                                                        :disabled="reportAbuse.inProgress"
                                                        :class="{'listivo-button--loading': reportAbuse.inProgress}"
                                                        @click.prevent="reportAbuse.onClick"
                                                >
                                                    <span>
                                                        <?php echo esc_html(tdf_string('send')); ?>

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                             height="11"
                                                             viewBox="0 0 12 11"
                                                             fill="none">
                                                            <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                                                  fill="#FDFDFE"/>
                                                        </svg>
                                                    </span>

                                                    <template>
                                                        <svg
                                                                width='40'
                                                                height='10'
                                                                viewBox='0 0 120 30'
                                                                xmlns='http://www.w3.org/2000/svg'
                                                                fill='#fff'
                                                                class="listivo-button__loading"
                                                        >
                                                            <circle cx='15' cy='15' r='15'>
                                                                <animate attributeName='r' from='15' to='15' begin='0s'
                                                                         dur='0.8s' values='15;9;15'
                                                                         calcMode='linear' repeatCount='indefinite'/>
                                                                <animate attributeName='fill-opacity' from='1' to='1'
                                                                         begin='0s' dur='0.8s'
                                                                         values='1;.5;1'
                                                                         calcMode='linear' repeatCount='indefinite'/>
                                                            </circle>

                                                            <circle cx='60' cy='15' r='9' fill-opacity='0.3'>
                                                                <animate attributeName='r' from='9' to='9' begin='0s'
                                                                         dur='0.8s' values='9;15;9'
                                                                         calcMode='linear' repeatCount='indefinite'/>
                                                                <animate attributeName='fill-opacity' from='0.5'
                                                                         to='0.5'
                                                                         begin='0s' dur='0.8s'
                                                                         values='.5;1;.5' calcMode='linear'
                                                                         repeatCount='indefinite'/>
                                                            </circle>

                                                            <circle cx='105' cy='15' r='15'>
                                                                <animate attributeName='r' from='15' to='15' begin='0s'
                                                                         dur='0.8s' values='15;9;15'
                                                                         calcMode='linear' repeatCount='indefinite'/>
                                                                <animate attributeName='fill-opacity' from='1' to='1'
                                                                         begin='0s' dur='0.8s'
                                                                         values='1;.5;1'
                                                                         calcMode='linear' repeatCount='indefinite'/>
                                                            </circle>
                                                        </svg>
                                                    </template>
                                                </button>
                                            </div>
                                        </div>

                                        <div
                                                class="listivo-listing-report-abuse-form__inner"
                                                v-if="reportAbuse.reported"
                                        >
                                            <h3 class="listivo-listing-report-abuse-form__label">
                                                <?php echo esc_html(tdf_string('report_abuse')); ?>
                                            </h3>

                                            <div class="listivo-listing-report-abuse-form__reported">
                                                <?php echo esc_html(tdf_string('abuse_reported')); ?>
                                            </div>

                                            <div class="listivo-listing-report-abuse-form__button">
                                                <button
                                                        class="listivo-button listivo-button--primary-1"
                                                        @click.prevent="showProps.onClick"
                                                >
                                                    <span>
                                                        <?php echo esc_html(tdf_string('close')); ?>

                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12"
                                                             height="11"
                                                             viewBox="0 0 12 11"
                                                             fill="none">
                                                            <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                                                  fill="#FDFDFE"/>
                                                        </svg>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </lst-model-report-abuse>
                            </div>
                        </div>
                    </div>
                </portal>
            </template>
        </div>
    </lst-show>
</div>