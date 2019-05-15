<?php
/**
 * Plugin Name: Search4Local Widget library
 * Description: The offical Search4Local widget library containing various widgets for use on sites.
 * Plugin URI: https://www.search4local.co.uk
 * Version: v1.0.2
 * Author: Search4Local
 * Author URI: https://www.search4local.co.uk
 * Text Domain: s4l-plugin-library
 */

if( ! defined('ABSPATH') ) exit; // Exit if accessed directly

define( 'S4L_PLUGIN_VERSION', '1.0.2' );
define( 'S4L_PLUGIN__FILE__', __FILE__ );
define( 'S4L_PLUGIN_BASE', plugin_basename( S4L_PLUGIN__FILE__ ) );
define( 'S4L_PLUGIN_PATH',  plugin_dir_path( S4L_PLUGIN__FILE__ ));
define( 'S4l_PLUGIN_URL', plugins_url( '/', S4L_PLUGIN__FILE__ ) );
\o;
 /**
	* Main S4L Plugin Library Class
	* The init class that runs the plugin
	*/
	final class S4L_Plugin_Library {
		/**
		 * Plugin Version
		 *
		 * @since 1.0
		 * @var string The plugin version.
		 */
		const VERSION = 'v1.0.2';
		/**
		 * Minimum Elementor Version
		 *
		 * @since 1.0
		 * @var string Minimum Elementor version required to run the plugin.
		 */
		const MINIMUM_ELEMENTOR_VERSION = '2.0.0';
		/**
		 * Minimum PHP Version
		 *
		 * @since 1.0
		 * @var string Minimum PHP version required to run the plugin.
		 */
		const MINIMUM_PHP_VERSION = '7.0';
		/**
		 * Constructor
		 *
		 * @since 1.0
		 * @access public
		 */
		public function __construct() {
			// Load translation
			add_action( 'init', array( $this, 'i18n' ) );
			// Init Plugin
			add_action( 'plugins_loaded', array( $this, 'init' ) );
		}
		/**
		 * Load Textdomain
		 *
		 * Load plugin localization files.
		 * Fired by `init` action hook.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function i18n() {
			load_plugin_textdomain( 's4l-plugin-library' );
		}
		/**
		 * Initialize the plugin
		 *
		 * Validates that Elementor is already loaded.
		 * Checks for basic plugin requirements, if one check fail don't continue,
		 * if all check have passed include the plugin class.
		 *
		 * Fired by `plugins_loaded` action hook.
		 *
		 * @since 1.0
		 * @access public
		 */
		public function init() {

			// Check for updates before anything else.
			if( !class_exists( 'GitHubPluginUpdater' ) ) {
				include_once( plugin_dir_path( __FILE__ ) . 'GitHubPluginUpdater.php' );
			}

			$updater = new GitHubPluginUpdater( __FILE__ );
			$updater->set_username('search4local-ltd');
			$updater->set_repository('s4l-plugin-library');
			$updater->set_authorize('3267451bf4f8a06db3e755ddfb25dc69be83f356');
			$updater->initialize();


			// Check if Elementor installed and activated
			if ( ! did_action( 'elementor/loaded' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_missing_main_plugin' ) );
				return;
			}
			// Check for required Elementor version
			if ( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_minimum_elementor_version' ) );
				return;
			}
			// Check for required PHP version
			if ( version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '<' ) ) {
				add_action( 'admin_notices', array( $this, 'admin_notice_minimum_php_version' ) );
				return;
			}
			// Once we get here, We have passed all validation checks so we can safely include our plugin
			require_once( 'plugin.php' );
		}
		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have Elementor installed or activated.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function admin_notice_missing_main_plugin() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor */
				esc_html__( '"%1$s" requires "%2$s" to be installed and activated.', 's4l-plugin-library' ),
				'<strong>' . esc_html__( 'S4L Widget Library', 's4l-plugin-library' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 's4l-plugin-library' ) . '</strong>'
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}
		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required Elementor version.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function admin_notice_minimum_elementor_version() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			$message = sprintf(
				/* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 's4l_plugin_library' ),
				'<strong>' . esc_html__( 'S4L Widget Library', 's4l_plugin_library' ) . '</strong>',
				'<strong>' . esc_html__( 'Elementor', 's4l_plugin_library' ) . '</strong>',
				self::MINIMUM_ELEMENTOR_VERSION
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}
		/**
		 * Admin notice
		 *
		 * Warning when the site doesn't have a minimum required PHP version.
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function admin_notice_minimum_php_version() {
			if ( isset( $_GET['activate'] ) ) {
				unset( $_GET['activate'] );
			}
			$message = sprintf(
				/* translators: 1: Plugin name 2: PHP 3: Required PHP version */
				esc_html__( '"%1$s" requires "%2$s" version %3$s or greater.', 's4l-plugin-library' ),
				'<strong>' . esc_html__( 'S4L Widget Library', 's4l-plugin-library' ) . '</strong>',
				'<strong>' . esc_html__( 'PHP', 's4l-plugin-library' ) . '</strong>',
				self::MINIMUM_PHP_VERSION
			);
			printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
		}
	}
	// Instantiate S4L_Plugin_Library.
	new S4L_Plugin_Library();
