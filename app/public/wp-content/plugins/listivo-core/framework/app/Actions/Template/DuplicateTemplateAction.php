<?php


namespace Tangibledesign\Framework\Actions\Template;


use Tangibledesign\Framework\Models\Template\Template;

/**
 * Class DuplicateTemplateAction
 * @package Tangibledesign\Framework\Actions\Template
 */
class DuplicateTemplateAction
{
    use CreateUniqueTemplateName;

    /**
     * @param  int  $templateId
     * @return Template|false
     */
    public function duplicate(int $templateId)
    {
        $template = tdf_template_factory()->create($templateId);
        if (!$template) {
            return false;
        }

        $duplicatedTemplateId = $this->createNewTemplate($template);
        if (!$duplicatedTemplateId) {
            return false;
        }

        return tdf_template_factory()->create($duplicatedTemplateId);

    }

    /**
     * @param  Template  $template
     * @return false|int
     * @noinspection SqlDialectInspection
     * @noinspection SqlNoDataSourceInspection
     */
    protected function createNewTemplate(Template $template)
    {
        $templateId = wp_insert_post([
            'post_title' => $template->getName(),
            'post_type' => $template->getPostType(),
            'post_status' => $template->getStatus(),
            'post_author' => $template->getUserId(),
            'post_content' => $template->getContent(),
            'post_excerpt' => $template->getExcerpt(),
            'post_modified' => current_time('mysql'),
        ]);

        if (is_wp_error($templateId)) {
            return false;
        }

        global $wpdb;
        $meta = $wpdb->get_results("SELECT meta_key, meta_value FROM $wpdb->postmeta WHERE post_id=".$template->getId());
        if (count($meta) !== 0) {
            $query = "INSERT INTO $wpdb->postmeta (post_id, meta_key, meta_value) ";
            $selectQuery = [];

            foreach ($meta as $meta_info) {
                $key = $meta_info->meta_key;
                if ($key === '_wp_old_slug') {
                    continue;
                }

                $value = addslashes($meta_info->meta_value);
                $selectQuery[] = "SELECT $templateId, '$key', '$value'";
            }
            $query .= implode(" UNION ALL ", $selectQuery);
            $wpdb->query($query);
        }

        wp_update_post([
            'ID' => $templateId,
            'post_title' => $this->getName($template->getName(), $template->getType()),
        ]);

        return $templateId;
    }

}