<?php
/**
 * Init Class.
 *
 * @package wpx-pp-import-export\Pages
 */

use Inc\Base\PP_IMPORT_EXPORT_WPSPIN_Base_Controller;
use Inc\Base\PP_IMPORT_EXPORT_WPSPIN_Enqueue;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Includes and initialize mount zerin api helper classes.
 */
class PP_IMPORT_EXPORT_WPSPIN_Init {

	/**
	 * Gets mount zerin api helper classes
	 *
	 * @return string[]
	 */
	public static function get_services() {

		require_once PP_IMPORT_EXPORT_WPSPIN_PATH . 'inc/Base/class-pp-wpspin-base-controller.php';
		require_once PP_IMPORT_EXPORT_WPSPIN_PATH . 'inc/Base/class-pp-wpspin-enqueue.php';
		require_once PP_IMPORT_EXPORT_WPSPIN_PATH . 'inc/classes/class-pp-export-wpspin.php';
		require_once PP_IMPORT_EXPORT_WPSPIN_PATH . 'inc/classes/class-pp-import-wpspin.php';


		return array(
			PP_IMPORT_EXPORT_WPSPIN_Base_Controller::class,
			PP_IMPORT_EXPORT_WPSPIN_Enqueue::class,
			PP_EXPORT_WPSPIN::class,
			PP_IMPORT_WPSPIN::class
		);

	}

	/**
	 * Register mount zerin api helper classes.
	 *
	 * @return void
	 */
	public static function register_services() {

		foreach ( self::get_services() as $class ) {
			$service = self::instantiate( $class );
			if ( method_exists( $service, 'register' ) ) {
				$service->register();
			}
		}

	}

	/**
	 * Instantiate mount zerin api helper class.
	 *
	 * @param ClassDeclaration $class Mount Zerin Api Helper class to be instantiated.
	 * @return mixed
	 */
	private static function instantiate( $class ) {
		return new $class();
	}
}
