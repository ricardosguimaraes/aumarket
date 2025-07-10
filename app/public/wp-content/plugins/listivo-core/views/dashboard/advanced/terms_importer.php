<?php

use Tangibledesign\Framework\Core\Settings\SettingKey;
use Tangibledesign\Framework\Models\ContactForm;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Page;

?>
<div class="listivo-docs listivo-docs--margin-top">
    <div class="listivo-docs__label-wrapper">
        <div class="listivo-docs__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                <path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"></path>
            </svg>
        </div>

        <div class="listivo-docs__label">
            Bulk Add Terms Guide
        </div>
    </div>

    <div class="listivo-docs___content">
        <p>
            Before using the Term Importer, check what it can do for you and how to use it.
        </p>
    </div>

    <a
            class="listivo-docs__button"
            href="https://support.listivotheme.com/support/solutions/articles/101000373814-bulk-add-terms-makes-models-cities-etc-"
            target="_blank"
    >
        Go to Article
    </a>
</div>

<form
        action="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/termImporter/import')); ?>"
        method="post"
>
    <lst-term-importer>
        <div slot-scope="importer">
            <table class="form-table">
                <tbody>
                <tr>
                    <th scope="row">
                        <label for="tdf-parent-taxonomy">
                            <?php esc_html_e('Taxonomy', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
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
                    </td>
                </tr>

                <tr>
                    <th scope="row">
                        <label for="tdf-parent-terms">
                            <?php esc_html_e('Terms', 'listivo-core'); ?>
                        </label>
                    </th>

                    <td>
                        <textarea
                                id="tdf-parent-terms"
                                name="parent_terms"
                                class="listivo-backend-text-area"
                                cols="30"
                                rows="10"
                        ></textarea>
                    </td>
                </tr>

                <?php foreach (tdf_app('child_taxonomies') as $tdfTaxonomy) :
                    /* @var TaxonomyField $tdfTaxonomy */
                    foreach ($tdfTaxonomy->getParentTaxonomyFields() as $tdfParentTaxonomy) :?>
                        <tr v-if="importer.taxonomy === '<?php echo esc_attr($tdfParentTaxonomy->getKey()); ?>'">
                            <th class="row">
                                <label for="child_taxonomy">
                                    <?php echo sprintf(esc_html__('%s (Optional)', 'listivo-core'), $tdfTaxonomy->getName()); ?>
                                </label>
                            </th>

                            <td>
                                <input
                                        type="hidden"
                                        name="child_taxonomy[]"
                                        value="<?php echo esc_attr($tdfTaxonomy->getKey()); ?>"
                                >

                                <textarea
                                        name="child_terms[]"
                                        id="tdf-child-terms"
                                        class="listivo-backend-text-area"
                                        cols="30"
                                        rows="10"
                                ></textarea>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                </tbody>
            </table>

            <p class="submit">
                <button class="button button-primary">
                    <?php esc_html_e('Import', 'listivo-core'); ?>
                </button>
            </p>
        </div>
    </lst-term-importer>
</form>