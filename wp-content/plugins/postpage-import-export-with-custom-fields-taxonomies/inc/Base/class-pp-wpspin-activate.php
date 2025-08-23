<?php
/**
 * Activate Class.
 *
 * @package wpx-pp-import-export\Base
 */

namespace Inc\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Activate Post/Page import/export with custom fields & taxonomies plugin.
 */
class PP_IMPORT_EXPORT_WPSPIN_Activate {

	/**
	 * Activate Post/Page import/export with custom fields & taxonomies plugin.
	 *
	 * @return void
	 */
	public static function activate() {
		flush_rewrite_rules();
	}

}
