<?php

use Tangibledesign\Listivo\Widgets\General\ContentV7Widget;

/* @var ContentV7Widget $lstCurrentWidget */
global $lstCurrentWidget;

$lstImage = $lstCurrentWidget->getImage();
?>
<div class="listivo-content-v7">
    <div class="listivo-content-v7__container">
        <div class="listivo-content-v7__background">
            <svg xmlns="http://www.w3.org/2000/svg" width="1373" height="586" viewBox="0 0 1373 586" fill="none">
                <path d="M1349.71 23.3432L1349.48 23.7869L1349.92 24.0175L1354.55 26.4224L1354.99 26.653L1355.22 26.2094L1358.99 18.9736L1365.7 22.4636L1366.14 22.6943L1366.37 22.2507L1368.71 17.7564L1368.94 17.3128L1368.5 17.0821L1361.78 13.5921L1365.55 6.35622L1365.78 5.91261L1365.33 5.68195L1360.71 3.2771L1360.27 3.04644L1360.03 3.49005L1356.27 10.7259L1349.56 7.23586L1349.12 7.0052L1348.89 7.44882L1346.55 11.9431L1346.32 12.3867L1346.76 12.6173L1353.47 16.1074L1349.71 23.3432Z"
                      fill="#EFE9E4" stroke="#EFE9E4"/>
                <path d="M64.5332 551.228L67.6207 545.29L62.0876 542.413L63.8944 538.938L69.4276 541.815L72.5151 535.877L76.0914 537.736L73.0039 543.675L78.5371 546.552L76.7302 550.027L71.197 547.15L68.1095 553.088L64.5332 551.228Z"
                      fill="#D6A26E"/>
                <rect x="433" y="36" width="6" height="6" rx="3" fill="#D6A26E"/>
                <rect x="1.5" y="132.5" width="17" height="17" rx="8.5" stroke="#EFE9E4" stroke-width="5"/>
                <rect x="598.5" y="561.5" width="22" height="22" rx="11" stroke="#EFE9E4" stroke-width="5"/>
                <path d="M1289.26 581.035L1291.64 576.463L1287.38 574.248L1288.77 571.572L1293.03 573.787L1295.41 569.215L1298.16 570.647L1295.78 575.219L1300.04 577.434L1298.65 580.11L1294.39 577.895L1292.01 582.467L1289.26 581.035Z"
                      fill="#D6A26E"/>
            </svg>
        </div>

        <?php if (!empty($lstCurrentWidget->getImageUrl())) : ?>
            <div class="listivo-content-v7__image-mask">
                <svg xmlns="http://www.w3.org/2000/svg" width="675" height="450" viewBox="0 0 675 450" fill="none">
                    <clipPath id="listivo-content-v7-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>">
                        <path d="M660 450C668.284 450 675 443.284 675 435L675 15C675 6.71573 668.285 0 660 0H220.308C204.818 0 190.721 8.94339 184.121 22.9571L3.14894 407.218C-6.22227 427.116 8.29518 450 30.2896 450H660Z"
                              fill="#D9D9D9"/>
                    </clipPath>
                </svg>
            </div>

            <div class="listivo-content-v7__image-wrapper">
                <div class="listivo-content-v7__image">
                    <img
                            src="<?php echo esc_url($lstCurrentWidget->getImageUrl()); ?>"
                            alt="<?php echo esc_attr($lstCurrentWidget->getHeading()); ?>"
                            style="clip-path: url('#listivo-content-v7-<?php echo esc_attr($lstCurrentWidget->get_id()); ?>');"
                    >

                    <svg xmlns="http://www.w3.org/2000/svg" width="620" height="446" viewBox="0 0 620 446" fill="none">
                        <path d="M718 446V0H206.198C190.303 0 175.917 9.41072 169.549 23.9736L3.37492 403.98C-5.29225 423.8 9.22943 446 30.8617 446H718Z"
                              fill="#EFE9E4"/>
                    </svg>
                </div>
            </div>
        <?php endif; ?>

        <div class="listivo-content-v7__content">
            <h2 class="listivo-content-v7__heading">
                <?php echo nl2br(wp_kses_post($lstCurrentWidget->getHeading())); ?>
            </h2>

            <div class="listivo-content-v7__text">
                <?php echo nl2br(wp_kses_post($lstCurrentWidget->getText())); ?>
            </div>

            <div class="listivo-content-v7__buttons">
                <?php if (!empty($lstCurrentWidget->getButtonText())) : ?>
                    <a
                            class="listivo-button listivo-button--primary-2"
                            href="<?php echo esc_url($lstCurrentWidget->getButtonUrl()); ?>"
                            title="<?php echo esc_attr($lstCurrentWidget->getButtonText()); ?>"
                    >
                        <span>
                            <?php echo esc_html($lstCurrentWidget->getButtonText()); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                 fill="none">
                                <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </span>
                    </a>
                <?php endif; ?>

                <?php if (!empty($lstCurrentWidget->getSecondButtonText())) : ?>
                    <a
                            class="listivo-button listivo-button--primary-1"
                            href="<?php echo esc_url($lstCurrentWidget->getSecondButtonUrl()); ?>"
                            title="<?php echo esc_attr($lstCurrentWidget->getSecondButtonText()); ?>"
                    >
                        <span>
                            <?php echo esc_html($lstCurrentWidget->getSecondButtonText()); ?>

                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                 fill="none">
                                <path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                      fill="#FDFDFE"/>
                            </svg>
                        </span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>