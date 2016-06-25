<?php
/**
 * List View Single Event
 * This file contains one event in the list view
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list/single-event.php
 *
 * @package TribeEventsCalendar
 *
 */
if (!defined('ABSPATH')) {
    die('-1');
}

// Setup an array of venue details for use later in the template
$venue_details = tribe_get_venue_details();

// Venue
$has_venue_address = (!empty($venue_details['address'])) ? ' location' : '';

// Organizer
$organizer = tribe_get_organizer();

?>

<!-- Event Image -->
<?php echo tribe_event_featured_image(null, 'medium') ?>

<div id="event-content">
    <!-- Event Title -->
    <?php do_action('tribe_events_before_the_event_title') ?>
        <h2 class="tribe-events-list-event-title">
            <a class="tribe-event-url" href="<?php echo esc_url(tribe_get_event_link()); ?>"
               title="<?php the_title_attribute() ?>" rel="bookmark">
                <?php the_title() ?>
            </a>
        </h2>

    <?php
    $event_baseline = get_post_meta(get_the_ID(), 'event_baseline', true);
    if (!empty($event_baseline)) {
        ?>
        <p class="sous-titre"><?php echo $event_baseline; ?></p>
    <?php } ?>

    <?php
    $event_animateur = get_post_meta(get_the_ID(), 'event_animateur', true);
    if (!empty($event_animateur)) {
        ?>
        <span class="intervenant">Animée par <?php echo $event_animateur; ?></span>
    <?php } ?>

    <?php do_action('tribe_events_after_the_event_title') ?>

    <!-- Event Content -->
    <?php do_action('tribe_events_before_the_content') ?>
    <div class="tribe-events-list-event-description tribe-events-content">
        <?php echo tribe_events_get_the_excerpt(null, wp_kses_allowed_html('post')); ?>
    </div><!-- .tribe-events-list-event-description -->
</div>

    
<!-- Event Meta -->
<?php do_action('tribe_events_before_the_meta') ?>
    <div class="tribe-events-event-meta">
        <div class="author <?php echo esc_attr($has_venue_address); ?>">

            <!-- Category -->
            <span class="categorie"><?php echo tribe_get_event_taxonomy() ?></span>

            <!-- Schedule & Recurrence Details -->
            <div class="tribe-event-schedule-details">
                <?php echo tribe_get_start_date(null, false, 'j.m.Y') ?>
            </div>

            <!-- Event Cost -->
            <?php if (tribe_get_cost()) : ?>
                <div class="tribe-events-event-cost">
                    <span><?php echo tribe_get_cost(null, true); ?></span>
                </div>
            <?php endif; ?>

            <?php if ($venue_details) : ?>
                <!-- Venue Display Info -->
                <div class="tribe-events-venue-details">
                    <?php echo implode(' ', $venue_details); ?>
                </div> <!-- .tribe-events-venue-details -->
            <?php endif; ?>

            <?php
            $gmt_offset = ( get_option( 'gmt_offset' ) >= '0' ) ? ' +' . get_option( 'gmt_offset' ) : ' ' . get_option( 'gmt_offset' );
            $gmt_offset = str_replace( array( '.25', '.5', '.75' ), array( ':15', ':30', ':45' ), $gmt_offset );
            if ( strtotime( tribe_get_end_date( $post, false, 'Y-m-d G:i' ) . $gmt_offset ) >= time() ) {
                ?>
                <a class="tribe-event-inscription-url" href="<?php echo esc_url(tribe_get_event_link()) . "#inscriptions"; ?>"
                   title="Inscriptions">
                    Je m'inscris
                </a>
                <?php

            }
            ?>
        </div>
    </div><!-- .tribe-events-event-meta -->
<?php do_action('tribe_events_after_the_meta') ?>

<?php
do_action('tribe_events_after_the_content');
