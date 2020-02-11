<?php
/**
 * Set up widgets
 *
 * @package air-light
 */

namespace Air_Light;

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
add_action( 'widgets_init', __NAMESPACE__ . '\widgets_init' );
function widgets_init() {
  register_sidebar( array(
    'name'          => esc_html__( 'Sidebar', THEME_SETTINGS['textdomain'] ),
    'id'            => 'sidebar-1',
    'description'   => esc_html__( 'Add widgets here.', THEME_SETTINGS['textdomain'] ),
    'before_widget' => '<section id="%1$s" class="widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );
} // end widgets_init