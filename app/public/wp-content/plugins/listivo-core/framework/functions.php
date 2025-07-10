<?php

use Elementor\Core\Kits\Documents\Kit;
use Stripe\StripeClient;
use Tangibledesign\Framework\Core\App;
use Tangibledesign\Framework\Core\Collection;
use Tangibledesign\Framework\Core\Settings\Settings;
use Tangibledesign\Framework\Factories\CommentFactory;
use Tangibledesign\Framework\Factories\FieldFactory;
use Tangibledesign\Framework\Factories\ImageFactory;
use Tangibledesign\Framework\Factories\ModelFactory;
use Tangibledesign\Framework\Factories\NotificationFactory;
use Tangibledesign\Framework\Factories\NotificationTaskFactory;
use Tangibledesign\Framework\Factories\OrderFactory;
use Tangibledesign\Framework\Factories\PaymentPackageFactory;
use Tangibledesign\Framework\Factories\PostFactory;
use Tangibledesign\Framework\Factories\ReviewFactory;
use Tangibledesign\Framework\Factories\SubscriptionFactory;
use Tangibledesign\Framework\Factories\TemplateFactory;
use Tangibledesign\Framework\Factories\TemplateTypeFactory;
use Tangibledesign\Framework\Factories\TermFactory;
use Tangibledesign\Framework\Factories\UserFactory;
use Tangibledesign\Framework\Factories\UserPaymentPackageFactory;
use Tangibledesign\Framework\Factories\UserSubscriptionFactory;
use Tangibledesign\Framework\Factories\WooProductFactory;
use Tangibledesign\Framework\Models\Currency;
use Tangibledesign\Framework\Models\Field\AttachmentsField;
use Tangibledesign\Framework\Models\Field\EmbedField;
use Tangibledesign\Framework\Models\Field\Field;
use Tangibledesign\Framework\Models\Field\GalleryField;
use Tangibledesign\Framework\Models\Field\Helpers\SimpleTextValue;
use Tangibledesign\Framework\Models\Field\LinkField;
use Tangibledesign\Framework\Models\Field\LocationField;
use Tangibledesign\Framework\Models\Field\NumberField;
use Tangibledesign\Framework\Models\Field\PriceField;
use Tangibledesign\Framework\Models\Field\RichTextField;
use Tangibledesign\Framework\Models\Field\SalaryField;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use Tangibledesign\Framework\Models\Field\TextField;
use Tangibledesign\Framework\Models\Model;
use Tangibledesign\Framework\Models\Payments\PaymentPackageRepository;
use Tangibledesign\Framework\Models\Payments\Subscription;
use Tangibledesign\Framework\Models\Payments\UserPaymentPackageRepository;
use Tangibledesign\Framework\Models\User\User;
use Tangibledesign\Framework\Queries\QueryAttachments;
use Tangibledesign\Framework\Queries\QueryBlogPosts;
use Tangibledesign\Framework\Queries\QueryFields;
use Tangibledesign\Framework\Queries\QueryImages;
use Tangibledesign\Framework\Queries\QueryModels;
use Tangibledesign\Framework\Queries\QueryNotifications;
use Tangibledesign\Framework\Queries\QueryNotificationTasks;
use Tangibledesign\Framework\Queries\QueryOrders;
use Tangibledesign\Framework\Queries\QueryPages;
use Tangibledesign\Framework\Queries\QueryPaymentPackages;
use Tangibledesign\Framework\Queries\QueryPosts;
use Tangibledesign\Framework\Queries\QueryReviews;
use Tangibledesign\Framework\Queries\QuerySubscriptions;
use Tangibledesign\Framework\Queries\QueryTemplates;
use Tangibledesign\Framework\Queries\QueryTerms;
use Tangibledesign\Framework\Queries\QueryUserPaymentPackages;
use Tangibledesign\Framework\Queries\QueryUsers;
use Tangibledesign\Framework\Queries\QueryUserSubscriptions;

/**
 * @param array $array
 * @return Collection
 */
function tdf_collect(array $array = []): Collection
{
    return new Collection($array);
}

/**
 * @return string
 */
function tdf_prefix(): string
{
    return apply_filters('tdf/prefix', 'tdf');
}

/**
 * @return string
 */
function tdf_short_prefix(): string
{
    return apply_filters('tdf/shortPrefix', 'tdf');
}

/**
 * @param string $key
 * @return string
 */
function tdf_admin_string(string $key): string
{
    return App::getInstance()->get($key . '_admin_string');
}

/**
 * @param string $key
 * @return mixed|null
 */
function tdf_app(string $key)
{
    return App::getInstance()->get($key);
}

function tdf_slug(string $key): string
{
    return App::getInstance()->get($key . '_slug');
}

function tdf_string(string $key): string
{
    return App::getInstance()->get($key . '_string');
}

function tdf_settings(): Settings
{
    return tdf_app('settings');
}

/**
 * @return Collection|Currency[]
 */
function tdf_currencies(): Collection
{
    return tdf_app('currencies');
}

/**
 * @return Currency|false
 */
function tdf_current_currency()
{
    return tdf_app('current_currency');
}

/**
 * @return Collection|Field[]
 */
function tdf_fields(): Collection
{
    return tdf_app('fields');
}

/**
 * @return Collection|Field[]
 */
function tdf_ordered_fields(): Collection
{
    return tdf_app('ordered_fields');
}

/**
 * @return Collection|PriceField[]
 */
function tdf_price_fields(): Collection
{
    return tdf_app('price_fields');
}

/**
 * @return Collection|PriceField[]
 */
function tdf_currency_fields(): Collection
{
    return tdf_fields()->filter(static function ($field) {
        return $field instanceof PriceField || $field instanceof SalaryField;
    });
}

/**
 * @return Collection|EmbedField[]
 */
function tdf_embed_fields(): Collection
{
    return tdf_fields()->filter(static function ($field) {
        return $field instanceof EmbedField;
    });
}

/**
 * @return Collection|NumberField[]
 */
function tdf_number_fields(): Collection
{
    return tdf_app('number_fields');
}

/**
 * @return Collection|TextField[]
 */
function tdf_text_fields(): Collection
{
    return tdf_app('text_fields');

}

/**
 * @return Collection|LinkField[]
 */
function tdf_link_fields(): Collection
{
    return tdf_app('link_fields');
}

/**
 * @return Collection|TextField[]
 */
function tdf_rich_text_fields(): Collection
{
    return tdf_fields()->filter(static function ($field) {
        return $field instanceof RichTextField;
    });
}

/**
 * @return Collection|GalleryField[]
 */
function tdf_gallery_fields(): Collection
{
    return tdf_fields()->filter(static function ($field) {
        return $field instanceof GalleryField;
    });
}

/**
 * @return Collection|AttachmentsField[]
 */
function tdf_attachment_fields(): Collection
{
    return tdf_fields()->filter(static function ($field) {
        return $field instanceof AttachmentsField;
    });
}


/**
 * @return Collection|LocationField[]
 */
function tdf_location_fields(): Collection
{
    return tdf_app('location_fields');
}

/**
 * @return Collection|TaxonomyField[]
 */
function tdf_taxonomy_fields(): Collection
{
    return tdf_app('taxonomy_fields');
}

function tdf_taxonomy_keys(): array
{
    return tdf_app('taxonomy_keys');
}

function tdf_action_url(string $action): string
{
    return admin_url('admin-post.php?action=' . $action);
}

/**
 * @param string $path
 * @param array $params
 */
function tdf_load_view(string $path, array $params = []): void
{
    foreach ($params as $key => $value) {
        ${$key} = $value;
    }

    require tdf_app('path') . 'views/' . $path . '.php';
}

function tdf_subscription_factory(): SubscriptionFactory
{
    return tdf_app('subscription_factory');
}

function tdf_user_subscription_factory(): UserSubscriptionFactory
{
    return tdf_app('user_subscription_factory');
}

function tdf_notification_factory(): NotificationFactory
{
    return tdf_app('notification_factory');
}

function tdf_notification_task_factory(): NotificationTaskFactory
{
    return tdf_app('notification_task_factory');
}

function tdf_term_factory(): TermFactory
{
    return tdf_app('term_factory');
}

function tdf_woo_product_factory(): WooProductFactory
{
    return tdf_app('woo_product_factory');
}

function tdf_model_factory(): ModelFactory
{
    return tdf_app('model_factory');
}

function tdf_query_notifications(): QueryNotifications
{
    return new QueryNotifications();
}

function tdf_query_notification_tasks(): QueryNotificationTasks
{
    return new QueryNotificationTasks();
}

function tdf_query_terms(string $taxonomyKey = ''): QueryTerms
{
    if (!empty($taxonomyKey)) {
        return (new QueryTerms())->setTaxonomy($taxonomyKey);
    }

    return new QueryTerms();
}

function tdf_query_users(): QueryUsers
{
    return new QueryUsers();
}

function tdf_user_factory(): UserFactory
{
    return tdf_app('user_factory');
}

function tdf_template_type_factory(): TemplateTypeFactory
{
    return tdf_app('template_type_factory');
}

function tdf_template_factory(): TemplateFactory
{
    return tdf_app('template_factory');
}

function tdf_field_factory(): FieldFactory
{
    return tdf_app('field_factory');
}

function tdf_payment_package_factory(): PaymentPackageFactory
{
    return tdf_app('payment_package_factory');
}

function tdf_user_payment_package_factory(): UserPaymentPackageFactory
{
    return tdf_app('user_payment_package_factory');
}

function tdf_query_templates(string $type = ''): QueryTemplates
{
    if (!empty($type)) {
        return (new QueryTemplates())->setType($type);
    }

    return new QueryTemplates();
}

function tdf_order_factory(): OrderFactory
{
    return tdf_app('order_factory');
}

/**
 * @return PostFactory
 */
function tdf_post_factory(): PostFactory
{
    return tdf_app('post_factory');
}

function tdf_query_posts(): QueryPosts
{
    return new QueryPosts();
}

function tdf_query_orders(): QueryOrders
{
    return new QueryOrders();
}

function tdf_query_pages(): QueryPages
{
    return new QueryPages();
}

function tdf_query_payment_packages(): QueryPaymentPackages
{
    return new QueryPaymentPackages();
}

function tdf_query_subscriptions(): QuerySubscriptions
{
    return new QuerySubscriptions();
}

function tdf_query_user_subscriptions(): QueryUserSubscriptions
{
    return new QueryUserSubscriptions();
}

function tdf_query_user_payment_packages(): QueryUserPaymentPackages
{
    return new QueryUserPaymentPackages();
}

function tdf_image_factory(): ImageFactory
{
    return tdf_app('image_factory');
}

function tdf_query_reviews(): QueryReviews
{
    return new QueryReviews();
}

function tdf_review_factory(): ReviewFactory
{
    return tdf_app('review_factory');
}

function tdf_pages(): Collection
{
    return tdf_app('pages');
}

function tdf_contact_forms(): Collection
{
    return tdf_app('contact_forms');
}

function tdf_query_blog_posts(): QueryBlogPosts
{
    return new QueryBlogPosts();
}

/**
 * @return CommentFactory
 */
function tdf_comment_factory(): CommentFactory
{
    return tdf_app('comment_factory');
}

function tdf_simple_text_value_fields(): Collection
{
    return tdf_ordered_fields()->filter(static function ($field) {
        return $field instanceof SimpleTextValue;
    });

}

function tdf_filter($value)
{
    return $value;
}

function tdf_query_images(): QueryImages
{
    return new QueryImages();
}

function tdf_query_attachments(): QueryAttachments
{
    return new QueryAttachments();
}

/**
 * @return User|false
 */
function tdf_current_user()
{
    return tdf_app('current_user');
}

function tdf_model_post_type(): string
{
    return tdf_app('model_post_type');
}

function tdf_review_post_type(): string
{
    return tdf_app('review_post_type');
}

function tdf_model_archive_slug(): string
{
    return apply_filters(tdf_prefix() . '/model/archiveSlug', '');
}

function tdf_query_models(): QueryModels
{
    return new QueryModels();
}

function tdf_query_fields(): QueryFields
{
    return new QueryFields();
}

function tdf_payment_packages_repository(): PaymentPackageRepository
{
    return tdf_app('payment_package_repository');
}

function tdf_user_payment_packages_repository(): UserPaymentPackageRepository
{
    return tdf_app('user_payment_package_repository');
}

function tdf_payment_packages(): Collection
{
    return tdf_app('payment_packages');
}

/**
 * @return Collection|Subscription[]
 */
function tdf_subscriptions(): Collection
{
    return tdf_app('subscriptions');
}

function tdf_bumps_payment_packages(): Collection
{
    return tdf_app('bumps_payment_packages');
}

/**
 * @param $date
 * @return string
 */
function tdf_get_hum_date_diff($date): string
{
    $humanTimeDiff = human_time_diff(strtotime($date), current_time('timestamp', 1));
    $ago = tdf_string('ago');

    if (strpos($ago, '%s') === false) {
        return $humanTimeDiff . ' ' . $ago . '2';
    }

    return sprintf($ago, $humanTimeDiff);
}

/**
 * @return Model|false
 */
function tdf_current_model()
{
    return tdf_app('current_model');
}

/**
 * @return Kit|false
 */
function tdf_current_kit()
{
    return tdf_app('current_kit');
}

function tdf_stripe(): StripeClient
{
    return tdf_app('stripe');
}

function tdf_load_icon(string $url): string
{
    $parsedUrl = parse_url($url);
    if (!isset($parsedUrl['path'])) {
        return (string)file_get_contents($url);
    }

    $icon = (string)file_get_contents(ABSPATH . ltrim($parsedUrl['path'], '/'));
    if (!empty($icon)) {
        return $icon;
    }

    return '';
}

function tdf_logout_url(): string
{
    return admin_url('admin-post.php?action=' . tdf_prefix() . '/logout');
}

function tdf_date_diff(string $date): string
{
    try {
        $nowDate = new DateTime();
        $finalDate = new DateTime($date);
    } catch (Exception $e) {
        return '';
    }

    $difference = $nowDate->diff($finalDate);

    if (!$difference) {
        return '';
    }

    if ($difference->days === 1) {
        $daysString = mb_strtolower(tdf_string('day'), 'UTF-8');
    } else {
        $daysString = mb_strtolower(tdf_string('days'), 'UTF-8');
    }

    if ($difference->h === 1) {
        $hoursString = mb_strtolower(tdf_string('hour'), 'UTF-8');
    } else {
        $hoursString = mb_strtolower(tdf_string('hours'), 'UTF-8');
    }

    if ($difference->i === 1) {
        $minutesString = mb_strtolower(tdf_string('minute'), 'UTF-8');
    } else {
        $minutesString = mb_strtolower(tdf_string('minutes'), 'UTF-8');
    }

    if (empty($difference->days) && !empty($difference->h)) {
        return $difference->h . ' ' . $hoursString . ', ' . $difference->i . ' ' . $minutesString;
    }

    if (empty($difference->days)) {
        return $difference->i . ' ' . $minutesString;
    }

    return $difference->days . ' ' . $daysString . ', ' . $difference->h . ' ' . $hoursString;
}

function tdf_render_icon(array $icon): void
{
    if (isset($icon['library']) && $icon['library'] === 'svg' && !empty($icon['value']['url'])) {
        echo tdf_load_icon($icon['value']['url']);
        return;
    }

    if (!empty($icon['value'])) {
        echo '<i class="' . esc_attr($icon['value']) . '"></i>';
    }
}

function tdf_template(string $template, array $args = []): void
{
    get_template_part('templates/' . $template, args: $args);
}

function tdf_partial_template(string $template, array $args = []): void
{
    tdf_template('partials/' . $template, $args);
}

// Shortcode para exibir a Cover Image do usuário
add_shortcode('user_cover_image', function($atts) {
    $atts = shortcode_atts([
        'user_id' => null,
        'size' => 'full',
        'class' => 'user-cover-image',
        'placeholder' => '',
    ], $atts);

    if ($atts['user_id']) {
        $user = tdf_user_factory()->create((int)$atts['user_id']);
    } else {
        // Tenta obter o usuário do perfil público aberto
        $queried = get_queried_object();
        if ($queried instanceof WP_User) {
            $user = tdf_user_factory()->create($queried);
        } else {
            $user = tdf_current_user();
        }
    }
    if (!$user || !method_exists($user, 'getCoverImageUrl')) {
        return '';
    }
    $coverUrl = $user->getCoverImageUrl($atts['size']);
    if (!$coverUrl && $atts['placeholder']) {
        $coverUrl = $atts['placeholder'];
    }
    if (!$coverUrl) {
        return '';
    }
    $alt = esc_attr($user->getDisplayName() ?: 'Cover Image');
    $class = esc_attr($atts['class']);
    return "<img src='{$coverUrl}' alt='{$alt}' class='{$class}' style='width:100%;height:auto;display:block;' />";
});