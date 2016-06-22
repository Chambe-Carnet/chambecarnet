<?php
// Don't load directly
if ( ! defined( 'ABSPATH' ) ) {
    die( '-1' );
}

?>
<label for="<?php echo esc_attr( $this->get_field_id('nb_items')); ?>"><?php esc_html_e('Choisir le nombre d\'événements à afficher', 'chambecarnet'); ?></label>
<input id="<?php echo esc_attr( $this->get_field_id('nb_items')); ?>" name="<?php echo esc_attr($this->get_field_name('nb_items')); ?>" type="number" value="<?php echo esc_attr($instance['nb_items']); ?>"  />
