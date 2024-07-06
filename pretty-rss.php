<?php
/**
 * Plugin Name:     Pretty RSS Feeds
 * Description:     Transforms the default in-browser view of the feed to be user-friendly.
 * Author:          Bob Matyas
 * Author URI:      https://www.bobmatyas.com
 * Text Domain:     pretty-rss
 * Domain Path:     /languages
 * Version:         1.0.0
 *
 * @package         Pretty_Rss
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Include Pretty Feed
 * Source: https://github.com/genmon/aboutfeeds/tree/main/tools
 *
 * @return void
 */
function wsd_feed_stylesheet( $feed ) {
	$xsl_url = plugin_dir_url( __FILE__ ) . 'xslt/pretty-feed.xsl';
	echo '<?xml-stylesheet href="'. esc_url( $xsl_url ) .'" type="text/xsl" media="screen" ?>';
}
add_action( 'rss_tag_pre', 'wsd_feed_stylesheet' );

/**
 * Change feed Content-type
 * This is required to render XSLT in browser
 * 
 * @param string $content_type Current Content-type
 * 
 * @return string The new Content-Type
 */
function wsd_feed_content_type( $content_type ) {
	if ( is_feed() ) {
		return 'text/xml';
	}
	return $content_type;
}
add_filter( 'feed_content_type', 'wsd_feed_content_type', 10, 1 );
