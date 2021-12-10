<?php
# Ajout des CSS en queue
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');
function theme_enqueue_styles()
{
    $themeVersion = wp_get_theme()->get('Version');
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
    wp_enqueue_style('twentysixteen-style', get_stylesheet_directory_uri() . '/style.css', array('parent-style'), $themeVersion);
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
    register_sidebar(
        array(
            'name' => 'Sidebar Jobs Left',
            'id' => 'sidebar-8',
            'description' => 'Sidebar Jobs Left',
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


/** widget countdown */
function register_countdown_widget()
{
    register_widget('Countdown_Event_Widget');
}
add_action('widgets_init', 'register_countdown_widget');
function chambecarnet_get_list_widget_events()
{
    return apply_filters('chambecarnet_get_list_widget_events', Countdown_Event_Widget::$posts);
}


/** widget compte rendu */
function register_compterendu_widget()
{
    register_widget('Compte_Rendu_Widget');
}
add_action('widgets_init', 'register_compterendu_widget');
function chambecarnet_get_comptes_rendus_widget()
{
    return apply_filters('chambecarnet_get_comptes_rendus_widget', Compte_Rendu_Widget::$posts);
}


/** widget billets correles */
function register_billetscorrelesevent_widget()
{
    register_widget('Billets_Correles_Event_Widget');
}
add_action('widgets_init', 'register_billetscorrelesevent_widget');
function chambecarnet_get_billets_correles_event_widget()
{
    return apply_filters('chambecarnet_get_billets_correles_event_widget', Billets_Correles_Event_Widget::$posts);
}


/** widget projets */
function register_projets_widget()
{
    register_widget('Projets_Widget');
}
add_action('widgets_init', 'register_projets_widget');
function chambecarnet_get_projets_widget()
{
    return apply_filters('chambecarnet_get_projets_widget', Projets_Widget::$posts);
}


/** widget jobs */
add_action('widgets_init', 'register_jobs_widget');
function register_jobs_widget()
{
    register_widget('Jobs_Widget');
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

add_image_size('jobcompany-thumb', 90, 90, false);
set_post_thumbnail_size(1500, 9999);

#Override de la function qui récupère les événements
/**
 * Trigger is_404 on single event if no events are found
 */
function custom_template_redirect()
{
    global $wp_query;

    // if JS is disabled, then we need to handle tribe bar submissions manually
    if (!empty($_POST['tribe-bar-view']) && !empty($_POST['submit-bar'])) {
        $this->handle_submit_bar_redirect($_POST);
    }
    if ($wp_query->tribe_is_event_query && get_query_var('eventDisplay') == 'single-event' && empty($wp_query->posts)) {
        //Si pas d'événements, on regarde si on trouve un post correspondant
        $args = array(
            'name' => get_query_var('name'),
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 1,
            'caller_get_posts' => 1
        );
        $wp_query = new WP_Query($args);
        if (empty($wp_query->posts)) {
            $wp_query->is_404 = true;
        } else {
            $wp_query->is_404 = false;
            status_header(200);
            global $post;
            $post = $wp_query->posts[0];
            add_filter('wpseo_title', 'custom_seo_title', 20);
            function custom_seo_title()
            {
                global $post;
                return $post->post_title;
            }
        }
    } elseif (get_query_var('name') == 'page' && is_int(get_query_var('page')) && !empty(get_query_var('category_name'))) {
        //Correction du problème de pagination des catégories qui provient du fait que la préfixe des catégories soit un point '.'
        unset($wp_query->query['name']);
        $wp_query->query['paged'] = get_query_var('page');
        unset($wp_query->query['page']);
        $wp_query = new WP_Query($wp_query->query);
        if (empty($wp_query->posts)) {
            $wp_query->is_404 = true;
        }
    }
}

add_action('template_redirect', 'custom_template_redirect', 20);

#Override des fonctions du flux rss des jobs
if (class_exists("WP_Job_Manager_Post_Types")) {
    remove_action('job_feed_item', $post_id);
    $jobsFeed = new WP_Job_Manager_Post_Types();
    function custom_job_feed_item()
    {
        $post_id = get_the_ID();
        $location = get_the_job_location($post_id);
        $job_type = get_the_job_type($post_id);
        $company = get_the_company_name($post_id);

        echo "<description>" . esc_html($location) . " - " . esc_html($company) . " - " . esc_html($job_type->name) . "</description>\n";

        if ($location) {
            echo "<job_listing:location><![CDATA[" . esc_html($location) . "]]></job_listing:location>\n";
        }
        if ($job_type) {
            echo "<job_listing:job_type><![CDATA[" . esc_html($job_type->name) . "]]></job_listing:job_type>\n";
            echo "<content:encoded><![CDATA[" . esc_html($job_type->name) . "]]></content:encoded>\n";
        }
        if ($company) {
            echo "<job_listing:company><![CDATA[" . esc_html($company) . "]]></job_listing:company>\n";
            echo "<dc:creator><![CDATA[" . esc_html($company) . "]]></dc:creator>\n";
        }

        /**
         * Fires at the end of each job RSS feed item.
         *
         * @param int $post_id The post ID of the job.
         */
        do_action('custom_job_feed_item', $post_id, 20);
    }

    function custom_job_feed()
    {
        global $jobsFeed;
        $query_args = array(
            'post_type' => 'job_listing',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => isset($_GET['posts_per_page']) ? absint($_GET['posts_per_page']) : 10,
            'tax_query' => array(),
            'meta_query' => array()
        );

        if (!empty($_GET['search_location'])) {
            $location_meta_keys = array('geolocation_formatted_address', '_job_location', 'geolocation_state_long');
            $location_search = array('relation' => 'OR');
            foreach ($location_meta_keys as $meta_key) {
                $location_search[] = array(
                    'key' => $meta_key,
                    'value' => sanitize_text_field($_GET['search_location']),
                    'compare' => 'like'
                );
            }
            $query_args['meta_query'][] = $location_search;
        }

        if (!empty($_GET['job_types'])) {
            $query_args['tax_query'][] = array(
                'taxonomy' => 'job_listing_type',
                'field' => 'slug',
                'terms' => explode(',', sanitize_text_field($_GET['job_types'])) + array(0)
            );
        }

        if (!empty($_GET['job_categories'])) {
            $cats = explode(',', sanitize_text_field($_GET['job_categories'])) + array(0);
            $field = is_numeric($cats) ? 'term_id' : 'slug';
            $operator = 'all' === get_option('job_manager_category_filter_type', 'all') && sizeof($args['search_categories']) > 1 ? 'AND' : 'IN';
            $query_args['tax_query'][] = array(
                'taxonomy' => 'job_listing_category',
                'field' => $field,
                'terms' => $cats,
                'include_children' => $operator !== 'AND',
                'operator' => $operator
            );
        }

        if ($job_manager_keyword = sanitize_text_field($_GET['search_keywords'])) {
            $query_args['_keyword'] = $job_manager_keyword; // Does nothing but needed for unique hash
            add_filter('posts_clauses', 'get_job_listings_keyword_search');
        }

        if (empty($query_args['meta_query'])) {
            unset($query_args['meta_query']);
        }

        if (empty($query_args['tax_query'])) {
            unset($query_args['tax_query']);
        }

        query_posts(apply_filters('job_feed_args', $query_args));
        add_action('rss2_ns', array($jobsFeed, 'job_feed_namespace'));
        add_action('rss2_item', 'custom_job_feed_item', 20);
        //    do_feed_rss2( false );
        $rss_template = get_stylesheet_directory() . '/feed-job_listing.php';
        load_template($rss_template);
    }

    add_feed('jobs_feed', 'custom_job_feed');
}

function my_custom_rss( $for_comments ) {
        if ( $for_comments )
                load_template( ABSPATH . WPINC . '/feed-rss2-comments.php' );
        else
                load_template( ABSPATH . '/wp-content/themes/chambecarnet/feed-rss2-custom.php' );
}
remove_all_actions( 'do_feed_rss2' );
add_action( 'do_feed_rss2', 'my_custom_rss', 10, 1 );

add_filter( 'tribe_events_add_no_index_meta', '__return_false' );
add_filter( 'wpseo_robots', '__return_false' );
