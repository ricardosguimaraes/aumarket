<?php

use Tangibledesign\Framework\Models\Field\Fieldable as FieldableAlias;
use Tangibledesign\Framework\Models\Field\EmbedField;

/* @var EmbedField $lstField */
/* @var FieldableAlias $lstModel */
?>
<lst-embed-field
        :field-id="<?php echo esc_attr($lstField->getId()); ?>"
        :field="<?php echo htmlspecialchars(json_encode($lstField)); ?>"
        :taxonomy-fields-values="props.taxonomyFieldsValues"
        :validation="props.validation"
        :is-required="<?php echo esc_attr($lstField->isRequired() ? 'true' : 'false'); ?>"
        :initial-value="<?php echo htmlspecialchars(json_encode($lstField->getValue($lstModel))); ?>"
        request-url="<?php echo esc_url(tdf_action_url('listivo/embedPreview')); ?>"
        nonce-value="<?php echo esc_attr(wp_create_nonce(tdf_prefix() . '_embed_preview')); ?>"
        :dependency-terms="props.dependencyTerms"
>
    <div
            slot-scope="fieldProps"
            v-if="fieldProps.isVisible"
            class="tdfm-field-group tdfm-form__field tdfm-form__field--full-width"
            :class="fieldProps.classes"
            data-name="<?php echo esc_attr($lstField->getName()); ?>"
    >
        <label
                class="tdfm-field-group__label"
                for="<?php echo esc_attr($lstField->getKey()); ?>"
        >
            <?php echo esc_html($lstField->getName()); ?>

            <?php if ($lstField->isRequired()): ?>
                <span class="tdfm-field-group__required">*</span>
            <?php endif; ?>
        </label>

        <div class="tdfm-field-group__field">
            <div class="tdfm-input">
                <input
                        id="<?php echo esc_attr($lstField->getKey()); ?>"
                        name="<?php echo esc_attr($lstField->getKey()); ?>[<?php echo esc_attr(EmbedField::URL); ?>]"
                        :value="fieldProps.url"
                        @input="fieldProps.setUrl($event.target.value)"
                        placeholder="<?php echo esc_attr($lstField->getName()); ?>"
                        @keypress.enter.prevent
                        type="text"
                ></input>

                <div
                        v-if="fieldProps.url !== ''"
                        class="tdfm-input__clear"
                        @click.stop.prevent="fieldProps.setUrl('')"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" viewBox="0 0 8 8"
                         fill="none">
                        <path d="M0.889354 0.000385399C0.713166 0.000603672 0.541042 0.0533645 0.394971 0.151928C0.248899 0.250491 0.135512 0.390383 0.0692934 0.553731C0.00307477 0.71708 -0.0129688 0.89647 0.0232121 1.06899C0.059393 1.2415 0.146156 1.39931 0.272417 1.52225L2.74709 3.9981L0.272417 6.47394C0.187381 6.55563 0.119491 6.65346 0.0727219 6.76173C0.0259528 6.86999 0.00124506 6.9865 4.58543e-05 7.10443C-0.00115335 7.22237 0.0211801 7.33935 0.0657381 7.44855C0.110296 7.55774 0.176183 7.65694 0.25954 7.74033C0.342897 7.82373 0.442049 7.88965 0.551188 7.93423C0.660327 7.97881 0.77726 8.00115 0.895139 7.99995C1.01302 7.99875 1.12947 7.97403 1.23768 7.92724C1.34589 7.88045 1.44368 7.81252 1.52533 7.72745L4 5.2516L6.47467 7.72745C6.55631 7.81253 6.6541 7.88045 6.76231 7.92724C6.87052 7.97403 6.98698 7.99875 7.10486 7.99995C7.22274 8.00115 7.33967 7.97881 7.44881 7.93423C7.55795 7.88965 7.6571 7.82373 7.74046 7.74034C7.82382 7.65694 7.88971 7.55774 7.93426 7.44855C7.97882 7.33936 8.00115 7.22237 7.99995 7.10443C7.99875 6.9865 7.97405 6.86999 7.92728 6.76173C7.88051 6.65346 7.81261 6.55563 7.72758 6.47394L5.25291 3.9981L7.72758 1.52225C7.85561 1.39774 7.94306 1.23743 7.97847 1.06234C8.01387 0.887245 7.99558 0.705535 7.92599 0.541021C7.8564 0.376508 7.73876 0.236865 7.58848 0.140392C7.4382 0.0439203 7.26229 -0.00488048 7.08382 0.000385399C6.85363 0.00724757 6.63515 0.103498 6.47467 0.268746L4 2.74459L1.52533 0.268746C1.44266 0.183724 1.34377 0.116165 1.23453 0.0700682C1.12529 0.023972 1.00791 0.000276521 0.889354 0.000385399Z"
                              fill="#EA6A6A"/>
                    </svg>
                </div>
            </div>

            <input
                    name="<?php echo esc_attr($lstField->getKey()); ?>[<?php echo esc_attr(EmbedField::EMBED); ?>]"
                    type="hidden"
                    :value="fieldProps.embed"
            >

            <div class="tdfm-form__embed-preview">
                <div class="tdf-embed-preview-wrapper">
                    <div
                            class="tdf-edit-listing-field__embed-preview"
                            :class="{'tdf-edit-listing-field__embed-preview--tik-tok': fieldProps.embed.includes('tiktok-embed')}"
                            v-if="fieldProps.embed !== ''"
                            v-html="fieldProps.embed"
                    ></div>
                </div>
            </div>
        </div>
    </div>
</lst-embed-field>