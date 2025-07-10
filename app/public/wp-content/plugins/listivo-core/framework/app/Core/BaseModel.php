<?php


namespace Tangibledesign\Framework\Core;


abstract class BaseModel
{
    abstract public function getId(): int;

    public function getKey(): string
    {
        return tdf_prefix() . '_' . $this->getId();
    }

    /**
     * @param string $key
     * @return mixed
     */
    abstract public function getMeta(string $key);

    /**
     * @param string $key
     * @param mixed $value
     * @return bool
     */
    abstract public function setMeta(string $key, $value): bool;

    /**
     * @param array $metas
     */
    public function setMetas(array $metas): void
    {
        foreach ($metas as $key => $value) {
            $this->setMeta($key, $value);
        }
    }
}