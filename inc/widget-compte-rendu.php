<?php
/**
 * Countdown Widget Template
 */
if (!defined('ABSPATH')) {
    die('-1');
}

$posts = chambecarnet_get_comptes_rendus_widget();

// Check if any event posts are found.
if ($posts) : ?>
    <div class="compterendu-widget">
        <h2 class="widget-title">Derniers comptes rendus</h2>
        <?php
        // Setup the post data for each event.
        foreach ($posts as $post) :
            setup_postdata($post);
        ?>
            <div class="compterendu">
                <a class="img" href="<?php echo esc_url(get_permalink()); ?>">
                    <?php the_post_thumbnail(); ?>
                </a>
                
                <a class="title" href="<?php echo esc_url(get_permalink()); ?>">
                    <strong>
                        <?php the_title(); ?>
                    </strong>
                </a>
            </div>
        <?php
        endforeach;
        ?>
    </div>

<?php
// No posts find
else : 
?>
    <p><?php printf(esc_html__('Aucun compte rendu n\'est disponible', 'chambecarnet')); ?></p>
<?php
endif;
