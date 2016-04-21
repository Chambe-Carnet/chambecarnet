<?php
/**
 * Countdown Widget Template
 */
if (!defined('ABSPATH')) {
    die('-1');
}

$events_label_plural = tribe_get_event_label_plural();
$events_label_plural_lowercase = tribe_get_event_label_plural_lowercase();

$posts = chambecarnet_get_list_widget_events();

// Check if any event posts are found.
if ($posts) : ?>

    <div class="countdown-widget">
        <?php
        // Setup the post data for each event.
        foreach ($posts as $post) :
            setup_postdata($post);
            ?>

            <span class="compteur"></span>
            <script type="text/javascript">
                (function ($) {
                    $('document').ready(function () {
                        $('.compteur').countdown('<?php echo tribe_get_start_date($post, true, 'Y/m/d H:i:s') ?>', function (event) {
                            $(this).html(event.strftime('%DJ - %HH - %MM - %SS'));
                        });
                    });
                })(jQuery);
            </script>


            <span class="categorie"><?php echo tribe_get_event_taxonomy() ?></span>
            <!-- Event Title -->
            <strong class="tribe-event-title">
                <a href="<?php echo esc_url(tribe_get_event_link()); ?>" rel="bookmark"><?php the_title(); ?></a>
            </strong>

            <p class="sous-titre">Ici la baseline de l'événement</p>

            <span class="intervenant">Animée par Robert</span>

            <a class="inscription" href="<?php echo esc_url(tribe_get_event_link()); ?>" rel="bookmark">Je m'inscris</a>
            <?php
        endforeach;
        ?>
    </div><!-- .tribe-list-widget -->

    <?php
// No events were found.
else : ?>
    <p><?php printf(esc_html__('There are no upcoming %s at this time.', 'the-events-calendar'), $events_label_plural_lowercase); ?></p>
    <?php
endif;
