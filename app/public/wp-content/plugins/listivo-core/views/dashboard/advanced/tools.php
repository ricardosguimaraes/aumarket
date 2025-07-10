<div class="listivo-docs listivo-docs--margin-top">
    <div class="listivo-docs__label-wrapper">
        <div class="listivo-docs__icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                <path d="M320 32c-8.1 0-16.1 1.4-23.7 4.1L15.8 137.4C6.3 140.9 0 149.9 0 160s6.3 19.1 15.8 22.6l57.9 20.9C57.3 229.3 48 259.8 48 291.9v28.1c0 28.4-10.8 57.7-22.3 80.8c-6.5 13-13.9 25.8-22.5 37.6C0 442.7-.9 448.3 .9 453.4s6 8.9 11.2 10.2l64 16c4.2 1.1 8.7 .3 12.4-2s6.3-6.1 7.1-10.4c8.6-42.8 4.3-81.2-2.1-108.7C90.3 344.3 86 329.8 80 316.5V291.9c0-30.2 10.2-58.7 27.9-81.5c12.9-15.5 29.6-28 49.2-35.7l157-61.7c8.2-3.2 17.5 .8 20.7 9s-.8 17.5-9 20.7l-157 61.7c-12.4 4.9-23.3 12.4-32.2 21.6l159.6 57.6c7.6 2.7 15.6 4.1 23.7 4.1s16.1-1.4 23.7-4.1L624.2 182.6c9.5-3.4 15.8-12.5 15.8-22.6s-6.3-19.1-15.8-22.6L343.7 36.1C336.1 33.4 328.1 32 320 32zM128 408c0 35.3 86 72 192 72s192-36.7 192-72L496.7 262.6 354.5 314c-11.1 4-22.8 6-34.5 6s-23.5-2-34.5-6L143.3 262.6 128 408z"></path>
            </svg>
        </div>

        <div class="listivo-docs__label">
            Tools Explained
        </div>
    </div>

    <div class="listivo-docs___content">
        <p>
            Before using any tools, please take the time to read the documentation to fully understand what each option
            does.
        </p>
    </div>

    <a
            class="listivo-docs__button"
            href="https://support.listivotheme.com/support/solutions/articles/101000528057-listivo-panel-advanced-tools"
            target="_blank"
    >
        Go to Article
    </a>
</div>

<table class="form-table">
    <tbody>
    <tr>
        <th scope="row">
            <label>
                <?php esc_html_e('Expired Ads', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <a
                    class="button button-secondary"
                    href="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/models/checkExpired')); ?>"
            >
                <?php esc_html_e('Check Expired', 'listivo-core'); ?>
            </a>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label>
                <?php esc_html_e('Connect Terms', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <a
                    class="button button-secondary"
                    href="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/term/relations/connect')); ?>"
            >
                <?php esc_html_e('Connect Terms', 'listivo-core'); ?>
            </a>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label>
                <?php esc_html_e('Files', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <a
                    class="button button-secondary"
                    href="<?php echo esc_url(tdf_action_url('listivo/images/cleanUp')); ?>"
            >
                <?php
                echo sprintf(
                    esc_html__('Clear Files (%d)', 'listivo-core'),
                    tdf_app('imagesToDeleteCount')
                );
                ?>
            </a>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label>
                <?php esc_html_e('Order by most relevant', 'listivo-core'); ?>
            </label>
        </th>

        <td>
            <a
                    class="button button-secondary"
                    href="<?php echo esc_url(tdf_action_url('listivo/bugs/featured')); ?>"
            >
                <?php esc_html_e('Fix order by most relevant when using WP All Import'); ?>
            </a>
        </td>
    </tr>

    <tr>
        <th scope="row">
            <label>
                <?php echo sprintf(esc_html__('Regenerate %s titles', 'listivo-core'), tdf_string('listings')); ?>
            </label>
        </th>

        <td>
            <lst-generate-model-titles
                    request-url="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/model/regenerate-titles')); ?>"
                    :count="<?php echo esc_attr(tdf_app('models_count')); ?>"
            >
                <div slot-scope="props">
                    <div v-if="!props.isDone">
                        <div v-if="!props.inProgress">
                            <button
                                    class="button button-secondary"
                                    @click="props.onStart"
                            >
                                <?php esc_html_e('Regenerate', 'listivo-core'); ?>
                            </button>

                            <p class="listivo-backend-description">
                                <?php esc_html_e('Note: This applies only when the "Settings -> SEO -> Auto-generate Title" option is enabled.', 'listivo-core'); ?>
                            </p>
                        </div>

                        <div v-if="props.inProgress">
                            <div class="spinner is-active" style="float:left;"></div>
                        </div>
                    </div>

                    <div v-if="props.isDone">
                        <strong><?php esc_html_e('Finished!', 'listivo-core'); ?></strong>
                    </div>
                </div>
            </lst-generate-model-titles>
        </td>
    </tr>
    </tbody>
</table>