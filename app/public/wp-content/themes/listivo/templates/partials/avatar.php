<?php
$lstUser = tdf_current_user();
if (!$lstUser) {
    return;
}

if (is_author()) : ?>
    <div class="listivo-avatar listivo-user-image-control-size">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
        </svg>
    </div>
<?php else : ?>
    <a
            class="listivo-avatar-link-wrapper"
            href="<?php echo esc_url($lstUser->getUrl()); ?>"
    >
        <div class="listivo-avatar listivo-user-image-control-size">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
            </svg>
        </div>
    </a>
<?php
endif;