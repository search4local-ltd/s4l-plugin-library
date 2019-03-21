<?php
namespace S4LPluginLibrary;
/**
 * Class Plugin
 *
 * Main Plugin Class
 * @since 1.0
 */
class Plugin {
	/**
	 * Instance
	 * @since 1.0
	 * @access private
	 * @static
	 * @var Plugin The single instacne of the class
	 */
	private static $_instance = null;

	/**
	 * Instance
	 * Ensures only one instance of the class is loaded
	 * @since 1.0
	 * @access public
	 * @return Plugin An instace of the class
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Inlcude widget files
	 *
	 * @since 1.0
	 * @access private
	 */

	 private function include_widgets_files() {
		 require_once( __DIR__ . '/widgets/copyright-text.php' );
		 require_once( __DIR__ . '/widgets/responsive-cta.php' );
	 }

	 /**
		* Register Widgets
		* @since 1.0
		* @access public
		*/
		public function register_widgets() {
			// Safe to include widget files
			$this->include_widgets_files();

			// Register Widgets
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Copyright_Text() );
			\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Widgets\Responsive_CTA() );
		}

		/**
		 * Register Categories
		 * @since 1.0
		 * @access public
		 */
		public function register_categories() {
			\Elementor\Plugin::instance()->elements_manager->add_category(
				's4l-main',
				array( 'title'  => esc_html__( 'Search4Local Main', 's4l-plugin-library' ), ),
				1
			);
		}

		/**
		 * Plugin class constructor
		 * @since 1.0
		 * @access public
		 */
		public function __construct() {
			// Register widgets
			add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
			add_action( 'elementor/init', [ $this, 'register_categories' ], 0 );
		}

}

// Instantiate plugin class
Plugin::instance();