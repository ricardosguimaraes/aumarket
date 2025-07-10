<?php

namespace Tangibledesign\Framework\Providers;

use Elementor\Plugin;
use Elementor\Utils;
use Exception;
use Tangibledesign\Framework\Core\Demo;
use Tangibledesign\Framework\Core\ServiceProvider;
use Tangibledesign\Framework\Models\BlogPost;
use Tangibledesign\Framework\Models\Field\TaxonomyField;
use WC_Install;
use WP_Query;

class DemosServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected bool $fullDemo = false;

    /**
     * @return void
     */
    public function initiation(): void
    {
        $this->container['demos'] = static function () {
            return tdf_collect(apply_filters(tdf_prefix() . '/demoImporter/demos', []))->map(static function ($demo) {
                return new Demo($demo);
            });
        };
    }

    public function afterInitiation(): void
    {
        add_action('admin_post_' . tdf_prefix() . '/demoImporter/prepare', [$this, 'prepare']);
        add_action('admin_post_' . tdf_prefix() . '/demoImporter/posts', [$this, 'addPosts']);
        add_action('admin_post_' . tdf_prefix() . '/demoImporter/terms', [$this, 'addTerms']);
        add_action('admin_post_' . tdf_prefix() . '/demoImporter/term_taxonomy', [$this, 'addTermTaxonomy']);
        add_action('admin_post_' . tdf_prefix() . '/demoImporter/term_relationships', [$this, 'addTermRelationships']);
        add_action('admin_post_' . tdf_prefix() . '/demoImporter/term_meta', [$this, 'addTermMeta']);
        add_action('admin_post_' . tdf_prefix() . '/demoImporter/comments', [$this, 'addComments']);
        add_action('admin_post_' . tdf_prefix() . '/demoImporter/options', [$this, 'addOptions']);
        add_action('admin_post_' . tdf_prefix() . '/demoImporter/users', [$this, 'addUsers']);
        add_action('admin_post_' . tdf_prefix() . '/demoImporter/media', [$this, 'addMedia']);
        add_action('admin_post_' . tdf_prefix() . '/demoImporter/cache', [$this, 'reset']);

        add_action('admin_menu', static function () {
            if (!tdf_settings()->showDemoImporter()) {
                return;
            }

            add_menu_page(
                tdf_admin_string('demo_importer'),
                tdf_admin_string('demo_importer'),
                'manage_options',
                tdf_prefix() . '_demo_importer',
                static function () {
                    tdf_load_view('importer/importer');
                },
                'dashicons-migrate',
                2
            );
        });

        add_action('admin_init', [$this, 'refreshTermsCount']);

        add_action('admin_init', static function () {
            $redirect = get_option(tdf_prefix() . '_importer_redirect');
            if (!empty($redirect)) {
                update_option(tdf_prefix() . '_importer_redirect', 0);

                if (!tdf_settings()->showDemoImporter()) {
                    return;
                }

                wp_safe_redirect(admin_url('admin.php?page=' . tdf_prefix() . '_demo_importer'));
                exit;
            }
        });
    }

    public function reset(): void
    {
        $this->clearCache();

        update_option(tdf_prefix() . '_refresh_terms_count', 1);

        tdf_settings()->setDisableDemoImporter(0);
        tdf_settings()->save();

        do_action(tdf_prefix() . '/demoImporter/finished');

        do_action(tdf_prefix() . '/urls/flush');

        if (is_user_logged_in()) {
            tdf_current_user()->setUserSubscription(0);
        }

        $this->fixMenus();
    }

    /** @noinspection SqlNoDataSourceInspection */
    public function prepare(): void
    {
        $this->clearCache();

        update_option(tdf_prefix() . '_status', 'demo_installation');

        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->posts} ");
        $wpdb->query("DELETE FROM {$wpdb->postmeta} ");
        $wpdb->query("DELETE FROM {$wpdb->commentmeta} ");
        $wpdb->query("DELETE FROM {$wpdb->comments} ");
        $wpdb->query("DELETE FROM {$wpdb->terms} ");
        $wpdb->query("DELETE FROM {$wpdb->term_taxonomy} ");
        $wpdb->query("DELETE FROM {$wpdb->term_relationships} ");
        $wpdb->query("DELETE FROM {$wpdb->termmeta} ");
        $wpdb->query("DELETE FROM {$wpdb->users} WHERE ID != 1 AND ID != " . get_current_user_id());
        $wpdb->query("DELETE FROM {$wpdb->usermeta} WHERE user_id != 1 AND user_id != " . get_current_user_id());
    }

    /**
     * @return string
     */
    private function getSourceUrl(): string
    {
        if (!isset($_POST['demoKey'])) {
            return '';
        }

        return apply_filters(tdf_prefix() . '/demoImporter/sourceUrl', '') . '/' . $_POST['demoKey'];
    }

    /**
     * @return string
     */
    private function getDemoUrl(): string
    {
        $demo = $this->getDemo();

        if (!$demo) {
            return '';
        }

        return $demo->getUrl();
    }

    public function addPosts(): void
    {
        if (!isset($_POST['start'], $_POST['limit'], $_POST['demoKey'])) {
            return;
        }

        $start = (int)$_POST['start'];
        $end = (int)$_POST['limit'];

        $posts = get_option(tdf_prefix() . '_demo_posts');
        if (empty($posts)) {
            $file = $this->getSourceUrl() . '/posts.json?time=' . time();
            $posts = $this->getData($file);
            update_option(tdf_prefix() . '_demo_posts', $posts);
        }

        global $wpdb;

        $exclude = [];

        for ($i = $start; $i < $end; $i++) {
            $post = $posts[$i]['post'];
            $post_meta = $posts[$i]['post_meta'];

            if (in_array($post['ID'], $exclude, true)) {
                continue;
            }

            if (!$this->fullDemo) {
                $post['post_author'] = get_current_user_id();
            }

            $wpdb->insert($wpdb->posts, $post);

            if (is_array($post_meta)) {
                foreach ($post_meta as $key => $meta) {
                    if ($meta['meta_key'] === '_menu_item_url' && $post['post_type'] === 'nav_menu_item') {
                        $meta['meta_value'] = str_replace($this->getDemoUrl(), site_url(), $meta['meta_value']);
                    }

                    $check = get_post_meta_by_id($meta['meta_id']);
                    if (!$check) {
                        $wpdb->insert(
                            $wpdb->postmeta,
                            $meta
                        );
                    }
                }
            }
        }
    }

    public function addTerms(): void
    {
        if (isset($_POST['start'], $_POST['limit'])) {
            $start = (int)$_POST['start'];
            $end = (int)$_POST['limit'];

            $terms = get_option(tdf_prefix() . '_demo_terms');
            if (empty($terms)) {
                $file = $this->getSourceUrl() . '/terms.json';
                $terms = $this->getData($file);
                update_option(tdf_prefix() . '_demo_terms', $terms);
            }

            global $wpdb;

            $excluded = [''];

            for ($i = $start; $i < $end; $i++) {
                if (in_array($terms[$i]['term_id'], $excluded, true)) {
                    continue;
                }

                $wpdb->insert($wpdb->terms, $terms[$i]);
            }
        }
    }

    public function addTermTaxonomy(): void
    {
        if (isset($_POST['start'], $_POST['limit'])) {
            $start = (int)$_POST['start'];
            $end = (int)$_POST['limit'];

            $termTaxonomy = get_option(tdf_prefix() . '_demo_term_taxonomy');
            if (empty($termTaxonomy)) {
                $file = $this->getSourceUrl() . '/term_taxonomy.json';
                $termTaxonomy = $this->getData($file);
                update_option(tdf_prefix() . '_demo_term_taxonomy', $termTaxonomy);
            }

            global $wpdb;
            for ($i = $start; $i < $end; $i++) {
                $wpdb->insert($wpdb->term_taxonomy, $termTaxonomy[$i]);
            }
        }
    }

    public function addTermRelationships(): void
    {
        if (isset($_POST['start'], $_POST['limit'])) {
            $start = (int)$_POST['start'];
            $end = (int)$_POST['limit'];

            $termRelationships = get_option(tdf_prefix() . '_demo_term_relationships');
            if (empty($termRelationships)) {
                $file = $this->getSourceUrl() . '/term_relationships.json';
                $termRelationships = $this->getData($file);
                update_option(tdf_prefix() . '_demo_term_relationships', $termRelationships);
            }

            global $wpdb;
            for ($i = $start; $i < $end; $i++) {
                $wpdb->insert($wpdb->term_relationships, $termRelationships[$i]);
            }
        }
    }

    public function addTermMeta(): void
    {
        if (isset($_POST['start'], $_POST['limit'])) {
            $start = (int)$_POST['start'];
            $end = (int)$_POST['limit'];

            $termMeta = get_option(tdf_prefix() . '_demo_term_meta');
            if (empty($termMeta)) {
                $file = $this->getSourceUrl() . '/term_meta.json';
                $termMeta = $this->getData($file);
                update_option(tdf_prefix() . '_demo_term_meta', $termMeta);
            }

            global $wpdb;
            for ($i = $start; $i < $end; $i++) {
                $wpdb->insert($wpdb->termmeta, $termMeta[$i]);
            }
        }
    }

    public function addComments(): void
    {
        if (!$this->fullDemo) {
            return;
        }

        if (isset($_POST['start'], $_POST['limit'])) {
            $start = (int)$_POST['start'];
            $end = (int)$_POST['limit'];
            $file = $this->getSourceUrl() . '/comments.json';
            $comments = $this->getData($file);

            global $wpdb;
            for ($i = $start; $i < $end; $i++) {
                $comment = $comments[$i]['comment'];
                $comment_meta = $comments[$i]['comment_meta'];
                $wpdb->insert($wpdb->comments, $comment);
                if (is_array($comment_meta)) {
                    foreach ($comment_meta as $meta) {
                        $wpdb->insert($wpdb->commentmeta, $meta);
                    }
                }
            }
        }
    }

    /** @noinspection SqlNoDataSourceInspection */
    public function addOptions(): void
    {
        if (isset($_POST['start'], $_POST['limit'])) {
            $start = (int)$_POST['start'];
            $end = (int)$_POST['limit'];
            $file = $this->getSourceUrl() . '/options.json';
            $options = $this->getData($file);

            global $wpdb;
            for ($i = $start; $i < $end; $i++) {
                $option = $options[$i];

                if ($option['option_name'] === 'theme_mods_' . tdf_prefix() . '-child' || $option['option_name'] === 'theme_mods_' . tdf_prefix()) {
                    $theme = get_option('stylesheet');
                    $option['option_name'] = 'theme_mods_' . $theme;
                }

                $wpdb->query("
                    DELETE FROM {$wpdb->options}
                    WHERE option_name = '" . $option['option_name'] . "'
                ");
                $wpdb->insert(
                    $wpdb->options,
                    array(
                        'option_name' => $option['option_name'],
                        'option_value' => $option['option_value'],
                        'autoload' => $option['autoload']
                    )
                );
            }
        }
    }

    public function addUsers(): void
    {
        if (isset($_POST['start'], $_POST['limit'])) {
            $start = (int)$_POST['start'];
            $end = (int)$_POST['limit'];
            $file = $this->getSourceUrl() . '/users.json';
            $users = $this->getData($file);
            $current_user = wp_get_current_user();

            global $wpdb;
            for ($i = $start; $i < $end; $i++) {
                $user = $users[$i]['user'];
                if ($user['user_login'] === 'admin'
                    || $user['ID'] === get_current_user_id()
                    || $user['ID'] === 1
                    || $user['ID'] === '1'
                ) {
                    continue;
                }

                $user['user_pass'] = $current_user->data->user_pass;
                $user_meta = $users[$i]['user_meta'];
                $wpdb->insert($wpdb->users, $user);
                foreach ($user_meta as $meta) {
                    $test = get_metadata_by_mid('user', $meta['umeta_id']);
                    if ($test !== false) {
                        continue;
                    }

                    $wpdb->insert($wpdb->usermeta, $meta);
                    if (strpos($meta['meta_key'], '_capabilities') !== false) {
                        if (strpos($meta['meta_value'], tdf_prefix() . '_user') !== false) {
                            $role = tdf_prefix() . '_user';
                        } elseif (strpos($meta['meta_value'], 'editor') !== false) {
                            $role = 'editor';
                        } elseif (strpos($meta['meta_value'], 'subscriber') !== false) {
                            $role = 'subscriber';
                        }

                        if (isset($role)) {
                            wp_update_user(['ID' => $user['ID'], 'role' => $role]);
                        }
                    }
                }
            }
        }
    }

    /**
     * @return string
     */
    private function getDemoKey(): string
    {
        if (!isset($_POST['demoKey'])) {
            return '';
        }

        return $_POST['demoKey'];
    }

    /**
     * @return Demo|false
     */
    private function getDemo()
    {
        return tdf_app('demos')->find(function ($demo) {
            /* @var Demo $demo */
            return $demo->getKey() === $this->getDemoKey();
        });
    }

    public function addMedia(): void
    {
        $demo = $this->getDemo();
        if (!$demo) {
            return;
        }

        $upload_dir = wp_upload_dir();
        $save_path = $upload_dir['basedir'] . '/';

        if (isset($_POST['start'], $_POST['limit'])) {
            $start = (int)$_POST['start'];
            $end = (int)$_POST['limit'];

            $media = get_option(tdf_prefix() . '_demo_media');
            if (empty($media)) {
                $file = $this->getSourceUrl() . '/media.json';
                $media = $this->getData($file);
                update_option(tdf_prefix() . '_demo_media', $media);
            }

            global $wpdb;
            for ($i = $start; $i < $end; $i++) {
                $attachment = $media[$i]['attachment'];
                $attachment_meta = $media[$i]['attachment_meta'];

                $check = $wpdb->insert($wpdb->posts, $attachment);
                if (!$check) {
                    echo $wpdb->last_error;
                    continue;
                }

                foreach ($attachment_meta as $key => $meta) {
                    if ($meta['meta_key'] === '_wp_attachment_metadata') {
                        $value = unserialize($meta['meta_value']);

                        if (isset($value['sizes'])) {
                            unset($value['sizes']['woocommerce_thumbnail']);
                            unset($value['sizes']['woocommerce_single']);
                            unset($value['sizes']['woocommerce_gallery_thumbnail']);
                            unset($value['sizes']['shop_catalog']);
                            unset($value['sizes']['shop_single']);
                            unset($value['sizes']['shop_thumbnail']);

                            $meta['meta_value'] = serialize($value);

                        }
                    }

                    if ($meta['meta_key'] === '_wp_attached_file') {
                        $name = $save_path . $meta['meta_value'];
                        $source = $demo->getMediaSource() . $meta['meta_value'];

                        $dir = dirname($name);
                        if (!is_dir($dir)) {
                            mkdir($dir, 0777, true);
                        }
                        $response = wp_remote_get($source, [
                            'timeout' => 60
                        ]);

                        if (is_wp_error($response)) {
                            echo $response->get_error_message();
                        }

                        $file = $response['body'];
                        file_put_contents($name, $file);
                        $metadata = wp_generate_attachment_metadata($attachment['ID'], $name);
                        if (!empty($metadata)) {
                            wp_update_attachment_metadata($attachment['ID'], $metadata);
                        }
                    }

                    $check = get_post_meta_by_id($meta['meta_id']);
                    if (!$check) {
                        $wpdb->insert($wpdb->postmeta, $meta);
                    }
                }
            }
        }
    }

    /** @noinspection SqlNoDataSourceInspection */
    public function clearCache(): void
    {
        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%/');
        update_option('rewrite_rules', false);
        $wp_rewrite->flush_rules(true);

        global $wpdb;
        $wpdb->query("DELETE FROM {$wpdb->options} WHERE option_name LIKE '%transient_%' ");

        wp_load_alloptions();
        wp_cache_delete('alloptions', 'options');

        $options = get_option('theme_mods_' . tdf_prefix());
        update_option('theme_mods_' . tdf_prefix(), $options);
        update_option(tdf_prefix() . '_status', '0');
        update_option(tdf_prefix() . '_reset_rewrites', 1);

        update_option(tdf_prefix() . '_demo_posts', '0');
        update_option(tdf_prefix() . '_demo_terms', '0');
        update_option(tdf_prefix() . '_demo_term_taxonomy', '0');
        update_option(tdf_prefix() . '_demo_term_relationships', '0');
        update_option(tdf_prefix() . '_demo_term_meta', '0');
        update_option(tdf_prefix() . '_demo_media', '0');
        update_option(tdf_prefix() . '_demo', '1');

        if (class_exists(WC_Install::class)) {
            WC_Install::create_pages();
        }

        $this->updateContactForms();

//        $kit = Plugin::instance()->kits_manager->get_active_kit_for_frontend();
//        $kit->set_settings('container_width', [
//            'size' => 1428,
//            'unit' => 'px',
//            'sizes' => []
//        ]);
//
//        $kit->set_settings('viewport_md', 900);
//        $kit->set_settings('viewport_lg', 1200);
//        $kit->set_settings('viewport_mobile', 900);
//        $kit->set_settings('viewport_tablet', 1200);
//        $kit->save(['settings' => $kit->get_settings()]);

        $mc = get_option('mc4wp');
        $mc['api_key'] = '';
        update_option('mc4wp', $mc);

        try {
            Utils::replace_urls($this->getDemoUrl(), site_url());
        } catch (Exception $e) {
        }
        Plugin::instance()->files_manager->clear_cache();
    }

    protected function updateContactForms(): void
    {
        $query = new WP_Query([
            'post_type' => 'wpcf7_contact_form',
            'posts_per_page' => -1
        ]);

        if (isset($_SERVER['SERVER_NAME'])) {
            $domain = $_SERVER['SERVER_NAME'];
        } else {
            $domain = 'tangibledesign.net';
        }

        $user = _wp_get_current_user();
        if ($user) {
            $adminMail = $user->user_email;
        } else {
            $adminMail = get_option('admin_email');
        }

        foreach ($query->posts as $post) {
            if ($post->ID === apply_filters(tdf_prefix() . '/contactForm/contactAdminId', 647)) {
                $cf = new BlogPost($post);
                $mail = $cf->getMeta('_mail');
                $mail['sender'] = 'info@' . $domain;
                $mail['recipient'] = $adminMail;
                $cf->setMeta('_mail', $mail);
            } elseif ($post->ID === apply_filters(tdf_prefix() . '/contactForm/contactAdminId', 423)) {
                $cf = new BlogPost($post);
                $mail = $cf->getMeta('_mail');
                $mail['sender'] = 'info@' . $domain;
                $mail['recipient'] = '[_post_author_email]';
                $cf->setMeta('_mail', $mail);
            }
        }
    }

    public function refreshTermsCount(): void
    {

        $check = get_option(tdf_prefix() . '_refresh_terms_count');
        if (empty($check)) {
            return;
        }

        $taxonomies = tdf_taxonomy_fields();
        if ($taxonomies->isEmpty()) {
            return;
        }

        $taxonomies = $taxonomies->map(static function ($taxonomy) {
            /* @var TaxonomyField $taxonomy */
            return $taxonomy->getKey();
        })->values();

        $taxonomies[] = 'category';
        $taxonomies[] = 'post_tag';

        foreach ($taxonomies as $taxonomy) {
            $args = [
                'taxonomy' => $taxonomy,
                'fields' => 'ids',
                'hide_empty' => false,
            ];

            $terms = get_terms($args);
            if (!empty($terms) && is_array($terms)) {
                wp_update_term_count_now($terms, $taxonomy);
            }
        }

        update_option(tdf_prefix() . '_refresh_terms_count', '0');

        do_action(tdf_prefix() . '/demoImporter/checkGalleries');
    }


    /**
     * @param string $url
     * @return mixed
     */
    private function getData(string $url)
    {
        $response = wp_remote_get($url, [
            'timeout' => 60
        ]);

        if (!is_wp_error($response)) {
            return json_decode($response['body'], true);
        }

        if (ini_get('allow_url_fopen')) {
            return json_decode(file_get_contents($url), true);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);

        return json_decode($result, true);
    }

    public function fixMenus(): void
    {
        foreach (wp_get_nav_menus() as $menu) {
            foreach (wp_get_nav_menu_items($menu) as $menuItem) {
                if ('post_type' === $menuItem->type && !get_post($menuItem->object_id)) {
                    wp_update_nav_menu_item($menu->term_id, $menuItem->ID, [
                        'menu-item-object-id' => 0,
                        'menu-item-status' => 'draft'
                    ]);
                }
            }
        }
    }

}