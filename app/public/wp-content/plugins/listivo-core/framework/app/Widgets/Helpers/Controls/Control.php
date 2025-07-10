<?php

namespace Tangibledesign\Framework\Widgets\Helpers\Controls;

trait Control
{
    /**
     * @param $id
     * @param array $args
     * @param array $options
     * @return bool
     * @noinspection PhpMissingReturnTypeInspection
     * @noinspection ReturnTypeCanBeDeclaredInspection
     */
    abstract public function add_control($id, array $args, $options = []);

    /**
     * @param $group_name
     * @param array $args
     * @param array $options
     * @return mixed
     */
    abstract public function add_group_control($group_name, array $args = [], array $options = []);

    /**
     * @param string|null $key
     * @return mixed
     */
    abstract public function get_settings_for_display($key = null);

    /**
     * @param $id
     * @param array $args
     * @param array $options
     * @return mixed
     */
    abstract public function add_responsive_control($id, array $args, $options = []);

    /**
     * @param string $key
     * @param string $label
     */
    abstract protected function startContentControlsSection(string $key = 'general_content', string $label = ''): void;

    /**
     * @param string $key
     * @param string $label
     */
    abstract protected function startStyleControlsSection(string $key = 'general_style', string $label = ''): void;

    abstract protected function endControlsSection(): void;

    abstract public function start_controls_tabs($tabs_id, array $args = []);

    abstract public function end_controls_tabs();

    abstract public function start_controls_tab($tab_id, $args);

    abstract public function end_controls_tab();
}