<?php
/**
 * Deactivate Class.
 *
 * @package wpx-pp-import-export\Base
 */

namespace Inc\Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Deactivate Post/Page import/export with custom fields & taxonomies plugin.
 */
class PP_IMPORT_EXPORT_WPSPIN_Deactivate {

	/**
	 * Deactivate Post/Page import/export with custom fields & taxonomies plugin.
	 *
	 * @return void
	 */
	public static function deactivate() {
		flush_rewrite_rules();
	}

}
