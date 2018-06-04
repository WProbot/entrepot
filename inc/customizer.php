<?php
/**
 * Entrepôt Customizer functions.
 *
 * @package Entrepôt\inc
 *
 * @since 1.4.0
 */

/**
 * Registers the Entrepôt alternative source of themes.
 *
 * @since 1.4.0
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function entrepot_customize_register( $wp_customize ) {
	if ( ! is_multisite() ) {
        $wp_customize->add_section(
            new WP_Customize_Themes_Section(
                $wp_customize, 'entrepot_themes', array(
                    'title'       => __( 'Thèmes de l’Entrepôt', 'entrepot' ),
                    'action'      => 'entrepot',
                    'filter_type' => 'remote',
                    'capability'  => 'install_themes',
                    'panel'       => 'themes',
                    'priority'    => 10,
                )
            )
        );
    }
}
add_action( 'customize_register', 'entrepot_customize_register' );

/**
 * Load the Entrepôt Themes into the corresponding Customizer section.
 *
 * @since 1.4.0
 *
 * @param  array $themes List of themes data.
 * @param  array $args   List of the arguments of the themes query.
 * @return array         Populated List of Entrepôt themes data.
 */
function entrepot_load_themes( $themes = array(), $args = array() ) {
    if ( ! isset( $_POST['theme_action'] ) || 'entrepot' !== $_POST['theme_action'] ) {
        return $themes;
    }

    $themes = entrepot_admin_get_theme_repositories_list();

    // No Themes in the Entrepôt, stop!
    if ( ! $themes ) {
        return array();
    }

    return (object) array(
        'info' => array(
            'page'    => 1,
            'pages'   => 1,
            'results' => count( $themes ),
        ),
        'themes' => $themes,
    );
}
add_filter( 'customize_load_themes', 'entrepot_load_themes', 10, 2 );
