<?php
/**
 * Plugin Name:           AutomatorWP - WP PostRatings integration
 * Plugin URI:            https://automatorwp.com/add-ons/wp-postratings/
 * Description:           Connect AutomatorWP with WP PostRatings.
 * Version:               1.0.0
 * Author:                AutomatorWP
 * Author URI:            https://automatorwp.com/
 * Text Domain:           automatorwp-wp-postratings-integration
 * Domain Path:           /languages/
 * Requires at least:     4.4
 * Tested up to:          5.7
 * License:               GNU AGPL v3.0 (http://www.gnu.org/licenses/agpl.txt)
 *
 * @package               AutomatorWP\WP_PostRatings
 * @author                AutomatorWP
 * @copyright             Copyright (c) AutomatorWP
 */

final class AutomatorWP_Integration_WP_PostRatings {

    /**
     * @var         AutomatorWP_Integration_WP_PostRatings $instance The one true AutomatorWP_Integration_WP_PostRatings
     * @since       1.0.0
     */
    private static $instance;

    /**
     * Get active instance
     *
     * @access      public
     * @since       1.0.0
     * @return      AutomatorWP_Integration_WP_PostRatings self::$instance The one true AutomatorWP_Integration_WP_PostRatings
     */
    public static function instance() {
        if( !self::$instance ) {
            self::$instance = new AutomatorWP_Integration_WP_PostRatings();

            if( ! self::$instance->pro_installed() ) {

                self::$instance->constants();
                self::$instance->includes();
                
            }

            self::$instance->hooks();
        }

        return self::$instance;
    }

    /**
     * Setup plugin constants
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function constants() {
        // Plugin version
        define( 'AUTOMATORWP_WP_POSTRATINGS_VER', '1.0.0' );

        // Plugin file
        define( 'AUTOMATORWP_WP_POSTRATINGS_FILE', __FILE__ );

        // Plugin path
        define( 'AUTOMATORWP_WP_POSTRATINGS_DIR', plugin_dir_path( __FILE__ ) );

        // Plugin URL
        define( 'AUTOMATORWP_WP_POSTRATINGS_URL', plugin_dir_url( __FILE__ ) );
    }

    /**
     * Include plugin files
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function includes() {

        if( $this->meets_requirements() ) {

            // Triggers
            require_once AUTOMATORWP_WP_POSTRATINGS_DIR . 'includes/triggers/rate-post.php';

        }
    }

    /**
     * Setup plugin hooks
     *
     * @access      private
     * @since       1.0.0
     * @return      void
     */
    private function hooks() {

        add_action( 'automatorwp_init', array( $this, 'register_integration' ) );
        
    }

    /**
     * Registers this integration
     *
     * @since 1.0.0
     */
    function register_integration() {

        automatorwp_register_integration( 'wp_postratings', array(
            'label' => 'WP PostRatings',
            'icon'  => plugin_dir_url( __FILE__ ) . 'assets/wp-postratings.svg',
        ) );

    }

    /**
     * Check if there are all plugin requirements
     *
     * @since  1.0.0
     *
     * @return bool True if installation meets all requirements
     */
    private function meets_requirements() {

        if ( ! class_exists( 'AutomatorWP' ) ) {
            return false;
        }

        if ( ! function_exists( 'postratings_init' ) ) {
            return false;
        }

        return true;

    }

    /**
     * Check if the pro version of this integration is installed
     *
     * @since  1.0.0
     *
     * @return bool True if pro version installed
     */
    private function pro_installed() {

        if ( ! class_exists( 'AutomatorWP_WP_PostRatings' ) ) {
            return false;
        }

        return true;

    }

}

/**
 * The main function responsible for returning the one true AutomatorWP_Integration_WP_PostRatings instance to functions everywhere
 *
 * @since       1.0.0
 * @return      \AutomatorWP_Integration_WP_PostRatings The one true AutomatorWP_Integration_WP_PostRatings
 */
function AutomatorWP_Integration_WP_PostRatings() {
    return AutomatorWP_Integration_WP_PostRatings::instance();
}
add_action( 'automatorwp_pre_init', 'AutomatorWP_Integration_WP_PostRatings' );
