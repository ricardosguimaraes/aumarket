<?php

namespace Tangibledesign\Framework\Providers;

use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\Model;

class ReportAbuseServiceProvider extends ServiceProvider
{

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/model/reportAbuse', [$this, 'model']);
        add_action('admin_post_nopriv_' . tdf_prefix() . '/model/reportAbuse', [$this, 'model']);
    }

    public function model(): void
    {
        $modelId = (int)$_POST['modelId'];
        $mail = $_POST['mail'];
        $text = $_POST['text'];

        if (empty($modelId) || empty($mail) || empty($text)) {
            return;
        }

        $model = tdf_post_factory()->create($modelId);
        if (!$model instanceof Model) {
            return;
        }

        $text = '<a href="' . $model->getUrl() . '">' . $model->getName() . '</a><br><br>' . $text;

        wp_mail(get_option('admin_email'), tdf_string('report_abuse') . ' - ' . $model->getName(), nl2br($text), [
            'Content-Type: text/html; charset=UTF-8',
            'Reply-To: <' . $mail . '>'
        ]);
    }

}