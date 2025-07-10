<template>
    <lst-bumps-payment-packages
            :initial-packages="<?php echo htmlspecialchars(json_encode(tdf_bumps_payment_packages())); ?>"
            delete-request-url="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/paymentPackage/delete')); ?>"
            update-order-request-url="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/paymentPackages/updateOrder')); ?>"
    >
        <div slot-scope="props" class="tdf-packages">
            <lst-draggable :list="props.packages" handle=".tdf-package__name">
                <div
                        v-for="package in props.packages"
                        :key="package.key"
                >
                    <lst-edit-bumps-payment-package
                            :initial-package="package"
                            request-url="<?php echo esc_url(tdf_action_url(tdf_prefix() . '/paymentPackage/update')); ?>"
                    >
                        <div slot-scope="editProps">
                            <div class="tdf-package">
                                <div class="tdf-package__name">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="20" viewBox="0 0 8 20">
                                        <g>
                                            <g>
                                                <path fill="#adadad"
                                                      d="M.052 1.452c0-.316.113-.586.338-.812.226-.226.497-.339.812-.339.316 0 .586.113.812.339.226.226.339.496.339.812 0 .315-.113.586-.339.812a1.108 1.108 0 0 1-.812.338c-.315 0-.586-.113-.812-.338a1.107 1.107 0 0 1-.338-.812zm5.287 0c0-.316.113-.586.338-.812.226-.226.497-.339.812-.339.316 0 .586.113.812.339.226.226.339.496.339.812 0 .315-.113.586-.339.812a1.108 1.108 0 0 1-.812.338c-.315 0-.586-.113-.812-.338a1.107 1.107 0 0 1-.338-.812zM.052 7.109c0-.316.113-.586.338-.812.226-.226.497-.339.812-.339.316 0 .586.113.812.339.226.226.339.496.339.812 0 .315-.113.585-.339.811a1.108 1.108 0 0 1-.812.34c-.315 0-.586-.114-.812-.34a1.107 1.107 0 0 1-.338-.811zm5.287 0c0-.316.113-.586.338-.812.226-.226.497-.339.812-.339.316 0 .586.113.812.339.226.226.339.496.339.812 0 .315-.113.585-.339.811a1.108 1.108 0 0 1-.812.34c-.315 0-.586-.114-.812-.34a1.107 1.107 0 0 1-.338-.811zM.052 12.765c0-.315.113-.586.338-.811.226-.226.497-.34.812-.34.316 0 .586.114.812.34.226.225.339.496.339.811 0 .316-.113.586-.339.812a1.108 1.108 0 0 1-.812.339c-.315 0-.586-.113-.812-.339a1.107 1.107 0 0 1-.338-.812zm5.287 0c0-.315.113-.586.338-.811.226-.226.497-.34.812-.34.316 0 .586.114.812.34.226.225.339.496.339.811 0 .316-.113.586-.339.812a1.108 1.108 0 0 1-.812.339c-.315 0-.586-.113-.812-.339a1.107 1.107 0 0 1-.338-.812zM.052 18.422c0-.315.113-.586.338-.812.226-.225.497-.338.812-.338.316 0 .586.113.812.338.226.226.339.497.339.812 0 .316-.113.586-.339.812a1.108 1.108 0 0 1-.812.339c-.315 0-.586-.113-.812-.339a1.107 1.107 0 0 1-.338-.812zm5.287 0c0-.315.113-.586.338-.812.226-.225.497-.338.812-.338.316 0 .586.113.812.338.226.226.339.497.339.812 0 .316-.113.586-.339.812a1.108 1.108 0 0 1-.812.339c-.315 0-.586-.113-.812-.339a1.107 1.107 0 0 1-.338-.812z"></path>
                                            </g>
                                        </g>
                                    </svg>

                                    {{ package.name }}
                                </div>

                                <div class="tdf-package__actions">
                                    <button
                                            @click.prevent="editProps.onEdit"
                                            class="tdf-button-small-edit"
                                    >
                                        <i class="fas fa-cog"></i>

                                        <?php esc_html_e('Edit', 'listivo-core'); ?>
                                    </button>

                                    <button
                                            @click.prevent="props.onDelete(package.id)"
                                            class="tdf-button-small-delete"
                                    >
                                        <i class="fas fa-trash listivo-action"></i>

                                        <?php esc_html_e('Delete', 'listivo-core'); ?>
                                    </button>
                                </div>
                            </div>

                            <div v-if="editProps.showForm" class="tdf-edit-package">
                                <form @submit.prevent="editProps.onSave">
                                    <div class="tdf-field">
                                        <label for="tdf-package-name">
                                            <?php esc_html_e('Name', 'listivo-core'); ?>
                                        </label>

                                        <input
                                                id="tdf-package-name"
                                                @input="editProps.setName($event.target.value)"
                                                :value="editProps.package.name"
                                                type="text"
                                        >
                                    </div>

                                    <div class="tdf-field">
                                        <label for="tdf-package-label">
                                            <?php esc_html_e('Label', 'listivo-core'); ?>
                                        </label>

                                        <input
                                                id="tdf-package-label"
                                                @input="editProps.setLabel($event.target.value)"
                                                :value="editProps.package.label"
                                                type="text"
                                        >
                                    </div>

                                    <div class="tdf-field">
                                        <label for="tdf-package-text">
                                            <?php esc_html_e('Text', 'listivo-core'); ?>
                                        </label>

                                        <input
                                                id="tdf-package-text"
                                                @input="editProps.setText($event.target.value)"
                                                :value="editProps.package.text"
                                                type="text"
                                        >
                                    </div>

                                    <div class="tdf-field">
                                        <label for="tdf-package-is-featured">
                                            <?php esc_html_e('Is Featured', 'listivo-core'); ?>
                                        </label>

                                        <input
                                                id="tdf-package-is-featured"
                                                @change="editProps.setIsFeatured(editProps.package.isFeatured)"
                                                :checked="editProps.package.isFeatured"
                                                type="checkbox"
                                        >
                                    </div>

                                    <div class="tdf-field">
                                        <label for="tdf-package-price">
                                            <?php esc_html_e('Price (integer e.g. 10)', 'listivo-core'); ?>
                                        </label>

                                        <input
                                                id="tdf-package-price"
                                                @input="editProps.setPrice($event.target.value)"
                                                :value="editProps.package.price"
                                                type="text"
                                        >
                                    </div>

                                    <div class="tdf-field">
                                        <label for="tdf-package-display-price">
                                            <?php esc_html_e('Display price (format number as currency e.g. $10.00)', 'listivo-core'); ?>
                                        </label>

                                        <input
                                                id="tdf-package-display-price"
                                                @input="editProps.setDisplayPrice($event.target.value)"
                                                :value="editProps.package.displayPrice"
                                                type="text"
                                        >
                                    </div>

                                    <div class="tdf-field">
                                        <label for="tdf-package-bumps-number">
                                            <?php esc_html_e('Bumps', 'listivo-core'); ?>
                                        </label>

                                        <input
                                                id="tdf-package-bumps-number"
                                                @input="editProps.setBumpsNumber($event.target.value)"
                                                :value="editProps.package.bumpsNumber"
                                                type="text"
                                        >
                                    </div>

                                    <div class="tdf-edit-package__buttons">
                                        <button class="tdf-button-save">
                                            <?php esc_html_e('Save', 'listivo-core'); ?>
                                        </button>

                                        <button
                                                @click.prevent="editProps.onCancel"
                                                class="tdf-button-cancel"
                                        >
                                            <?php esc_html_e('Cancel', 'listivo-core'); ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </lst-edit-bumps-payment-package>
                </div>
            </lst-draggable>
        </div>
    </lst-bumps-payment-packages>
</template>