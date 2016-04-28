<?php
/**
 * List View Loop
 * This file sets up the structure for the list loop
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/loop.php
 *
 * @package TribeEventsCalendar
 *
 */

if (!defined('ABSPATH')) {
    die('-1');
} ?>

<?php
global $post;
global $more;
$more = false;
?>

<div class="tribe-events-loop">

    <?php while (have_posts()) :
    the_post(); ?>
    <?php do_action('tribe_events_inside_before_loop'); ?>

    <!-- Event  -->
    <?php
    $post_parent = '';
    if ($post->post_parent) {
        $post_parent = ' data-parent-post-id="' . absint($post->post_parent) . '"';
    }
    ?>
    <article id="post-<?php the_ID() ?>" class="<?php tribe_events_event_classes() ?>" <?php echo $post_parent; ?>>
        <div class="evenenemt"><?php tribe_get_template_part('list/single', 'event') ?></div>
       
        <?php
        $tags = wp_get_post_tags($post->ID, array('fields' => 'ids'));
        foreach ($tags as $tag) {
            $args = array(
                'posts_per_page' => 20,
                'exclude' => $post->ID,
                'orderby' => 'date',
                'order' => 'ASC',
                'post_type' => 'post',
                'post_status' => 'publish',
                'tax_query' => array(
                    array(
                        'taxonomy' => 'post_tag',
                        'field' => 'id',
                        'terms' => $tag
                    )
                )
            );
            $associated_posts = get_posts($args);
            if ($associated_posts):
                ?>
                <div class="tribe-events-list-related-content">
                    <?php
                    foreach ($associated_posts as $post) {
                        setup_postdata($post);
                        ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <?php the_title(sprintf('<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url(get_permalink())), '</a></h2>'); ?>
                            <?php the_excerpt(); ?>
                        </article>
                        <?php
                    }
                    wp_reset_postdata();
                    ?>
                </div>
                <?php
            endif;
        }
        ?>
        </article>


<?php do_action('tribe_events_inside_after_loop'); ?>
<?php endwhile; ?>

</div><!-- .tribe-events-loop -->
