<?php
/**
 * Enqueue Class.
 *
 * @package wpx-pp-import-export\Base
 */

namespace Inc\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue Post/Page import/export with custom fields & taxonomies styles and scripts.
 */
class PP_IMPORT_EXPORT_WPSPIN_Enqueue extends PP_IMPORT_EXPORT_WPSPIN_Base_Controller {

	/**
	 * Registers Post/Page import/export with custom fields & taxonomies styles and scripts.
	 *
	 * @return void
	 */
	public function register() {
		add_action( 'admin_enqueue_scripts', array( $this, '_pp_wpspin_include_js_css' ) );
	}

	/**
	 * Enqueue Post/Page import/export with custom fields & taxonomies styles and scripts.
	 *
	 * @return void
	 */
	public function _pp_wpspin_include_js_css() {
		wp_enqueue_style( 'pp_wpspin_css', $this->plugin_url . 'assets/css/pp_wpspin_custom_style.css', array(), '1.0.0' );
		wp_enqueue_script( 'pp_wpspin_js', $this->plugin_url . '/assets/js/pp_wpspin_custom.js', array( 'jquery' ), '1.0.0', true );
		$this->local_scripts();
	}

	/**
	 * Enqueue Post/Page import/export with custom fields & taxonomies local scripts.
	 *
	 * @return void
	 */
	public function local_scripts() {

		wp_localize_script(
			'pp_wpspin_js',
			'pp_wpspin_ajax',
			array(
				'ajax_url'       => admin_url( 'admin-ajax.php' ),
				'siteurl'        => site_url(),
				'security_nonce' => wp_create_nonce( 'pp_wpspin_ajax-nonce' ),
				'userId'         => get_current_user_id(),
				'userRoles'      => (array) wp_get_current_user()->roles,
			)
		);

	}

}
