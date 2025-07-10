<?php


namespace Tangibledesign\Framework\Core;

/**
 * Class Demo
 * @package Tangibledesign\Framework\Core
 */
class Demo
{
    public const URL = 'url';
    public const NAME = 'name';
    public const KEY = 'key';
    public const IMAGE = 'image';
    public const MEDIA_SOURCE = 'media_source';

    /**
     * @var array
     */
    private $demo;

    /**
     * Demo constructor.
     * @param array $demo
     */
    public function __construct(array $demo)
    {
        $this->demo = $demo;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->demo[self::NAME];
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->demo[self::KEY];
    }

    /**
     * @return string
     */
    public function getImage(): string
    {
        return $this->demo[self::IMAGE];
    }

    /**
     * @return string
     */
    public function getMediaSource(): string
    {
        return $this->demo[self::MEDIA_SOURCE] . '/wp-content/uploads/';
    }

    /**
     * @return string
     */
    public function getUrl(): string
    {
        return $this->demo[self::URL];
    }
}