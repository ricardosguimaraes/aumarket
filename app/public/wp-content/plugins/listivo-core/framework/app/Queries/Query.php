<?php

namespace Tangibledesign\Framework\Queries;

use Tangibledesign\Framework\Core\Collection;

abstract class Query
{
    /**
     * @var array
     */
    protected $args = [];

    /**
     * @var int
     */
    protected $limit = -1;

    /**
     * @var int
     */
    protected $offset;

    /**
     * @var array
     */
    protected $in = [];

    /**
     * @var array
     */
    protected $notIn = [];

    /**
     * QueryModifier constructor.
     * @param array $args
     */
    public function __construct(array $args = [])
    {
        $this->args = $args;
    }

    /**
     * @param array $args
     * @return static
     * @noinspection PhpMissingReturnTypeInspection
     */
    public static function query(array $args = [])
    {
        return new static($args);
    }

    /**
     * @return array
     */
    abstract protected function parseArgs(): array;

    /**
     * @return Collection
     */
    abstract public function get(): Collection;

    /**
     * @param int $value
     * @return $this
     */
    public function take(int $value): Query
    {
        $this->limit = $value;

        return $this;
    }

    /**
     * @param int $value
     * @return Query
     */
    public function skip(int $value): Query
    {
        $this->offset = $value;

        return $this;
    }

    /**
     * @param array|int $ids
     * @return Query
     */
    public function in($ids = []): Query
    {
        $this->in = is_array($ids) ? $ids : [$ids];

        return $this;
    }

    /**
     * @param array|int $ids
     * @return Query
     */
    public function notIn($ids): Query
    {
        $this->notIn = is_array($ids) ? $ids : [$ids];

        return $this;
    }

    /**
     * @return Collection
     */
    public static function all(): Collection
    {
        return static::query()->get();
    }
}