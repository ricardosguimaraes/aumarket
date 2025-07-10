<?php
$lstCurrentAction = $_GET['page'] ?? 'listivo_user_panel';
?>
<div class="tdf-logo">
    <a href="<?php echo esc_url(admin_url('admin.php?page=listivo_basic_setup')); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="110" height="54" viewBox="0 0 110 54" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M83.3579 23.5893C80.6019 23.5893 78.3676 25.8235 78.3676 28.5796C78.3676 31.3357 80.6019 33.5699 83.3579 33.5699C86.114 33.5699 88.3482 31.3357 88.3482 28.5796C88.3482 25.8235 86.114 23.5893 83.3579 23.5893ZM73.8086 28.5796C73.8086 23.3057 78.084 19.0303 83.3579 19.0303C88.6319 19.0303 92.9072 23.3057 92.9072 28.5796C92.9072 33.8535 88.6319 38.1289 83.3579 38.1289C78.084 38.1289 73.8086 33.8535 73.8086 28.5796Z"
                  fill="#2A3946"></path>
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M0.0515147 53.5769C-0.499768 53.9057 83.9605 1.75622 96.3799 9.89899C103.441 14.5286 71.3522 38.054 71.7122 37.9439C71.8512 37.9014 124.055 -1.82841 106.328 0.0656306C78.0944 3.08226 0.390044 53.3749 0.0515147 53.5769Z"
                  fill="#ED6B42"></path>
            <path d="M29.0086 37.9646C27.3053 37.9646 25.732 37.7516 24.2889 37.3257C22.8458 36.8762 21.5919 36.2375 20.5273 35.4094L22.9404 32.1802C24.005 32.8899 25.0223 33.4222 25.9923 33.7771C26.9859 34.1319 27.9677 34.3094 28.9376 34.3094C30.0259 34.3094 30.8894 34.1319 31.5282 33.7771C32.1906 33.3985 32.5218 32.9136 32.5218 32.3221C32.5218 31.849 32.3325 31.4704 31.954 31.1866C31.5991 30.9027 31.0195 30.7016 30.2152 30.5833L26.6665 30.051C24.8212 29.7671 23.4254 29.1756 22.4791 28.2767C21.5328 27.354 21.0596 26.1475 21.0596 24.657C21.0596 23.4505 21.3672 22.4214 21.9823 21.5697C22.621 20.6944 23.5082 20.0201 24.6438 19.547C25.803 19.0502 27.1752 18.8018 28.7602 18.8018C30.1087 18.8018 31.4217 18.991 32.6992 19.3695C34.0004 19.7481 35.2188 20.3277 36.3543 21.1084L34.0122 24.2667C32.9949 23.6279 32.025 23.1666 31.1023 22.8827C30.1797 22.5988 29.2452 22.4569 28.2989 22.4569C27.4236 22.4569 26.7138 22.6225 26.1697 22.9537C25.6492 23.2849 25.389 23.7226 25.389 24.2667C25.389 24.7635 25.5783 25.1538 25.9568 25.4377C26.3353 25.7216 26.9859 25.9227 27.9085 26.041L31.4572 26.5733C33.2788 26.8335 34.6746 27.425 35.6446 28.3476C36.6146 29.2466 37.0995 30.4177 37.0995 31.8608C37.0995 33.0437 36.7447 34.0964 36.0349 35.0191C35.3252 35.9181 34.3671 36.6398 33.1605 37.1839C31.954 37.7044 30.57 37.9646 29.0086 37.9646Z"
                  fill="#2A3946"></path>
            <path d="M63.062 37.9004L55.1504 18.8018H60.4367L65.51 31.5221L70.5478 18.8018H75.7276L67.7805 37.9004H63.062Z"
                  fill="#2A3946"></path>
            <path d="M4.55903 13.3623H0V38.0057H4.55903V13.3623Z" fill="#2A3946"></path>
            <path d="M19.2934 18.8018H14.7344V38.0236H19.2934V18.8018Z" fill="#2A3946"></path>
            <path d="M53.9184 18.8018H49.3594V38.0236H53.9184V18.8018Z" fill="#2A3946"></path>
            <path d="M42.8286 13.3799H38.2695V38.0233H42.8286V13.3799Z" fill="#2A3946"></path>
            <path d="M48.1269 33.4648H38.2695V38.0239H48.1269V33.4648Z" fill="#2A3946"></path>
            <path d="M48.1269 18.8018H38.2695V23.3608H48.1269V18.8018Z" fill="#2A3946"></path>
            <path d="M13.5539 33.4463H0V38.0053H13.5539V33.4463Z" fill="#2A3946"></path>
        </svg>
    </a>
</div>

<div class="tdf-header">
    <div class="tdf-header__menu-primary">
        <a
                href="<?php echo esc_url(admin_url('admin.php?page=listivo_basic_setup')); ?>"
            <?php if ($lstCurrentAction === 'listivo_basic_setup') : ?>
                class="tdf-header__menu-primary-link tdf-header__menu-primary-link--active"
            <?php else : ?>
                class="tdf-header__menu-primary-link"
            <?php endif; ?>
        >
            <?php esc_html_e('Basic', 'listivo-core'); ?>
        </a>

        <a
                href="<?php echo esc_url(admin_url('admin.php?page=listivo_design')); ?>"
            <?php if ($lstCurrentAction === 'listivo_design') : ?>
                class="tdf-header__menu-primary-link tdf-header__menu-primary-link--active"
            <?php else : ?>
                class="tdf-header__menu-primary-link"
            <?php endif; ?>
        >
            <?php esc_html_e('Design', 'listivo-core'); ?>
        </a>

        <a
                href="<?php echo esc_url(admin_url('admin.php?page=listivo_user_panel')); ?>"
            <?php if ($lstCurrentAction === 'listivo_user_panel') : ?>
                class="tdf-header__menu-primary-link tdf-header__menu-primary-link--active"
            <?php else : ?>
                class="tdf-header__menu-primary-link"
            <?php endif; ?>
        >
            <?php esc_html_e('User Panel', 'listivo-core'); ?>
        </a>

        <a
                href="<?php echo esc_url(admin_url('admin.php?page=listivo_layouts_and_templates')); ?>"
            <?php if ($lstCurrentAction === 'listivo_layouts_and_templates') : ?>
                class="tdf-header__menu-primary-link tdf-header__menu-primary-link--active"
            <?php else : ?>
                class="tdf-header__menu-primary-link"
            <?php endif; ?>
        >
            <?php esc_html_e('Templates', 'listivo-core'); ?>
        </a>

        <a
                href="<?php echo esc_url(admin_url('admin.php?page=listivo_custom_fields')); ?>"
            <?php if ($lstCurrentAction === 'listivo_custom_fields' || (isset($_GET['page']) && strpos($_GET['page'], tdf_prefix() . '-field-') !== false)) : ?>
                class="tdf-header__menu-primary-link tdf-header__menu-primary-link--active"
            <?php else : ?>
                class="tdf-header__menu-primary-link"
            <?php endif; ?>
        >
            <?php esc_html_e('Custom Fields', 'listivo-core'); ?>
        </a>

        <a
                href="<?php echo esc_url(admin_url('admin.php?page=listivo_monetization')); ?>"
            <?php if ($lstCurrentAction === 'listivo_monetization') : ?>
                class="tdf-header__menu-primary-link tdf-header__menu-primary-link--active"
            <?php else : ?>
                class="tdf-header__menu-primary-link"
            <?php endif; ?>
        >
            <?php esc_html_e('Monetization', 'listivo-core'); ?>
        </a>

        <a
                href="<?php echo esc_url(admin_url('admin.php?page=listivo_notifications')); ?>"
            <?php if ($lstCurrentAction === 'listivo_notifications') : ?>
                class="tdf-header__menu-primary-link tdf-header__menu-primary-link--active"
            <?php else : ?>
                class="tdf-header__menu-primary-link"
            <?php endif; ?>
        >
            <?php esc_html_e('Notifications', 'listivo-core'); ?>
        </a>

        <a
                href="<?php echo esc_url(admin_url('admin.php?page=listivo_maps')); ?>"
            <?php if ($lstCurrentAction === 'listivo_maps') : ?>
                class="tdf-header__menu-primary-link tdf-header__menu-primary-link--active"
            <?php else : ?>
                class="tdf-header__menu-primary-link"
            <?php endif; ?>
        >
            <?php esc_html_e('Maps', 'listivo-core'); ?>
        </a>

        <a
                href="<?php echo esc_url(admin_url('admin.php?page=listivo_translate_and_rename')); ?>"
            <?php if ($lstCurrentAction === 'listivo_translate_and_rename') : ?>
                class="tdf-header__menu-primary-link tdf-header__menu-primary-link--active"
            <?php else : ?>
                class="tdf-header__menu-primary-link"
            <?php endif; ?>
        >
            <?php esc_html_e('Translate/Rename', 'listivo-core'); ?>
        </a>

        <a
                href="<?php echo esc_url(admin_url('admin.php?page=listivo_advanced')); ?>"
            <?php if ($lstCurrentAction === 'listivo_advanced') : ?>
                class="tdf-header__menu-primary-link tdf-header__menu-primary-link--active"
            <?php else : ?>
                class="tdf-header__menu-primary-link"
            <?php endif; ?>
        >
            <?php esc_html_e('Advanced', 'listivo-core'); ?>
        </a>
    </div>
</div>