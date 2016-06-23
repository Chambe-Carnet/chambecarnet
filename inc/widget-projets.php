<?php
/**
 * Countdown Widget Template
 */
if (!defined('ABSPATH')) {
    die('-1');
}

$posts = chambecarnet_get_projets_widget();

// Check if any event posts are found.
if ($posts) : ?>
    <div class="projets-widget">
        <h2 class="widget-title">Derniers projets</h2>
        <?php
        // Setup the post data for each event.
        foreach ($posts as $post) :
            setup_postdata($post);
        ?>
            <div class="projet">
                <a class="title" href="<?php echo esc_url(get_permalink()); ?>">
                    <strong>
                        <?php the_title(); ?>
                    </strong>
                </a>
                
                <a class="excerpt" href="<?php echo esc_url(get_permalink()); ?>">
                    <?php the_excerpt(); ?>
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
    <p><?php printf(esc_html__('Aucun projet n\'est disponible', 'chambecarnet')); ?></p>
<?php
endif;
