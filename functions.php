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