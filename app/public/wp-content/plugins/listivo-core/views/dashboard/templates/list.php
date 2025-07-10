<?php

use Tangibledesign\Framework\Models\Template\TemplateType\TemplateType;

/* @var TemplateType $lstTemplateType */
?>
<lst-templates
        :templates="<?php echo htmlspecialchars(json_encode($lstTemplateType->getTemplates())); ?>"
        delete-request-url="<?php echo esc_url(tdf_action_url('listivo/template/delete')); ?>"
        delete-nonce="<?php echo esc_attr(wp_create_nonce('listivo/template/delete')); ?>"
        set-default-request-url="<?php echo esc_url(tdf_action_url('listivo/template/setDefault')); ?>"
        duplicate-request-url="<?php echo esc_url(tdf_action_url('listivo/template/duplicate')); ?>"
        type="<?php echo esc_attr($lstTemplateType->getType()); ?>"
        :default-template-id="<?php echo esc_attr($lstTemplateType->getDefaultTemplateId()); ?>"
        delete-title-text="<?php esc_attr_e('Are you sure?', 'listivo-core'); ?>"
        confirm-button-text="<?php esc_attr_e('Confirm', 'listivo-core'); ?>"
        cancel-button-text="<?php esc_attr_e('Cancel', 'listivo-core'); ?>"
>
    <div slot-scope="props" class="listivo-backend-content">
        <table class="wp-list-table widefat fixed striped posts listivo-backend-table listivo-backend-table--compact">
            <thead>
            <tr>
                <th class="listivo-backend-table__col listivo-backend-table__col--small"></th>

                <th class="listivo-backend-table__col listivo-backend-table__col--primary">
                    <?php esc_html_e('Name', 'listivo-core'); ?>
                </th>

                <th class="listivo-backend-table__col listivo-backend-table__col--wide">
                    <?php esc_html_e('Actions', 'listivo-core'); ?>
                </th>
            </tr>
            </thead>

            <tbody>
            <tr
                    v-for="template in props.templates"
                    :key="template.id"
            >
                <th>
                    <input
                            type="radio"
                            :checked="template.id === props.defaultTemplateId"
                            @click="props.setDefault(template.id)"
                    >
                </th>

                <th class="listivo-backend-table__cell listivo-backend-table__cell--primary">
                    <span>{{ template.name }}</span>
                </th>

                <td class="listivo-backend-table__cell">
                    <?php if ($lstTemplateType->getType() === 'post_single') : ?>
                        <?php if (tdf_query_blog_posts()->anyStatus()->take(1)->get()->isEmpty()) : ?>
                            <?php esc_html_e('Add at least 1 post to edit template', 'listivo-core'); ?><br>
                        <?php else : ?>
                            <a
                                    class="button button-small button-primary"
                                    :href="template.editUrl"
                                    target="_blank"
                            >
                                <?php esc_html_e('Edit', 'listivo-core'); ?>
                            </a>
                        <?php endif; ?>
                    <?php elseif ($lstTemplateType->getType() === 'listing_single') : ?>
                        <?php if (tdf_query_models()->anyStatus()->take(1)->get()->isEmpty()) : ?>
                            <?php esc_html_e('Add at least 1 listing to edit template', 'listivo-core'); ?><br>
                        <?php else : ?>
                            <a
                                    class="button button-small button-primary"
                                    :href="template.editUrl"
                                    target="_blank"
                            >
                                <?php esc_html_e('Edit', 'listivo-core'); ?>
                            </a>
                        <?php endif; ?>
                    <?php else : ?>
                        <a
                                class="button button-small button-primary"
                                :href="template.editUrl"
                                target="_blank"
                        >
                            <?php esc_html_e('Edit', 'listivo-core'); ?>
                        </a>
                    <?php endif; ?>

                    <button
                            class="button button-small button-secondary"
                            @click.prevent="props.duplicate(template.id)"
                    >
                        <?php esc_html_e('Duplicate', 'listivo-core'); ?>
                    </button>

                    <a
                            class="button button-small button-secondary"
                            :href="template.url"
                            target="_blank"
                            title="<?php esc_attr_e('Preview', 'listivo-core'); ?>"
                    >
                        <?php esc_html_e('Preview', 'listivo-core'); ?>
                    </a>

                    <button
                            v-if="props.templates.length > 1"
                            @click.prevent="props.delete(template.id)"
                            class="button button-small button-secondary"
                    >
                        <?php esc_html_e('Delete', 'listivo-core'); ?>
                    </button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</lst-templates>