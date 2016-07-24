<?php
# Ajout des CSS en queue
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_script('jquery-countdown', get_stylesheet_directory_uri() . '/js/jquery.countdown.min.js', array(), '', true);

}

# Ajout de la font
add_action('wp_print_styles', 'load_fonts');
function load_fonts()
{
    wp_register_style('googleFonts', 'https://fonts.googleapis.com/css?family=Open+Sans:400,700,300');
    wp_enqueue_style('googleFonts');
}

# Enregistrement des différentes sidebars
add_action('widgets_init', 'chambecarnet_register_sidebars');
function chambecarnet_register_sidebars()
{
    register_sidebar(
        array(
            'name' => 'Sidebar Home Top',
            'id' => 'sidebar-4',
            'description' => 'Sidebar Home Top',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
    register_sidebar(
        array(
            'name' => 'Sidebar Home Left',
            'id' => 'sidebar-5',
            'description' => 'Sidebar Home Left',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );

    register_sidebar(
        array(
            'name' => 'Sidebar Asso Top',
            'id' => 'sidebar-6',
            'description' => 'Sidebar Asso Top',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
    register_sidebar(
        array(
            'name' => 'Sidebar Asso Left',
            'id' => 'sidebar-7',
            'description' => 'Sidebar Asso Left',
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
}

/**
 * Custom template tags for this theme.
 */
require get_stylesheet_directory() . '/inc/template-tags.php';

/**
 * widgets
 */
require get_stylesheet_directory() . '/inc/widgets.php';
function register_countdown_widget()
{
    register_widget('Countdown_Event_Widget');
}

add_action('widgets_init', 'register_countdown_widget');

function chambecarnet_get_list_widget_events()
{
    return apply_filters('chambecarnet_get_list_widget_events', Countdown_Event_Widget::$posts);
}

function register_compterendu_widget()
{
    register_widget('Compte_Rendu_Widget');
}

add_action('widgets_init', 'register_compterendu_widget');

function chambecarnet_get_comptes_rendus_widget()
{
    return apply_filters('chambecarnet_get_comptes_rendus_widget', Compte_Rendu_Widget::$posts);
}

function register_projets_widget()
{
    register_widget('Projets_Widget');
}

add_action('widgets_init', 'register_projets_widget');

function chambecarnet_get_projets_widget()
{
    return apply_filters('chambecarnet_get_projets_widget', Projets_Widget::$posts);
}


# Override du script js du plugin pbd-ajax-load-posts
add_action('wp_enqueue_scripts', 'load_posts_ajax');
function load_posts_ajax()
{
    global $wp_query;
    wp_dequeue_script('pbd-alp-load-posts');
    wp_enqueue_script('load-posts', get_stylesheet_directory_uri() . '/js/load-posts.js', array('jquery'), '', true);

    // What page are we on? And what is the pages limit?
    $max = $wp_query->max_num_pages;
    $paged = (get_query_var('paged') > 1) ? get_query_var('paged') : 1;

    // Add some parameters for the JS.
    wp_localize_script(
        'load-posts',
        'pbd_alp',
        array(
            'startPage' => $paged,
            'maxPages' => $max,
            'nextLink' => next_posts($max, false)
        )
    );
}

# Gestion du style de la liste des events
add_action('wp_enqueue_scripts', 'style_list_events');
function style_list_events()
{
    wp_enqueue_script('events', get_stylesheet_directory_uri() . '/js/list-events.js', array(), '', true);

}

add_image_size( 'jobcompany-thumb', 90, 90, false );
set_post_thumbnail_size(1500, 9999);
