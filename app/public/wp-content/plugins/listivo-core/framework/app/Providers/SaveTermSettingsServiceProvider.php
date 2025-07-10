<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Term\CustomTerm;

class SaveTermSettingsServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('create_term', [$this, 'save']);

        add_action('edit_term', [$this, 'save']);
    }

    public function save(int $termId): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        if (!wp_verify_nonce($_POST['nonce'] ?? '', 'tdf/term/update')) {
            return;
        }

        $term = tdf_term_factory()->create($termId);
        if (!$term instanceof CustomTerm) {
            return;
        }

        $term->updateSettings($_POST);
    }

}