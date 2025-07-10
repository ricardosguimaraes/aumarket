<?php

namespace Tangibledesign\Framework\Models\PanelFields;

use JsonSerializable;
use Tangibledesign\Framework\Models\Model;

abstract class PanelField implements JsonSerializable
{
    /**
     * @var array
     */
    protected $config;

    /**
     * @var mixed
     */
    protected $model;

    /**
     * PanelField constructor.
     *
     * @param array $config
     * @param mixed $model
     */
    public function __construct(array $config = [], $model = null)
    {
        $this->config = $config;
        $this->model = $model;
    }

    /**
     * @return string
     */
    abstract public function getKey(): string;

    /**
     * @return string
     */
    abstract public function getLabel(): string;

    /**
     * @return string
     */
    abstract protected function getTemplate(): string;

    public function loadTemplate(): void
    {
        global ${tdf_short_prefix() . 'PanelField'};
        ${tdf_short_prefix() . 'PanelField'} = $this;

        get_template_part('templates/widgets/general/panel/fields/' . $this->getTemplate());
    }

    /**
     * @param Model $model
     * @param array $data
     */
    abstract public function update(Model $model, array $data = []): void;

    public function jsonSerialize(): array
    {
        return [
                'key' => $this->getKey(),
                'label' => $this->getLabel(),
                'config' => $this->config
            ] + $this->getAdditionalJsonData();
    }

    /**
     * @return array
     */
    protected function getAdditionalJsonData(): array
    {
        return [];
    }

    /**
     * @return bool
     */
    abstract public function isSingleValue(): bool;

    /**
     * @return bool
     */
    abstract public function isRequired(): bool;

    /**
     * @param array $data
     *
     * @return bool
     */
    abstract public function validate(array $data): bool;

    /**
     * @param string $userRole
     * @return bool
     */
    public function visibleByUserRole(string $userRole): bool
    {
        return true;
    }

}