<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<!--
          ...                                                            ..                        ...                                                                 s
   xH88"`~ .x8X      .uef^"                                    . uW8"                       xH88"`~ .x8X                                                          :8
 :8888   .f"8888Hf :d88E                      ..    .     :    `t888                      :8888   .f"8888Hf                .u    .      u.    u.                 .88
:8888>  X8L  ^""`  `888E             u      .888: x888  x888.   8888   .        .u       :8888>  X8L  ^""`        u      .d88B :@8c   x@88k u@88c.      .u      :888ooo
X8888  X888h        888E .z8k     us888u.  ~`8888~'888X`?888f`  9888.z88N    ud8888.     X8888  X888h          us888u.  ="8888f8888r ^"8888""8888"   ud8888.  -*8888888
88888  !88888.      888E~?888L .@88 "8888"   X888  888X '888>   9888  888E :888'8888.    88888  !88888.     .@88 "8888"   4888>'88"    8888  888R  :888'8888.   8888
88888   %88888      888E  888E 9888  9888    X888  888X '888>   9888  888E d888 '88%"    88888   %88888     9888  9888    4888> '      8888  888R  d888 '88%"   8888
88888 '> `8888>     888E  888E 9888  9888    X888  888X '888>   9888  888E 8888.+"       88888 '> `8888>    9888  9888    4888>        8888  888R  8888.+"      8888
`8888L %  ?888   !  888E  888E 9888  9888    X888  888X '888>   9888  888E 8888L         `8888L %  ?888   ! 9888  9888   .d888L .+     8888  888R  8888L       .8888Lu=
 `8888  `-*""   /   888E  888E 9888  9888   "*88%""*88" '888!` .8888  888" '8888c. .+     `8888  `-*""   /  9888  9888   ^"8888*"     "*88*" 8888" '8888c. .+  ^%888*
   "888.      :"   m888N= 888> "888*""888"    `~    "    `"`    `%888*%"    "88888%         "888.      :"   "888*""888"     "Y"         ""   'Y"    "88888%      'Y"
     `""***~"`      `Y"   888   ^Y"   ^Y'                          "`         "YP'            `""***~"`      ^Y"   ^Y'                                "YP'
                         J88"
                         @%
                       :"
  ______                                                                   _                          _                     _
 / _____)                                         _                       | |                        | |                   (_)
| /      ___  ____  ____  _   _ ____   ____ _   _| |_  ____    _ _ _  ____| | _      ____ ____        \ \   ____ _   _ ___  _  ____
| |     / _ \|    \|    \| | | |  _ \ / _  | | | |  _)/ _  )  | | | |/ _  ) || \    / _  )  _ \        \ \ / _  | | | / _ \| |/ _  )
| \____| |_| | | | | | | | |_| | | | ( ( | | |_| | |_( (/ /   | | | ( (/ /| |_) )  ( (/ /| | | |   _____) | ( | |\ V / |_| | ( (/ /
 \______)___/|_|_|_|_|_|_|\____|_| |_|\_||_|\____|\___)____)   \____|\____)____/    \____)_| |_|  (______/ \_||_| \_/ \___/|_|\____)
-->
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php if (is_singular() && pings_open(get_queried_object())) : ?>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
</head>
<?php
$class = '';
$categories = get_the_category();
if (!empty($categories)) {
    foreach ($categories as $categ) {
        $class .= ' ' . $categ->slug;
    }
}
?>
<body <?php body_class($class); ?>>
<div id="page" class="site">
    <div class="site-inner">
        <a class="skip-link screen-reader-text" href="#content"><?php _e('Skip to content', 'twentysixteen'); ?></a>

        <header id="masthead" class="site-header" role="banner">
            <div class="site-header-main">

                <div class="site-branding">
                    <div class="header-image">
                        <?php if (get_header_image()) : ?>
                            <?php
                            /**
                             * Filter the default twentysixteen custom header sizes attribute.
                             *
                             * @since Twenty Sixteen 1.0
                             *
                             * @param string $custom_header_sizes sizes attribute
                             * for Custom Header. Default '(max-width: 709px) 85vw,
                             * (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px'.
                             */
                            $custom_header_sizes = apply_filters('twentysixteen_custom_header_sizes', '(max-width: 709px) 85vw, (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px');
                            ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <img src="<?php header_image(); ?>"
                                     srcset="<?php echo esc_attr(wp_get_attachment_image_srcset(get_custom_header()->attachment_id)); ?>"
                                     sizes="<?php echo esc_attr($custom_header_sizes); ?>"
                                     width="<?php echo esc_attr(get_custom_header()->width); ?>"
                                     height="<?php echo esc_attr(get_custom_header()->height); ?>"
                                     alt="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>">
                            </a>
                        <?php endif; // End header image check. ?>
                        <?php if (is_front_page() && is_home()) : ?>
                            <h1 class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                      rel="home"><?php bloginfo('name'); ?></a></h1>
                        <?php else : ?>
                            <p class="site-title"><a href="<?php echo esc_url(home_url('/')); ?>"
                                                     rel="home"><?php bloginfo('name'); ?></a></p>
                        <?php endif;

                        $description = get_bloginfo('description', 'display');
                        if ($description || is_customize_preview()) : ?>
                            <p class="site-description"><?php echo $description; ?></p>
                        <?php endif; ?>
                    </div><!-- .header-image -->
                </div><!-- .site-branding -->

                <?php if (has_nav_menu('primary') || has_nav_menu('social')) : ?>
                    <button id="menu-toggle" class="menu-toggle"><?php _e('Menu', 'twentysixteen'); ?></button>

                    <div id="site-header-menu" class="site-header-menu">
                        <?php if (has_nav_menu('primary')) : ?>
                            <nav id="site-navigation" class="main-navigation" role="navigation"
                                 aria-label="<?php esc_attr_e('Primary Menu', 'twentysixteen'); ?>">
                                <?php
                                wp_nav_menu(array(
                                    'theme_location' => 'primary',
                                    'menu_class' => 'primary-menu',
                                ));
                                ?>
                            </nav><!-- .main-navigation -->
                        <?php endif; ?>

                        <?php if (has_nav_menu('social')) : ?>
                            <nav id="social-navigation" class="social-navigation" role="navigation"
                                 aria-label="<?php esc_attr_e('Social Links Menu', 'twentysixteen'); ?>">
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
                    </div><!-- .site-header-menu -->
                <?php endif; ?>
            </div><!-- .site-header-main -->

        </header><!-- .site-header -->

        <?php if (is_home() and is_active_sidebar('sidebar-4')) : ?>
            <section id="top" class="sidebar widget-area" role="complementary">
                <?php dynamic_sidebar('sidebar-4'); ?>
            </section><!-- .sidebar .widget-area -->
        <?php endif; ?>

        <?php if (is_category('asso') and is_active_sidebar('sidebar-6')) : ?>
            <section id="top" class="sidebar widget-area" role="complementary">
                <?php dynamic_sidebar('sidebar-6'); ?>
            </section><!-- .sidebar .widget-area -->
        <?php endif; ?>

        <div id="content" class="site-content">
