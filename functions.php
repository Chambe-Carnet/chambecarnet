<?php
# Ajout des CSS en queue
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );

}

# Enregistrement des différentes sidebars
add_action( 'widgets_init', 'chambecarnet_register_sidebars' );
function chambecarnet_register_sidebars() {
	register_sidebar(
		 array(
			'name'			=> 'Sidebar Home Top',
			'id'            => 'sidebar-4',
			'description' 	=> 'Sidebar Home Top',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
			   )
		 );
	register_sidebar(
		 array(
			'name'			=> 'Sidebar Home Left',
			'id'            => 'sidebar-5',
			'description' 	=> 'Sidebar Home Left',
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
			   )
		 );
}

?>