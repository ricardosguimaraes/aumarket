<?php


namespace Tangibledesign\Framework\Providers;


use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class StringsServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class StringsServiceProvider extends ServiceProvider
{
    public const OPTION = 'strings';

    /**
     * @return void
     */
    public function initiation(): void
    {
        foreach ($this->getStrings() as $key => $string) {
            $this->container[$key.'_string'] = $string;
        }

        $this->container['strings'] = function () {
            $strings = $this->getSettings();

            usort($strings, static function ($a, $b) {
                $aName = strtolower($a['name']);
                $bName = strtolower($b['name']);

                if ($aName === $bName) {
                    return 0;
                }

                return $aName > $bName ? 1 : -1;
            });

            return $strings;
        };
    }

    public function afterInitiation(): void
    {
        add_action(tdf_prefix().'/strings/save', [$this, 'save']);
    }

    public function save(): void
    {
        if (!current_user_can('manage_options')) {
            exit;
        }

        $strings = $_POST['strings'] ?? [];
        if (!is_array($strings) || empty($strings)) {
            return;
        }

        foreach ($strings as $key => $string) {
            $strings[$key] = stripslashes_deep($string);
        }

        update_option($this->getOptionKey(), $strings, true);
    }

    /**
     * @return array
     */
    private function getStrings(): array
    {
        $strings = $this->getStringsOption();
        $output = [];

        foreach ($this->getDefinedStrings() as $key => $string) {
            if (isset($strings[$key]) && !empty($strings[$key])) {
                $output[$key] = $strings[$key];
            } else {
                $output[$key] = $string;
            }
        }

        return $output;
    }

    /**
     * @return array
     */
    private function getStringsOption(): array
    {
        $strings = get_option($this->getOptionKey());

        if (!is_array($strings)) {
            return [];
        }

        return $strings;
    }

    /**
     * @return string
     */
    private function getOptionKey(): string
    {
        return tdf_prefix().'_'.self::OPTION;
    }

    /**
     * @return array
     */
    private function getSettings(): array
    {
        $settings = [];
        $strings = $this->getStringsOption();

        foreach ($this->getDefinedStrings() as $key => $string) {
            $settings[] = [
                'key' => $key,
                'name' => $string,
                'value' => $strings[$key] ?? $string
            ];
        }

        return $settings;
    }

    /**
     * @return array
     */
    private function getDefinedStrings(): array
    {
        return apply_filters('tdf/strings', []);
    }

}