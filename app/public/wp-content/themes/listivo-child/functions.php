<?php


add_action('wp_enqueue_scripts', static function () {
    $deps = [];

    if (class_exists(\Elementor\Plugin::class)) {
        $deps[] = 'elementor-frontend';
    }

    if (is_rtl()) {
        wp_enqueue_style('listivo-rtl', get_template_directory_uri().'/style-rtl.css', $deps, LISTIVO_VERSION);
        wp_enqueue_style('listivo-child', get_stylesheet_directory_uri().'/style.css',
            ['listivo-rtl'], LISTIVO_VERSION);
    } else {
        wp_enqueue_style('listivo', get_template_directory_uri().'/style.css', $deps, LISTIVO_VERSION);
        wp_enqueue_style('listivo-child', get_stylesheet_directory_uri().'/style.css',
            ['listivo'], LISTIVO_VERSION);
    }
});

add_action('after_setup_theme', static function () {
    load_child_theme_textdomain('listivo', get_stylesheet_directory().'/languages');
});

add_action('wp_enqueue_scripts', function() {
    if (is_user_logged_in() && isset($_SERVER['REQUEST_URI']) && strpos($_SERVER['REQUEST_URI'], '/panel/settings') !== false) {
        wp_enqueue_script('viewshop-btn', get_stylesheet_directory_uri() . '/viewshop-btn.js', [], null, true);
        $current_user = wp_get_current_user();
        wp_localize_script('viewshop-btn', 'aumarketUser', [
            'username' => $current_user->user_login
        ]);
    }
});

// 1. Registrar Custom Post Type para salvar buscas
add_action('init', function() {
    register_post_type('saech_save', [
        'label' => 'Buscas Salvas',
        'public' => false,
        'show_ui' => true,
        'supports' => ['title'],
        'capability_type' => 'post',
        'menu_icon' => 'dashicons-search',
    ]);
});

// 2. Handler AJAX para salvar busca
add_action('wp_ajax_save_search_term', function() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Usuário não logado.']);
    }
    $user_id = get_current_user_id();
    $term = isset($_POST['term']) ? sanitize_text_field($_POST['term']) : '';
    if (empty($term)) {
        wp_send_json_error(['message' => 'Termo vazio.']);
    }
    // Salvar como post type personalizado
    $post_id = wp_insert_post([
        'post_type' => 'saech_save',
        'post_title' => $term,
        'post_status' => 'publish',
        'meta_input' => [
            'user_id' => $user_id,
            'termo' => $term,
        ],
    ]);
    if (is_wp_error($post_id)) {
        wp_send_json_error(['message' => 'Erro ao salvar.']);
    }
    wp_send_json_success(['message' => 'Busca salva com sucesso!']);
});

add_action('wp_enqueue_scripts', function() {
    // Enfileirar o JS de save search em todas as páginas
    wp_enqueue_script('save-search', get_stylesheet_directory_uri() . '/save-search.js', [], null, true);
    // Passar variável global para o JS
    wp_localize_script('save-search', 'saveSearchUserLogged', is_user_logged_in());
});
