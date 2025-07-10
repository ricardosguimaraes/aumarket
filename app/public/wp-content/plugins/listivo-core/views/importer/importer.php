<?php

use Tangibledesign\Framework\Core\Demo;

?>
<div class="tdf-app">
    <div class="wrap">
        <lst-demo-importer
                prefix="listivo"
                request-url="<?php echo esc_url(admin_url('admin-post.php')); ?>"
                demo-url="<?php echo esc_url(apply_filters('listivo/demoImporter/sourceUrl', '')); ?>"
                redirect-url="<?php echo esc_url(admin_url('admin.php?page=listivo-quick-wizard')); ?>"
        >
            <div slot-scope="importerProps" class="tdf-importer">
                <h1 class="wp-heading-inline">
                    <?php esc_html_e('Listivo Demo Importer', 'listivo-core'); ?>
                </h1>

                <div class="tdf-importer__content">
                    <template v-if="importerProps.showProgress">
                        <div class="tdf-importer-progress">
                            <img src="<?php echo esc_url(includes_url().'js/tinymce/skins/lightgray/img//loader.gif'); ?>"/>

                            <strong>{{ importerProps.progress }}%</strong>
                        </div>
                    </template>

                    <div v-if="!importerProps.showProgress">
                        <div class="notice notice-warning">
                            <p>
                                <?php esc_html_e('Importing the demo will remove all current data.',
                                    'listivo-core'); ?>
                            </p>
                        </div>

                        <div class="notice notice-info">
                            <p>
                                <?php esc_html_e('In case of any problems, please', 'listivo-core'); ?>

                                <a
                                        href="https://support.listivotheme.com/support/tickets/new"
                                        target="_blank"
                                >
                                    <?php esc_html_e('contact us', 'listivo-core'); ?>
                                </a>
                            </p>
                        </div>

                        <?php if (!function_exists('curl_version') && !ini_get('allow_url_fopen')) : ?>
                            <div class="notice notice-error notice-alt">
                                <p>
                                    CURL extension is not installed on your server or allow_url_fopen option is
                                    disabled. This may generate problems when importing the demo.
                                </p>
                            </div>
                        <?php endif; ?>

                        <?php if (!extension_loaded('mbstring')) : ?>
                            <div class="notice notice-error notice-alt">
                                <p>
                                    The PHP extension 'mbstring' is not installed on your hosting. This can lead to
                                    unexpected behavior.
                                </p>
                            </div>
                        <?php endif; ?>

                        <?php if (!function_exists('gd_info') || !extension_loaded('gd')) : ?>
                            <div class="notice notice-error notice-alt">
                                <p>
                                    The PHP GD extension is not installed on your hosting. This can lead to a problem
                                    with image thumbnail generation.
                                </p>
                            </div>
                        <?php endif; ?>

                        <div class="tdf-importer__demos">
                            <?php foreach (tdf_app('demos') as $lstDemo) :
                                /* @var Demo $lstDemo */
                                ?>
                                <div class="tdf-importer-demo">
                                    <div class="tdf-importer-demo__image">
                                        <img src="<?php echo esc_url($lstDemo->getImage()); ?>" alt="">
                                    </div>

                                    <div class="tdf-importer-demo__body">
                                        <div class="tdf-importer-demo__bottom">
                                            <h3 class="tdf-importer-demo__name">
                                                <?php echo esc_html($lstDemo->getName()); ?>
                                            </h3>

                                            <button
                                                    class="button button-secondary button-small"
                                                    @click.prevent="importerProps.onImport('<?php echo esc_attr($lstDemo->getKey()); ?>')"
                                            >
                                                <?php esc_html_e('Import', 'listivo-core'); ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </lst-demo-importer>
    </div>
</div>