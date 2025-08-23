<?php
/**
 * Export functions
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    wpx-pp-import-export
 * @subpackage wpx-pp-import-export/classes
 */
// require 'class-pp-import-export-common.php';

use Inc\Base\PP_IMPORT_EXPORT_WPSPIN_Base_Controller;


if ( ! class_exists( 'PP_EXPORT_WPSPIN' ) && defined( 'ABSPATH' ) ) {
	/**
	 * PP_EXPORT_WPSPIN
	 *
	 * @since      1.0.0
	 */
	class PP_EXPORT_WPSPIN extends PP_IMPORT_EXPORT_WPSPIN_Base_Controller{
		/**
		 * The version of this plugin.
		 *
		 * @since    1.0.0
		 * @access   public
		 * @var      string    $version    The current version of this plugin.
		 */
		public $version = PP_IMPORT_EXPORT_WPSPIN_VERSION;
		/**
		 * Constructor
		 *
		 * @since    1.0.0
		 */
		public function __construct() {
			// load the hook of export json function.
			
			add_action( 'admin_init', array( $this, '_pp_wpspin_export_json' ) );
			
		}


		// Handle the export action when the link is clicked.
		public function _pp_wpspin_export_json() {
			// get current loggedin user
			$current_user = wp_get_current_user();
			// if current user is not admin then return
			if ( ! in_array( 'administrator', $current_user->roles ) ) {
				return;
			}
			// Check if the export action is triggered.
			if ( isset( $_GET['action'] ) && 'export_post' === $_GET['action'] && isset( $_GET['id'] ) ) {
				$post_id = absint( $_GET['id'] );

				$post_type = get_post_type( $post_id );

					/*
					Get post data
					*/
					$post_data            = get_post( $post_id );
					$results['post_data'] = $post_data;

					/*
					Get post meta
					*/
					$post_meta            = get_post_meta( $post_id );
					$results['post_meta'] = $post_meta;

					/*
					Get post taxonomies
					*/
					$taxonomies            = get_object_taxonomies( $post_type );
					$term_list             = wp_get_post_terms( $post_id, $taxonomies, array( 'fields' => 'all' ) );
					$results['taxonomies'] = $term_list;

					/*
					Get post featured image
					*/
					$feature_img            = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'full' );
					$results['feature_img'] = $feature_img;

					/*
					Get ACF fields
					*/
					if ( function_exists( 'get_fields' ) ) {
						$acf_fields            = get_fields( $post_id );
						$results['acf_fields'] = $acf_fields;
					} else {
						$results['acf_fields'] = null;
					}

					/*
					Post type
					*/
					$results['post_type'] = $post_type;


					// Output JSON
					$json_data = json_encode( $results );
					$filename = $post_type.'_ID_'.$post_id.'_data.json';

					// Set headers for file download
					header( 'Content-Type: application/json' );
					header( 'Content-Disposition: attachment; filename="'.$filename.'"' );
					
					// Output the JSON data
					echo $json_data;

					exit;
			}
		}
		

		/**
		 * Define constant if not already set
		 *
		 * @param  string      $name name.
		 * @param  string|bool $value value.
		 *
		 * @since    1.0.0
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

	}

} // class_exists
