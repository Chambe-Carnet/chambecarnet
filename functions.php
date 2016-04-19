<?php
# Ajout des CSS en queue
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');

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