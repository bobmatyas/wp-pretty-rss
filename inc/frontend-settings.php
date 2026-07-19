<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName -- We don't use core's class naming convention
/**
 * Admin Settings
 *
 * This file registers and outputs the admin page under the Readeing Settings of WP Admin.
 *
 * @package   pretty-rss
 * @author    Brooke.
 * @copyright 2025 Brooke.
 * @license   GPL-3.0-or-later
 */

require_once PRETTYRSS_DIR . '/inc/lib/ArrayToXml.php';
use Spatie\ArrayToXml\ArrayToXml;

$prettyrss_settings = get_option( 'prettyrss_settings' );

$prettyrss_title              = ( ! empty( $prettyrss_settings['title'] ) ) ? $prettyrss_settings['title'] : 'RSS Feed Preview';
$prettyrss_bg_color           = ( ! empty( $prettyrss_settings['bg_color'] ) ) ? $prettyrss_settings['bg_color'] : '#F7F7F7';
$prettyrss_header_color       = ( ! empty( $prettyrss_settings['header_color'] ) ) ? $prettyrss_settings['header_color'] : '#222222';
$prettyrss_link_color         = ( ! empty( $prettyrss_settings['link_color'] ) ) ? $prettyrss_settings['link_color'] : '#388AE8';
$prettyrss_hover_color        = ( ! empty( $prettyrss_settings['hover_color'] ) ) ? $prettyrss_settings['hover_color'] : '#3D729C';
$prettyrss_text_color         = ( ! empty( $prettyrss_settings['text_color'] ) ) ? $prettyrss_settings['text_color'] : '#222222';
$prettyrss_site_info_bg_color = ( ! empty( $prettyrss_settings['site_info_bg_color'] ) ) ? $prettyrss_settings['site_info_bg_color'] : '#EEEEEE';
$prettyrss_site_info_text_color = ( ! empty( $prettyrss_settings['site_info_text_color'] ) ) ? $prettyrss_settings['site_info_text_color'] : '#222222';

$prettyrss_hide_intro            = ( isset( $prettyrss_settings['hide_intro'] ) ) ? 1 : 0;
$prettyrss_show_about_feeds_link = ( isset( $prettyrss_settings['show_about_feeds_link'] ) ) ? 1 : 0;

// Handle if no settings have been saved,
// show intro and about link.
if ( ! $prettyrss_settings ) {
	$prettyrss_show_about_feeds_link = 1;
	$prettyrss_hide_intro            = 0;
}

$prettyrss_xml_settings = array(
	'title'            => sanitize_text_field( $prettyrss_title ),
	'site-icon'        => get_site_icon_url( 64 ),
	'background-color' => sanitize_hex_color( $prettyrss_bg_color ),
	'header-color'     => sanitize_hex_color( $prettyrss_header_color ),
	'link-color'       => sanitize_hex_color( $prettyrss_link_color ),
	'hover-color'      => sanitize_hex_color( $prettyrss_hover_color ),
	'text-color'       => sanitize_hex_color( $prettyrss_text_color ),
	'site-info-bg'     => sanitize_hex_color( $prettyrss_site_info_bg_color ),
	'site-info-text'   => sanitize_hex_color( $prettyrss_site_info_text_color ),
	'feed-url'         => get_feed_link(),
	'hide-intro'       => (int) $prettyrss_hide_intro,
	'about-feed-link'  => (int) $prettyrss_show_about_feeds_link,
);


try {
	$prettyrss_xml = ArrayToXml::convert( $prettyrss_xml_settings, 'settings' );
	echo ( $prettyrss_xml ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- helper class hanles escaping
} catch ( DOMException $e ) {
	return;
}
