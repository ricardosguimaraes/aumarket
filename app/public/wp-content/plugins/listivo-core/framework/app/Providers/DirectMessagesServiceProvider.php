<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Actions\Message\CreateDirectMessageAction;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\DirectMessage\Conversation;
use Tangibledesign\Framework\Widgets\General\PanelWidget;
use WP_User;

class DirectMessagesServiceProvider extends ServiceProvider
{
    public function afterInitiation(): void
    {
        add_action('admin_init', [$this, 'createTable']);
        add_action('admin_post_' . tdf_prefix() . '/directMessages/create', [$this, 'create']);
        add_action('admin_post_nopriv_' . tdf_prefix() . '/directMessages/create', [$this, 'createNotLogged']);
        add_action('admin_post_' . tdf_prefix() . '/directMessages/reload', [$this, 'reload']);
        add_action('admin_post_' . tdf_prefix() . '/directMessages/seen', [$this, 'seen']);
        add_action('admin_post_' . tdf_prefix() . '/directMessages/get', [$this, 'messages']);
        add_action('wp_footer', [$this, 'countChecker']);
        add_action('admin_post_' . tdf_prefix() . '/directMessages/checkCount', [$this, 'checkCount']);
        add_action('wp_login', [$this, 'checkTempMessages'], 10, 2);
    }

    /** @noinspection SqlDialectInspection
     * @noinspection SqlNoDataSourceInspection
     */
    public function createTable(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';

        global $wpdb;
        $charsetCollate = $wpdb->get_charset_collate();

        $tableName = self::getTableName();

        $statement = "CREATE TABLE `$tableName` (
            id bigint(20) NOT NULL auto_increment,
            user_from bigint(20) UNSIGNED NOT NULL,
            user_to bigint(20) UNSIGNED NOT NULL,
            created_at datetime NOT NULL,
            message longtext,
            seen tinyint(1) UNSIGNED DEFAULT 0,
            notified tinyint(1) UNSIGNED DEFAULT 0,
            PRIMARY KEY  (id)
        ) $charsetCollate;";

        maybe_create_table($tableName, $statement);
    }

    public static function getTableName(): string
    {
        global $wpdb;

        return $wpdb->prefix . tdf_prefix() . '_messages';
    }

    public function create(): void
    {
        if (empty($_POST['message']) || empty($_POST['userId']) || empty($_POST['tdNonce'])) {
            $this->errorJsonResponse();
            return;
        }

        if (!wp_verify_nonce($_POST['tdNonce'], tdf_prefix() . '_create_message')) {
            $this->errorJsonResponse();
            return;
        }

        if (!is_user_logged_in()) {
            $this->errorJsonResponse();
            return;
        }

        $message = wp_kses(stripslashes($_POST['message']), [
            'a' => [
                'href' => [],
                'title' => [],
                'target' => [],
            ],
        ]);

        $message = preg_replace_callback('/(https?:\/\/[^\s]+)/', static function ($matches) {
            return esc_url_raw($matches[0]);
        }, $message);

        $userTo = (int)$_POST['userId'];
        $limit = !empty($_POST['limit']) ? (int)$_POST['limit'] : 200;

        if (!empty(trim($message))) {
            CreateDirectMessageAction::create(get_current_user_id(), $userTo, $message);
        }

        $this->successJsonResponse([
            'messages' => Conversation::make($userTo)->getMessages($limit),
        ]);
    }

    public function createNotLogged(): void
    {
        if (empty($_POST['message']) || empty($_POST['userId']) || empty($_POST['nonce'])) {
            $this->errorJsonResponse();
            return;
        }

        $message = sanitize_textarea_field($_POST['message']);
        $userTo = (int)$_POST['userId'];

        if (!wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_create_message')) {
            $this->errorJsonResponse();
            return;
        }

        setcookie(tdf_prefix() . '/directMessages/tempMessage', $message, time() + (60 * 60), '/');
        setcookie(tdf_prefix() . '/directMessages/tempMessageUser', $userTo, time() + (60 * 60), '/');

        $this->successJsonResponse();
    }

    /**
     * @noinspection PhpUnusedParameterInspection
     */
    public function checkTempMessages(string $login, WP_User $wpUser): void
    {
        if (!is_user_logged_in()) {
//            return;
        }

        $message = stripslashes($_COOKIE[tdf_prefix() . '/directMessages/tempMessage'] ?? '');
        $userTo = (int)($_COOKIE[tdf_prefix() . '/directMessages/tempMessageUser'] ?? 0);

        if (empty($message) || empty($userTo)) {
            return;
        }

        CreateDirectMessageAction::create($wpUser->ID, $userTo, $message);

        setcookie(tdf_prefix() . '/directMessages/tempMessage', 0, time() + (60 * 60), '/');
        setcookie(tdf_prefix() . '/directMessages/tempMessageUser', 0, time() + (60 * 60), '/');

        tdf_user_factory()
            ->create($wpUser)
            ->setRedirectUrl(PanelWidget::getUrl(PanelWidget::ACTION_MESSAGES) . '/?' . tdf_slug('user') . '=' . $userTo);
    }


    public function reload(): void
    {
        if (empty($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], tdf_prefix() . '_messages_reload')) {
            $this->errorJsonResponse();
            return;
        }

        /** @noinspection NullPointerExceptionInspection */
        $this->successJsonResponse([
            'conversations' => tdf_current_user()->getConversations(),
        ]);
    }

    public function seen(): void
    {
        if (empty($_POST['userId']) || !is_user_logged_in()) {
            return;
        }

        Conversation::setSeen((int)$_POST['userId'], get_current_user_id());
    }

    public function messages(): void
    {
        if (empty($_POST['userId']) || !is_user_logged_in()) {
            return;
        }

        $conversation = Conversation::make((int)$_POST['userId']);
        $limit = !empty($_POST['limit']) ? (int)$_POST['limit'] : 200;

        echo json_encode([
            'messages' => $conversation->getMessages($limit),
            'count' => $conversation->getCount(),
        ]);
    }

    public function countChecker(): void
    {
        if (!is_user_logged_in()) {
            return;
        }

        get_template_part('templates/partials/direct_message_count_checker');
    }

    public function checkCount(): void
    {
        if (!is_user_logged_in() || !tdf_settings()->messageSystem()) {
            return;
        }

        /** @noinspection NullPointerExceptionInspection */
        echo tdf_current_user()->getNotSeenConversationNumber();
    }
}