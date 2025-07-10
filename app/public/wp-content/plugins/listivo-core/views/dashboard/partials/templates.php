<?php

use Tangibledesign\Framework\Models\Template\TemplateType\TemplateType;

/* @var TemplateType $lstTemplateType */
?>
<div id="tdf-<?php echo esc_attr($lstTemplateType->getType()); ?>" class="tdf-templates-section">
    <div>
        <lst-templates
                :templates="<?php echo htmlspecialchars(json_encode($lstTemplateType->getTemplates())); ?>"
                delete-request-url="<?php echo esc_url(tdf_action_url('listivo/templates/delete')); ?>"
                set-default-request-url="<?php echo esc_url(tdf_action_url('listivo/templates/setDefault')); ?>"
                duplicate-request-url="<?php echo esc_url(tdf_action_url('listivo/templates/duplicate')); ?>"
                type="<?php echo esc_attr($lstTemplateType->getType()); ?>"
                :default-template-id="<?php echo esc_attr($lstTemplateType->getDefaultTemplateId()); ?>"
                delete-title-text="<?php esc_attr_e('Are you sure?', 'listivo-core'); ?>"
                confirm-button-text="<?php esc_attr_e('Confirm', 'listivo-core'); ?>"
                cancel-button-text="<?php esc_attr_e('Cancel', 'listivo-core'); ?>"
        >
            <div slot-scope="props" class="tdf-templates">
                <div
                        v-for="template in props.templates"
                        :key="template.id"
                        class="tdf-templates-row"
                >
                    <div class="tdf-templates-state">
                        <div
                                v-if="template.id === props.defaultTemplateId"
                                class="tdf-templates-default"
                        >
                            <div class="tdf-templates-default__inner"></div>

                            <div class="tdf-templates-default__label">
                                <?php esc_html_e('Default', 'listivo-core'); ?>
                            </div>
                        </div>

                        <div
                                v-if="template.id !== props.defaultTemplateId"
                                @click.prevent="props.setDefault(template.id)"
                                class="tdf-templates-set-as-default"
                        >
                            <div class="tdf-templates-set-as-default__circle"></div>

                            <div class="tdf-templates-set-as-default__label">
                                <?php esc_html_e('Set as default', 'listivo-core'); ?>
                            </div>
                        </div>
                    </div>

                    <div class="tdf-templates-name">
                        <span>{{ template.name }}</span>
                    </div>

                    <div class="tdf-templates-action">
                        <?php if ($lstTemplateType->getType() === 'post_single') : ?>
                            <?php if (tdf_query_blog_posts()->anyStatus()->take(1)->get()->isEmpty()) : ?>
                                <?php esc_html_e('Add at least 1 post to edit template', 'listivo-core'); ?><br>
                            <?php else : ?>
                                <a
                                        class="tdf-button-small-edit"
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
                                        class="tdf-button-small-edit"
                                        :href="template.editUrl"
                                        target="_blank"
                                >
                                    <?php esc_html_e('Edit', 'listivo-core'); ?>
                                </a>
                            <?php endif; ?>
                        <?php else : ?>
                            <a
                                    class="tdf-button-small-edit"
                                    :href="template.editUrl"
                                    target="_blank"
                            >
                                <?php esc_html_e('Edit', 'listivo-core'); ?>
                            </a>
                        <?php endif; ?>

                        <button
                                class="tdf-button-icon"
                                @click.prevent="props.duplicate(template.id)"
                        >
                            <i class="fas fa-clone vehica-action"></i> <?php esc_html_e('Duplicate', 'listivo-core'); ?>
                        </button>

                        <a
                                class="tdf-button-icon"
                                :href="template.url"
                                target="_blank"
                                title="<?php esc_attr_e('Preview', 'listivo-core'); ?>"
                        >
                            <i class="fas fa-eye vehica-action"></i>
                        </a>

                        <button
                                v-if="props.templates.length > 1"
                                @click.prevent="props.delete(template.id)"
                                class="tdf-button-icon"
                        >
                            <i class="fas fa-trash vehica-action"></i>
                        </button>
                    </div>

                </div>
            </div>
        </lst-templates>

        <lst-create-template
                request-url="<?php echo esc_url(tdf_action_url('listivo/templates/create')); ?>"
                type="<?php echo esc_attr($lstTemplateType->getType()); ?>"
        >
            <div slot-scope="props">
                <button @click.prevent="props.create" class="tdf-button-add">
                    <?php esc_html_e('Create New', 'listivo-core'); ?>

                    <i class="fas fa-plus-circle"></i>
                </button>
            </div>
        </lst-create-template>

    </div>
</div>
