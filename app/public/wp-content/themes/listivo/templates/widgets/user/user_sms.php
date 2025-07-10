<?php

use Tangibledesign\Listivo\Widgets\User\UserSmsWidget;

/* @var UserSmsWidget $lstCurrentWidget */
global $lstCurrentWidget;
$lstUser = $lstCurrentWidget->getUser();

if (!$lstUser || !$lstUser->hasPhone()) {
    return;
}

$lstInitialMessage = '';
$lstModel = $lstCurrentWidget->getModel();
if ($lstModel && is_singular(tdf_model_post_type())) {
    $lstInitialMessage = tdf_string('i_m_interested_in') . ' ' . $lstModel->getName();
}
?>
<a
        class="listivo-contact-button"
        href="sms:<?php echo esc_attr($lstUser->getPhoneUrl()); ?>;?&body=<?php echo esc_attr($lstInitialMessage); ?>"
>
    <div class="listivo-contact-button__inner">
        <div class="listivo-contact-button__icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                <path d="M19.2243 2.63722e-05C19.1071 0.000998772 18.9916 0.028748 18.8868 0.0811549L0.425298 9.31177C0.306649 9.37109 0.205354 9.46008 0.131248 9.57009C0.0571415 9.68011 0.0127419 9.80742 0.00236002 9.93966C-0.00802183 10.0719 0.0159668 10.2046 0.0719969 10.3248C0.128027 10.445 0.214195 10.5488 0.322133 10.6259L3.70754 13.0447L5.16687 17.4226C5.21128 17.5558 5.29127 17.6742 5.39818 17.7652C5.50509 17.8562 5.63485 17.9161 5.77341 17.9386C5.91196 17.9611 6.05403 17.9453 6.18422 17.8928C6.31442 17.8403 6.42778 17.7532 6.51202 17.641L7.59575 16.1957L12.6238 19.8525C12.7216 19.9237 12.8348 19.9709 12.9543 19.9902C13.0737 20.0095 13.1961 20.0003 13.3113 19.9634C13.4266 19.9265 13.5315 19.8629 13.6176 19.7779C13.7036 19.6928 13.7684 19.5887 13.8067 19.4739L19.9605 1.01263C19.9992 0.896477 20.0097 0.772756 19.991 0.651754C19.9723 0.530751 19.9249 0.415962 19.8529 0.316927C19.7809 0.217893 19.6863 0.137474 19.577 0.082356C19.4677 0.0272379 19.3468 -0.000987358 19.2243 2.63722e-05ZM17.127 4.64639L12.6789 17.9895L8.55027 14.9878L17.127 4.64639ZM13.1827 4.6534L4.33655 11.6034L2.25522 10.116L13.1827 4.6534ZM14.0971 5.89036L6.84956 14.6302C6.84855 14.6312 6.84755 14.6322 6.84655 14.6332L6.84355 14.6372C6.83564 14.6467 6.82796 14.6564 6.82051 14.6663C6.81222 14.6767 6.80421 14.6874 6.79647 14.6983L6.16246 15.5426L5.26002 12.8334L14.0971 5.89036Z"
                      fill="#2A3946"/>
            </svg>
        </div>

        <?php echo esc_html(tdf_string('send_sms')); ?>
    </div>
</a>
