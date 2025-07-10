<?php
/* @var \Tangibledesign\Framework\Search\Field\TextSearchField $lstSearchField */
global $lstSearchField;
?>
<lst-text-search-field
        :field="<?php echo htmlspecialchars(json_encode($lstSearchField)); ?>"
        :filters="props.filters"
        :dependencies="props.dependencies"
>
    <div
            slot-scope="textField"
            v-if="textField.isVisible"
            class="listivo-field"
            :class="{'listivo-field--active': textField.value !== ''}"
    >
        <div class="listivo-relative">
            <input
                    type="text"
                    @input="textField.setValue($event.target.value)"
                    :value="textField.value"
                    placeholder="<?php echo esc_attr($lstSearchField->getPlaceholder()); ?>"
            >

            <div
                    v-if="textField.value !== ''"
                    class="listivo-field__icon listivo-field__icon--clear"
                    @click.prevent="textField.clear"
            ></div>
        </div>
    </div>
</lst-text-search-field>
