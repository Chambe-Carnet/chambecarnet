<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

</div><!-- .site-content -->

<footer id="colophon" class="site-footer" role="contentinfo">
    <?php if (is_active_sidebar('sidebar-2')) : ?>
        <section class="sidebar widget-area" role="complementary">
            <?php dynamic_sidebar('sidebar-2'); ?>
        </section><!-- .sidebar .widget-area -->
    <?php endif; ?>

    <?php if (has_nav_menu('primary')) : ?>
        <nav class="main-navigation" role="navigation"
             aria-label="<?php esc_attr_e('Footer Primary Menu', 'twentysixteen'); ?>">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'menu_class' => 'primary-menu',
            ));
            ?>
        </nav><!-- .main-navigation -->
    <?php endif; ?>

    <?php if (has_nav_menu('social')) : ?>
        <nav class="social-navigation" role="navigation"
             aria-label="<?php esc_attr_e('Footer Social Links Menu', 'twentysixteen'); ?>">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'social',
                'menu_class' => 'social-links-menu',
                'depth' => 1,
                'link_before' => '<span class="screen-reader-text">',
                'link_after' => '</span>',
            ));
            ?>
        </nav><!-- .social-navigation -->
    <?php endif; ?>

    <div class="site-info">
        <?php
        /**
         * Fires before the twentysixteen footer text for footer customization.
         *
         * @since Twenty Sixteen 1.0
         */
        do_action('twentysixteen_credits');
        ?>

        <a href="<?php echo esc_url(home_url('/')); ?>mentions-legales" class="mentions-legales">Mentions Légales</a>
    </div><!-- .site-info -->
</footer><!-- .site-footer -->
</div><!-- .site-inner -->
</div><!-- .site -->

<?php wp_footer(); ?>
<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
            (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-3340785-2', 'auto');
    ga('send', 'pageview');

</script>
</body>
</html>
