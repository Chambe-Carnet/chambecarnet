<?php
/**
 * Created by PhpStorm.
 * User: jseb
 * Date: 19/04/2016
 * Time: 12:55
 */

// Don't load directly
if (!defined('ABSPATH')) {
    die('-1');
}

class Countdown_Event_Widget extends WP_Widget
{

    private static $limit = 1;
    public static $posts = array();

    /**
     * Allows widgets extending this one to pass through their own unique name, ID base etc.
     *
     * @param string $id_base
     * @param string $name
     * @param array $widget_options
     * @param array $control_options
     */
    public function __construct($id_base = '', $name = '', $widget_options = array(), $control_options = array())
    {
        $widget_options = array_merge(
            array(
                'classname' => 'countdown-event-widget',
                'description' => esc_html__('A widget that displays  countdown to the next event.', 'chambecarnet'),
            ),
            $widget_options
        );

        $control_options = array_merge(array('id_base' => 'countdown-event-widget'), $control_options);

        $id_base = empty($id_base) ? 'countdown-event-widget' : $id_base;
        $name = empty($name) ? esc_html__('Countdown Event', 'chambecarnet') : $name;

        parent::__construct($id_base, $name, $widget_options, $control_options);
    }

    /**
     * The main widget output function.
     *
     * @param array $args
     * @param array $instance
     *
     * @return string The widget output (html).
     */
    public function widget($args, $instance)
    {
        return $this->widget_output($args, $instance);
    }

    /**
     * The main widget output function (called by the class's widget() function).
     *
     * @param array $args
     * @param array $instance
     * @param string $template_name The template name.
     * @param string $subfolder The subfolder where the template can be found.
     * @param string $namespace The namespace for the widget template stuff.
     * @param string $pluginPath The pluginpath so we can locate the template stuff.
     * @return string
     */
    public function widget_output($args, $instance, $template_name = '/inc/widget-countdown.php')
    {
        global $wp_query, $tribe_ecp, $post;

        $instance = wp_parse_args(
            $instance, array(
                'limit' => 1,
                'title' => '',
            )
        );

        /**
         * @var $after_title
         * @var $after_widget
         * @var $before_title
         * @var $before_widget
         * @var $limit
         * @var $no_upcoming_events
         * @var $title
         */
        extract($args, EXTR_SKIP);
        extract($instance, EXTR_SKIP);

        // Temporarily unset the tribe bar params so they don't apply
        $hold_tribe_bar_args = array();
        foreach ($_REQUEST as $key => $value) {
            if ($value && strpos($key, 'tribe-bar-') === 0) {
                $hold_tribe_bar_args[$key] = $value;
                unset($_REQUEST[$key]);
            }
        }

        $title = apply_filters('widget_title', $title);

        self::$limit = absint($limit);

        if (!function_exists('tribe_get_events')) {
            return 'coucou';
        }

        self::$posts = tribe_get_events(
            apply_filters(
                'tribe_events_list_widget_query_args', array(
                    'eventDisplay' => 'list',
                    'posts_per_page' => self::$limit,
                    'tribe_render_context' => 'widget',
                )
            )
        );

        // If no posts, and the don't show if no posts checked, let's bail
        if (empty(self::$posts) && $no_upcoming_events) {
            return 'pouet';
        }

        echo $before_widget;
        do_action('tribe_events_before_list_widget');

        if ($title) {
            do_action('tribe_events_list_widget_before_the_title');
            echo $before_title . $title . $after_title;
            do_action('tribe_events_list_widget_after_the_title');
        }

        // Include template file
        include(get_stylesheet_directory() . $template_name);
        do_action('tribe_events_after_list_widget');

        echo $after_widget;
        wp_reset_query();

        // Reinstate the tribe bar params
        if (!empty($hold_tribe_bar_args)) {
            foreach ($hold_tribe_bar_args as $key => $value) {
                $_REQUEST[$key] = $value;
            }
        }
    }

    /**
     * The function for saving widget updates in the admin section.
     *
     * @param array $new_instance
     * @param array $old_instance
     *
     * @return array The new widget settings.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $new_instance = $this->default_instance_args($new_instance);

        /* Strip tags (if needed) and update the widget settings. */
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['no_upcoming_events'] = $new_instance['no_upcoming_events'];

        return $instance;
    }

    /**
     * Output the admin form for the widget.
     *
     * @param array $instance
     *
     * @return string The output for the admin widget form.
     */
    public function form($instance)
    {
        include(get_stylesheet_directory() . '/inc/widget-countdown-admin.php');
    }

    /**
     * Accepts and returns the widget's instance array - ensuring any missing
     * elements are generated and set to their default value.
     *
     * @param array $instance
     *
     * @return array
     */
    protected function default_instance_args(array $instance)
    {
        return wp_parse_args($instance, array(
            'title' => esc_html__('Upcoming Events', 'the-events-calendar'),
            'no_upcoming_events' => false,
        ));
    }
}

class Compte_Rendu_Widget extends WP_Widget
{
    public static $posts = array();

    /**
     * Allows widgets extending this one to pass through their own unique name, ID base etc.
     *
     * @param string $id_base
     * @param string $name
     * @param array $widget_options
     * @param array $control_options
     */
    public function __construct($id_base = '', $name = '', $widget_options = array(), $control_options = array())
    {
        $widget_options = array_merge(
            array(
                'classname' => 'compte-rendu-widget',
                'description' => esc_html__('A widget that displays one or more \'Comptes Rendus\'', 'chambecarnet'),
            ),
            $widget_options
        );

        $control_options = array_merge(array('id_base' => 'compte-rendu-widget'), $control_options);

        $id_base = empty($id_base) ? 'compte-rendu-widget' : $id_base;
        $name = empty($name) ? esc_html__('Comptes Rendus', 'chambecarnet') : $name;

        parent::__construct($id_base, $name, $widget_options, $control_options);
    }

    /**
     * The main widget output function.
     *
     * @param array $args
     * @param array $instance
     *
     * @return string The widget output (html).
     */
    public function widget($args, $instance)
    {
        return $this->widget_output($args, $instance);
    }

    /**
     * The main widget output function (called by the class's widget() function).
     *
     * @param array $args
     * @param array $instance
     * @param string $template_name The template name.
     * @param string $subfolder The subfolder where the template can be found.
     * @param string $namespace The namespace for the widget template stuff.
     * @param string $pluginPath The pluginpath so we can locate the template stuff.
     * @return string
     */
    public function widget_output($args, $instance, $template_name = '/inc/widget-compte-rendu.php')
    {
        global $wp_query, $tribe_ecp, $post;

        $title = apply_filters('widget_title', $title);

        $args = array(
            'orderby' => 'date',
            'order' => 'DESC',
            'post_type' => 'post',
            'post_status' => 'publish',
            'numberposts' => $instance['nb_items'],
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_tag',
                    'field' => 'id',
                    'terms' => '163' # id du tag "compte rendu"
                )
            )
        );

        self::$posts = get_posts($args);
        // If no posts, and the don't show if no posts checked, let's bail
        if (empty(self::$posts) || empty($instance['nb_items'])) {
            return 'pouet';
        }

        // Include template file
        include(get_stylesheet_directory() . $template_name);

        wp_reset_query();

    }

    /**
     * The function for saving widget updates in the admin section.
     *
     * @param array $new_instance
     * @param array $old_instance
     *
     * @return array The new widget settings.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $new_instance = $this->default_instance_args($new_instance);

        /* Strip tags (if needed) and update the widget settings. */
        $instance['nb_items'] = $new_instance['nb_items'];

        return $instance;
    }

    /**
     * Output the admin form for the widget.
     *
     * @param array $instance
     *
     * @return string The output for the admin widget form.
     */
    public function form($instance)
    {
        include(get_stylesheet_directory() . '/inc/widget-compte-rendu-admin.php');
    }

    /**
     * Accepts and returns the widget's instance array - ensuring any missing
     * elements are generated and set to their default value.
     *
     * @param array $instance
     *
     * @return array
     */
    protected function default_instance_args(array $instance)
    {
        return wp_parse_args($instance, array(
            'title' => esc_html__('Derniers comptes rendus', 'chambecarnet'),
            'nb_items' => 1,
        ));
    }
}

class Projets_Widget extends WP_Widget
{
    public static $posts = array();

    /**
     * Allows widgets extending this one to pass through their own unique name, ID base etc.
     *
     * @param string $id_base
     * @param string $name
     * @param array $widget_options
     * @param array $control_options
     */
    public function __construct($id_base = '', $name = '', $widget_options = array(), $control_options = array())
    {
        $widget_options = array_merge(
            array(
                'classname' => 'projets-widget',
                'description' => esc_html__('A widget that displays one or more \'Projets\' Page', 'chambecarnet'),
            ),
            $widget_options
        );

        $control_options = array_merge(array('id_base' => 'projets-widget'), $control_options);

        $id_base = empty($id_base) ? 'projets-widget' : $id_base;
        $name = empty($name) ? esc_html__('Projets', 'chambecarnet') : $name;

        parent::__construct($id_base, $name, $widget_options, $control_options);
    }

    /**
     * The main widget output function.
     *
     * @param array $args
     * @param array $instance
     *
     * @return string The widget output (html).
     */
    public function widget($args, $instance)
    {
        return $this->widget_output($args, $instance);
    }

    /**
     * The main widget output function (called by the class's widget() function).
     *
     * @param array $args
     * @param array $instance
     * @param string $template_name The template name.
     * @param string $subfolder The subfolder where the template can be found.
     * @param string $namespace The namespace for the widget template stuff.
     * @param string $pluginPath The pluginpath so we can locate the template stuff.
     * @return string
     */
    public function widget_output($args, $instance, $template_name = '/inc/widget-projets.php')
    {
        global $wp_query, $tribe_ecp, $post;

        $args = array(
            'meta_key' => '_wp_page_template',
            'meta_value' => 'page-projet.php'
        );

        self::$posts = get_pages($args);
        // If no posts, and the don't show if no posts checked, let's bail
        if (empty(self::$posts) || empty($instance['nb_items'])) {
            return 'pouet';
        }

        // Include template file
        include(get_stylesheet_directory() . $template_name);

        wp_reset_query();

    }

    /**
     * The function for saving widget updates in the admin section.
     *
     * @param array $new_instance
     * @param array $old_instance
     *
     * @return array The new widget settings.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $new_instance = $this->default_instance_args($new_instance);

        /* Strip tags (if needed) and update the widget settings. */
        $instance['nb_items'] = $new_instance['nb_items'];

        return $instance;
    }

    /**
     * Output the admin form for the widget.
     *
     * @param array $instance
     *
     * @return string The output for the admin widget form.
     */
    public function form($instance)
    {
        include(get_stylesheet_directory() . '/inc/widget-projets-admin.php');
    }

    /**
     * Accepts and returns the widget's instance array - ensuring any missing
     * elements are generated and set to their default value.
     *
     * @param array $instance
     *
     * @return array
     */
    protected function default_instance_args(array $instance)
    {
        return wp_parse_args($instance, array(
            'title' => esc_html__('Derniers projets', 'chambecarnet'),
            'nb_items' => 1,
        ));
    }
}


class Jobs_Widget extends WP_Widget
{
    public static $posts = array();

    /**
     * Allows widgets extending this one to pass through their own unique name, ID base etc.
     *
     * @param string $id_base
     * @param string $name
     * @param array $widget_options
     * @param array $control_options
     */
    public function __construct($id_base = '', $name = '', $widget_options = array(), $control_options = array())
    {
        $widget_options = array_merge(
            array(
                'classname' => 'jobs-widget',
                'description' => esc_html__('A widget that displays links for Jobs', 'chambecarnet'),
            ),
            $widget_options
        );

        $control_options = array_merge(array('id_base' => 'jobs-widget'), $control_options);

        $id_base = empty($id_base) ? 'jobs-widget' : $id_base;
        $name = empty($name) ? esc_html__('Jobs', 'chambecarnet') : $name;

        parent::__construct($id_base, $name, $widget_options, $control_options);
    }

    /**
     * The main widget output function.
     *
     * @param array $args
     * @param array $instance
     *
     * @return string The widget output (html).
     */
    public function widget($args, $instance)
    {
        return $this->widget_output($args, $instance);
    }

    /**
     * The main widget output function (called by the class's widget() function).
     *
     * @param array $args
     * @param array $instance
     * @param string $template_name The template name.
     * @param string $subfolder The subfolder where the template can be found.
     * @param string $namespace The namespace for the widget template stuff.
     * @param string $pluginPath The pluginpath so we can locate the template stuff.
     * @return string
     */
    public function widget_output($args, $instance, $template_name = '/inc/widget-jobs.php')
    {

        // Include template file
        include(get_stylesheet_directory() . $template_name);

    }

    /**
     * The function for saving widget updates in the admin section.
     *
     * @param array $new_instance
     * @param array $old_instance
     *
     * @return array The new widget settings.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $new_instance = $this->default_instance_args($new_instance);

        return $instance;
    }

    /**
     * Output the admin form for the widget.
     *
     * @param array $instance
     *
     * @return string The output for the admin widget form.
     */
    public function form($instance)
    {
        include(get_stylesheet_directory() . '/inc/widget-jobs-admin.php');
    }

    /**
     * Accepts and returns the widget's instance array - ensuring any missing
     * elements are generated and set to their default value.
     *
     * @param array $instance
     *
     * @return array
     */
    protected function default_instance_args(array $instance)
    {
        return wp_parse_args($instance, array(
            'title' => esc_html__('Jobs', 'chambecarnet'),
        ));
    }
}
