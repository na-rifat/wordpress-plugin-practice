<?php
/**
 * Plugin Name:       Advanced plugin
 * Plugin URI:        https://rafalotech.com/advanced-plugin
 * Description:       Advanced plugin functionalities tester
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Nura Alam
 * Author URI:        https://rafalotech.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

namespace WeDevs\Academy;


if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once __DIR__ . '/vendor/autoload.php';
/**
 * The main class
 */
final class weDevs_Academy {
    /**
     * Plugin version
     */
    const version = '1.0';
    /**
     * construct the class
     */
    private function __construct() {
        $this->define_constants();
        register_activation_hook( __FILE__, array( $this, 'activate' ) );

        add_action( 'plugins_loaded', array( $this, 'init_plugin' ) );

    }
    /**
     * initilizes a single instance
     *
     * @return void
     */
    public static function init() {
        static $instance = false;
        if ( !$instance ) {
            $instance = new self();
        }
        return $instance;
    }
    /**
     * Defines usable constants
     *
     * @return void
     */
    public static function define_constants() {
        define( 'WD_ACADEMY_VERSION', self::version );
        define( 'WD_ACADEMY_FILE', __FILE__ );
        define( 'WD_ACADEMY_PATH', __DIR__ );
        define( 'WD_ACADEMY_URL', plugins_url( '', WD_ACADEMY_FILE ) );
        define( 'WP_ACADEMY_ASSETS', WD_ACADEMY_URL . '/assets' );
        define( 'WD_ACADEMY_JS', WP_ACADEMY_ASSETS . '/js' );
        define( 'WD_ACADEMY_CSS', WP_ACADEMY_ASSETS . '/css' );
        define( 'WD_ACADEMY_IMAGES', WP_ACADEMY_ASSETS . '/images' );
    }
    /**
     * Stores current plugin version to database
     *
     * @return void
     */
    public function activate() {
        $installer = new Installer();
        $installer->run();
    }

    /**
     * initializes the plugin
     *
     * @return void
     */
    public function init_plugin() {
        new User();
        new Assets();

        if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
            new Ajax();
        }        

        if ( is_admin() ) {
            new Frontend\Shortcode();
            new Admin();
        } else {
            new Frontend();
        }
    }
}

/**
 * Initializes the main plugin
 *
 * @return void
 */
function wedevs_academy() {
    return weDevs_Academy::init();
}

wedevs_academy();
