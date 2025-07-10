<?php

use Tangibledesign\Framework\Models\Currency;

?>
<div id="tdf-currencies" class="tdf-content-section-full">
    <h2><?php esc_html_e('Currencies', 'listivo-core'); ?></h2>

    <lst-currencies
            create-currency-request-url="<?php echo esc_url(admin_url('admin-post.php?action=listivo/currencies/create')); ?>"
            update-currencies-request-url="<?php echo esc_url(admin_url('admin-post.php?action=listivo/currencies/update')); ?>"
            delete-currency-request-url="<?php echo esc_url(admin_url('admin-post.php?action=listivo/currencies/delete')); ?>"
            delete-title-text="<?php esc_attr_e('Are you sure?', 'listivo-core'); ?>"
            confirm-button-text="<?php esc_attr_e('Confirm', 'listivo-core'); ?>"
            cancel-button-text="<?php esc_attr_e('Cancel', 'listivo-core'); ?>"
        <?php if (!tdf_currencies()->isEmpty()) : ?>
            :initial-currencies="<?php echo htmlspecialchars(json_encode(tdf_currencies()->values())); ?>"
        <?php endif; ?>
    >
        <div slot-scope="props">
            <div class="tdf-currencies">
                <div class="tdf-currencies__head">
                    <div class="tdf-currencies__head-cell tdf-currencies-name">
                        <?php esc_html_e('Name', 'listivo-core'); ?>
                    </div>

                    <div class="tdf-currencies__head-cell tdf-currencies-sign">
                        <?php esc_html_e('Sign', 'listivo-core'); ?>
                    </div>

                    <div class="tdf-currencies__head-cell tdf-currencies-position">
                        <?php esc_html_e('Sign Position', 'listivo-core'); ?>
                    </div>

                    <div class="tdf-currencies__head-cell tdf-currencies-format">
                        <?php esc_html_e('Format', 'listivo-core'); ?>
                    </div>

                    <div class="tdf-currencies__head-cell tdf-currencies-actions">
                        <?php esc_html_e('Actions', 'listivo-core'); ?>
                    </div>
                </div>

                <div v-for="(currency, index) in props.currencies" :key="index">
                    <lst-edit-currency :currency="currency">
                        <div slot-scope="currencyProps">
                            <div class="tdf-currencies__row" v-if="!currencyProps.edit">
                                <div class="tdf-currencies__row-cell tdf-currencies-name">
                                    {{ currency.name }}
                                </div>

                                <div class="tdf-currencies__row-cell tdf-currencies-sign">
                                    {{ currency.sign }}
                                </div>

                                <div class="tdf-currencies__row-cell tdf-currencies-position">
                                    {{ currency.sign_position }}
                                </div>

                                <div class="tdf-currencies__row-cell tdf-currencies-format">
                                    {{ currency.format }}
                                </div>

                                <div class="tdf-currencies__row-cell tdf-currencies-actions">
                                    <button @click.prevent="currencyProps.onEdit" class="tdf-button-small-edit">
                                        <?php esc_html_e('Edit', 'listivo-core'); ?>
                                    </button>

                                    <button
                                            v-if="props.currencies.length > 1"
                                            @click.prevent="props.onDelete(currency.id)"
                                            class="tdf-button-small-delete"
                                    >
                                        <?php esc_html_e('Delete', 'listivo-core'); ?>
                                    </button>
                                </div>
                            </div>

                            <div v-if="currencyProps.edit" class="tdf-currencies-edit">
                                <div class="tdf-field">
                                    <label for="tdf-currency-name">
                                        <?php esc_html_e('Name', 'listivo-core'); ?>
                                    </label>

                                    <input
                                            id="tdf-currency-name"
                                            type="text"
                                            @input="currencyProps.setName($event.target.value)"
                                            :value="currencyProps.currency.name"
                                    >
                                </div>

                                <div class="tdf-field">
                                    <label for="tdf-currency-sign">
                                        <?php esc_html_e('Sign', 'listivo-core'); ?>
                                    </label>

                                    <input
                                            id="tdf-currency-sign"
                                            type="text"
                                            @input="currencyProps.setSign($event.target.value)"
                                            :value="currencyProps.currency.sign"
                                    >
                                </div>

                                <div class="tdf-field">
                                    <label for="tdf-currency-sign-position">
                                        <?php esc_html_e('Sign Position', 'listivo-core'); ?>
                                    </label>

                                    <select
                                            id="tdf-currency-sign-position"
                                            @change="currencyProps.setSignPosition($event.target.value)"
                                            :value="currencyProps.currency.sign_position"
                                    >
                                        <option value="before">
                                            <?php esc_html_e('Before', 'listivo-core'); ?>
                                        </option>

                                        <option value="after">
                                            <?php esc_html_e('After', 'listivo-core'); ?>
                                        </option>
                                    </select>
                                </div>

                                <div class="tdf-field">
                                    <label for="tdf-currency-format">
                                        <?php esc_html_e('Format', 'listivo-core'); ?>
                                    </label>

                                    <select
                                            id="tdf-currency-format"
                                            @change="currencyProps.setFormat($event.target.value)"
                                            :value="currencyProps.currency.format"
                                    >
                                        <?php foreach (Currency::getFormats() as $lstCurrencyFormatKey => $lstCurrencyFormatLabel) : ?>
                                            <option value="<?php echo esc_attr($lstCurrencyFormatKey); ?>">
                                                <?php echo esc_html($lstCurrencyFormatLabel); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <button class="tdf-button-save" @click.prevent="currencyProps.onSave">
                                    <?php esc_html_e('Save', 'listivo-core'); ?>
                                </button>

                                <button class="tdf-button-cancel" @click.prevent="currencyProps.onCancel">
                                    <?php esc_html_e('Cancel', 'listivo-core'); ?>
                                </button>
                            </div>
                        </div>
                    </lst-edit-currency>
                </div>
            </div>

            <button
                    class="tdf-button-add"
                    @click.prevent="props.createCurrency"
            >
                <?php esc_html_e('Add New Currency', 'listivo-core'); ?> <i class="fas fa-plus-circle"></i>
            </button>
        </div>
    </lst-currencies>
</div>