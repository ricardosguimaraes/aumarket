<?php

namespace Tangibledesign\Listivo\Providers;

use Elementor\Plugin;
use Tangibledesign\Framework\Core\ServiceProvider;

class FontsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action(tdf_prefix().'/settings/saved', [$this, 'updateSettings']);

        add_action(tdf_prefix().'/demoImporter/finished', [$this, 'updateSettings']);

        add_action('admin_init', [$this, 'checkFonts']);
    }

    public function checkFonts(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $kit = Plugin::instance()->kits_manager->get_active_kit();
        if (!$kit || $kit->get_id() === 0) {
            return;
        }

        $settings = $kit->get_settings_for_display('system_typography');
        if (!is_array($settings)) {
            $settings = [];
        }

        $change = false;

        foreach ($settings as $key => $setting) {
            if (in_array($setting['_id'], [
                'primary',
                'secondary',
                'text',
                'accent',
            ])) {
                unset($settings[$key]);

                $change = true;
            } else {
                $settings[$key]['title'] = str_replace('Listivo ', '', $setting['title']);
            }
        }

        if (!$change) {
            return;
        }

        $kit->set_settings('system_typography', tdf_collect($settings)->values());
        $kit->save(['settings' => $kit->get_settings()]);
    }

    public function updateSettings(): void
    {
        $kit = Plugin::instance()->kits_manager->get_active_kit();
        if (!$kit) {
            return;
        }

        $settings = $kit->get_settings_for_display('system_typography');
        if (!is_array($settings)) {
            $settings = [];
        }

        $change = false;

        foreach ($this->getFonts() as $fontSettings) {
            if (!$this->exists($fontSettings, $settings)) {
                $settings[] = $fontSettings;

                $change = true;
            }
        }

        $settings = tdf_collect($settings)->sortBy('_id')->values();
        if (!$change) {
            return;
        }

        $kit->set_settings('system_typography', $settings);
        $kit->save(['settings' => $kit->get_settings()]);
    }

    private function getFonts(): array
    {
        return [
            /* Heading 1 */
            [
                '_id' => 'lheading1',
                'title' => 'Heading 1',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Red Hat Display',
                'typography_font_weight' => '800',
                'typography_font_size' => [
                    'unit' => 'px',
                    'size' => '68',
                    'sizes' => [],
                ],
                'typography_line_height' => [
                    'unit' => 'px',
                    'size' => '68',
                    'sizes' => [],
                ],
                'typography_letter_spacing' => [
                    'unit' => 'px',
                    'size' => '-2',
                ]
            ],
            /* Heading 2 */
            [
                '_id' => 'lheading2',
                'title' => 'Heading 2',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Red Hat Display',
                'typography_font_weight' => '800',
                'typography_font_size' => [
                    'unit' => 'px',
                    'size' => '36',
                    'sizes' => [],
                ],
                'typography_line_height' => [
                    'unit' => 'px',
                    'size' => '38',
                    'sizes' => [],
                ],
                'typography_letter_spacing' => [
                    'unit' => 'px',
                    'size' => '-1',
                ]
            ],
            /* Heading 3 */
            [
                '_id' => 'lheading3',
                'title' => 'Heading 3',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Red Hat Display',
                'typography_font_weight' => '800',
                'typography_font_size' => [
                    'unit' => 'px',
                    'size' => '24',
                    'sizes' => [],
                ],
                'typography_line_height' => [
                    'unit' => 'px',
                    'size' => '24',
                    'sizes' => [],
                ],
                'typography_letter_spacing' => [
                    'unit' => 'px',
                    'size' => '-1',
                ]
            ],
            /* Heading 4 */
            [
                '_id' => 'lheading4',
                'title' => 'Heading 4',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Red Hat Display',
                'typography_font_weight' => '800',
                'typography_font_size' => [
                    'unit' => 'px',
                    'size' => '16',
                    'sizes' => [],
                ],
                'typography_line_height' => [
                    'unit' => 'px',
                    'size' => '16',
                    'sizes' => [],
                ],
                'typography_letter_spacing' => [
                    'unit' => 'px',
                    'size' => '',
                ]
            ],
            /* Heading 5 */
            [
                '_id' => 'lheading5',
                'title' => 'Heading 5',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Red Hat Display',
                'typography_font_weight' => '800',
                'typography_font_size' => [
                    'unit' => 'px',
                    'size' => '16',
                    'sizes' => [],
                ],
                'typography_line_height' => [
                    'unit' => 'px',
                    'size' => '16',
                    'sizes' => [],
                ],
                'typography_letter_spacing' => [
                    'unit' => 'px',
                    'size' => '',
                ]
            ],
            /* Heading 6 */
            [
                '_id' => 'lheading6',
                'title' => 'Heading 6',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Red Hat Display',
                'typography_font_weight' => '800',
                'typography_font_size' => [
                    'unit' => 'px',
                    'size' => '16',
                    'sizes' => [],
                ],
                'typography_line_height' => [
                    'unit' => 'px',
                    'size' => '16',
                    'sizes' => [],
                ],
                'typography_letter_spacing' => [
                    'unit' => 'px',
                    'size' => '',
                ]
            ],
            /* Label */
            [
                '_id' => 'llabel',
                'title' => 'Label',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Red Hat Display',
                'typography_font_weight' => '600',
                'typography_font_size' => [
                    'unit' => 'px',
                    'size' => '16',
                    'sizes' => [],
                ],
                'typography_line_height' => [
                    'unit' => 'px',
                    'size' => '16',
                    'sizes' => [],
                ],
                'typography_letter_spacing' => [
                    'unit' => 'px',
                    'size' => '',
                ]
            ],
            /* Text 1 */
            [
                '_id' => 'ltext1',
                'title' => 'Text 1',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Red Hat Display',
                'typography_font_weight' => '500',
                'typography_font_size' => [
                    'unit' => 'px',
                    'size' => '16',
                    'sizes' => [],
                ],
                'typography_line_height' => [
                    'unit' => 'px',
                    'size' => '29',
                    'sizes' => [],
                ],
                'typography_letter_spacing' => [
                    'unit' => 'px',
                    'size' => '',
                ]
            ],
            /* Text 1 Bold */
            [
                '_id' => 'ltext1bold',
                'title' => 'Text 1 Bold',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Red Hat Display',
                'typography_font_weight' => '600',
                'typography_font_size' => [
                    'unit' => 'px',
                    'size' => '16',
                    'sizes' => [],
                ],
                'typography_line_height' => [
                    'unit' => 'px',
                    'size' => '29',
                    'sizes' => [],
                ],
                'typography_letter_spacing' => [
                    'unit' => 'px',
                    'size' => '',
                ]
            ],
            /* Text 2 */
            [
                '_id' => 'ltext2',
                'title' => 'Text 2',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Red Hat Display',
                'typography_font_weight' => '400',
                'typography_font_size' => [
                    'unit' => 'px',
                    'size' => '14',
                    'sizes' => [],
                ],
                'typography_line_height' => [
                    'unit' => 'px',
                    'size' => '24',
                    'sizes' => [],
                ],
                'typography_letter_spacing' => [
                    'unit' => 'px',
                    'size' => '',
                ]
            ],
            /* Text 2 Bold */
            [
                '_id' => 'ltext2bold',
                'title' => 'Text 2 Bold',
                'typography_typography' => 'custom',
                'typography_font_family' => 'Red Hat Display',
                'typography_font_weight' => '700',
                'typography_font_size' => [
                    'unit' => 'px',
                    'size' => '14',
                    'sizes' => [],
                ],
                'typography_line_height' => [
                    'unit' => 'px',
                    'size' => '29',
                    'sizes' => [],
                ],
                'typography_letter_spacing' => [
                    'unit' => 'px',
                    'size' => '',
                ]
            ],
        ];
    }

    private function exists(array $fontSettings, array $settings): bool
    {
        foreach ($settings as $setting) {
            if ($setting['_id'] === $fontSettings['_id']) {
                return true;
            }
        }

        return false;
    }

}