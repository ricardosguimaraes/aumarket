<?php

namespace Tangibledesign\Framework\Core;

class Notification
{
    public const MAIL_CONFIRMATION = 'mail_confirmation';
    public const RESET_PASSWORD = 'reset_password';
    public const WELCOME_USER = 'welcome_user';
    public const CHANGE_EMAIL = 'change_email';

    /**
     * @var string
     */
    public $key;

    /**
     * @var string
     */
    public $label;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $message;

    /**
     * @var array
     */
    public $vars;

    /**
     * @var bool
     */
    public $optional;

    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var string
     */
    public $description;

    /**
     * Notification constructor.
     * @param  string  $key
     * @param  string  $label
     * @param  string  $title
     * @param  string  $message
     * @param  array  $vars
     * @param  bool  $optional
     * @param  bool  $enabled
     * @param  string  $description
     */
    public function __construct(
        string $key,
        string $label,
        string $title,
        string $message,
        array $vars = [],
        bool $optional = true,
        bool $enabled = false,
        string $description = ''
    ) {
        $this->key = $key;
        $this->label = $label;
        $this->title = $title;
        $this->message = $message;
        $this->vars = $vars;
        $this->optional = $optional;
        $this->enabled = $enabled;
        $this->description = $description;
    }

    /**
     * @param  array  $data
     * @return Notification
     */
    public static function create(array $data): Notification
    {
        return new self(
            $data['key'],
            $data['label'],
            $data['title'],
            $data['message'],
            $data['vars'],
            $data['optional'],
            $data['enabled'],
            $data['description']
        );
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        if (!$this->optional) {
            return true;
        }

        return $this->enabled;
    }

    /**
     * @param  string  $key
     * @return Notification|false
     */
    public static function getByKey(string $key)
    {
        /** @noinspection NullPointerExceptionInspection */
        return tdf_app('notifications')->find(static function ($notification) use ($key) {
            /* @var Notification $notification */
            return $notification->key === $key;
        });
    }

    /**
     * @return string
     */
    public function getAvailableVarsString(): string
    {
        return implode(', ', tdf_collect($this->vars)
            ->map(static function ($var) {
                return '{'.$var.'}';
            })
            ->values());
    }

}