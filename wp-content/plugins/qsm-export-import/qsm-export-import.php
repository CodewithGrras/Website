<?php
/**
 * Plugin Name: QSM - Export & Import
 * Plugin URI: https://quizandsurveymaster.com
 * Description: Export and import your quizzes and surveys
 * Author: QSM Team
 * Author URI: https://quizandsurveymaster.com
 * Version: 4.1.3
 * Text Domain: qsm-export-import
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * This class is the main class of the plugin
 *
 * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
 *
 * @since 0.1.0
 */
class QSM_Export_Import {

	/**
	 * Version Number
	 *
	 * @var string
	 * @since 0.1.0
	 */
	public $version = '4.1.3';

	/**
	 * Main Construct Function
	 *
	 * Call functions within class
	 *
	 * @since 0.1.0
	 * @uses QSM_Export_Import::load_dependencies() Loads required filed
	 * @uses QSM_Export_Import::add_hooks() Adds actions to hooks and filters
	 * @return void
	 */
	function __construct() {
		$this->load_dependencies();
		$this->add_hooks();
		$this->check_license();
	}

	/**
	 * Load File Dependencies
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function load_dependencies() {
		define( 'QSM_IMPORT_EXPORT_VER', $this->version );
		define( 'QSM_IMPORT_EXPORT_URL', plugin_dir_url( __FILE__ ) );
		define( 'QSM_IMPORT_EXPORT_THEME_PATH', plugin_dir_path( __FILE__ ) );
		define( 'QSM_IMPORT_EXPORT_CSS_URL', QSM_IMPORT_EXPORT_URL . 'css' );
		define( 'QSM_IMPORT_EXPORT_JS_URL', QSM_IMPORT_EXPORT_URL . 'js' );
		define( 'QSM_IMPORT_EXPORT_PHP_DIR', QSM_IMPORT_EXPORT_THEME_PATH . 'php' );
		define( 'QSM_IMPORT_EXPORT_ITEM', 17226 );
		include QSM_IMPORT_EXPORT_PHP_DIR . '/license.php';
		include QSM_IMPORT_EXPORT_PHP_DIR . '/addon-settings-tab-content.php';
		include QSM_IMPORT_EXPORT_PHP_DIR . '/ajax.php';
		include QSM_IMPORT_EXPORT_PHP_DIR . '/class-import-export-quiz.php';
	}

	/**
	 * Add Hooks
	 *
	 * Adds functions to relavent hooks and filters
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function add_hooks() {
		add_action( 'admin_init', 'qsm_addon_export_import_register_addon_settings_tabs' );
		//add_action( 'wp_ajax_qsm_export_quiz', 'qsm_addon_export_quiz' );
		add_action( 'wp_ajax_qsm_export_question', 'qsm_addon_export_question' );
		add_action( 'wp_ajax_qsm_export_settings', 'qsm_addon_export_quiz_settings' );
		add_action( 'wp_ajax_qsm_export_i_validate_license', 'qsm_export_i_validate_license' );
		if ( class_exists( 'QSM_Flashcards' ) ) {
			add_action( 'wp_ajax_qsm_flashcards_export', 'qsm_addon_export_flashcards' );
		}
		add_action( 'wp_ajax_qsm_import_media', 'qsm_fetch_and_import_media_files' );
	}

	/**
	 * Checks license
	 *
	 * Checks to see if license is active and, if so, checks for updates
	 *
	 * @since 1.3.0
	 * @return void
	 */
	public function check_license() {

		if ( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) {

			// load our custom updater.
			include 'php/EDD_SL_Plugin_Updater.php';
		}

		// retrieve our license key from the DB.
		$settings    = get_option( 'qsm_addon_export_import_settings', '' );
		$license_key = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';

		// setup the updater.
		$edd_updater = new EDD_SL_Plugin_Updater(
			'https://quizandsurveymaster.com',
			__FILE__,
			array(
				'version'   => $this->version,      // current version number.
				'license'   => $license_key,        // license key (used get_option above to retrieve from DB).
				'item_name' => 'Export & Import',   // name of this plugin.
				'author'    => 'QSM Team',       // author of this plugin.
			)
		);
	}
}

/**
 * Loads the addon if QSM is installed and activated
 *
 * @since 0.1.0
 * @return void
 */
function qsm_addon_export_import_load() {
	// Make sure QSM is active.
	if ( class_exists( 'MLWQuizMasterNext' ) ) {
		$qsm_export_import = new QSM_Export_Import();
		load_plugin_textdomain( 'qsm-export-import', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
	} else {
		add_action( 'admin_notices', 'qsm_addon_export_import_missing_qsm' );
	}
}
add_action( 'plugins_loaded', 'qsm_addon_export_import_load' );

/**
 * Display notice if Quiz And Survey Master isn't installed
 *
 * @since       0.1.0
 * @return      string The notice to display
 */
function qsm_addon_export_import_missing_qsm() {
	echo '<div class="error"><p>QSM - Export & Import requires Quiz And Survey Master. Please install and activate the Quiz And Survey Master plugin.</p></div>';
}


function qsm_export_i_validate_license() {
	global $mlwQuizMasterNext;
	$post_license = isset( $_POST['input'] ) ? sanitize_text_field( wp_unslash( $_POST['input'] ) ) : '';
	$update_status = isset( $_POST['update_status'] ) ? sanitize_text_field( wp_unslash( $_POST['update_status'] ) ) : '';
	if ( "" != $post_license ) {

		$settings    = get_option( 'qsm_addon_export_import_settings', array() );
		$license     = isset( $settings['license_key'] ) ? trim( $settings['license_key'] ) : '';

		if ( class_exists ( 'QSM_Check_License' ) ) {
			$activation = $mlwQuizMasterNext->check_license->activate( $post_license, 'Export & Import' );
		}else {
			$activation = QSM_license::activate( $post_license, 'Export & Import' );
		}

		if ( ! empty($activation) && ( ( __( 'Attempting to activate a bundle\'s parent license', 'qsm-export-import' ) == $activation['message'] || __( 'License key revoked', 'qsm-export-import' ) == $activation['message'] || __( 'No activations left', 'qsm-export-import' ) == $activation['message'] || __( 'License has expired', 'qsm-export-import' ) == $activation['message'] ) || 'success' == $activation['status'] ) ) {
			$item_url = 'https://quizandsurveymaster.com/checkout/?edd_license_key='.$license.'&download_id='.QSM_IMPORT_EXPORT_ITEM;
			$settings['license_key'] = $post_license;
			$settings['license_status'] = 'valid';
			$settings['last_validate'] = date("d-m-Y", time());
			$settings['expiry_date'] = isset($activation['expiry_date']) ? $activation['expiry_date'] : "";
			if ( 'success' == $activation['status'] ) {
				$validate = 1;
				$message = __( 'License validated Successfully', 'qsm-export-import' );
			}elseif ( __( 'License has expired', 'qsm-export-import' ) == $activation['message'] ) {
				$validate = 2;
				$message = __('License Key Expired. ', 'qsm-export-import');
			}else {
				$validate = 0;
				$message = $activation['message'];
			}
		} else {
			$validate = 0;
			$settings['license_key'] = '';
			$settings['license_status'] = '';
			$settings['last_validate'] = 'invalid';
			$settings['expiry_date'] = '';
			$message = $activation['message'];
		}
		// If same license key was entered.
		if ( $license != $post_license ) {
			$deactivation = QSM_license::deactivate( $license, 'Export & Import' );
		}
		if ( ! empty( $update_status ) && 'yes' === $update_status ) {
			$keys_to_exclude    = [ 'license_key', 'license_status', 'last_validate', 'expiry_date' ];
			$prev_settings      = array_diff_key($settings, array_flip($keys_to_exclude));
			$settings           = array_merge( $settings, $prev_settings );
		}
		update_option( 'qsm_addon_export_import_settings', $settings );
		echo wp_json_encode(array(
			'validate' => $validate,
			'message'  => $message,
		));
		wp_die();
	}
}

function qsm_deep_unserialize( $data ) {
    $unserializedData = maybe_unserialize( $data );

    if ( is_array( $unserializedData ) || is_object( $unserializedData ) ) {
        foreach ( $unserializedData as $key => &$value ) {
            $value = qsm_deep_unserialize( $value );
        }
        unset( $value );
    }

    return $unserializedData;
}

function qsm_replace_site_url_with_local_site_url( $array, $site_url, $local_site_url ) {
    foreach ( $array as $key => $value ) {
        if ( is_array( $value ) ) {
            $array[ $key ] = qsm_replace_site_url_with_local_site_url( $value, $site_url, $local_site_url );
        } elseif ( is_string( $value ) && strpos( $value, $site_url ) !== false ) {
            $array[ $key ] = str_replace( $site_url, $local_site_url, $value );
        }
    }
    return $array;
}

function qsm_fetch_and_import_media_files() {
    $media_urls = isset( $_POST['mediaUrls'] ) ? array_map( 'esc_url', $_POST['mediaUrls'] ) : [];
    $import_media = isset( $_POST['importMedia'] ) ? $_POST['importMedia'] : 0;
    $site_url = isset( $_POST['siteUrl'] ) ? esc_url( $_POST['siteUrl'] ) : '';
    $quizzes = isset( $_POST['quizzes'] ) ? wp_unslash( $_POST['quizzes'] ) : [];
    $count = 0;
    $new_quiz = $serialized_quiz = [];
    $local_site_url = trailingslashit( get_site_url() );

    foreach ( $quizzes as $key => $quiz ) {
        foreach ( $quiz as $qkey => $value ) {
            $new_quiz[ $key ][ $qkey ] = qsm_deep_unserialize( $value );
        }
    }

    $new_quiz = qsm_replace_site_url_with_local_site_url( $new_quiz, $site_url, $local_site_url );

    foreach ( $new_quiz as $key => $quiz ) {
        foreach ( $quiz as $qkey => $value ) {
            if ( 'questions' == $qkey ) {
                $temp = [];
                foreach ( $value as $id => $val ) {
                    foreach ( $val as $qukey => $qvalue ) {
                        $temp[ $id ][ $qukey ] = is_array( $qvalue ) ? serialize( $qvalue ) : $qvalue;
                    }
                }
                $serialized_quiz[ $key ][ $qkey ] = $temp;
            } else {
                $serialized_quiz[ $key ][ $qkey ] = is_array( $value ) ? serialize( $value ) : $value;
            }
        }
    }
    if ( $import_media ) {
        $failed_media_urls = [];
        $media_import_results = [];
        $max_response_time = ini_get('max_execution_time');
        foreach ( $media_urls as $media_url ) {
            $start_time = microtime(true);
            try {
                $response = wp_remote_get( $media_url, array( 'timeout' => $max_response_time ) );

                if ( is_wp_error( $response ) ) {
                    throw new Exception( 'Error fetching media: ' . $response->get_error_message() );
                }

                if ( wp_remote_retrieve_response_code( $response ) !== 200 ) {
                    throw new Exception( 'Failed to fetch media: ' . $media_url );
                }

                $end_time = microtime(true);
                $response_time = $end_time - $start_time;

                $file_name = basename( $media_url );
                $upload_dir = wp_upload_dir();
                $file_path = $upload_dir['path'] . '/' . $file_name;

                if ( file_exists( $file_path ) ) {
                    $media_import_results[] = [
                        'url'           => $media_url,
                        'status'        => 'skipped',
                        'response_time' => $response_time,
                    ];
                    continue;
                }

                $media_content = wp_remote_retrieve_body( $response );

                if ( empty( $media_content ) ) {
                    throw new Exception( 'Media not found at URL location: ' . $media_url );
                }

                file_put_contents( $file_path, $media_content );

                $attachment = [
                    'guid'           => $upload_dir['url'] . '/' . $file_name,
                    'post_mime_type' => wp_check_filetype( $file_name, null )['type'],
                    'post_title'     => sanitize_file_name( $file_name ),
                    'post_content'   => '',
                    'post_status'    => 'inherit',
                ];

                $attach_id = wp_insert_attachment( $attachment, $file_path );

                require_once( ABSPATH . 'wp-admin/includes/image.php' );

                $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
                $count = $attach_data ? $count + 1 : $count;
                wp_update_attachment_metadata( $attach_id, $attach_data );

                $media_import_results[] = [
                    'url'           => $media_url,
                    'status'        => 'success',
                    'response_time' => $response_time,
                ];
            } catch ( Exception $e ) {
                $failed_media_urls[] = $media_url;
                $media_import_results[] = [
                    'url'           => $media_url,
                    'status'        => 'failed',
                    'response_time' => microtime(true) - $start_time,
                    'error'         => $e->getMessage(),
                ];
            }
        }
    }

    wp_send_json_success( array(
        'uploads'              => $count,
        'quizzes'              => $serialized_quiz,
        'isImportMedia'        => $import_media ? true : false,
        'media_import_results' => $media_import_results,
    ) );
    wp_die();
}