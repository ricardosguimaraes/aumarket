<?php
/*
Plugin Name: Inappropriate Words Filter
Description: Blocks or filters inappropriate words in Listivo listings and reviews, including custom fields.
Version: 1.1
Author: Your Name
*/

if (!defined('ABSPATH')) exit;

class Inappropriate_Words_Filter {

    private $option_name = 'inappropriate_words';

    public function __construct() {
        // Admin
        add_action('admin_menu', [$this, 'create_admin_page']);
        add_action('admin_init', [$this, 'register_settings']);

        // Hooks for Listivo post types
        add_action('save_post_listivo_listing', [$this, 'check_post_for_words'], 10, 3);
        add_action('save_post_listivo_review', [$this, 'check_post_for_words'], 10, 3);

        // Filters for output
        add_filter('the_title', [$this, 'filter_text']);
        add_filter('the_content', [$this, 'filter_text']);
        add_filter('get_post_meta', [$this, 'filter_meta'], 10, 4);

        // Enqueue scripts
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

        // AJAX handlers
        add_action('wp_ajax_check_inappropriate_words', [$this, 'ajax_check']);
        add_action('wp_ajax_nopriv_check_inappropriate_words', [$this, 'ajax_check']);
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            'ajax-word-filter',
            plugin_dir_url(__FILE__) . 'assets/js/ajax-filter.js',
            ['jquery'],
            null,
            true
        );
        wp_localize_script('ajax-word-filter', 'WordFilterAjax', [
            'ajax_url' => admin_url('admin-ajax.php')
        ]);
    }

    public function get_word_list() {
        $list = get_option($this->option_name, '');
        return array_filter(array_map('trim', explode(',', strtolower($list))));
    }

    public function filter_text($text) {
        foreach ($this->get_word_list() as $word) {
            if (stripos($text, $word) !== false) {
                $text = preg_replace("/\b{$word}\b/i", str_repeat('*', strlen($word)), $text);
            }
        }
        return $text;
    }

    public function filter_meta($value, $post_id, $key, $single) {
        if (is_array($value)) {
            return array_map([$this, 'filter_text'], $value);
        }
        return $this->filter_text($value);
    }

    public function check_post_for_words($post_ID, $post, $update) {
        $fields = [$post->post_title, $post->post_content];
        $all_meta = get_post_meta($post_ID);
        foreach ($all_meta as $key => $values) {
            foreach ((array)$values as $value) {
                if (!is_array($value) && !is_object($value)) {
                    $fields[] = $value;
                }
            }
        }

        foreach ($fields as $field) {
            foreach ($this->get_word_list() as $word) {
                if (stripos($field, $word) !== false) {
                    wp_die('Error: Your content contains inappropriate words.');
                    exit;
                }
            }
        }
    }

    public function create_admin_page() {
        add_options_page(
            'Inappropriate Words Filter',
            'Inappropriate Words',
            'manage_options',
            'inappropriate-words',
            [$this, 'settings_page']
        );
    }

    public function register_settings() {
        register_setting('inappropriate_words_settings', $this->option_name);
    }

    public function settings_page() {
        include plugin_dir_path(__FILE__) . 'admin/settings-page.php';
    }

    public function ajax_check() {
        $text = sanitize_text_field($_POST['text']);
        $result = $this->filter_text($text);
        echo json_encode(['result' => $result]);
        wp_die();
    }
}

new Inappropriate_Words_Filter();
