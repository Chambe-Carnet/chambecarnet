<?php
/**
 * Compte Rendu Widget Template
 */
if (!defined('ABSPATH')) {
    die('-1');
}

$posts = chambecarnet_get_billets_correles_event_widget();

// Check if any event posts are found.
if ($posts) : ?>
    <section class="billetscorrelesevent-widget widget">
        <h2 class="widget-title">Autour de l'événement</h2>
        <ul class="billets">
		<?php
        // Setup the post data for each event.
        foreach ($posts as $post) :
            setup_postdata($post);
        ?>
            <li>
                
                
                <a class="title" href="<?php echo esc_url(get_permalink()); ?>">
                    <strong>
                        <?php the_title(); ?>
                    </strong>
                </a>
                <?php twentysixteen_excerpt(); ?>
                <a class="img" href="<?php echo esc_url(get_permalink()); ?>">
                    <?php the_post_thumbnail(); ?>
                </a>
            </li>
        <?php
        endforeach;
        ?>
        </ul>
    </section>

<?php
// No posts find
else : 
?>
    <p><?php printf(esc_html__('Aucun article n\'est disponible', 'chambecarnet')); ?></p>
<?php
endif;
