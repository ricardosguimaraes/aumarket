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

// Shortcode para exibir buscas salvas do usuário logado
add_shortcode('saved-short-code', function() {
    if (!is_user_logged_in()) {
        return '<p>You need to be logged in to view your saved searches.</p>';
    }
    $user_id = get_current_user_id();
    $args = [
        'post_type' => 'saech_save',
        'posts_per_page' => -1,
        'meta_query' => [
            [
                'key' => 'user_id',
                'value' => $user_id,
                'compare' => '='
            ]
        ]
    ];
    $searches = get_posts($args);
    if (!$searches) {
        return '<p>You have no saved searches.</p>';
    }
    ob_start();
    echo '<ul id="saved-search-list">';
    foreach ($searches as $search) {
        $term = esc_html($search->post_title);
        $id = (int)$search->ID;
        echo "<li data-id='$id'>"
            . "<span class='saved-term'>$term</span> "
            . "<button class='delete-saved-search' data-id='$id'>Delete</button>"
            . "</li>";
    }
    echo '</ul>';
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-saved-search').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                if (!confirm('Are you sure you want to delete this search?')) return;
                var id = this.getAttribute('data-id');
                var li = this.closest('li');
                fetch(window.ajaxurl || '/wp-admin/admin-ajax.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'action=delete_saved_search&id=' + encodeURIComponent(id)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        li.remove();
                    } else {
                        alert(data.data && data.data.message ? data.data.message : 'Error deleting.');
                    }
                })
                .catch(() => {
                    alert('Error deleting.');
                });
            });
        });
    });
    </script>
    <?php
    return ob_get_clean();
});

// Handler AJAX para deletar busca salva
add_action('wp_ajax_delete_saved_search', function() {
    if (!is_user_logged_in()) {
        wp_send_json_error(['message' => 'Not logged in.']);
    }
    $user_id = get_current_user_id();
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $post = get_post($id);
    if (!$post || $post->post_type !== 'saech_save') {
        wp_send_json_error(['message' => 'Search not found.']);
    }
    $saved_user_id = get_post_meta($id, 'user_id', true);
    if ($saved_user_id != $user_id) {
        wp_send_json_error(['message' => 'Permission denied.']);
    }
    wp_delete_post($id, true);
    wp_send_json_success(['message' => 'Deleted.']);
});
