<?php get_template_part('templates/widgets/general/panel/header'); ?>

<?php
/* @var \Tangibledesign\Listivo\Widgets\General\PanelWidget $lstCurrentWidget */
global $lstCurrentWidget;

$lstUser = tdf_current_user();
$lstConversations = $lstUser->getConversations();
?>
<div class="listivo-panel-section">
    <template>
        <lst-direct-messages
            :user-id="<?php echo esc_attr($lstUser->getId()); ?>"
            :initial-conversations="<?php echo htmlspecialchars(json_encode($lstConversations)); ?>"
            :check-interval="15000"
            request-url="<?php echo esc_url(tdf_action_url('listivo/directMessages/reload')); ?>"
            seen-request-url="<?php echo esc_url(tdf_action_url('listivo/directMessages/seen')); ?>"
            messages-request-url="<?php echo esc_url(tdf_action_url('listivo/directMessages/get')); ?>"
            message-request-url="<?php echo esc_url(tdf_action_url('listivo/directMessages/create')); ?>"
            td-nonce="<?php echo esc_attr(wp_create_nonce('listivo_messages_reload')); ?>"
            :limit="15"
            scroll-to-selector=".listivo-panel-conversation"
            scroll-to-users-selector=".listivo-panel-conversation"
            overflow-class="listivo-mobile-overflow-hidden"
            create-message-nonce="<?php echo esc_attr(wp_create_nonce('listivo_create_message')); ?>"
            <?php if (isset($_GET['view']) && $_GET['view'] === 'msg') : ?>
                initial-tab="messages"
            <?php endif; ?>
            <?php if (!empty($_GET['user'])) : ?>
                :user="<?php echo esc_attr((int)$_GET['user']); ?>"
            <?php endif; ?>
        >
            <div slot-scope="chat" class="listivo-container">
                <div class="listivo-panel-section__top">
                    <h1 class="listivo-panel-section__label">
                        <?php echo esc_html($lstCurrentWidget->getTitle()); ?>
                    </h1>

                    <?php get_template_part('templates/widgets/general/panel/packages_bar'); ?>
                </div>

                <div class="listivo-panel-section__content">
                    <div v-if="chat.conversations.length === 0">
                        <h2 class="listivo-panel-content-heading">
                            <div class="listivo-panel-content listivo-panel-section__content--with-background">
                                <div class="listivo-panel-no-listings">
                                    <h2 class="listivo-panel-no-listings__heading">
                                        <?php echo esc_html(tdf_string('no_messages')); ?>
                                    </h2>

                                    <div class="listivo-panel-no-listings__image">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="153" height="142"
                                             viewBox="0 0 153 142" fill="none">
                                            <path
                                                d="M19.0301 0L14.6352 0.0853417L14.3365 0.128007C6.27224 1.10938 0 8.10698 0 16.3846V71C0 80.003 7.38161 87.3846 16.3846 87.3846H32.6839V109.231L61.869 87.3846H90.5847L112.431 109.231H109.273V120.154L94.7236 109.231H60.0769C57.9008 109.231 56.0234 107.908 55.1274 106.031L46.3377 112.644C49.2819 117.167 54.3167 120.154 60.0769 120.154H91.0541L120.197 142V120.154H123.354L134.021 130.864L141.787 123.098L19.0301 0.341346V0ZM34.092 0L45.015 10.9231H92.8462C95.8756 10.9231 98.3077 13.3552 98.3077 16.3846V64.2157L108.761 74.6695C109.06 73.5174 109.231 72.2801 109.231 71V16.3846C109.231 7.33894 101.892 0 92.8462 0H34.092ZM14.5499 11.3498L79.6617 76.4615H58.1995L43.607 87.3846V76.4615H16.3846C13.3125 76.4615 10.9231 74.0721 10.9231 71V16.3846C10.9231 13.9952 12.4591 12.1178 14.5499 11.3498ZM120.154 32.7692V43.6923H136.538C139.568 43.6923 142 46.1244 142 49.1538V103.769C142 104.921 141.573 105.945 140.933 106.841L148.699 114.65C151.302 111.706 152.923 107.951 152.923 103.769V49.1538C152.923 40.1082 145.584 32.7692 136.538 32.7692H120.154Z"
                                                fill="#D5E3EE"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </h2>
                    </div>

                    <div
                        v-if="chat.conversations.length > 0"
                        class="listivo-panel-messages"
                        :class="{
                                'listivo-panel-messages--list': chat.currentTab === 'users',
                                'listivo-panel-messages--conversation': chat.currentTab === 'messages'
                             }"

                    >
                        <div class="listivo-panel-messages__top">
                            <h3 class="listivo-panel-messages__label">
                                <?php echo esc_html(tdf_string('conversations')); ?>
                            </h3>

                            <div class="listivo-panel-messages__user">
                                <div
                                    class="listivo-panel-messages__close"
                                    @click.prevent="chat.setTab('users')"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11"
                                         fill="none">
                                        <path
                                            d="M4.86195 0.528677C4.99228 0.398343 5.16262 0.333343 5.33329 0.333343C5.50395 0.333343 5.67429 0.398343 5.80462 0.528677C6.06496 0.789012 6.06496 1.21102 5.80462 1.47135L2.27593 5.00004L11.3333 5.00004C11.7013 5.00004 12 5.29871 12 5.66671C12 6.03472 11.7013 6.33338 11.3333 6.33338L2.27593 6.33338L5.80462 9.86208C6.06496 10.1224 6.06496 10.5444 5.80462 10.8047C5.54429 11.0651 5.12229 11.0651 4.86195 10.8047L0.195251 6.13805C-0.0650838 5.87771 -0.0650838 5.45571 0.195251 5.19538L4.86195 0.528677Z"
                                            fill="#2A3946"/>
                                    </svg>
                                </div>

                                <a
                                    :href="chat.conversation.user.url"
                                    target="_blank"
                                >
                                    {{ chat.conversation.user.name }}
                                </a>

                                <div class="listivo-panel-messages__view-profile">
                                    <a
                                        class="listivo-button listivo-button--primary-2"
                                        :href="chat.conversation.user.url"
                                        target="_blank"
                                    >
                                        <span>
                                            <?php echo esc_html(tdf_string('view_profile')); ?>

                                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11"
                                                 viewBox="0 0 12 11"
                                                 fill="none">
                                                <path
                                                    d="M7.13805 10.4713C7.00772 10.6017 6.83738 10.6667 6.66671 10.6667C6.49605 10.6667 6.32571 10.6017 6.19538 10.4713C5.93504 10.211 5.93504 9.78898 6.19538 9.52865L9.72407 5.99996H0.666672C0.298669 5.99996 0 5.70129 0 5.33329C0 4.96528 0.298669 4.66662 0.666672 4.66662H9.72407L6.19538 1.13792C5.93504 0.877589 5.93504 0.455586 6.19538 0.195251C6.45571 -0.0650838 6.87771 -0.0650838 7.13805 0.195251L11.8047 4.86195C12.0651 5.12229 12.0651 5.54429 11.8047 5.80462L7.13805 10.4713Z"
                                                    fill="#FDFDFE"/>
                                            </svg>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="listivo-panel-messages__content">
                            <div class="listivo-panel-messages__left-wrapper">
                                <div class="listivo-panel-messages__left">
                                    <div
                                        class="listivo-panel-conversation-preview"
                                        :class="{
                                                'listivo-panel-conversation-preview--active': chat.conversation && chat.conversation.user.id === conversation.user.id,
                                                'listivo-panel-conversation-preview--alert': !conversation.seen
                                            }"
                                        v-for="conversation in chat.conversations"
                                        :key="conversation.user.id"
                                        @click.prevent="chat.setUserTo(conversation.user.id);chat.setTab('messages');"
                                    >
                                        <div class="listivo-panel-conversation-preview__avatar">
                                            <img
                                                v-if="conversation.user.image !== '' && conversation.user.image !== false"
                                                :src="conversation.user.image"
                                                :alt="conversation.user.name"
                                            >

                                            <div
                                                class="listivo-user-image-placeholder listivo-user-image-placeholder--circle"
                                                v-if="conversation.user.image === ''"
                                            >
                                                <svg
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    width="20"
                                                    height="20"
                                                    viewBox="0 0 132 148"
                                                    fill="none"
                                                >
                                                    <path
                                                        d="M6 141.5C6 120.789 32.8629 104 66 104C99.1371 104 126 120.789 126 141.5M103.5 44.0001C103.5 64.7108 86.7107 81.5002 66 81.5002C45.2893 81.5002 28.5 64.7108 28.5 44.0001C28.5 23.2894 45.2893 6.5 66 6.5C86.7107 6.5 103.5 23.2894 103.5 44.0001Z"
                                                        stroke="#D5E3EE" stroke-width="12" stroke-linecap="round"
                                                        stroke-linejoin="round"/>
                                                </svg>
                                            </div>

                                            <div
                                                v-if="conversation.user.image === '' || conversation.user.image === false"
                                                class="listivo-chat__avatar-big__placeholder"
                                            ><i class="fa fa-user"></i></div>
                                        </div>

                                        <div class="listivo-panel-conversation-preview__content">
                                            <div class="listivo-panel-conversation-preview__label">
                                                {{ conversation.user.name }}
                                            </div>

                                            <div
                                                class="listivo-panel-conversation-preview__data"
                                                v-if="conversation.intro"
                                            >
                                                <div class="listivo-panel-conversation-preview__message">
                                                    <span
                                                        v-if="conversation.intro.userFromId === <?php echo esc_attr(get_current_user_id()); ?>">
                                                        <?php echo esc_html(tdf_string('you')); ?>:
                                                    </span>

                                                    {{ conversation.intro.intro }}
                                                </div>

                                                <div class="listivo-panel-conversation-preview__date">
                                                    {{ conversation.intro.timeSinceLastMessage }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="listivo-panel-conversation-preview__status">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15"
                                                 viewBox="0 0 15 15" fill="none">
                                                <path
                                                    d="M7.5 0C3.36648 0 0 3.36648 0 7.5C0 11.6335 3.36648 15 7.5 15C11.6335 15 15 11.6335 15 7.5C15 3.36648 11.6335 0 7.5 0ZM7.5 1.36364C10.8958 1.36364 13.6364 4.10423 13.6364 7.5C13.6364 10.8958 10.8958 13.6364 7.5 13.6364C4.10423 13.6364 1.36364 10.8958 1.36364 7.5C1.36364 4.10423 4.10423 1.36364 7.5 1.36364ZM11.1861 4.90057L6.81818 9.24716L4.58097 7.00994L3.60085 7.99006L6.32812 10.7173L6.81818 11.1861L7.30824 10.7173L12.1449 5.85938L11.1861 4.90057Z"
                                                    fill="#D5E3EE"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="listivo-panel-messages__messages">
                                <div class="listivo-panel-conversation">
                                    <template v-if="chat.conversation && !chat.reload">
                                        <template v-if="chat.messages">
                                            <div
                                                v-if="chat.messages.length < chat.conversation.count && !chat.loadingMessages"
                                                class="listivo-panel-conversation__load-more"
                                                @click.prevent="chat.loadMore"
                                            >
                                                <?php echo esc_html(tdf_string('load_more')); ?>
                                            </div>

                                            <div
                                                v-for="message in chat.messages"
                                                :key="message.id"
                                                class="listivo-panel-conversation__message-wrapper"
                                                :class="{
                                                        'listivo-panel-conversation__message-wrapper--me': message.userFromId === <?php echo esc_attr($lstUser->getId()); ?>,
                                                        'listivo-panel-conversation__message-wrapper--other': message.userFromId !== <?php echo esc_attr($lstUser->getId()); ?>,
                                                    }"
                                            >
                                                <div v-if="message.showDate" class="listivo-panel-conversation__time">
                                                    {{ message.formattedDate }}
                                                </div>

                                                <div class="listivo-panel-conversation__avatar">
                                                    <img
                                                        v-if="message.userFromId !== <?php echo esc_attr($lstUser->getId()); ?> && chat.conversation.user.image !== '' && chat.conversation.user.image !== false"
                                                        :src="chat.conversation.user.image"
                                                        :alt="chat.conversation.user.name"
                                                    >

                                                    <div
                                                        class="listivo-user-image-placeholder listivo-user-image-placeholder--circle"
                                                        v-if="message.userFromId !== <?php echo esc_attr($lstUser->getId()); ?> && (chat.conversation.user.image === '' || chat.conversation.user.image === false)"
                                                    >
                                                        <svg
                                                            xmlns="http://www.w3.org/2000/svg"
                                                            width="20"
                                                            height="20"
                                                            viewBox="0 0 132 148"
                                                            fill="none"
                                                        >
                                                            <path
                                                                d="M6 141.5C6 120.789 32.8629 104 66 104C99.1371 104 126 120.789 126 141.5M103.5 44.0001C103.5 64.7108 86.7107 81.5002 66 81.5002C45.2893 81.5002 28.5 64.7108 28.5 44.0001C28.5 23.2894 45.2893 6.5 66 6.5C86.7107 6.5 103.5 23.2894 103.5 44.0001Z"
                                                                stroke="#D5E3EE" stroke-width="12"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"/>
                                                        </svg>
                                                    </div>
                                                </div>

                                                <div class="listivo-panel-conversation__message">
                                                    <div class="listivo-chat__message">
                                                        <div
                                                            class="listivo-chat__text"
                                                            v-html="message.message.linkify()"
                                                        ></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </template>
                                </div>

                                <form @submit.prevent="chat.onCreate">
                                    <div class="listivo-panel-messages__form">
                                        <div class="listivo-panel-messages__input">
                                            <div class="listivo-input-v2 listivo-input-v2--without-right-border">
                                                <input
                                                    type="text"
                                                    @input="chat.setMessage($event.target.value)"
                                                    :value="chat.message"
                                                    placeholder="<?php echo esc_attr(tdf_string('write_your_message_here')); ?>"
                                                >
                                            </div>
                                        </div>

                                        <textarea
                                            class="listivo-panel-messages__textarea"
                                            @input="chat.setMessage($event.target.value)"
                                            :value="chat.message"
                                            placeholder="<?php echo esc_attr(tdf_string('write_your_message_here')); ?>"
                                        ></textarea>

                                        <button
                                            class="listivo-panel-messages__mobile-send-button"
                                            :disabled="chat.inProgess"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                                 viewBox="0 0 13 13" fill="none">
                                                <path
                                                    d="M0.469991 0.000338581C0.39168 0.00318148 0.315209 0.0248591 0.247055 0.0635348C0.178901 0.102211 0.121074 0.156745 0.0784724 0.222517C0.0358709 0.288289 0.00975059 0.363361 0.00232448 0.441373C-0.00510163 0.519385 0.00638533 0.598037 0.0358121 0.670666L2.39904 6.49985L0.0358121 12.329C-0.00145763 12.4208 -0.00987623 12.5218 0.0116773 12.6185C0.0332309 12.7152 0.0837338 12.8031 0.15646 12.8703C0.229186 12.9376 0.320684 12.9811 0.418767 12.9951C0.51685 13.0091 0.616864 12.9929 0.705489 12.9486L12.7305 6.93594C12.8115 6.89545 12.8796 6.8332 12.9272 6.75618C12.9748 6.67916 13 6.5904 13 6.49985C13 6.4093 12.9748 6.32054 12.9272 6.24352C12.8796 6.16649 12.8115 6.10425 12.7305 6.06375L0.705489 0.051121C0.632474 0.0147599 0.551503 -0.00270058 0.469991 0.000338581ZM1.42468 1.50096L11.4229 6.49985L1.42468 11.4987L3.25407 6.98736H7.63776C7.70236 6.98827 7.76649 6.97634 7.82644 6.95225C7.88639 6.92816 7.94095 6.89239 7.98695 6.84703C8.03296 6.80167 8.06949 6.74762 8.09442 6.68802C8.11936 6.62842 8.1322 6.56446 8.1322 6.49985C8.1322 6.43524 8.11936 6.37128 8.09442 6.31168C8.06949 6.25207 8.03296 6.19802 7.98695 6.15266C7.94095 6.1073 7.88639 6.07154 7.82644 6.04745C7.76649 6.02336 7.70236 6.01142 7.63776 6.01234H3.25407L1.42468 1.50096Z"
                                                    fill="#FDFDFE"/>
                                            </svg>
                                        </button>

                                        <div class="listivo-panel-messages__send-button">
                                            <button
                                                class="listivo-button listivo-button--height-60 listivo-button--primary-1"
                                                :class="{'listivo-button--loading': chat.inProgress}"
                                                :disabled="chat.inProgess"
                                            >
                                                <span>
                                                    <?php echo esc_html(tdf_string('send')); ?>

                                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13"
                                                         viewBox="0 0 13 13" fill="none">
                                                        <path
                                                            d="M0.469991 0.000338581C0.39168 0.00318148 0.315209 0.0248591 0.247055 0.0635348C0.178901 0.102211 0.121074 0.156745 0.0784724 0.222517C0.0358709 0.288289 0.00975059 0.363361 0.00232448 0.441373C-0.00510163 0.519385 0.00638533 0.598037 0.0358121 0.670666L2.39904 6.49985L0.0358121 12.329C-0.00145763 12.4208 -0.00987623 12.5218 0.0116773 12.6185C0.0332309 12.7152 0.0837338 12.8031 0.15646 12.8703C0.229186 12.9376 0.320684 12.9811 0.418767 12.9951C0.51685 13.0091 0.616864 12.9929 0.705489 12.9486L12.7305 6.93594C12.8115 6.89545 12.8796 6.8332 12.9272 6.75618C12.9748 6.67916 13 6.5904 13 6.49985C13 6.4093 12.9748 6.32054 12.9272 6.24352C12.8796 6.16649 12.8115 6.10425 12.7305 6.06375L0.705489 0.051121C0.632474 0.0147599 0.551503 -0.00270058 0.469991 0.000338581ZM1.42468 1.50096L11.4229 6.49985L1.42468 11.4987L3.25407 6.98736H7.63776C7.70236 6.98827 7.76649 6.97634 7.82644 6.95225C7.88639 6.92816 7.94095 6.89239 7.98695 6.84703C8.03296 6.80167 8.06949 6.74762 8.09442 6.68802C8.11936 6.62842 8.1322 6.56446 8.1322 6.49985C8.1322 6.43524 8.11936 6.37128 8.09442 6.31168C8.06949 6.25207 8.03296 6.19802 7.98695 6.15266C7.94095 6.1073 7.88639 6.07154 7.82644 6.04745C7.76649 6.02336 7.70236 6.01142 7.63776 6.01234H3.25407L1.42468 1.50096Z"
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
                                                            <animate attributeName='fill-opacity' from='0.5' to='0.5'
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </lst-direct-messages>
    </template>
</div>