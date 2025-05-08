<?php
/**
 * Plugin Name: QSM - Installer
 * Plugin URI:http://www.quizandsurveymaster.com/
 * Description: Install qsm addons
 * Author:QSM Team
 * Author URI:http://www.quizandsurveymaster.com/
 * Version: 2.0.1
 * Text Domain: qsm-installer
 */

/**
 * @todo Follow this list to setup your addon:
 *
 * - Fill in information in the comments at the top of this file
 * - Replace the QSM_Installer class throughout the addon with your addon's main class
 * - Change the installer in the various settings functions to your addon's name
 * - Replace all instances of the qsm installer with your addon's name including the folder and the main file
 * - Find all @todo's and fill in the relevant information
 * QSM Installer
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if the QSM_addon_Installer class exists and deactivate the plugin if it does.
 */
function qsm_installer_check_qsm_addon_installer_class() {
    if ( class_exists( 'QSM_addon_Installer' ) ) {
        deactivate_plugins( plugin_basename( __FILE__ ) );

        // Display admin notice about the deactivation.
        add_action( 'admin_notices', 'qsm_installer_show_qsm_addon_installer_notice' );
    }
}
add_action( 'plugins_loaded', 'qsm_installer_check_qsm_addon_installer_class' );

/**
 * Display an admin notice when the plugin is deactivated.
 */
function qsm_installer_show_qsm_addon_installer_notice() {
    ?>
    <div class="notice notice-error">
        <p><?php echo esc_html__( 'QSM installer plugin has been deactivated because the code is already present in the QSM plugin.', 'qsm-installer' ); ?></p>
    </div>
    <?php
}

define( 'QSM_INSTALLER_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'QSM_INSTALLER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define('QSM_INSTALLER_API_URL', 'https://quizandsurveymaster.com');
define( 'QSM_INSTALLER_LIVE_SCRIPT_URL', QSM_INSTALLER_API_URL .'/wp-content/addon_installer_script.json' );

define('QSM_INSTALLER_ITEM', 132456);
define('QSM_INSTALLER_VERSION', '2.0.1');
//
/**
 * This class is the main class of the plugin
 *
 * When loaded, it loads the included plugin files and add functions to hooks or filters. The class also handles the admin menu
 *
 * @since 1.0.0
 */
class QSM_Installer {

	/**
	 * Version Number
	 *
	 * @var string
	 * @since 1.0.0
	 */
	public $version = QSM_INSTALLER_VERSION;

	/**
	 * Main Construct Function
	 *
	 * Call functions within class
	 *
	 * @since 1.0.0
	 * @uses QSM_Installer::load_dependencies() Loads required filed
	 * @uses QSM_Installer::add_hooks() Adds actions to hooks and filters
	 * @return void
	 */
	public function __construct() {
		$this->load_dependencies();
		$this->add_hooks();
		$this->check_license();
	}

	/**
	 * Load File Dependencies
	 *
	 * @since 1.0.0
	 * @return void
	 * @todo If you are not setting up the addon settings tab, the quiz settings tab, or variables, simply remove the include file below
	 */
	public function load_dependencies() {
		include 'php/functions.php';
		include 'php/license.php';
		include 'php/addon-settings-tab-content.php';
		include 'php/quiz-settings-tab-content.php';
		include 'php/variables.php';
		include 'php/addon-installer-page.php';
	}

	/**
	 * Add Hooks
	 *
	 * Adds functions to relavent hooks and filters
	 *
	 * @since 1.0.0
	 * @return void
	 * @todo If you are not setting up the addon settings tab, the quiz settings tab, or variables, simply remove the relevant add_action below
	 */
	public function add_hooks() {
		add_action( 'admin_init', 'qsm_addon_installer_register_addon_settings_tabs' );
		add_action( 'admin_enqueue_scripts', array( $this, 'qsm_installer_admin_scripts_style' ), 10 );
		add_action( 'admin_menu', array( $this, 'setup_admin_menu' ) );
		add_filter( 'mlw_qmn_template_variable_results_page', 'qsm_addon_installer_my_variable', 10, 2 );

		add_action( 'qsm_add_new_settings_tab',  'qsm_addon_installer_addon_list' );
		add_action( 'admin_init', array( $this, 'redirect_if_old_addon_page' ) );
		add_action('wp_ajax_qsm_handle_ajax_install', array( $this, 'qsm_handle_ajax_install' ));
        add_action('wp_ajax_qsm_handle_ajax_activate', array( $this, 'qsm_handle_ajax_activate' ));
		add_action('wp_ajax_qsm_handle_ajax_deactivate', array( $this, 'qsm_handle_ajax_deactivate' ));
		add_action('wp_ajax_qsm_handle_ajax_check_license', array( $this, 'qsm_handle_ajax_check_license' ));

		add_action( 'qsm_create_quiz_addon_option_buttons', 'qsm_installer_addon_option_buttons', 10, 9 );
		add_action( 'qsm_create_quiz_theme_option_buttons', 'qsm_installer_theme_option_buttons', 10, 8 );

		add_action( 'qsm_create_quiz_script_style', 'qsm_create_quiz_load_script_styles' );

		add_action('wp_ajax_qsm_installer_validate_single_license', array( $this, 'qsm_installer_validate_single_license' ) );
	}

	public function qsm_installer_admin_scripts_style() {
		if ( isset( $_GET['page'] ) && ! isset($_GET['tab']) && ( 'qsm_addons' === $_GET['page'] || 'qmn_addons' === $_GET['page'] ) ) {
			wp_enqueue_style( 'qsm_installer_admin_style', QSM_INSTALLER_PLUGIN_URL.'css/qsm-installer-admin.css', array(),  QSM_INSTALLER_VERSION);
			wp_enqueue_script( 'qsm_installer_admin_script', QSM_INSTALLER_PLUGIN_URL.'js/qsm-installer-admin.js', array( 'jquery' ), QSM_INSTALLER_VERSION, true );
			$settings_data   = QSM_Installer::get_installer_option();
			$bundle_license_key     = isset( $settings_data['license_key'] ) ? trim( $settings_data['license_key'] ) : '';
			wp_localize_script('qsm_installer_admin_script', 'qsm_installer_js', array(
				'ajaxurl'            => admin_url('admin-ajax.php'),
				'nonce'              => wp_create_nonce('qsm_installer_nonce'),
				'install'            => __('Installing...', 'qsm-installer'),
				'activate'           => __('Activating Plugin...', 'qsm-installer'),
				'deactivate'         => __('Deactivating...', 'qsm-installer'),
				'checkupdate'        => __('Checking for updates...', 'qsm-installer'),
				'update'             => __('Updating plugin...', 'qsm-installer'),
				'installbtn'         => __('Install',  'qsm-installer'),
				'activebtn'          => __('Activate',  'qsm-installer'),
				'deactivatebtn'      => __('Deactivate',  'qsm-installer'),
				'deactivated'        => __('Deactivated',  'qsm-installer'),
				'activated'          => __('Activated',  'qsm-installer'),
				'checkupdatebtn'     => __('Check For Update',  'qsm-installer'),
				'updatebtn'          => __('Update Now',  'qsm-installer'),
				'updated'            => __('Updated',  'qsm-installer'),
				'install_key_error'  => __('Please check your license key',  'qsm-installer'),
				'license_key'        => $bundle_license_key,
				'change_license'     => __('Change key',  'qsm-installer'),
				'userValidationAjax' => QSM_INSTALLER_API_URL.'/wp-json/validate-license/v1/verify',
				'invalid'            => __('Please enter a valid license key.', 'qsm-installer'),
				'hold'               => __('Please Wait! We are validating your license', 'qsm-installer'),
				'empty'              => __('Please enter a license key.', 'qsm-installer'),
				'try_again'          => __('Try Again', 'qsm-installer'),
				'view_details'       => __('View Details', 'qsm-installer'),
				'check_version'      => __('Checking Version...', 'qsm-installer'),
				'latest_version'     => __('Your version is up-to-date.', 'qsm-installer'),
				'version_error'      => __('Error checking version.', 'qsm-installer'),
				'download_update'    => __('Download Plugin', 'qsm-installer'),
			));
		}
	}

	public function setup_admin_menu() {
		remove_submenu_page('qsm_dashboard', 'qmn_addons');
		remove_submenu_page('qsm_dashboard', 'qsm-free-addon');
		add_submenu_page('qsm_dashboard', __( 'Extensions Settings', 'qsm-installer' ), '<span style="color:#f39c12;">' . __( 'Extensions', 'qsm-installer' ) . '</span>', 'activate_plugins', 'qsm_addons', 'qsm_addon_installer_addon_list', 30);
		add_submenu_page( 'options.php', __( 'Extensions Settings', 'qsm-installer' ), '<span style="color:#f39c12;">' . __( 'Extensions', 'qsm-installer' ) . '</span>', 'activate_plugins', 'qmn_addons', 'qmn_addons_page' );
		add_submenu_page( 'qsm_dashboard', __( 'Free Add-ons', 'quiz-master-next' ), '<span style="color:#f39c12;">' . esc_html__( 'Free Add-ons', 'quiz-master-next' ) . '</span>', 'activate_plugins', 'qsm-free-addon', 'qsm_display_optin_page', 90 );
	}

	public static function get_installer_option() {
		return wp_parse_args( get_option('qsm_addon_installer_settings', array()), array(
			'license_key'    => '',
			'license_status' => '',
			'last_validate'  => '',
			'expiry_date'    => '',
			'download_id'    => '',
			'bundle'         => '',
			'current_bundle' => '',
			'api_available'  => 1,
		));
	}

	public function redirect_if_old_addon_page(){
		if ( isset( $_GET['page'] ) && 'qmn_addons' === $_GET['page'] && ! isset($_GET['tab']) ) {
			wp_safe_redirect( admin_url( 'admin.php?page=qsm_addons' ) );
			exit();
		}

	}

	public function qsm_get_plugin_by_slug( $slug ) {
		foreach ( self::qsm_get_addon_data() as $plugin ) {
			if ( isset( $plugin['slug'] ) && $plugin['slug'] === $slug ) {
				return $plugin;
			}
		}
		return null;
	}

	public static function qsm_get_plugin_by_name( $name ) {
		foreach ( self::qsm_get_addon_data() as $plugin ) {
			if ( $plugin['name'] == $name ) {
				return $plugin;
			}
		}
		return null;
	}

	public function qsm_handle_ajax_install() {

		if ( isset( $_POST["nonce"] ) && wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['nonce'] )), 'qsm_installer_nonce') ) {
			global $mlwQuizMasterNext;
			if ( ! $mlwQuizMasterNext->qsm_is_admin( 'install_plugins' ) ) {
				wp_send_json_error( array( 'message' => __( 'You do not have permission to install plugins. Please contact the site administrator.', 'qsm-installer' ) ) );
			}
			$slug = isset( $_POST['slug'] ) ? sanitize_text_field( wp_unslash( $_POST['slug'] ) ) : "";
			$plugin_info = $this->qsm_get_plugin_by_slug($slug);
			$item_name = $plugin_info['name'];
			$plugin_status = $this->get_plugin_status($plugin_info['path']);
			$zip_url = "";
			if ( 1 != $plugin_status['installed'] ) {

				$settings_data   = self::get_installer_option();
				$license_key     = isset( $settings_data['license_key'] ) ? trim( $settings_data['license_key'] ) : '';

				$license_data = array(
					'timeout'   => 15,
					'sslverify' => false,
					'body'      => array(
						'license_key' => $license_key,
						'item_name'   => $item_name,
						'slug'        => $slug,
						'url'         => home_url(),
					),
				);

				$api_url = QSM_INSTALLER_API_URL.'/wp-json/license-activate/v1/install';
				$response = wp_remote_post( $api_url, $license_data);
				if ( is_wp_error($response) ) {
					$message = $response->get_error_message();
				} else {

					// Hook the function to http_request_args filter
					add_filter('http_request_args', 'qsm_addon_installer_disable_ssl_verification', 10, 2);

					$body = wp_remote_retrieve_body($response);
					$return_data = json_decode($body, true);
					if ( isset($return_data['message']) ) {
						$message = $return_data['message'];
					}
					$zip_url = $return_data['zip_url'];
					if ( "" == $zip_url && 0 == $return_data['api_available'] ) {
						$message = $return_data['message'];
						$settings_data   = QSM_Installer::get_installer_option();
						$settings_data['api_available'] = 0;
						update_option( 'qsm_addon_installer_settings', $settings_data);
					}
					if ( "" != $zip_url && 'sync-with-google-sheets' == $slug ) {
						$message = __('Please download and upload the zip file.', 'qsm-installer');
					}
					if ( "" != $zip_url && 'sync-with-google-sheets' != $slug ) {
						require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
						require_once ABSPATH . 'wp-admin/includes/file.php';
						require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
						$upgrader = new Plugin_Upgrader(new WP_Upgrader_Skin());

						$response_install = $upgrader->install($zip_url);
						if ( is_wp_error($response_install) ) {
							$message = $response->get_error_message();
						} else {
							$current_plugin   = get_option($plugin_info['option'], array());
							$current_plugin['license_key'] = $settings_data['license_key'];
							$current_plugin['license_status'] = $settings_data['license_status'];
							$current_plugin['last_validate'] = gmdate("d-m-Y", time());
							$current_plugin['expiry_date'] = $settings_data['expiry_date'];
							$path = $plugin_info['path'];
							update_option( $plugin_info['option'], $current_plugin );
							activate_plugin($path);
							$message = 'Plugin installed successfully!';
						}
					}

					remove_filter('http_request_args', 'qsm_addon_installer_disable_ssl_verification', 10);
				}
			} else {
				$message = __('Plugin is already installed.', 'qsm-installer');
			}
			wp_send_json_success(array(
				'message' => $message,
				'zip_url' => $zip_url,
			));
		}else {
			wp_send_json_error( array( 'message' => __( 'Please try after some time !', 'qsm-installer' ) ) );
		}
    }

    public function qsm_handle_ajax_activate() {
		if ( isset( $_POST["nonce"] ) && wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['nonce'] )), 'qsm_installer_nonce') ) {
			global $mlwQuizMasterNext;
			if ( ! $mlwQuizMasterNext->qsm_is_admin( 'activate_plugins' ) ) {
				wp_send_json_error( array( 'message' => __( 'You do not have permission to activate plugins. Please contact the site administrator.', 'qsm-installer' ) ) );
			}
			$slug = isset( $_POST['slug'] ) ? sanitize_text_field( wp_unslash( $_POST['slug'] ) ) : "";
			$is_bundle = isset($_POST['single']) ? sanitize_text_field( wp_unslash( $_POST['single'] ) ) : "bundle";
			$plugin_info = $this->qsm_get_plugin_by_slug($slug);
			$path = $plugin_info['path'];
			$plugin_status = $this->get_plugin_status($path);
			$item_name = $plugin_info['name'];
			if ( 1 == $plugin_status['installed'] && 1 != $plugin_status['activated'] ) {
				if ( "bundle" == $is_bundle ) {
					$bundle_data = $settings_data   = self::get_installer_option();
				} else {
					$settings_data   = get_option($plugin_info['option'], array());
				}
				$license_key         = isset( $settings_data['license_key'] ) ? trim( $settings_data['license_key'] ) : '';
				$item_name = $plugin_info['name'];
				$is_activable = self::license_activate($license_key, $item_name);

				if ( 'success' == $is_activable['status'] ) {
					if ( "bundle" == $is_bundle ) {
						$current_plugin   = get_option($plugin_info['option'], array());
						$current_plugin['license_key'] = $bundle_data['license_key'];
						$current_plugin['license_status'] = $bundle_data['license_status'];
						$current_plugin['last_validate'] = gmdate("d-m-Y", time());
						$current_plugin['expiry_date'] = $bundle_data['expiry_date'];
					} else {
						$current_plugin['license_key'] = $license_key;
						$current_plugin['license_status'] = 'valid';
						$current_plugin['last_validate'] = gmdate("d-m-Y", time());
						$current_plugin['expiry_date'] = isset($is_activable['expiry_date']) ? $is_activable['expiry_date'] : "";
					}
					update_option( $plugin_info['option'], $current_plugin );
					activate_plugin($path);
					$message = 'Plugin activated successfully!';
				}else {
					$message = $is_activable['message'];
				}
			} elseif ( 1 != $plugin_status['installed'] ) {
				$message = __('Plugin is not installed.', 'qsm-installer');
			} elseif ( 1 == $plugin_status['activated'] ) {
				$message = __('Plugin is already activated.', 'qsm-installer');
			} else {
				$message = __( 'Please try after some time !', 'qsm-installer' );
			}
			wp_send_json_success(array( 'message' => $message ));
		}else {
			wp_send_json_error( array( 'message' => __( 'Please try after some time !', 'qsm-installer' ) ) );
		}
    }

	public function qsm_handle_ajax_check_license() {

		if ( isset( $_POST["nonce"] ) && wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['nonce'] )), 'qsm_installer_nonce') ) {
			$api_url = QSM_INSTALLER_API_URL.'/wp-json/license-activate/v1/apistatus';
				$response = wp_remote_post( $api_url );
				if ( is_wp_error($response) ) {
					$message = $response->get_error_message();
				} else {
					$body = wp_remote_retrieve_body($response);
					$return_data = json_decode($body, true);
					$success = 0;
					$message = __( 'Installer option is currently not availalbe please try after some time !', 'qsm-installer' );
					if ( 1 == $return_data['bundle_apis'] ) {
						$settings_data   = QSM_Installer::get_installer_option();
						$success = 1;
						$message = '';
						$settings_data['api_available'] = 1;
						update_option( 'qsm_addon_installer_settings', $settings_data);
					}
				}
			echo wp_json_encode(array(
				'message' => $message,
				'success' => $success,
			));
		}
		wp_die();
	}

	public function qsm_handle_ajax_deactivate() {

		if ( isset( $_POST["nonce"] ) && wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['nonce'] )), 'qsm_installer_nonce') ) {
			global $mlwQuizMasterNext;
			if ( ! $mlwQuizMasterNext->qsm_is_admin( 'install_plugins' ) ) {
				wp_send_json_error( array( 'message' => __( 'You do not have permission to uninstall plugins. Please contact the site administrator.', 'qsm-installer' ) ) );
			}
			$slug = isset( $_POST['slug'] ) ? sanitize_text_field( wp_unslash( $_POST['slug'] ) ) : "";
			$plugin_info = $this->qsm_get_plugin_by_slug($slug);
			$path = $plugin_info['path'];
			$plugin_status = $this->get_plugin_status($path);
			if ( 1 == $plugin_status['installed'] && 1 == $plugin_status['activated'] ) {
				deactivate_plugins($path);
				$message = 'Plugin deactivated successfully!';
			} elseif ( 1 != $plugin_status['installed'] ) {
				$message = __('Plugin is not installed.', 'qsm-installer');
			} elseif ( 1 != $plugin_status['activated'] ) {
				$message = __('Plugin is not activated.', 'qsm-installer');
			} else {
				$message = __( 'Please try after some time !', 'qsm-installer' );
			}
			wp_send_json_success(array( 'message' => $message ));
		}else {
			wp_send_json_error( array( 'message' => __( 'Please try after some time !', 'qsm-installer' ) ) );
		}
	}

    private function get_plugin_status( $path ) {
        $installed_plugins = get_plugins();
        $activated_plugins = get_option('active_plugins');
        $is_installed = isset($installed_plugins[ $path ]);
        $is_activated = in_array($path, $activated_plugins, true);
        return array(
            'installed' => $is_installed,
            'activated' => $is_activated,
        );
    }
	/**
	 * Checks license
	 *
	 * Checks to see if license is active and, if so, checks for updates
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function check_license() {
		if ( ! class_exists( 'EDD_SL_Plugin_Updater' ) ) {
			// Load our custom updater.
			include 'php/EDD_SL_Plugin_Updater.php';
		}
		// Retrieves our license key from the DB.
		$settings      = get_option( 'mlw_qmn_installer', array() );
		$settings_data = QSM_Installer::get_installer_option();
		$license_key = '';
		if ( isset( $settings['license_key'] ) ) {
			$license_key = trim( $settings['license_key'] );
		} elseif ( isset( $settings_data['license_key'] ) ) {
			$license_key = trim( $settings_data['license_key'] );
		}


		// Sets up the updater.
		$edd_updater = new EDD_SL_Plugin_Updater(
			QSM_INSTALLER_API_URL, __FILE__, array(
				'version'   => $this->version,
				'license'   => $license_key,
				'item_name' => 'QSM Installer',
				'author'    => 'QSM Team',
			)
		);
	}

	/**
	 * @since 1.0.0
	 */
	public static function qsm_get_addon_data() {
		$current_date = gmdate( 'Y-m-d' );
		$last_update_date = get_option( 'qsm_addon_installer_script_update_date', '' );
		$addon_list_path = QSM_INSTALLER_PLUGIN_PATH . '/data/addon_installer_script.json';
		$addon_list_data = file_get_contents($addon_list_path);
		if ( '' == $last_update_date || $last_update_date < $current_date ) {
			$response = wp_remote_get( QSM_INSTALLER_LIVE_SCRIPT_URL, array( 'sslverify' => false ) );
			if (!is_wp_error($response)) {
				$addon_list_data = wp_remote_retrieve_body($response);
				file_put_contents($addon_list_path, $addon_list_data);
				update_option('qsm_addon_installer_script_update_date', $current_date);
			}
		}
		return self::qsm_return_filtered_data(json_decode($addon_list_data, true));
	}
	
	public static function qsm_return_filtered_data($addon_list_data) {
		$addon_options_path = QSM_INSTALLER_PLUGIN_PATH . 'data/addons-options.json';
		$addon_options_response = file_get_contents( $addon_options_path );
		$addon_options_data = json_decode($addon_options_response, true );

		if ( is_array( $addon_list_data ) ) {
			foreach ( $addon_list_data as $key => $addon_data ) {
				$addon_slug = $addon_data['slug'];
				$addon_list_data[ $key ]['path'] = isset( $addon_options_data[ $addon_slug ]['path'] ) ? $addon_options_data[ $addon_slug ]['path'] : $addon_data['path'];
				$addon_list_data[ $key ]['option'] = isset( $addon_options_data[ $addon_slug ]['option'] ) ? $addon_options_data[ $addon_slug ]['option'] : $addon_data['option'];
				$addon_list_data[ $key ]['settings_tab'] = isset( $addon_options_data[ $addon_slug ]['settings_tab'] ) ? $addon_options_data[ $addon_slug ]['settings_tab'] : $addon_data['settings_tab'];
			}
		}
		return $addon_list_data;
	}

	public static function license_activate( $license_key = '', $item_name = '' ) {

		$response = array(
			'status'      => 'error',
			'message'     => __( 'Please try again!', 'qsm-installer' ),
			'expiry_date' => "",
		);
		if ( ! empty( $license_key ) ) {
			$params              = array(
				'timeout'   => 15,
				'sslverify' => false,
				'body'      => array(
					'edd_action' => 'activate_license',
					'license'    => $license_key,
					'item_name'  => $item_name,
					'url'        => home_url(),
				),
			);

			$activation_response = wp_remote_post( QSM_INSTALLER_API_URL, $params );

			if ( ! empty( $activation_response ) ) {
				preg_match('/\{.*\}/s', $activation_response['body'], $matches);
				$body = json_decode( $matches[0] );
				if ( $body && $body->success ) {
					$response = array(
						'status'      => 'success',
						'message'     => __( 'License validated Successfully', 'qsm-installer' ),
						'expiry_date' => 'lifetime' != $body->expires ? gmdate( "d-m-Y", strtotime( $body->expires ) ) : gmdate( "d-m-Y", strtotime( '+1000 years' ) ),
					);
					$older_settings = QSM_Installer::qsm_get_plugin_by_name( $item_name );
					if ( 0 < $body->activations_left || 'unlimited' == $body->activations_left || ( isset($older_settings['license_key']) && $older_settings['license_key'] == $license_key ) ) {
						// Do Nothing
					} else {
						$expires = isset( $body->expires ) ? gmdate("d-m-Y", strtotime($body->expires)) : "";
						if ( 0 == $body->activations_left ) {
							$message = __( 'No activations left !', 'qsm-installer' );
						} else {
							$message = $body->error;
						}
						$response = array(
							'status'      => 'error',
							'message'     => $message,
							'expiry_date' => $expires,
						);
					}
				} else {
					$error_message   = array(
						'missing'               => __( 'License doesn\'t exist', 'qsm-installer' ),
						'missing_url'           => __( 'URL not provided', 'qsm-installer' ),
						'license_not_activable' => __( 'Attempting to activate a bundle\'s parent license', 'qsm-installer' ),
						'disabled'              => __( 'License key revoked', 'qsm-installer' ),
						'no_activations_left'   => __( 'No activations left', 'qsm-installer' ),
						'expired'               => __( 'License has expired', 'qsm-installer' ),
						'key_mismatch'          => __( 'License is not valid for this product', 'qsm-installer' ),
						'invalid_item_id'       => __( 'Invalid Item ID', 'qsm-installer' ),
						'item_name_mismatch'    => __( 'License is not valid for this product', 'qsm-installer' ),
					);
					$message         = __( 'Please try again!', 'qsm-installer' );
					if ( ! empty( $body->error ) ) {
						$message = $error_message[ $body->error ];
					}
					$response = array(
						'status'      => 'error',
						'message'     => $message,
						'expiry_date' => isset( $body->expires ) ? gmdate("d-m-Y", strtotime($body->expires)) : "",
					);
				}
			}
		}
		return $response;
	}

	public static function license_deactivate( $license_key = '', $item_name = '' ) {
		$response = "";
		if ( ! empty( $license_key ) ) {
			$params      = array(
				'timeout'   => 15,
				'sslverify' => false,
				'body'      => array(
					'edd_action' => 'deactivate_license',
					'license'    => $license_key,
					'item_name'  => rawurlencode( $item_name ), /* The name of product in EDD. */
					'url'        => home_url(),
				),
			);
			$request_deactivate    = wp_remote_post( QSM_INSTALLER_API_URL, $params );
			preg_match('/\{.*\}/s', $request_deactivate['body'], $matches);
			$response = json_decode( $matches[0] );
		}
		// return $response;
	}

	public function qsm_installer_validate_single_license() {
		$success = 0;
		$last_validate = "";
		$updated_html = "";
		$respnse_message = __('Please try after sometime.', 'qsm-installer');
		if ( isset( $_POST["nonce"] ) && wp_verify_nonce( sanitize_text_field(wp_unslash( $_POST['nonce'] )), 'qsm_installer_nonce') ) {
			$post_license   = isset( $_POST['input'] ) ? sanitize_text_field( wp_unslash( $_POST['input'] ) ) : '';
			$slug   = isset( $_POST['slug'] ) ? sanitize_text_field( wp_unslash( $_POST['slug'] ) ) : '';
			$plugin_info = $this->qsm_get_plugin_by_slug($slug);
			$path = $plugin_info['path'];
			$plugin_status = $this->get_plugin_status($path);
			$item_name = $plugin_info['name'];
			$settings_data   = QSM_Installer::get_installer_option();
			$bundle_license_key     = isset( $settings_data['license_key'] ) ? trim( $settings_data['license_key'] ) : '';
			if ( $post_license == $bundle_license_key ) {
				$item_name = $settings_data['current_bundle'];
			}
			if ( 1 == $plugin_status['installed'] && 1 == $plugin_status['activated'] ) {
				$is_activable = self::license_activate($post_license, $item_name);

				if ( 'success' == $is_activable['status'] ) {
					$current_plugin   = get_option($plugin_info['option'], array());
					$current_plugin['license_key'] = $post_license;
					$current_plugin['license_status'] = 'valid';
					$current_plugin['last_validate'] = gmdate("d-m-Y", time());
					$current_plugin['expiry_date'] = isset($is_activable['expiry_date']) ? $is_activable['expiry_date'] : "";
					$success = 1;
					$last_validate = $current_plugin['last_validate'];
					update_option( $plugin_info['option'], $current_plugin );
					if ( $post_license == $bundle_license_key ) {
						$item_name = $settings_data['current_bundle'];
					}
					$updated_html = '<div class="qsm-installer-license-details">
					<span class="dashicons dashicons-yes-alt"></span>
					<p class="license-info success">
						<b>' . esc_html($item_name . ' ' . __(' License |', 'qsm-installer')) . '</b> ' . esc_html__('Valid till ', 'qsm-installer') . ' ' . esc_html(gmdate("d-m-Y", strtotime($current_plugin['expiry_date']))) . '
						<a href="javascript:void(0);" class="qsm-installer-change-license">' . esc_html__('Change License', 'qsm-installer') . '</a>
					</p>
				  </div>';
				}
				$respnse_message = $is_activable['message'];
			}
		}
		wp_send_json_success(array(
			'success'       => $success,
			'message'       => $respnse_message,
			'last_validate' => $last_validate,
			'html'          => $updated_html,
		));
		wp_die();
	}

}

/**
 * Loads the addon if QSM is installed and activated
 *
 * @since 1.0.0
 */
function qsm_addon_installer_load() {
	// Make sure QSM is active.
	if ( class_exists( 'MLWQuizMasterNext' ) ) {
		$qsm_installer = new QSM_Installer();
	} else {
		add_action( 'admin_notices', 'qsm_addon_installer_missing_qsm' );
	}
}
add_action( 'plugins_loaded', 'qsm_addon_installer_load' );

/**
 * Display notice if Quiz And Survey Master isn't installed
 *
 * @since 1.0.0
 */
function qsm_addon_installer_missing_qsm() {
	echo '<div class="error"><p>Qsm Installer requires Quiz And Survey Master. Please install and activate the Quiz And Survey Master plugin.</p></div>';
}

// Define a function to modify cURL options for SSL verification
function qsm_addon_installer_disable_ssl_verification( $args, $url ) {
	if ( strpos($url, 'https://') === 0 ) {
		$args['sslverify'] = false;
	}
	return $args;
}
