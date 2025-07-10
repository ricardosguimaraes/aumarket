<?php


if (!function_exists('tdf_string')) {
    return;
}

if (post_password_required()) {
    return;
}

$listivoCommenter = wp_get_current_commenter();
$listivoRequired = get_option('require_name_email');
$listivoAriaReq = ($listivoRequired ? " aria-required='true'" : '');
?>
<div class="listivo-comments">
    <?php

    if (get_comments_number() > 0) : ?>
        <div class="listivo-comments__list">
            <h4 class="listivo-comments__label">
                <?php echo esc_html(tdf_string('comments')); ?>

                <div class="listivo-comments__count">
                    <?php echo esc_html(get_comments_number()); ?>
                </div>
            </h4>

            <?php wp_list_comments(
                ['style' => 'div',
                    'short_ping' => true,
                    'avatar_size' => 85,
                    'callback' => static function ($comment, $args, $depth) {

                        $lstComment = get_comment();
                        if ($lstComment instanceof WP_Comment && !empty($lstComment->user_id) && class_exists(\Tangibledesign\Framework\Core\App::class)) {
                            $lstUser = tdf_user_factory()->create((int)$lstComment->user_id);
                            if ($lstUser) {
                                $lstUserImage = $lstUser->getImageUrl('listivo_100_100');
                            } else {
                                $lstUserImage = false;
                            }
                        } else {
                            $lstUserImage = false;
                        }
                        ?>

                        <div <?php comment_class(empty($args['has_children']) ? 'listivo-comment' : 'listivo-comment listivo-comment--parent'); ?>
                                id="listivo-comment-<?php comment_ID(); ?>">
                            <div class="listivo-comment__inner">
                                <div class="listivo-comment__top">
                                    <div class="listivo-comment__left">
                                        <div class="listivo-comment__user">
                                            <div class="listivo-comment__avatar">
                                                <?php
                                                if ($lstUserImage) :?>
                                                    <img
                                                            class="lazyload"
                                                            src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAMAAAACCAQAAAA3fa6RAAAADklEQVR42mNkAANGCAUAACMAA2w/AMgAAAAASUVORK5CYII="
                                                            data-src="<?php echo esc_url($lstUserImage); ?>"
                                                            alt="<?php echo esc_attr(get_comment_author()); ?>"
                                                    >
                                                <?php else :
                                                    echo get_avatar($comment, 85);
                                                endif;
                                                ?>
                                            </div>

                                            <div class="listivo-comment__user-data">
                                                <?php comment_author_link(); ?>

                                                <?php if ($comment->comment_approved) : ?>
                                                    <div class="listivo-comment__date">
                                                        <?php echo esc_html(get_comment_date()); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <?php if ($comment->comment_approved) : ?>
                                            <div class="listivo-comment__reply">
                                                <?php comment_reply_link(array_merge($args, [
                                                    'reply_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="17" viewBox="0 0 18 17" fill="none"><path d="M7.32075 0.000316567C7.13971 0.00585971 6.96763 0.0803186 6.83966 0.20848L0.208027 6.84011C0.0748266 6.97336 0 7.15406 0 7.34248C0 7.53089 0.0748266 7.71159 0.208027 7.84485L6.83966 14.4765C6.93904 14.5758 7.06563 14.6434 7.20344 14.6708C7.34124 14.6982 7.48407 14.6841 7.61388 14.6303C7.74368 14.5766 7.85464 14.4855 7.93272 14.3687C8.0108 14.2519 8.0525 14.1146 8.05256 13.9741V10.353C9.08879 10.2982 10.6944 10.2984 12.3343 10.8378C14.2772 11.4768 16.0304 12.7229 16.5928 15.5349C16.6276 15.7076 16.7254 15.8612 16.8671 15.9659C17.0087 16.0706 17.1843 16.1189 17.3596 16.1015C17.5349 16.0841 17.6975 16.0022 17.8159 15.8717C17.9342 15.7412 17.9998 15.5713 18 15.3952C18 15.3436 17.9848 15.3066 17.9843 15.2555H17.9861C17.9854 15.2519 17.9831 15.2498 17.9824 15.2462C17.9336 10.5971 15.8305 7.78162 13.4648 6.24985C11.3809 4.90052 9.31125 4.53911 8.05256 4.39858V0.710848C8.05259 0.615725 8.03352 0.521563 7.99649 0.433945C7.95946 0.346327 7.90521 0.267036 7.83696 0.200773C7.76871 0.13451 7.68786 0.0826242 7.59918 0.0481908C7.51051 0.0137574 7.41583 -0.0025224 7.32075 0.000316567ZM6.63149 2.42612V4.99624C6.63148 5.17557 6.69928 5.34828 6.82127 5.47971C6.94327 5.61115 7.11046 5.6916 7.28929 5.70492C8.23884 5.77504 10.6204 6.10085 12.6923 7.4424C13.9519 8.25798 15.06 9.49415 15.7796 11.2532C14.8806 10.4187 13.8331 9.83487 12.7783 9.48795C10.5206 8.74537 8.26256 8.85615 7.27541 8.94858C7.09922 8.96518 6.93557 9.04693 6.81648 9.17783C6.69739 9.30873 6.63142 9.47936 6.63149 9.65633V12.2588L1.71513 7.34248L6.63149 2.42612Z" fill="#2A3946"/></svg>',
                                                    'depth' => $depth,
                                                    'max_depth' => $args['max_depth'],
                                                    'before' => '',
                                                    'after' => ''
                                                ]));
                                                ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <?php if (!$comment->comment_approved) : ?>
                                    <div class="listivo-comment__moderate">
                                        <div class="listivo-comment__moderate__inner">
                                            <?php echo esc_html(tdf_string('comment_awaiting_moderation')); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>

                            <div class="listivo-comment__text">
                                <?php comment_text(); ?>
                            </div>
                        </div>
                        <?php
                    }]); ?>
        </div>
    <?php
    endif;

    the_comments_navigation();

    if (comments_open()) : ?>
        <div class="listivo-comment-form">
            <?php
            comment_form([
                'logged_in_as' => '',
                'fields' => [
                    'author' =>
                        '<div class="listivo-comment-form__field listivo-comment-form__field--full"><div class="listivo-comment-form__icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16" fill="none">
<path d="M7.27273 0C4.46875 0 2.18182 2.28693 2.18182 5.09091C2.18182 6.84375 3.0767 8.40057 4.43182 9.31818C1.83807 10.4318 0 13.0057 0 16H1.45455C1.45455 13.8977 2.56534 12.0682 4.22727 11.0455C4.71591 12.2443 5.90625 13.0909 7.27273 13.0909C8.6392 13.0909 9.82955 12.2443 10.3182 11.0455C11.9801 12.0682 13.0909 13.8977 13.0909 16H14.5455C14.5455 13.0057 12.7074 10.4318 10.1136 9.31818C11.4688 8.40057 12.3636 6.84375 12.3636 5.09091C12.3636 2.28693 10.0767 0 7.27273 0ZM7.27273 1.45455C9.28977 1.45455 10.9091 3.07386 10.9091 5.09091C10.9091 7.10795 9.28977 8.72727 7.27273 8.72727C5.25568 8.72727 3.63636 7.10795 3.63636 5.09091C3.63636 3.07386 5.25568 1.45455 7.27273 1.45455ZM7.27273 10.1818C7.86932 10.1818 8.4375 10.267 8.97727 10.4318C8.72443 11.1335 8.06534 11.6364 7.27273 11.6364C6.48011 11.6364 5.82102 11.1335 5.56818 10.4318C6.10795 10.267 6.67614 10.1818 7.27273 10.1818Z" fill="#FDFDFE"/>
</svg></div><input id="author" name="author" ' .
                        'placeholder="' . esc_attr(tdf_string('name')) . ($listivoRequired ? '*' : '') . '" type="text" ' .
                        'value="' . esc_attr($listivoCommenter['comment_author']) . '" size="30" ' . $listivoAriaReq . ' /></div>',
                    'email' =>
                        '<div class="listivo-comment-form__field"><div class="listivo-comment-form__icon"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" viewBox="0 0 16 15" fill="none">
<path fill-rule="evenodd" clip-rule="evenodd" d="M0.0302734 7.5C0.0302734 3.36453 3.3948 0 7.53027 0C11.6657 0 15.0303 3.36453 15.0303 7.5C15.0303 11.6355 11.6657 15 7.53027 15C3.3948 15 0.0302734 11.6355 0.0302734 7.5ZM13.9053 7.5C13.9053 3.97252 11.0578 1.125 7.53027 1.125C4.00279 1.125 1.15527 3.97252 1.15527 7.5C1.15527 11.0275 4.00279 13.875 7.53027 13.875C11.0578 13.875 13.9053 11.0275 13.9053 7.5ZM7.53027 2.25C4.63732 2.25 2.28027 4.60705 2.28027 7.5C2.28027 10.393 4.63732 12.75 7.53027 12.75C8.17794 12.75 8.80087 12.6325 9.37524 12.4167C9.56569 12.3478 9.70434 12.1817 9.73826 11.982C9.77219 11.7823 9.69614 11.5798 9.53916 11.4518C9.38218 11.3238 9.16851 11.2901 8.97974 11.3635C8.52961 11.5326 8.04211 11.625 7.53027 11.625C5.24523 11.625 3.40527 9.78505 3.40527 7.5C3.40527 5.21495 5.24523 3.375 7.53027 3.375C9.81532 3.375 11.6553 5.21495 11.6553 7.5V8.0625C11.6553 8.58683 11.2421 9 10.7178 9C10.1934 9 9.78027 8.58683 9.78027 8.0625V5.4375C9.78254 5.15149 9.56983 4.90931 9.28592 4.87464C9.00201 4.83997 8.73728 5.02385 8.67065 5.302C8.29101 5.0341 7.83691 4.875 7.34277 4.875C5.97334 4.875 4.90527 6.0853 4.90527 7.5C4.90527 8.9147 5.97334 10.125 7.34277 10.125C8.0368 10.125 8.65238 9.81305 9.0918 9.32227C9.47035 9.80853 10.059 10.125 10.7178 10.125C11.8502 10.125 12.7803 9.19492 12.7803 8.0625V7.5C12.7803 4.60705 10.4232 2.25 7.53027 2.25ZM8.65527 7.5C8.65527 6.63995 8.04109 6 7.34277 6C6.64445 6 6.03027 6.63995 6.03027 7.5C6.03027 8.36005 6.64445 9 7.34277 9C8.04109 9 8.65527 8.36005 8.65527 7.5Z" fill="#FDFDFE"/>
</svg></div>' .
                        '<input id="email" name="email" placeholder="' . esc_attr(tdf_string('email')) . ($listivoRequired ? '*'
                            : '') .
                        '" type="text" value="' . esc_attr($listivoCommenter['comment_author_email']) .
                        '" size="30" ' . $listivoAriaReq . ' /></div>',
                    'url' =>
                        '<div class="listivo-comment-form__field"><div class="listivo-comment-form__icon"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
<path d="M7.06055 0C4.77929 0 2.75463 1.10417 1.47559 2.8H1.46055V2.81914C0.585514 3.98768 0.0605469 5.43227 0.0605469 7C0.0605469 10.8577 3.20284 14 7.06055 14C10.9182 14 14.0605 10.8577 14.0605 7C14.0605 3.1423 10.9182 0 7.06055 0ZM9.16055 1.80879C11.2151 2.63715 12.6605 4.64285 12.6605 7C12.6605 8.46148 12.101 9.78482 11.1895 10.7803C11.0104 10.2135 10.4867 9.8 9.86055 9.8H9.16055V7.7C9.16055 7.3136 8.84695 7 8.46055 7H4.96055V5.6H5.66055C6.04695 5.6 6.36055 5.2864 6.36055 4.9V3.5H7.76055C8.53405 3.5 9.16055 2.8735 9.16055 2.1V1.80879ZM1.60547 5.74492L2.86055 7L4.96055 9.1V9.8C4.96055 10.5735 5.58705 11.2 6.36055 11.2V12.5521C3.59259 12.2088 1.46055 9.86346 1.46055 7C1.46055 6.56753 1.51341 6.14882 1.60547 5.74492Z" fill="#FDFDFE"/>
</svg></div><input id="url" name="url" placeholder="' . esc_attr(tdf_string('website')) . '" ' .
                        'type="text" value="' . esc_attr($listivoCommenter['comment_author_url']) . '" size="30" /></div>',
                    'cookies' => '<p class="comment-form-cookies-consent">
                            <input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes">
                            <label for="wp-comment-cookies-consent"><span>' . esc_html(tdf_string('comment_cookie')) . '</span></label>
                        </p>',
                ],
                'comment_notes_before' => '',
                'title_reply' => esc_html(tdf_string('add_comment')),
                'title_reply_to' => esc_html(tdf_string('add_comment_to')) . ' %s',
                'comment_field' => '<div class="listivo-comment-form__text"><textarea id="comment" name="comment" ' .
                    'placeholder="' . esc_attr(tdf_string('comments')) . '" aria-required="true"></textarea></div>',
                'submit_field' => '<div class="listivo-comment-form__submit">%1$s %2$s</div>',
                'submit_button' => '<button id="submit" class="listivo-button listivo-button--primary-1"><span>'
                    . esc_html(tdf_string('post_comment')) . '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11" fill="none">
<path d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z" fill="#FDFDFE"/>
</svg></span></button>'
            ]);
            ?>
        </div>
    <?php endif; ?>
</div>
