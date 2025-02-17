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

if ( ! class_exists( 'PrettyRSS_Admin_Settings' ) ) :
	/**
	 * Class to display and register WordPress settings page and option array
	 */
	class PrettyRSS_Admin_Settings {

		/**
		 * Constructor.
		 *
		 * @since  1.1.0
		 * @access public
		 */
		public function __construct() {
			add_action( 'admin_menu', array( $this, 'add_settings_to_reading' ) );
			add_action( 'admin_init', array( $this, 'register_prettyrss_settings' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_color_picker' ) );
		}

		/**
		 * Register the Pretty RSS Settings within the Reading menu
		 *
		 * @since  2.0.0
		 * @access public
		 * @link   https://developer.wordpress.org/reference/functions/add_settings_section/
		 * @return void
		 **/
		public function add_settings_to_reading() {
			add_settings_section(
				'wp_pretty_feeds',
				__( 'WP Pretty RSS', 'pretty-rss' ),
				array( $this, 'settings_display' ),
				'reading',
			);
		}

		/**
		 * Enqueue Color Picker.
		 * Adds the color picker to the Reading Page in WP-Admin.
		 *
		 * @since  2.0.0
		 * @access public
		 * @link   https://developer.wordpress.org/reference/hooks/admin_enqueue_scripts/
		 * @param string $hook_suffix -- The current admin page.
		 * @return void
		 */
		public function enqueue_color_picker( $hook_suffix ) {
			if ( 'options-reading.php' !== $hook_suffix ) {
				return;
			}
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script(
				'pretty-rss',
				PRETTYRSS_PATH . '/js/pretty-rss.js',
				array( 'wp-color-picker' ),
				PRETTYRSS_VERSION,
				true
			);
		}

		/**
		 * Saves the sanatized data into the prettyrss_settings option.
		 * Also sets the default values for first time saved
		 *
		 * @since  2.0.0
		 * @access public
		 * @link   https://developer.wordpress.org/reference/functions/register_setting/
		 * @return void
		 **/
		public function register_prettyrss_settings() {
			$args = array(
				'type'              => 'array',
				'sanitize_callback' => array( $this, 'validate_prettyrss_settings' ),
				'default'           => array(
					'title'                 => 'RSS Feed Preview',
					'bg_color'              => '#F7F7F7',
					'header_color'          => '#222222',
					'link_color'            => '#388AE8',
					'hover_color'           => '#3D729C',
					'text_color'            => '#222222',
					'site_info_bg_color'    => '#EEEEEE',
					'site_info_text_color'  => '#222222',
					'hide_intro'            => 0,
					'show_about_feeds_link' => 1,
				),
			);
			register_setting( 'prettyrss_settings_group', 'prettyrss_settings', $args );
		}

		/**
		 * Callback to sanatizes the user input before saving the option into the database.
		 *
		 * @since  2.0.0
		 * @access public
		 * @param array $settings The data array from POST object.
		 * @return array
		 */
		public function validate_prettyrss_settings( $settings ) {

			$prettyrss_settings                         = $settings;
			$prettyrss_settings['title']                = sanitize_text_field( $prettyrss_settings['title'] );
			$prettyrss_settings['bg_color']             = sanitize_hex_color( $prettyrss_settings['bg_color'] );
			$prettyrss_settings['header_color']         = sanitize_hex_color( $prettyrss_settings['header_color'] );
			$prettyrss_settings['link_color']           = sanitize_hex_color( $prettyrss_settings['link_color'] );
			$prettyrss_settings['hover_color']          = sanitize_hex_color( $prettyrss_settings['hover_color'] );
			$prettyrss_settings['text_color']           = sanitize_hex_color( $prettyrss_settings['text_color'] );
			$prettyrss_settings['site_info_bg_color']   = sanitize_hex_color( $prettyrss_settings['site_info_bg_color'] );
			$prettyrss_settings['site_info_text_color'] = sanitize_hex_color( $prettyrss_settings['site_info_text_color'] );

			if ( isset( $prettyrss_settings['hide_intro'] ) && 1 === $settings['hide_intro'] ) {
				$prettyrss_settings['hide_intro'] = 1;
			}

			if ( isset( $prettyrss_settings['show_about_feeds_link'] ) && 1 === $prettyrss_settings['show_about_feeds_link'] ) {
				$prettyrss_settings['show_about_feeds_link'] = 1;
			}

			return $prettyrss_settings;
		}

		/**
		 * HTML markup for the options.
		 * Output to the DOM by add_settings_to_reading().
		 *
		 * @since  2.0.0
		 * @access public
		 */
		public function settings_display() {
			$prettyrss_settings    = get_option( 'prettyrss_settings' );
			$hide_intro            = ( isset( $prettyrss_settings['hide_intro'] ) ) ? (bool) $prettyrss_settings['hide_intro'] : 0;
			$show_about_feeds_link = ( isset( $prettyrss_settings['show_about_feeds_link'] ) ) ? (bool) $prettyrss_settings['show_about_feeds_link'] : 0;

			settings_fields( 'prettyrss_settings_group' ); ?>
			<table class="form-table" role="presentation">
				<tbody>
					<tr>
						<th scope="row"><label for="prettyrss_title"><?php esc_html_e( 'RSS Preview Title', 'pretty-rss' ); ?></label></th>
						<td>
							<input name="prettyrss_settings[title]" type="text" id="prettyrss_title" value="<?php echo ( esc_attr( $prettyrss_settings['title'] ) ); ?>" class="regular-text" placeholder="RSS Feed Preview" maxlength="60">
							<p class="description" id="pretty_rss_title_description">
								<?php esc_html_e( 'This is the title shown before the RSS preview.', 'pretty-rss' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="prettyrss_bg_color"><?php esc_html_e( 'Background Color', 'pretty-rss' ); ?></label></th>
						<td>
						<input name="prettyrss_settings[bg_color]" type="text" class="color-field" value="<?php echo ( esc_attr( $prettyrss_settings['bg_color'] ) ); ?>" />
						<p class="description" id="prettyrss_bg_color_description">
								<?php esc_html_e( 'Set the background color.', 'pretty-rss' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="prettyrss_header_color"><?php esc_html_e( 'Header Color', 'pretty-rss' ); ?></label></th>
						<td>
						<input name="prettyrss_settings[header_color]" type="text" class="color-field" value="<?php echo ( esc_attr( $prettyrss_settings['header_color'] ) ); ?>" />
						<p class="description" id="prettyrss_header_color_description">
								<?php esc_html_e( 'Set the header color.', 'pretty-rss' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="prettyrss_text_color"><?php esc_html_e( 'Text Color', 'pretty-rss' ); ?></label></th>
						<td>
						<input name="prettyrss_settings[text_color]" type="text" class="color-field" value="<?php echo ( esc_attr( $prettyrss_settings['text_color'] ) ); ?>" />
						<p class="description" id="prettyrss_text_color_description">
								<?php esc_html_e( 'Set the text color.', 'pretty-rss' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="prettyrss_site_info_background_color"><?php esc_html_e( 'Site Info Background Color', 'pretty-rss' ); ?></label></th>
						<td>
						<input name="prettyrss_settings[site_info_bg_color]" type="text" class="color-field" value="<?php echo ( esc_attr( $prettyrss_settings['site_info_bg_color'] ) ); ?>" />
						<p class="description" id="prettyrss_site_info_bg_color_description">
								<?php esc_html_e( 'Set the background color for the site info section.', 'pretty-rss' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="prettyrss_site_info_text_color"><?php esc_html_e( 'Site Info Text Color', 'pretty-rss' ); ?></label></th>
						<td>
						<input name="prettyrss_settings[site_info_text_color]" type="text" class="color-field" value="<?php echo ( esc_attr( $prettyrss_settings['site_info_text_color'] ) ); ?>" />
						<p class="description" id="prettyrss_site_info_text_color_description">
								<?php esc_html_e( 'Set the text color for the site info section.', 'pretty-rss' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="prettyrss_link_color"><?php esc_html_e( 'Link Color', 'pretty-rss' ); ?></label></th>
						<td>
						<input name="prettyrss_settings[link_color]" type="text" class="color-field" value="<?php echo ( esc_attr( $prettyrss_settings['link_color'] ) ); ?>" />
						<p class="description" id="prettyrss_link_color_description">
								<?php esc_html_e( 'Set the link color.', 'pretty-rss' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><label for="prettyrss_hover_color"><?php esc_html_e( 'Link Hover Color', 'pretty-rss' ); ?></label></th>
						<td>
						<input name="prettyrss_settings[hover_color]" type="text" class="color-field" value="<?php echo ( esc_attr( $prettyrss_settings['hover_color'] ) ); ?>" />
						<p class="description" id="prettyrss_link_hover_color_description">
								<?php esc_html_e( 'Set the link hover color.', 'pretty-rss' ); ?>
							</p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php echo esc_html__( 'Hide Feed Intro', 'pretty-rss' ); ?></th>
						<td>
							<label for="prettyrss_hide_intro">
								<input name="prettyrss_settings[hide_intro]" type="checkbox" id="prettyrss_hide_intro" value="1" <?php checked( $hide_intro, 1 ); ?> >
								<?php esc_html_e( 'If checked, the entire intro heading area will be hidden.', 'pretty-rss' ); ?>
							</label>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php echo esc_html__( 'Show About Feeds Link', 'pretty-rss' ); ?></th>
						<td>
							<label for="prettyrss_show_about_feeds_link">
								<input name="prettyrss_settings[show_about_feeds_link]" type="checkbox" id="prettyrss_show_about_feeds_link" value="1" <?php checked( $show_about_feeds_link, 1 ); ?> >
								<?php
									printf(
										/* translators: Requests unique Domain ID with current site URL  */
										esc_html__( 'If checked, a link to %s will appear in the intro header.', 'pretty-rss' ),
										/* Link and anchor text*/
											sprintf(
												'<a href="%s" target="_blank">%s</a>',
												esc_url( 'https://aboutfeeds.com' ),
												esc_html__( 'About Feeds', 'pretty-rss' )
											)
									);
								?>
							</label>
						</td>
					</tr>
			</table>
			<?php
		} /* end of admin page settings */
	} /* end of class */
	new PrettyRSS_Admin_Settings();
endif;

