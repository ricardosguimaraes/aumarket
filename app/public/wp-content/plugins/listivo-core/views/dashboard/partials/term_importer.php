<?php

use Tangibledesign\Framework\Models\Field\TaxonomyField;

?>
<div class="tdf-content-section">
    <div class="tdf-content-section__left">
        <h2><?php esc_html_e('Bulk Add Terms', 'listivo-core'); ?></h2>

        <div class="tdf-doc">
            <div class="tdf-doc__icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>

            <div class="tdf-doc__text">
                <a
                        href="https://support.listivotheme.com/support/solutions/articles/101000373814/"
                        target="_blank"
                >
                    <?php esc_html_e('Please click here to read documentation before you use this module', 'listivo-core'); ?>
                </a>
            </div>
        </div>

        <div class="tdf-margin-bottom-small">
            <?php esc_html_e('This module can be used in 2 ways:', 'listivo-core'); ?>
        </div>
        <div class="tdf-margin-bottom-small">
            <?php esc_html_e('1. You can import list of terms e.g. 100 vehicle features via plain text (each term in new line)', 'listivo-core'); ?>
        </div>
        <div class="tdf-margin-bottom-small">
            <?php esc_html_e('2. You can use it to quickly create Parent-Child relationship e.g. you can add Make (Lamborghini) and connect to it many childs (Aventador, Gallardo, Murcielago, Diablo, Huracan)', 'listivo-core'); ?>
        </div>

    </div>

    <div class="tdf-content-section__right">
        <form
                action="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/termImporter/import')); ?>"
                method="post"
        >
            <lst-term-importer>
                <div slot-scope="importer">
                    <div class="tdf-term-importer">
                        <div class="tdf-term-importer__parent">
                            <div>
                                <div class="tdf-margin-bottom-small">
                                    <label for="tdf-parent-taxonomy">
                                        <?php esc_html_e('Taxonomy', 'listivo-core'); ?>
                                    </label>
                                </div>

                                <div class="tdf-margin-bottom-small">
                                    <select
                                            id="tdf-parent-taxonomy"
                                            name="parent_taxonomy"
                                            @change="importer.setTaxonomy($event.target.value)"
                                            :value="importer.taxonomy"

                                    >
                                        <option value="0">
                                            <?php esc_html_e('Select', 'listivo-core'); ?>
                                        </option>

                                        <?php foreach (tdf_taxonomy_fields() as $tdfTaxonomyField):
                                            /* @var TaxonomyField $tdfTaxonomyField */
                                            ?>
                                            <option value="<?php echo esc_attr($tdfTaxonomyField->getKey()); ?>">
                                                <?php echo esc_html($tdfTaxonomyField->getName()); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div>
                                <div>
                                    <label for="tdf-parent-terms">
                                        <?php esc_html_e('Terms', 'listivo-core'); ?>
                                    </label>
                                </div>

                                <textarea
                                        id="tdf-parent-terms"
                                        name="parent_terms"
                                        cols="30"
                                        rows="10"
                                ></textarea>
                            </div>
                        </div>

                        <?php foreach (tdf_app('child_taxonomies') as $tdfTaxonomy) :
                            /* @var TaxonomyField $tdfTaxonomy */
                            foreach ($tdfTaxonomy->getParentTaxonomyFields() as $tdfParentTaxonomy) :?>
                                <div
                                        v-if="importer.taxonomy === '<?php echo esc_attr($tdfParentTaxonomy->getKey()); ?>'"
                                        class="tdf-term-importer__child"
                                >

                                    <div class="tdf-margin-bottom-small">
                                        <label for="child_taxonomy">
                                            <?php esc_html_e('Child Field (Optional)', 'listivo-core'); ?>
                                        </label>
                                    </div>

                                    <div class="tdf-margin-bottom-small">
                                        <strong><?php echo esc_html($tdfTaxonomy->getName()); ?></strong>
                                    </div>

                                    <input
                                            type="hidden"
                                            name="child_taxonomy[]"
                                            value="<?php echo esc_attr($tdfTaxonomy->getKey()); ?>"
                                    >

                                    <div>
                                        <div>
                                            <label for="tdf-child-terms">
                                                <?php esc_html_e('Child Terms', 'listivo-core'); ?>
                                            </label>
                                        </div>

                                        <textarea
                                                name="child_terms[]"
                                                id="tdf-child-terms"
                                                cols="30"
                                                rows="10"
                                        ></textarea>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </lst-term-importer>

            <div class="tdf-button-save-wrapper">
                <button class="tdf-button-save">
                    <i class="fas fa-file-import"></i> <?php esc_html_e('Import', 'listivo-core'); ?>
                </button>
            </div>
        </form>
    </div>
</div>