<?php

use Tangibledesign\Framework\Models\Model;

/* @var Model $model */
?>
<div>
    <div style="margin-bottom: 5px;">
        <label for="model-expire">
            <?php esc_html_e('Expire', 'listivo-core'); ?>
        </label>

        <div>
            <input
                    id="model-expire"
                    class="regular-text"
                    style="width: 100%;"
                    name="model_expire"
                    type="text"
                    value="<?php echo esc_attr($model->getExpireDate()); ?>"
                    placeholder="Example: <?php echo esc_attr((new DateTime())->modify('+7 days')->format('Y-m-d H:i:s')); ?>"
            >
        </div>
    </div>

    <div>
        <label for="model-featured-expire">
            <?php esc_html_e('Featured Expire', 'listivo-core'); ?>
        </label>

        <div>
            <input
                    id="model-featured-expire"
                    class="regular-text"
                    style="width: 100%;"
                    name="model_featured_expire"
                    type="text"
                    value="<?php echo esc_attr($model->getFeaturedExpireDate()); ?>"
                    placeholder="Example: <?php echo esc_attr((new DateTime())->modify('+3 days')->format('Y-m-d H:i:s')); ?>"
            >
        </div>
    </div>

    <div>
        <label for="<?php echo esc_attr(Model::VIEWS); ?>">
            <?php esc_html_e('Views', 'listivo-core'); ?>
        </label>

        <div>
            <input
                    id="<?php echo esc_attr(Model::VIEWS); ?>"
                    class="regular-text"
                    style="width: 100%;"
                    name="<?php echo esc_attr(Model::VIEWS); ?>"
                    type="text"
                    value="<?php echo esc_attr($model->getViews()); ?>"
                    placeholder="1345"
            >
        </div>
    </div>

    <div>
        <label for="<?php echo esc_attr(Model::PHONE_REVEALS); ?>">
            <?php esc_html_e('Phone Reveals', 'listivo-core'); ?>
        </label>

        <div>
            <input
                    id="<?php echo esc_attr(Model::PHONE_REVEALS); ?>"
                    class="regular-text"
                    style="width: 100%;"
                    name="<?php echo esc_attr(Model::PHONE_REVEALS); ?>"
                    type="text"
                    value="<?php echo esc_attr($model->getRevealPhoneCounter()); ?>"
                    placeholder="1345"
            >
        </div>
    </div>

    <div>
        <label for="<?php echo esc_attr(Model::FAVORITE_COUNT); ?>">
            <?php esc_html_e('Favorite Count', 'listivo-core'); ?>
        </label>

        <div>
            <input
                    id="<?php echo esc_attr(Model::FAVORITE_COUNT); ?>"
                    class="regular-text"
                    style="width: 100%;"
                    name="<?php echo esc_attr(Model::FAVORITE_COUNT); ?>"
                    type="text"
                    value="<?php echo esc_attr($model->getFavoriteCount()); ?>"
                    placeholder="1345"
            >
        </div>
    </div>
</div>