<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName -- We don't use core's class naming convention
/**
 * Plugin Name:     Pretty RSS Feeds
 * Description:     Transforms the default in-browser view of the feed to be user-friendly.
 * Author:          Bob Matyas
 * Author URI:      https://www.bobmatyas.com
 * Text Domain:     pretty-rss
 * Domain Path:     /languages
 * Version:         2.0.0
 *
 * @package         Pretty_Rss
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * The main PrettyRSS class which includes our other classes and sets things up.
 */
class PrettyRSS {

	/**
	 * Constructor.
	 */
	public function __construct() {
		define( 'PRETTYRSS_FILE', __FILE__ );
		define( 'PRETTYRSS_DIR', trailingslashit( __DIR__ ) );
		define( 'PRETTYRSS_PATH', plugin_dir_url( __FILE__ ) );
		define( 'PRETTYRSS_VERSION', '2.0.0' );

		add_action( 'plugins_loaded', array( $this, 'includes' ) );
		add_action( 'rss_tag_pre', array( $this, 'add_feed_stylesheet' ) );
		add_action( 'parse_request', array( $this, 'add_feed_settings' ) );
		add_filter( 'feed_content_type', array( $this, 'set_feed_content_type' ), 10, 1 );
	}

	/**
	 * Includes.
	 */
	public function includes() {
		include_once PRETTYRSS_DIR . 'inc/admin-settings.php';
	}

	/**
	 * Include XSL Stylesheet in Feed
	 *
	 * @param string $feed Current Content-type.
	 * @return void
	 **/
	public function add_feed_stylesheet( $feed ) {
		$xsl_url = PRETTYRSS_PATH . 'xslt/pretty-feed.xsl';
		echo '<?xml-stylesheet href="' . esc_url( $xsl_url ) . '" type="text/xsl" media="screen" ?>';
	}

	/**
	 * Change feed Content-type
	 * This is required to render XSLT in browser
	 *
	 * @param string $content_type Current Content-type.
	 * @return string The new Content-Type.
	 **/
	public function set_feed_content_type( $content_type ) {
		if ( is_feed() ) {
			return 'text/xml';
		}
		return $content_type;
	}
	/**
	 * Change feed Content-type
	 * This is required to render XSLT in browser
	 *
	 * @param string $wp Current Content-type.
	 * @return void.
	 **/
	public function add_feed_settings( $wp ) {
		$file_path = '';
		if ( isset( $wp->request ) && 'pretty-rss/pretty-rss-settings.xml' === $wp->request ) {
			header( 'Content-Type: application/xhtml+xml; charset=UTF-8' );
			$file_path = PRETTYRSS_DIR . 'inc/frontend-settings.php';
		} else if ( isset( $wp->request ) && 'pretty-rss/pretty-rss.css' === $wp->request ) {
			header( 'Content-Type: text/css; charset=UTF-8' );
			$file_path = PRETTYRSS_DIR . 'css/pretty-rss.css';
		}

		if ( ! empty( $file_path ) && file_exists( $file_path ) ) {
			include $file_path;
			exit;
		}
	}
}
new PrettyRSS();
