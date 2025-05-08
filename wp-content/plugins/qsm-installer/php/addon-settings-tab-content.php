<?php
/**
 * This file handles the Addon Settings tab for the addon
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers your tab in the addon  settings page
 *
 * @since 1.0.0
 * @return void
 */
function qsm_addon_installer_register_addon_settings_tabs() {
	global $mlwQuizMasterNext;
	if ( ! is_null( $mlwQuizMasterNext ) && ! is_null( $mlwQuizMasterNext->pluginHelper ) && method_exists( $mlwQuizMasterNext->pluginHelper, 'register_quiz_settings_tabs' ) ) {
		$mlwQuizMasterNext->pluginHelper->register_addon_settings_tab( "QSM Installer", 'qsm_addon_installer_addon_settings_tabs_content' );
	}
}

/**
 * Generates the content for your addon settings tab
 *
 * @since 1.0.0
 * @return void
 * @todo Replace the installer with your addon's name
 */
function qsm_addon_installer_addon_settings_tabs_content() {
	
}

