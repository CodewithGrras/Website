<?php

/**
 * Adds custom addon option buttons to the Quiz and Survey Master (QSM) addon settings.
 *
 * This function dynamically displays action buttons based on the addon's installation 
 * and activation status. It integrates with the `qsm_create_quiz_addon_option_buttons` 
 * hook to allow users to install, manage, or check the status of an addon.
 *
 * @since 2.0.0
 *
 * @param bool   $installer_activated  Whether the installer is activated.
 * @param bool   $invalid_and_expired  Whether the addon is invalid or expired.
 * @param array  $addon_lookup         Lookup data for the addon.
 * @param string $addon_slug           The unique slug identifier for the addon.
 * @param string $selected_bundle      The selected bundle type (if applicable).
 * @param bool   $is_installed         Whether the addon is installed.
 * @param bool   $is_activated         Whether the addon is activated.
 * @param string $addon_link           The management URL for the addon.
 * @param string $addon_status         The current status of the addon.
 */
function qsm_installer_addon_option_buttons( 
	$installer_activated, 
	$invalid_and_expired, 
	$addon_lookup, 
	$addon_slug, 
	$selected_bundle, 
	$is_installed, 
	$is_activated, 
	$addon_link, 
	$addon_status 
) {
?>
	<div class="qsm-quiz-addon-steps-button">
		<?php
		if (
			// Case 1: Addon is activated but expired
			((1 == $installer_activated && 1 == $invalid_and_expired)

			// Case 2: Addon is activated and valid, but user lacks the required bundle
			|| (1 == $installer_activated && 0 == $invalid_and_expired
				&& ! empty($addon_lookup)
				&& isset($addon_lookup[ $addon_slug ])
				&& ! in_array($selected_bundle, explode(',', str_replace(' ', '', $addon_lookup[ $addon_slug ]['bundle'])), true))

			// Case 3: Addon is not installed and is not activated
			|| (false === $is_installed && 0 == $installer_activated)

			// Case 4: Addon is not installed but activated, valid license, but user lacks the required bundle
			|| (false === $is_installed && 1 == $installer_activated && 0 == $invalid_and_expired
				&& ! empty($addon_lookup)
				&& isset($addon_lookup[ $addon_slug ])
				&& ! in_array($selected_bundle, explode(',', str_replace(' ', '', $addon_lookup[ $addon_slug ]['bundle'])), true))
			) && false == $is_activated
		) {
			?>
			<p class="qsm-dashboard-addon-status"></p>
			<a href="<?php echo esc_url($addon_link); ?>" class="button button-primary qsm-quiz-addon-steps-upgrade-btn buy" target="_blank">
				<?php echo esc_html__('Upgrade Plan', 'quiz-master-next'); ?>
			</a>
		<?php } else {
			$is_woocommerce_activated = 'woocommerce-integration' == $addon_slug && ! is_plugin_active( 'woocommerce/woocommerce.php' ) ? 'qsm-create-quiz-no-activated-tooltip' : '';
			?>
			<p class="qsm-dashboard-addon-status"><?php echo esc_html($addon_status); ?></p>
			<label class="qsm-dashboard-addon-switch <?php echo esc_attr($is_woocommerce_activated); ?>">
				<input type="checkbox" class="qsm-dashboard-addon-toggle"
					<?php checked(esc_attr($is_activated)); ?>
					<?php disabled(esc_attr($is_activated)); ?>>
				<span class="qsm-dashboard-addon-slider">
					<span class="qsm-dashboard-addon-checkmark">&#10003;</span>
				</span>
				<?php
				if ( "" != $is_woocommerce_activated ) { ?>
					<span class="qsm-create-quiz-tooltip"><?php esc_html_e('Please activate the WooCommerce plugin to proceed.', 'quiz-master-next'); ?></span>
				<?php } ?>
			</label>
		<?php } ?>
	</div>
	<?php 
}



/**
 * Adds custom theme option buttons to the Quiz and Survey Master (QSM) theme settings.
 *
 * This function dynamically displays action buttons based on the theme's installation 
 * and activation status. It integrates with the `qsm_create_quiz_theme_option_buttons` 
 * hook to allow users to install, manage, or check the status of an theme.
 *
 * @since 2.0.0
 *
 * @param bool   $installer_activated  Whether the installer is activated.
 * @param bool   $invalid_and_expired  Whether the theme is invalid or expired.
 * @param array  $theme_lookup         Lookup data for the theme.
 * @param string $theme_slug           The unique slug identifier for the theme.
 * @param string $selected_bundle      The selected bundle type (if applicable).
 * @param bool   $is_installed         Whether the theme is installed.
 * @param bool   $is_activated         Whether the theme is activated.
 * @param string $theme_demo           The demo URL for the theme.
 */

function qsm_installer_theme_option_buttons( $installer_activated, $invalid_and_expired, $addon_lookup, $theme_slug, $selected_bundle, $is_installed, $is_activated, $theme_demo ) {
?>
	<div class="qsm-quiz-steps-action-buttons">
		<?php
		if (
			// Case 1: Addon is activated but expired
			((1 == $installer_activated && 1 == $invalid_and_expired)

			// Case 2: Addon is activated and valid, but user lacks the required bundle
			|| (1 == $installer_activated && 0 == $invalid_and_expired
				&& ! empty($addon_lookup)
				&& isset($addon_lookup[ $theme_slug ])
				&& ! in_array($selected_bundle, explode(',', str_replace(' ', '', $addon_lookup[ $theme_slug ]['bundle'])), true))

			// Case 3: Addon is not installed and is not activated
			|| (false == $is_installed && 0 == $installer_activated)

			// Case 4: Addon is not installed but activated, valid license, but user lacks the required bundle
			|| (false == $is_installed && 1 == $installer_activated && 0 == $invalid_and_expired
				&& ! empty($addon_lookup)
				&& isset($addon_lookup[ $theme_slug ])
				&& ! in_array($selected_bundle, explode(',', str_replace(' ', '', $addon_lookup[ $theme_slug ]['bundle'])), true))
			) && false == $is_activated
		) { ?>
			<a href="<?php echo esc_url($theme_link); ?>" class="button button-primary" target="_blank">
				<?php echo esc_html__( 'Upgrade', 'quiz-master-next' ); ?>
			</a>
		<?php } elseif ( true == $is_activated || true == $is_installed || (false == $is_installed && 1 == $installer_activated && 0 == $invalid_and_expired && 'allaccess' == $selected_bundle) ) { ?>
			<a href="javascript:void(0)" class="qsm-theme-action-btn button button-secondary">
				<?php if ( true == $is_activated ) {
					echo esc_html__( 'Select', 'quiz-master-next' );
				} elseif ( true == $is_installed ) {
					echo esc_html__( 'Activate', 'quiz-master-next' );
				} elseif ( false == $is_activated && false == $is_installed ) {
					echo esc_html__( 'Install & Activate', 'quiz-master-next' );
				}
				?>
			</a>
		<?php } ?>
		<a href="<?php echo esc_url($theme_demo); ?>" class="button button-secondary demo" target="_blank">
			<?php echo esc_html__( 'Demo', 'quiz-master-next' ); ?>
		</a>
	</div>
	<?php 
}



function qsm_create_quiz_load_script_styles() {
	wp_enqueue_script( 'qsm_installer_admin_script', QSM_INSTALLER_PLUGIN_URL.'js/qsm-installer-create-quiz.js', array( 'jquery' ), QSM_INSTALLER_VERSION, true );
}