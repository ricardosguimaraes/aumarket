<?php

use Tangibledesign\Framework\Models\Template\TemplateType\TemplateType;

$tab = $_GET['tab'] ?? TemplateType::LAYOUT;
?>
<div class="tdf-app">
    <div class="wrap">
        <h1 class="wp-heading-inline">
            <?php esc_html_e('Templates', 'listivo-core'); ?>
        </h1>

        <a
                class="page-title-action"
                href="<?php echo esc_url(admin_url('admin.php?page=listivo-add-new-template')); ?>"
        >
            <?php esc_html_e('Add New Template', 'listivo-core'); ?>
        </a>

        <lst-tabs
                initial-tab="<?php echo esc_attr($tab); ?>"
                base-url="<?php echo esc_url(admin_url('admin.php?page=listivo_templates')); ?>"
        >
            <div slot-scope="tabs">
                <h2 class="nav-tab-wrapper">
                    <?php foreach (tdf_app('template_types') as $lstTemplateType) : /* @var TemplateType $lstTemplateType */ ?>
                        <a
                                @click="tabs.setTab('<?php echo esc_attr($lstTemplateType->getType()); ?>')"
                                href="#"
                                class="nav-tab"
                                :class="{'nav-tab-active': tabs.tab === '<?php echo esc_attr($lstTemplateType->getType()); ?>'}"
                        >
                            <?php echo esc_html($lstTemplateType->getName()); ?>
                        </a>
                    <?php endforeach; ?>
                </h2>

                <?php foreach (tdf_app('template_types') as $lstTemplateType) : ?>
                    <template>
                        <div
                                class="tabs-content"
                                v-show="tabs.tab === '<?php echo esc_attr($lstTemplateType->getType()); ?>'"
                        >
                            <?php tdf_load_view('dashboard/templates/list', compact('lstTemplateType')); ?>
                        </div>
                    </template>
                <?php endforeach; ?>
            </div>
        </lst-tabs>
    </div>
</div>