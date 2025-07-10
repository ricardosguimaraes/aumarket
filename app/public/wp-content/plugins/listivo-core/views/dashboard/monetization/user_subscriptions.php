<?php

use Tangibledesign\Framework\Models\Payments\FreeSubscription;
use Tangibledesign\Framework\Models\Payments\Subscription;
use Tangibledesign\Framework\Models\Payments\UserSubscription;

$currentPage = $_GET['pagination'] ?? 1;
$perPage = 20;

$query = tdf_query_user_subscriptions();
$userSubscriptions = $query
    ->take($perPage)
    ->setPage($currentPage)
    ->orderByNewest()
    ->get();

$maxResults = $query->getResultsNumber();
$maxPage = (int)ceil($maxResults / $perPage);
?>
<div class="listivo-backend-content listivo-app">
    <table class="wp-list-table widefat fixed striped posts listivo-backend-table listivo-backend-table--medium">
        <thead>
        <tr>
            <th class="listivo-backend-table__col listivo-backend-table__col--primary">
                <span><?php esc_html_e('User', 'listivo-core'); ?></span>
            </th>

            <th class="listivo-backend-table__col">
                <span><?php esc_html_e('Subscription', 'listivo-core'); ?></span>
            </th>

            <th class="listivo-backend-table__col listivo-backend-table__col--date">
                <span><?php esc_html_e('Expires', 'listivo-core'); ?></span>
            </th>

            <th class="listivo-backend-table__col">
                <span><?php esc_html_e('Status', 'listivo-core'); ?></span>
            </th>

            <td class="listivo-backend-table__col listivo-backend-table__col--actions">
                <span><?php esc_html_e('Actions', 'listivo-core'); ?></span>
            </td>
        </tr>
        </thead>

        <tbody>
        <?php foreach ($userSubscriptions as $userSubscription) :
            /* @var UserSubscription $userSubscription */
            ?>
            <tr>
                <td class="listivo-backend-table__cell listivo-backend-table__cell--primary">
                    <?php
                    $user = $userSubscription->getUser();
                    if ($user) :?>
                        <a href="<?php echo esc_url($user->getBackendEditUrl()); ?>">
                            <?php echo esc_html($user->getDisplayName()); ?>
                        </a>
                    <?php endif; ?>
                </td>

                <td class="listivo-backend-table__cell">
                    <?php
                    $subscription = $userSubscription->getSubscription();
                    if ($subscription instanceof Subscription) :?>
                        <a href="<?php echo esc_url($subscription->getBackendEditUrl()); ?>">
                            <?php echo esc_html($subscription->getName()); ?>
                        </a>
                    <?php elseif ($subscription instanceof FreeSubscription) : ?>
                        <a href="<?php echo esc_url(admin_url('admin.php?page=listivo_monetization&tab=subscriptions&subscriptions_type=free')); ?>">
                            <?php esc_html_e('Free', 'listivo-core'); ?>
                        </a>
                    <?php endif; ?>
                </td>

                <td class="listivo-backend-table__cell listivo-backend-table__cell--date">
                    <?php if ($userSubscription->getCurrentPeriodEnd()) : ?>
                        <?php echo esc_html($userSubscription->getCurrentPeriodEnd()->format('Y-m-d')); ?>
                    <?php else : ?>
                        <?php esc_html_e('N/A', 'listivo-core'); ?>
                    <?php endif; ?>
                </td>

                <td class="listivo-backend-table__cell">
                    <?php echo esc_html($userSubscription->getStatus()); ?>
                </td>

                <td class="listivo-backend-table__cell listivo-backend-table__cell--actions">
                    <lst-delete-user-subscription
                            request-url="<?php echo esc_url(tdf_action_url('tdf/userSubscription/delete')); ?>"
                            :user-subscription-id="<?php echo esc_attr($userSubscription->getId()); ?>"
                    >
                        <button
                                class="button button-small button-secondary"
                                slot-scope="deleteUserSubscription"
                                @click.stop.prevent="deleteUserSubscription.onDelete"
                        >
                            <?php esc_html_e('Delete', 'listivo-core'); ?>
                        </button>
                    </lst-delete-user-subscription>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($maxPage > 1) : ?>
        <div class="listivo-backend-content__pagination">
            <div class="listivo-backend-pagination">
                <span class="displaying-num"><?php echo esc_html($query->getResultsNumber()) ?> items</span>

                <?php if ($currentPage === 1) : ?>
                    <span class="button disabled">«</span>
                    <span class="button disabled">‹</span>
                <?php else : ?>
                    <a
                            class="button"
                            href="<?php echo esc_url(admin_url('admin.php?page=listivo_monetization&tab=user_subscriptions&pagination=1')); ?>"
                    >
                        <span>«</span>
                    </a>

                    <a
                            class="button"
                            href="<?php echo esc_url(admin_url('admin.php?page=listivo_monetization&tab=user_subscriptions&pagination=' . ($currentPage - 1))); ?>"
                    >
                        <span>‹</span>
                    </a>
                <?php endif; ?>

                <?php echo esc_html($currentPage); ?> of <?php echo esc_html($maxPage); ?>

                <?php if ($maxPage === $currentPage) : ?>
                    <span class="button disabled">›</span>

                    <span class="button disabled">››</span>
                <?php else : ?>
                    <a
                            class="button"
                            href="<?php echo esc_url(admin_url('admin.php?page=listivo_monetization&tab=user_subscriptions&pagination=' . ($currentPage + 1))); ?>"
                    >
                        <span>›</span>
                    </a>

                    <a
                            class="button"
                            href="<?php echo esc_url(admin_url('admin.php?page=listivo_monetization&tab=user_subscriptions&pagination=' . $maxPage)); ?>"
                    >
                        <span>»</span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
