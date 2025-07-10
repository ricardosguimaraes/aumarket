<div class="listivo-backend-content">
    <template>
        <lst-fields
                update-order-request-url="<?php echo esc_url(admin_url('admin-post.php?action=' . tdf_prefix() . '/field/updateOrder')); ?>"
                delete-request-url="<?php echo esc_url(admin_url('admin-post.php?action=' . tdf_prefix() . '/field/delete')); ?>"
                :fields="<?php echo htmlspecialchars(json_encode(tdf_app('ordered_fields')->values())); ?>"
                delete-title-text="<?php esc_attr_e('Are you sure?', 'listivo-core'); ?>"
                confirm-button-text="<?php esc_attr_e('Confirm', 'listivo-core'); ?>"
                cancel-button-text="<?php esc_attr_e('Cancel', 'listivo-core'); ?>"
            <?php if (!empty(tdf_app('dependency_terms'))) : ?>
                :dependency-terms="<?php echo htmlspecialchars(json_encode(tdf_app('dependency_terms'))); ?>"
            <?php endif; ?>
        >
            <div slot-scope="props">
                <div class="listivo-backend-filter">
                    <select
                            @change="props.setTerm($event.target.value)"
                            :value="props.selectedTerm"
                    >
                        <option value=""><?php esc_html_e('All Categories', 'listivo-core'); ?></option>

                        <?php foreach (tdf_app('main_dependency_terms') as $tdfTerm) :
                            /* @var \Tangibledesign\Framework\Models\Term\CustomTerm $tdfTerm */
                            ?>
                            <option value="<?php echo esc_attr($tdfTerm->getId()); ?>">
                                <?php if (tdf_app('main_dependency_terms')->count() > 15): ?>
                                    <?php echo esc_html($tdfTerm->getName()); ?>
                                <?php else : ?>
                                    <?php
                                    $tdfFieldsCount = $tdfTerm->getFieldsCount();
                                    if ($tdfFieldsCount === 1) :
                                        echo sprintf(esc_html('%s (%d %s)'), $tdfTerm->getName(), $tdfFieldsCount, esc_html__('Field', 'listivo-core'));
                                    else :
                                        echo sprintf(esc_html('%s (%d %s)'), $tdfTerm->getName(), $tdfFieldsCount, esc_html__('Fields', 'listivo-core'));
                                    endif;
                                    ?>
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <table class="wp-list-table widefat fixed striped posts listivo-backend-table listivo-backend-table--compact">
                    <thead>
                    <tr>
                        <th class="listivo-backend-table__col listivo-backend-table__col--drag"></th>

                        <th class="listivo-backend-table__col listivo-backend-table__col--primary">
                            <span><?php esc_html_e('Name', 'listivo-core'); ?></span>
                        </th>

                        <th class="listivo-backend-table__col">
                            <?php esc_html_e('Slug', 'listivo-core'); ?>
                        </th>

                        <th class="listivo-backend-table__col">
                            <?php esc_html_e('Type', 'listivo-core'); ?>
                        </th>

                        <th class="listivo-backend-table__col listivo-backend-table__col--actions">
                            <?php esc_html_e('Actions', 'listivo-core'); ?>
                        </th>
                    </tr>
                    </thead>

                    <tbody
                            is="lst-draggable"
                            :list="props.currentFields"
                            tag="tbody"
                            handle=".listivo-backend-table__cell--drag"
                    >
                    <tr
                            v-for="field in props.fields"
                            :key="field.id"
                    >
                        <th class="listivo-backend-table__cell--drag">
                            <div>
                                <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="8"
                                        height="20"
                                        viewBox="0 0 8 20"
                                >
                                    <g>
                                        <g>
                                            <path
                                                    fill="#adadad"
                                                    d="M.052 1.452c0-.316.113-.586.338-.812.226-.226.497-.339.812-.339.316 0 .586.113.812.339.226.226.339.496.339.812 0 .315-.113.586-.339.812a1.108 1.108 0 0 1-.812.338c-.315 0-.586-.113-.812-.338a1.107 1.107 0 0 1-.338-.812zm5.287 0c0-.316.113-.586.338-.812.226-.226.497-.339.812-.339.316 0 .586.113.812.339.226.226.339.496.339.812 0 .315-.113.586-.339.812a1.108 1.108 0 0 1-.812.338c-.315 0-.586-.113-.812-.338a1.107 1.107 0 0 1-.338-.812zM.052 7.109c0-.316.113-.586.338-.812.226-.226.497-.339.812-.339.316 0 .586.113.812.339.226.226.339.496.339.812 0 .315-.113.585-.339.811a1.108 1.108 0 0 1-.812.34c-.315 0-.586-.114-.812-.34a1.107 1.107 0 0 1-.338-.811zm5.287 0c0-.316.113-.586.338-.812.226-.226.497-.339.812-.339.316 0 .586.113.812.339.226.226.339.496.339.812 0 .315-.113.585-.339.811a1.108 1.108 0 0 1-.812.34c-.315 0-.586-.114-.812-.34a1.107 1.107 0 0 1-.338-.811zM.052 12.765c0-.315.113-.586.338-.811.226-.226.497-.34.812-.34.316 0 .586.114.812.34.226.225.339.496.339.811 0 .316-.113.586-.339.812a1.108 1.108 0 0 1-.812.339c-.315 0-.586-.113-.812-.339a1.107 1.107 0 0 1-.338-.812zm5.287 0c0-.315.113-.586.338-.811.226-.226.497-.34.812-.34.316 0 .586.114.812.34.226.225.339.496.339.811 0 .316-.113.586-.339.812a1.108 1.108 0 0 1-.812.339c-.315 0-.586-.113-.812-.339a1.107 1.107 0 0 1-.338-.812zM.052 18.422c0-.315.113-.586.338-.812.226-.225.497-.338.812-.338.316 0 .586.113.812.338.226.226.339.497.339.812 0 .316-.113.586-.339.812a1.108 1.108 0 0 1-.812.339c-.315 0-.586-.113-.812-.339a1.107 1.107 0 0 1-.338-.812zm5.287 0c0-.315.113-.586.338-.812.226-.225.497-.338.812-.338.316 0 .586.113.812.338.226.226.339.497.339.812 0 .316-.113.586-.339.812a1.108 1.108 0 0 1-.812.339c-.315 0-.586-.113-.812-.339a1.107 1.107 0 0 1-.338-.812z"
                                            />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                        </th>

                        <th class="listivo-backend-table__cell listivo-backend-table__cell--primary">
                            {{ field.name }}
                        </th>

                        <td class="listivo-backend-table__cell">
                            {{ field.slug }}
                        </td>

                        <td class="listivo-backend-table__cell">
                            {{ field.typeLabel }}
                        </td>

                        <td class="listivo-backend-table__cell">
                            <a class="button button-small button-primary" :href="field.editUrl">
                                <?php esc_html_e('Edit', 'listivo-core'); ?>
                            </a>

                            <button
                                    class="button button-small button-secondary"
                                    @click.prevent="props.delete(field.id)"
                            >
                                <?php esc_html_e('Delete', 'listivo-core'); ?>
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </lst-fields>
    </template>
</div>