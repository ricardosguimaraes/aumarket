<?php


namespace Tangibledesign\Framework\Providers;


use Cocur\Slugify\Slugify;
use Tangibledesign\Framework\Core\ServiceProvider;

/**
 * Class SlugsServiceProvider
 * @package Tangibledesign\Framework\Providers
 */
class SlugsServiceProvider extends ServiceProvider
{
    public const OPTION = 'slugs';

    /**
     * @return void
     */
    public function initiation(): void
    {
        foreach ($this->getSlugs() as $key => $slug) {
            $this->container[$key.'_slug'] = $slug;
        }

        $this->container['slugs'] = function () {
            return $this->getSettings();
        };
    }

    public function afterInitiation(): void
    {
        add_action(tdf_prefix().'/slugs/save', [$this, 'save']);
    }

    public function save(): void
    {
        if (!current_user_can('manage_options')) {
            exit;
        }

        $slugs = $this->parseSlugs();

        if (!empty($slugs)) {
            update_option($this->getOptionKey(), $slugs, true);
        }
    }

    /**
     * @return array
     */
    private function parseSlugs(): array
    {
        $slugs = $_POST['slugs'] ?? [];

        foreach ($slugs as $key => $slug) {
            $slugs[$key] = $this->parseSlug($slug);
        }

        return $slugs;
    }

    /**
     * @param  string  $slug
     * @return string
     */
    private function parseSlug(string $slug): string
    {
        $slug = preg_replace('/\s+/', '', $slug);

        if (empty($slug)) {
            return '';
        }

        $slug = Slugify::create(['trim' => false])->slugify($slug);

        if (in_array($slug, $this->getForbiddenSlugs(), true)) {
            return '';
        }

        return $slug;
    }

    /**
     * @return string[]
     */
    private function getForbiddenSlugs(): array
    {
        return [
            'id',
            'year',
            'month',
            'day',
            'p',
        ];
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
    private function getSlugsOption(): array
    {
        $slugs = get_option($this->getOptionKey());

        if (!is_array($slugs)) {
            return [];
        }

        return $slugs;
    }

    /**
     * @return array
     */
    private function getDefinedSlugs(): array
    {
        return apply_filters('tdf/slugs', []);
    }

    /**
     * @return array
     */
    private function getSlugs(): array
    {
        $slugs = $this->getSlugsOption();
        $output = [];

        foreach ($this->getDefinedSlugs() as $key => $slug) {
            if (isset($slugs[$key]) && !empty($slugs[$key])) {
                $output[$key] = $slugs[$key];
            } else {
                $output[$key] = $slug;
            }
        }

        return $output;
    }

    /**
     * @return array
     */
    private function getSettings(): array
    {
        $settings = [];
        $slugs = $this->getSlugsOption();

        foreach ($this->getDefinedSlugs() as $key => $slug) {
            $settings[] = [
                'key' => $key,
                'name' => $slug,
                'value' => !empty($slugs[$key]) ? $slugs[$key] : $slug,
            ];
        }

        return $settings;
    }

}