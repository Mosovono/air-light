<?php
/**
 * Gutenberg related settings
 *
 * @Author: Niku Hietanen
 * @Date: 2020-02-20 13:46:50
 * @Last Modified by:   Roni Laukkarinen
 * @Last Modified time: 2020-06-03 13:08:26
 *
 * @package air-light
 */

namespace Air_Light;

// Enable Gutenberg extra features.
add_theme_support( 'align-wide' );
add_theme_support( 'wp-block-styles' );

/**
 * Restrict blocks to only allowed blocks in the settings
 */
function allowed_block_types( $allowed_blocks, $post ) {
  if ( null !== THEME_SETTINGS['allowed_blocks'] || 'all' === THEME_SETTINGS['allowed_blocks'] ) {
    return $allowed_blocks;
  }

  // Add the default allowed blocks
  $allowed_blocks = null !== THEME_SETTINGS['allowed_blocks']['default'] ? THEME_SETTINGS['allowed_blocks']['default'] : [];

  // If there is post type specific blocks, add them to the allowed blocks list
  if ( null !== THEME_SETTINGS['allowed_blocks'][ get_post_type( $post->post_type ) ] ) {
    $allowed_blocks = array_merge( $allowed_blocks, THEME_SETTINGS['allowed_blocks'][ get_post_type( $post->post_type ) ] );
  }

  return $allowed_blocks;
}

/**
 * Check whether to use classic or block editor for a certain post type as defined in the settings
 */
function use_block_editor_for_post_type( $use_block_editor, $post_type ) {
  if ( in_array( $post_type, THEME_SETTINGS['use_classic_editor'], true ) ) {
    return false;
  }
  return true;
}

/**
 * Register Gutenberg blocks
 */
function register_block_editor_assets() {
  $dependencies = array(
    'wp-blocks',    // Provides useful functions and components for extending the editor
    'wp-i18n',      // Provides localization functions
    'wp-element',   // Provides React.Component
    'wp-components', // Provides many prebuilt components and controls
  );

  wp_register_script( 'block-editor', get_theme_file_uri( 'js/src/block.js', __FILE__ ), $dependencies, null ); // phpcs:ignore
  wp_register_style( 'block-editor', get_theme_file_uri( 'css/gutenberg.min.css', __FILE__ ), null, null ); // phpcs:ignore
}
add_action( 'admin_init', __NAMESPACE__ . '\register_block_editor_assets' );

/**
 * Register Gutenberg wp-admin editor style
 */
function setup_editor_styles() {
  // Add support for editor styles.
  add_theme_support( 'editor-styles' );

  // Enqueue editor styles.
  add_editor_style( get_theme_file_uri( 'css/gutenberg.min.css' ) );
}
add_action( 'after_setup_theme', __NAMESPACE__ . '\setup_editor_styles' );
